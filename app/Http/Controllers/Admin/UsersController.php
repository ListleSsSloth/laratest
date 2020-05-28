<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Exception;
use Carbon\Carbon;

use App\User;
use App\Role;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('get')) 
        {
            if (!Session()->has('users.viewmode'))
            {
                Session()->put('users.viewmode','active');
            }
            $view_mode = session('users.viewmode','all');

            $users = User::all();
            $users->load('roles');
            $data = [];

            foreach ($users as $user) {

                if ($view_mode == 'active' && !$user->is_active) {
                    continue;
                }

                $roles = [];
                foreach ($user->roles as $role) {
                    array_push(
                        $roles,
                        array(
                            'id' => $role->id,
                            'name' => $role->name,
                            'description' => $role->description,
                        ));
                }

                array_push(
                    $data,
                    array(
                        'id' => $user->id,
                        'login' => $user->login,
                        'ldap' => $user->ldap,
                        'protected' => $user->protected,
                        'root' => $user->is_root,
                        'active' => $user->is_active,
                        'roles' => $roles,
                    )
                );     
            }
            return view('admin.users',array('users' => $data))->withTitle('Users');
        }


        if ($request->isMethod('post'))
        {
            if ($request->has('changeviewmode'))
            {
                session()->put('users.viewmode', session('users.viewmode') == 'active' ? 'all' : 'active');
            }
            return redirect()->back();
        }
    }

    public function add(Request $request)
    {
        if ($request->isMethod('get')) 
        {
            $roles = Role::all();
            $roles_data = [];

            foreach ($roles as $role) {
                array_push(
                    $roles_data,
                    [
                        'id' => $role->id,
                        'name' => $role->name,
                        'description' => $role->description,
                    ]
                );
            }
            return view('admin.users_add',['roles' => $roles_data])->withTitle('Add user');
        }

        if ($request->isMethod('post')) 
        {
            $request->validate([
                'login' => 'required|unique:users|max:20',
            ]);
    
            $roles = $request->input('roles');
    
            $login = trim($request->input('login'));
            $password = Hash::make(trim($request->input('password')));
            $ldap = $request->Has('ldap');
    
            $user_data = array(
                'login' => $login,
                'password' => $password,
                'ldap' => $ldap,
            );
    
            try 
            {
                $created_user = User::create($user_data);
    
                if (!is_null($roles)) 
                {
                    $current_user = Auth::user()->login;
                    $current_date_time = Carbon::now()->toDateTimeString();
                    $roles_array = [];
    
                    foreach ($roles as $role) {
                        $roles_array[$role] = ['added_by' => $current_user,'added_on' => $current_date_time];
                    }
    
                    $created_user->roles()->attach($roles_array);
                }
    
                return redirect()->route('users')->withMessage('Пользователь "'. $login . '" добавлен');
            } 
            catch (Exception $e) 
            {
                return redirect()->back()->withError($e->getMessage());
            }
        }
        
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')) 
        {
            $user = User::FindOrFail($id);

            if($user->protected)
            {
                return redirect()->route('users')->withError('Пользователь "'. $user->login . '"защищен от редактирования');
            }

            $data = [];
            $roles = [];

            $user_roles = [];
            foreach ($user->roles as $role) {
                $user_roles[$role->id] = 'Добавлена пользователем "' . $role->pivot->added_by . '" ' . $role->pivot->added_on;
            }
            
            foreach (Role::all() as $role)
            {
                $has = in_array($role->id, array_keys($user_roles));
                array_push(
                    $roles,
                    [
                        'id' => $role->id,
                        'name' => $role->name,
                        'description' => $role->description,
                        'added_string' => $has ? $user_roles[$role->id] : null,
                        'has' => $has,
                    ]
                );
            }

            $data['id'] = $user->id;
            $data['login'] = $user->login;
            $data['ldap'] = $user->ldap;
            $data['protected'] = $user->protected;
            $data['root'] = $user->is_root;
            $data['active'] = $user->is_active;
            $data['roles'] = $roles;
        
            return view('admin.users_edit', ['user' => $data])->withTitle('Edit user');
        }


        if ($request->isMethod('post')) 
        {
            $user = User::FindOrFail($id);

            if($user->protected)
            {
                return redirect()->route('users')->withError('Пользователь "'. $user->login . '"защищен от редактирования');
            }
            
            if ($request->Has('update'))
            {
                $roles = $request->input('roles');
                $ldap = $request->Has('ldap');        
                $change_password = $request->Has('change_password');
                $active = $request->Has('active'); 
                try 
                {
                    $user->ldap = $ldap;
                    $user->is_active = $active;
                    if ($change_password)
                    {
                        $user->password = Hash::make(trim($request->input('password')));
                    }
                    $user->save();
                    

                    if (!is_null($roles)) 
                    {
                        $current_user = Auth::user()->login;
                        $current_date_time = Carbon::now()->toDateTimeString();
                        $roles_array = [];

                        foreach ($roles as $role) {
                            $roles_array[$role] = ['added_by' => $current_user,'added_on' => $current_date_time];
                        }

                        $user->roles()->sync($roles_array);
                    }
                    else 
                    {
                        $user->roles()->detach();
                    }

                    return redirect()->route('users')->withMessage('Пользователь "'. $user->login . '" изменен');
                } 
                catch (Exception $e) 
                {
                    return redirect()->back()->withError($e->getMessage());
                }
            }
            if ($request->Has('delete'))
            {
                if ($user->protected) 
                {
                    return redirect()->back()->withError('Пользователь "' . $user->login . '" защищен от удаления');
                }

                if (Auth::user()->login == $user->login) 
                {
                    return redirect()->back()->withError('Невозможно удалить своего пользователя');
                }

                try
                {
                    $user->roles()->detach();
                    $user->delete();
                } 
                catch (Exception $e) 
                {
                    return redirect()->back()->withError($e->getMessage());
                }
                return redirect()->route('users')->withMessage('Пользователь "' . $user->login . '" удален');
            }
        }
    }
}
