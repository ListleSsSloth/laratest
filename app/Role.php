<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable  = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('added_on', 'added_by');
    }
}
