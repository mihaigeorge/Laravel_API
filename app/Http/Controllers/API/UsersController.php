<?php 

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;

class UsersController extends APIController
{
	/**
	 * Create a new user account
	 * 
	 * @param Request $request 
	 * @return Response
	 */
	public function register(RegisterRequest $request, User $user)
	{	
		$user->register($request);
		return $this->respondCreated();
	}

	/**
	 * Retrieve authentication token
	 * 
	 * @param LoginRequest $request 
	 * @return type
	 */
	public function login(LoginRequest $request, User $user)
	{
		return $this->respond([
			'token' => $user->login($request)
		]);
	}

	/**
	 * Invalidate current token
	 *
	 * @param Request $request
	 */
	public function logout(Request $request, User $user)
	{
		$user->logout($request);
		return $this->respondAccepted();
	}

	/**
	 * Refresh an authentication token
	 * 
	 * @param Request $request 
	 */
	public function refreshToken(Request $request)
	{
		$user = new User;
		
		return $this->respond([
			'token' => $user->refreshToken($request)
		]);
	}

	/**
	 * Get language for current Request
	 * 
	 * @param Request $request 
	 */
	public function getLanguage(Request $request)
	{
		return $this->respond([
			'language' => 'en'
		]);
	}

	/**
	 * Method protected by authentication for testing purpose
	 * 
	 * @param Request $request 
	 */
	public function getProtected(Request $request) 
	{
		return $this->respondAccepted();
	}

	/**
	 * Get authenticated user based on JWT Token
	 * 
	 * @param  Request
	 * @return Response
	 */
	public function getUser(Request $request)
	{	
		return $this->respond([
			'user' => User::getAuthenticated($request)
		]);
	}
} 

 ?>