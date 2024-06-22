<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
        // Definir la relación con el modelo Permission
        public function permission()
        {
            return $this->belongsTo(Permission::class);
        }
    
        // Si también necesitas definir la relación inversa con Role, aquí va
        public function role()
        {
            return $this->belongsTo(Role::class);
        }
}
