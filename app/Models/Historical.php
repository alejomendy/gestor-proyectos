<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Historical extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'event_date' => 'date',
        'is_milestone' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Historial: {$this->title} ha sido {$eventName}");
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
