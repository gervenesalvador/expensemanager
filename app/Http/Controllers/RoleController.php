<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Http\Requests\StoreRolePost;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.index');
    }

    public function get()
    {
        $roles = Role::all();
        
        return response()->json([
            'status' => 'success',
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolePost $request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->description = $request->description;

        if ($role->save()) {
            return response()->json([
                'status' => 'success',
                'role' => $role
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to create role']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Invalid data']
            ]);
        }

        $role = Role::find($request->role_id);
        $role->name = $request->name;
        $role->description = $request->description;

        if ($role->save()) {
            return response()->json([
                'status' => 'success',
                'role' => $role
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to update the role']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if (empty($role)) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Role not existing']
            ]);
        }

        if ($role->delete()) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to delete the role']
        ]);
    }
}
