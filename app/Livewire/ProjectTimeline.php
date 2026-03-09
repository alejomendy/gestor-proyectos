<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ProjectTimeline extends Component
{
    public Project $project;

    public function render()
    {
        $activities = Activity::query()
            ->where(function ($query) {
                $query->where('subject_type', Project::class)
                    ->where('subject_id', $this->project->id);
            })
            ->orWhere(function ($query) {
                $query->whereHasMorph('subject', [\App\Models\Milestone::class, \App\Models\Document::class, \App\Models\Ticket::class], function ($q) {
                    $q->where('project_id', $this->project->id);
                });
            })
            ->with('causer')
            ->latest()
            ->get()
            ->groupBy(fn($activity) => $activity->created_at->format('Y-m-d'));

        return view('livewire.project-timeline', [
            'groupedActivities' => $activities,
        ]);
    }
}
