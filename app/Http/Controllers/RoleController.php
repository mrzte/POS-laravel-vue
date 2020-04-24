<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class RoleController extends Controller
{
	public function index()
	{
	   $data = Role::orderBy('created_at', 'DESC')->paginate(10);
       return response()->json($data);	
	}

	 public function store(Request $request)
    {
        $role = Role::all();
        $this->validate($request, [
            'name' => 'required|string|max:100',
        ]);
     
        $product = Role::firstOrcreate([
            'name' => $request->name,
        ]);
    }

    public function update(Request $request, $id)
    {
    	$data = Role::findOrFail($id);
        
        $this->validate($request,
        [
    
            'name' => 'required|string',
            'guard_name' => 'sometimes|nullable',

        ]);
        
        $data->update($request->all());
    }

    public function destroy($id)
	{
	    $data = Role::findOrFail($id);
	    $data->delete();
	}
}
