<?php

namespace App\Extensions;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;


class EloquentLdapUserProvider extends EloquentUserProvider
{    
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (!$user->is_active)
        {
            return false;
        }

        if ($user->ldap)
        {
            $login = $credentials['login'];
            $password = $credentials['password'];

            if (strlen(trim($password)) == 0)
            {
                return false;
            }

            $ldap = ldap_connect(config('ldap.host'),config('ldap.port')) 
                or die("Невозможно соединиться с LDAP сервером");

            $ldap_user = config('ldap.domain') . "\\" . $login;

            $bind = @ldap_bind($ldap, $ldap_user, $password);

            if (!$bind)
            {
                return false;
            }
            
            return true;
        }
        else
        {            
            return parent::validateCredentials($user, $credentials);
        }        
    }    
}