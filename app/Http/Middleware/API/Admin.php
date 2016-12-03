<?php

namespace App\Http\Middleware\API;

use Closure;
use App\Models\User;
use App\Exceptions\APIException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = User::getAuthenticated($request);

        if (empty($user) || !$user->hasScope('admin')) {
            throw new APIException('unauthorized', HttpResponse::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
