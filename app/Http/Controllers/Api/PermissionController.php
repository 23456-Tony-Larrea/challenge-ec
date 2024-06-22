<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Symfony\Component\HttpFoundation\Response; // Importa la clase Response

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getPermissions()
    {
        $permissions = Permission::all();
        return response()->json($permissions, Response::HTTP_OK);
    }
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Crear un nuevo permiso
        $permission = Permission::create($validatedData);

        // Retornar la respuesta JSON con el código de estado 201
        return response()->json($permission, 201);
    }
    //get by id
    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission, Response::HTTP_OK);
    }
    //put
    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Buscar el permiso por su id
        $permission = Permission::findOrFail($id);

        // Actualizar el permiso
        $permission->update($validatedData);

        // Retornar la respuesta JSON con el código de estado 200
        return response()->json($permission, 200);
    }


}
