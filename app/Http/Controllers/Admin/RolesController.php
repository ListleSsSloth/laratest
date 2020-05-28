<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

use App\User;
use App\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $roles->load('users');
        $data = [];
        
        foreach ($roles as $role) {
            $users = [];

            array_push(
                $data,
                [
                    'id' => $role->id,
                    'name' => $role->name,
                    'description' => $role->description,
                    'protected' => $role->protected,
                    'users' => count($role->users),
                ]
            );     
        }
        return view('admin.roles', ['roles' => $data])->withTitle('Roles');
    }

    public function add(Request $request)
    {
        if ($request->isMethod('get')) 
        {
            return view('admin.roles_add')->withTitle('Add role');
        }


        if ($request->isMethod('post')) 
        {
            $request->validate([
                'name' => 'required|unique:roles|max:50',
            ]);
    
            $name = $request->input('name');
            $description = $request->input('description');
    
            $role_data = [
                'name' => $name,
                'description' => $description,
            ];
    
            try 
            {
                $created_role = Role::create($role_data);
    
                return redirect()->route('roles')->withMessage('Роль '. $name . '( ' . $description . ' ) добавлена');
            } 
            catch (Exception $e) 
            {
                return redirect()->back()->withError($e->getMessage());
            }
    
            return view('admin.roles_add')->withTitle('Add role');
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get'))
        {
            $role = Role::FindOrFail($id);

            if($role->protected)
            {
                return redirect()->route('roles')->withError('Роль "'. $role->description . '" защищена от редактирования');
            }

            $data = [];
            $users = [];
            
            foreach ($role->users as $user) {
                array_push($users,
                [
                    'id' => $user->id,
                    'name' => $user->login,
                ]);
            }

            $data['id'] = $role->id;
            $data['name'] = $role->name;
            $data['description'] = $role->description;
            $data['users'] = $users;

            return view('admin.roles_edit', ['role' => $data])->withTitle('Edit roles');
        }
        
        
        if ($request->isMethod('post'))
        {
            $role = Role::FindOrFail($id);

            if($role->protected)
            {
                return redirect()->route('roles')->withError('Роль "'. $role->description . '"защищена');
            }
            
            if ($request->Has('update'))
            {
                $description = $request->input('description');
                
                try 
                {
                    $role->description = $description;
                    $role->save();

                    return redirect()->route('roles')->withMessage('Роль "'. $role->name . '" изменена');
                } 
                catch (Exception $e) 
                {
                    return redirect()->back()->withError($e->getMessage());
                }
            }
            if ($request->Has('delete'))
            {
                if($role->protected)
                {
                    return redirect()->route('roles')->withError('Роль "'. $role->description . '"защищена');
                }

                try
                {
                    $role->users()->detach();
                    $role->delete();
                } 
                catch (Exception $e) 
                {
                    return redirect()->back()->withError($e->getMessage());
                }

                return redirect()->route('roles')->withMessage('Роль "' . $role->name . '" удалена');
            }
        } 
    }
}
