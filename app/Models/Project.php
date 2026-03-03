<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    // Esto desactiva la protección de asignación masiva 
    // y te permite guardar todos los campos
    protected $guarded = [];
}