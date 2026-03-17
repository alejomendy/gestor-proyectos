<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Enums\ProjectStatus;
use App\Enums\ProjectPriority;
use App\Enums\EnvironmentType;
use App\Enums\ProjectTechnology;

class Project extends Model
{
    use HasFactory;

    // Esto desactiva la protección de asignación masiva 
    // y te permite guardar todos los campos
    protected $guarded = [];

    protected $casts = [
        'status' => ProjectStatus::class,
        'priority' => ProjectPriority::class,
        'environment_type' => EnvironmentType::class,
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function historicals()
    {
        return $this->hasMany(Historical::class);
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