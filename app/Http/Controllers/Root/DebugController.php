<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Response;


use App\Role;
use App\User;



class DebugController extends Controller
{
    public function __invoke()
    {        
        echo "Debug..." . "<br>";
        $user = Auth::user();
        if ($user->is_root) {
            dump("user is root");
        }
        else {
            dump("user not root");
        }
        //----------------------------------------------------------------------------------------------------
        
        
        

        
        
















        dd();
        return;
    }
}
