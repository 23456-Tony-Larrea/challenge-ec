<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $users = User::with('role:id,name')
                ->get()
                ->makeHidden('password') // Excluir la contraseña de la respuesta
                ->map(function ($user) {
                    // Añadir role_name al objeto del usuario
                    $user->role_name = $user->role->name;
                    unset($user->role); // Eliminar el objeto role para no incluirlo en la respuesta
                    return $user;
                });

    return response()->json($users);
} 

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'cedula' => 'required|string|max:10|unique:users',
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'estado_civil' => 'required|string|max:255',
        'latitud' => 'required|string|max:255',
        'longitud' => 'required|string|max:255',
        'role_name' => 'required|string|max:255', // Cambiado de role_id a role_name
    ]);

    // Buscar el rol por nombre 
    $role = Role::where('name', $validatedData['role_name'])->first();

    // Si el rol no existe, retornar un error
    if (!$role) {
        return response()->json(['error' => 'Rol no encontrado'], 404);
    }

    // Preparar los datos, incluyendo el role_id obtenido
    $validatedData['password'] = bcrypt($validatedData['password']);
    $validatedData['role_id'] = $role->id; // Asignar el role_id encontrado
    unset($validatedData['role_name']); // Remover role_name de los datos validados

    // Crear el usuario con los datos validados y el role_id
    $user = User::create($validatedData);

    return response()->json($user, 201);
}
public function login(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        // Valida con user y carga la relación 'role'
        $user = User::with('role') // Asegúrate de tener esta relación definida en tu modelo User
                    ->where('email', $credentials['email'])
                    ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'name' => $user->name,
            'nombres' => $user->nombres,
            'apellidos' => $user->apellidos,
            'email' => $user->email,
            'role_name' => $user->role->name, // Asume que tu relación 'role' tiene un campo 'name'
            'role_id' => $user->role_id, // Añade esta línea para incluir el role_id
        ], 200);
    } catch (\Exception $exception) {
        return response()->json([
            'message' => $exception->getMessage()
        ], 400);
    }
}
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscar el usuario por ID y cargar la relación 'role'
        $user = User::with('role:id,name') // Asumiendo que la tabla roles tiene los campos 'id' y 'name'
                    ->find($id);
    
        // Verificar si el usuario fue encontrado
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    
        // Excluir la contraseña de la respuesta
        $user->makeHidden('password');
    
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Reglas de validación, excluyendo 'password' y ajustando 'email' y 'cedula' para la unicidad
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'cedula' => 'required|string|max:10|unique:users,cedula,' . $user->id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'estado_civil' => 'required|string|max:255',
            'latitud' => 'required|string|max:255',
            'longitud' => 'required|string|max:255',
            'role_name' => 'required|string|exists:roles,name',
        ]);
    
        // Actualizar el usuario con los datos validados, excluyendo 'password'
        $user->update($validatedData);
    
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
    
        // Eliminar el usuario
        $user->delete();
    
        // Devolver una respuesta
        return response()->json(['message' => 'Usuario eliminado con éxito.']);
    }
}
