<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorePolicy
{
    use HandlesAuthorization;

    public function __construct() { }

    public function root_actions(User $user)        
    {
        return $user->is_root;
    }

    public function admin_actions(User $user)
    {
        $allowed_users = [];
        $allowed_roles = ['admin'];
        
        if ($user->is_root) {
            return true;
        }
        if (in_array($user->login,$allowed_users)) {
            return true;
        }
        if (is_null($user->roles)) {
            return false;
        }
        foreach ($user->roles as $role) {
            if (in_array($role->name, $allowed_roles)) {
                return true;
            }
        }
        return false;
    }

    public function edit_roles(User $user)
    {
        $allowed_users = [];
        $allowed_roles = [];

        if ($user->is_root) {
            return true;
        }
        if (in_array($user->login,$allowed_users)) {
            return true;
        }
        if (is_null($user->roles)) {
            return false;
        }
        foreach ($user->roles as $role) {
            if (in_array($role->name, $allowed_roles)) {
                return true;
            }
        }
        return false;
    }

    public function delete_users(User $user)
    {
        $allowed_users = [];
        $allowed_roles = [];

        if ($user->is_root) {
            return true;
        }
        if (in_array($user->login,$allowed_users)) {
            return true;
        }
        if (is_null($user->roles)) {
            return false;
        }
        foreach ($user->roles as $role) {
            if (in_array($role->name, $allowed_roles)) {
                return true;
            }
        }
        return false;
    }

    public function delete_roles(User $user)
    {
        $allowed_users = [];
        $allowed_roles = [];

        if ($user->is_root) {
            return true;
        }
        if (in_array($user->login,$allowed_users)) {
            return true;
        }
        if (is_null($user->roles)) {
            return false;
        }
        foreach ($user->roles as $role) {
            if (in_array($role->name, $allowed_roles)) {
                return true;
            }
        }
        return false;
    }
}
