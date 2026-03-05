<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    public static function getStatuses(): array
    {
        return [
            'backlog' => [
                'label' => 'BACKLOG',
                'color' => '#4A5568', // Gray
                'bg' => 'bg-gray-500/10',
                'text' => 'text-gray-400',
                'filament_color' => 'gray',
            ],
            'todo' => [
                'label' => 'TODO',
                'color' => '#3182CE', // Blue
                'bg' => 'bg-blue-500/10',
                'text' => 'text-blue-400',
                'filament_color' => 'info',
            ],
            'doing' => [
                'label' => 'DOING',
                'color' => '#805AD5', // Purple
                'bg' => 'bg-purple-500/10',
                'text' => 'text-purple-400',
                'filament_color' => 'warning',
            ],
            'review' => [
                'label' => 'REVIEW',
                'color' => '#DD6B20', // Orange
                'bg' => 'bg-orange-500/10',
                'text' => 'text-orange-400',
                'filament_color' => 'orange',
            ],
            'to_production' => [
                'label' => 'TO PRODUCTION',
                'color' => '#00B5D8', // Cyan
                'bg' => 'bg-cyan-500/10',
                'text' => 'text-cyan-400',
                'filament_color' => 'success',
            ],
            'stopped' => [
                'label' => 'STOPPED',
                'color' => '#D53F8C', // Pink
                'bg' => 'bg-pink-500/10',
                'text' => 'text-pink-400',
                'filament_color' => 'danger',
            ],
            'done' => [
                'label' => 'DONE',
                'color' => '#319795', // Teal
                'bg' => 'bg-teal-500/10',
                'text' => 'text-teal-400',
                'filament_color' => 'success',
            ],
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
