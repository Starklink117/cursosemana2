<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//SPATIE
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    //El controlador RolController, se vrifica  si el usuario tiene los permisos adecuados para realizar esas acciones.

    public function __construct()
    {
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|borrar-rol', ['only'=>['index']]);
        $this->middleware('permission:crear-rol', ['only'=>['create','store']]);
        $this->middleware('permission:editar-rol',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-rol',  ['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //esta acción index se utiliza para mostrar una lista de roles en una vista.
        $roles = Role::all();
        return view('roles.index', compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //  esta acción create se utiliza para mostrar un formulario que permita al usuario 
        //crear un nuevo rol y asignar permisos a ese rol.
        $permission = Permission::get();
        return view('roles.crear',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // esta acción store se utiliza para procesar y guardar un nuevo rol en la base de datos, 
        // así como para asociar los permisos seleccionados con ese rol.
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);
        $role = Role::create(['name'=> $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // esta acción edit se utiliza para mostrar un formulario prellenado con la información del rol que se va a editar,
        // así como para permitir al usuario modificar los permisos asociados a ese rol.
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();

        return view('roles.editar', compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //esta acción update se utiliza para procesar y guardar los cambios realizados en un rol existente en la base de datos, 
        // así como para actualizar los permisos asociados a ese rol.
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //esta acción destroy se utiliza para eliminar un rol específico de la base de datos. 
        DB::table('roles')->where('id',$id)->delete();
        return redirect()->route('roles.index');
    }
}
