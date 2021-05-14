<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_post = DB::table('users')
        ->select(
            'users.name',
            'users.email',
            'roles.name as role',
            'users.created_at'
        )
        ->join('roles', 'roles.id', '=', 'users.role')
        ->get();

        $roles_user = Role::all();

        return view('admin.users', compact('user_post', 'roles_user'));
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

    public function store(UserRequest $userrequest)
    {
        $user_post = User::create($userrequest->all());
        // $user_post = User::create([
        //     'name' => $userrequest['name'],
        //     'email' => $userrequest['email'],
        //     'role' => $userrequest['role'],
        //     'password' => Hash::make('password123'),
        // ]);

        return response()->json([
            'message' => 'User has been succesfully posted!',
            'data' => $user_post
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
