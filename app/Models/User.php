<?php

namespace App\Models;

use JWTAuth;
use Exception;
use APIException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Scope;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{   
    use Authenticatable, CanResetPassword;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The users that belong to the scope.
     */
    public function scopes()
    {
        return $this->belongsToMany('App\Models\Scope', 'users_scopes');
    }

    /**
     * Add a new user into database
     * 
     * @param Request $request
     * @return User
     */
    public function register($request)
    {   
        $this->first_name = $request->input("firstName");
        $this->last_name  = $request->input("lastName");
        $this->email      = $request->input("email");
        $this->password   = bcrypt($request->input("password"));

        $this->save();

        // Automatically assign 'user' scope
        $scope = Scope::where('name', 'user')->first();
        $this->scopes()->attach($scope->id);

        return $this;
    }

    /**
     * Generate a new authentication token
     * 
     * @param Request $request 
     * @return string
     */
    public function login($request)
    {
        if ($token = JWTAuth::attempt(['email' => $request->input("email"), 'password' => $request->input("password")])) {
            return $token;
        }
        
        throw new APIException("invalidCredentials", HttpResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Invalidate user token
     *
     * @param  Request  $request
     */
    public function logout($request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (Exception $e) {
            # If Exceptions are thrown this is ok.
            # It means that token is already invalid.
        }
    }

    /**
     * Try to refresh received token
     * 
     * @param Request $request 
     * @return string
     */
    public function refreshToken($request)
    {
        try {
            return JWTAuth::refresh(JWTAuth::getToken());
        } catch (Exception $e) {
            throw new APIException("invalidToken", HttpResponse::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Get authenticated user
     *
     * @param  Request  $request
     * @return User
     */
    public static function getAuthenticated($request)
    {
        return JWTAuth::parseToken()->authenticate();
    }
}
