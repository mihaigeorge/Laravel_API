<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    /**
     * The scopes that belong to the user.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'users_scopes');
    }
}
