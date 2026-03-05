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

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}