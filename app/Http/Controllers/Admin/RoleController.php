<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'adminAuthorization']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->paginate(15);

        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for assigning permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::pluck('name', 'id');

        return view('admin.role.assign', compact('role', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignPermission(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permission = Permission::findOrFail($request->permission);
        $role->givePermissionTo($permission);

        return redirect()->route('admin.role.index')->with('success', 'Permission assigned successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::leftJoin('role_has_permissions as rhp', 
                        'rhp.permission_id', '=' , 'permissions.id')
                        ->where(['rhp.role_id' => $id])
                        ->paginate(15);

        return view('admin.role.show', compact('role', 'permissions'));
    }

}
