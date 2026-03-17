<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AppInfo extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "AppInfo: {$this->title} ha sido {$eventName}");
    }
}
