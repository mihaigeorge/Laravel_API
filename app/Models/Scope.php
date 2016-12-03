<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\APIException;

class Scope extends Model
{
    /**
     * The scopes that belong to the user.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'users_scopes');
    }

    /**
     * Add a new scope
     * 
     * @param   Request $request
     * @return  Scope
     */
    public function add($request) {
    	$this->name = $request->input('name');
    	$this->type = 1;
    	$this->save();

    	return $this;
    }

    /**
     * Edit specific scope
     * 
     * @param   Request $request
     * @return  void
     */
    public function edit($request) {
    	$this->name = $request->input('name');
    	$this->save();
    }

    /**
     * Auhtorize a scope get request
     * 
     * @param   Request $request
     * @return  boolean
     */
    public static function authorizeGet($request) {
    	$scope = self::findOrFail($request->route('id'));
    	return ($scope->type == 1);
    }

    /**
     * Auhtorize a scope edit request
     * 
     * @param   Request $request
     * @return  bool
     */
    public static function authorizeEdit($request) {
    	$scope = self::findOrFail($request->route('id'));
    	return ($scope->type == 1);
    }
}
