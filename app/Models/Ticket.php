<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Enums\TicketStatus;

class Ticket extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'status' => TicketStatus::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Ticket: {$this->title} ha sido {$eventName}");
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

    public static function getStatuses(): array
    {
        return [
            'Por asignar' => [
                'label' => 'Por asignar',
                'filament_color' => 'gray',
                'color' => '#A5A8AC',
            ],
            'en proceso' => [
                'label' => 'En proceso',
                'filament_color' => 'warning',
                'color' => '#F59E0B',
            ],
            'En revision' => [
                'label' => 'En revisión',
                'filament_color' => 'orange',
                'color' => '#F97316',
            ],
            'Produccion' => [
                'label' => 'Producción',
                'filament_color' => 'success',
                'color' => '#10B981',
            ],
            'Parado' => [
                'label' => 'Parado',
                'filament_color' => 'danger',
                'color' => '#EF4444',
            ],
            'Terminado' => [
                'label' => 'Terminado',
                'filament_color' => 'success',
                'color' => '#22C55E',
            ],
        ];
    }
}
