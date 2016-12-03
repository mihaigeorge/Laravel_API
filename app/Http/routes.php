<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This route group applies for the API.
|
*/

Route::group(['prefix' => 'api'], function () {

    Route::get('language', 'API\UsersController@getLanguage');

    /**
     * Authentication routes
     */
    Route::group(['prefix' => 'auth'], function() {
    	Route::post('login',         'API\UsersController@login');
    	Route::post('logout',        'API\UsersController@logout');
    	Route::post('register',      'API\UsersController@register');
    	Route::get('refresh-token',  'API\UsersController@refreshToken');
    });

    /**
     * Authenticated routes
     */
    Route::group(['middleware' => ['jwt.auth']], function() {
    	Route::get('protected', 'API\UsersController@getProtected');

        /**
         * Admin routes
         */
        Route::group(['prefix' => 'admin', 'middleware' => 'api.admin'], function() {
            
            Route::get('scopes', 'API\ScopesController@getList');
            Route::get('scopes/{id}', 'API\ScopesController@get');
            Route::post('scopes', 'API\ScopesController@add');
            Route::post('scopes/{id}', 'API\ScopesController@edit');
        
        });
    });
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
