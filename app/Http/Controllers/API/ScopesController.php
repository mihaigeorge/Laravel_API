<?php 

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Scope;
use Illuminate\Http\Request;

use App\Http\Requests\API\GetScopeRequest;
use App\Http\Requests\API\AddScopeRequest;
use App\Http\Requests\API\EditScopeRequest;

class ScopesController extends APIController
{
	/**
	 * List scopes
	 * 
	 * @return Response
	 */
	public function getList() 
	{	
		$scopes = Scope::where('type', 1)->get();
		return $this->respond($scopes);
	}

	/**
	 * Get scope details
	 * 
	 * @return Response
	 */
	public function get(GetScopeRequest $request, $id) 
	{	
		$scope = Scope::findOrFail($id);
		return $this->respond($scope);
	}

	/**
	 * Add a new Scope
	 * 
	 * @param   ScopeRequest
	 * @return  Response
	 */
	public function add(AddScopeRequest $request) 
	{
		$scope = new Scope();
		$scope->add($request);

		return $this->respondCreated();
	}

	/**
	 * Edit scope details
	 * 
	 * @param  EditScopeRequest $request
	 * @param  int              $id     
	 * @return Response                   
	 */
	public function edit(EditScopeRequest $request, $id) 
	{
		$scope = Scope::findOrFail($id);
		$scope->edit($request);

		return $this->respondAccepted();
	}
} 

 ?>