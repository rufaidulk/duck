<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware(['auth', 'companyAuthorization']);
        $this->authorizeResource(User::class, 'user');
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->getUsersByCompanyId(Auth::user()->company_id)->paginate(10);
        
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = User::getCompanyUserRoles();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try
        {
            $attributes = $request->validated();
            $attributes['company_id'] = Auth::user()->company_id;
            $this->user->createModel($attributes);
            $this->user->assignRole($request->role);
        }
        catch (Exception $e) {
            logger($e);
            return back()->with('error', 'Oops something went wrong!')->withInput();
        }

        return redirect()->route('user.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = User::getCompanyUserRoles();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try
        {
            $attributes = $request->validated();
            $attributes['company_id'] = Auth::user()->company_id;
            $user->updateModel($attributes);
            $user->syncRoles($request->role);
        }
        catch (Exception $e) {
            logger($e);
            return back()->with('error', 'Oops something went wrong!')->withInput();
        }

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
