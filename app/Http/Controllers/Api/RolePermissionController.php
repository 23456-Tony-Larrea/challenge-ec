<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function getRolePermissionsById($roleId)
    {
        try {
            $role = Role::find($roleId);
    
            if (!$role) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }
    
            // Transformar cada permiso para incluir 'state' directamente
            $permissions = $role->permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'state' => $permission->pivot->state, // Acceder directamente al campo 'state' del pivot
                ];
            });
    
            return response()->json([
                'message' => 'Permisos del rol obtenidos correctamente',
                'data' => $permissions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

public function updateRolePermissionState(Request $request, $roleId, $permissionId)
{
    try {
        $newState = $request->input('newState');

        $rolePermission = RolePermission::where('role_id', $roleId)
            ->where('permission_id', $permissionId)
            ->first();

        if (!$rolePermission) {
            return response()->json(['error' => 'RolePermission no encontrado'], 404);
        }

        $rolePermission->state = $newState;
        $rolePermission->save();

        return response()->json([
            'message' => 'Estado de RolePermission actualizado correctamente',
            'data' => [
                'id' => $rolePermission->id,
                'state' => $rolePermission->state,
            ],
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
