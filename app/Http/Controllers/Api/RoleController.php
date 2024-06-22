<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

use Symfony\Component\HttpFoundation\Response; // Importa la clase Response

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Role::all();
        return response()->json($permissions, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Crear un nuevo Role
        $role = Role::create($validatedData);
    
        // Obtener todos los permisos
        $permissions = Permission::all();
    
        // Asignar todos los permisos al nuevo rol
        $role->permissions()->attach($permissions);
    
        // Retornar la respuesta JSON con el código de estado 201
        return response()->json([
            'message' => 'Role created successfully',
            'data' => $role
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // show by 
        $role = Role::findOrFail($id);
        return response()->json($role, Response::HTTP_OK);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Buscar el Role por su id
        $role = Role::findOrFail($id);

        // Actualizar el Role
        $role->update($validatedData);

        // Retornar la respuesta JSON con el código de estado 200
        return response()->json($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
