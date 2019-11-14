<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\StoreUserPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::all();

        // $roles = \App\Role::all();
        
        return view('users.index');
    }

    public function get()
    {
        $users = User::all();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'role' => $user->role->name,
                'created_at' => $user->created_at->format('Y-m-d h:i a')
            ];
        }
        return response()->json([
            'status' => 'success',
            'users' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserPost $request)
    {
        $role = Role::find($request->role_id);

        if (empty($role)) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Role is invalid']
            ]);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role_id = $request->role_id;

        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to create user']
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
        $user = User::find($id);

        if (empty($user)) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'User not existing']
            ]);
        }

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Invalid data']
            ]);
        }

        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to update the user']
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
        $user = User::find($id);

        if (empty($user)) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'User not existing']
            ]);
        }

        if ($user->delete()) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to delete the user']
        ]);
    }

    public function changePassword() 
    {
        return view('users.change_password');
    }

    public function updatePassword(Request $request) 
    {
        $user = User::find(Auth::id());
        if (!Hash::check($request->current_password, $user->password)) {
            return view('users.change_password', ['error' => 'Invalid password']);
        }
        
        if ($request->new_password !== $request->confirm_password) {
            return view('users.change_password', ['error' => "Confirm password doesn't match"]);
        }

        $user->password = $request->new_password;

        if ($user->save()) {
            Auth::logout();
            return redirect('/login');
        }

        return response()->json($request->all());
    }
}
