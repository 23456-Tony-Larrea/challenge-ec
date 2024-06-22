<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoblacionModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'CodProvincia',
        'Provincia',
        'CodMunicipio',
        'Municipio',
        'Poblacion',
    ];
}