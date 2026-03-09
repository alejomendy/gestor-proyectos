<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class AllProjectsTimeline extends Component
{
    public $selectedProjectId = null;

    public function selectProject($projectId)
    {
        $this->selectedProjectId = $projectId;
    }

    public function render()
    {
        $projects = Project::withCount(['milestones', 'documents', 'tickets'])
            ->has('milestones')
            ->orHas('documents')
            ->orHas('tickets')
            ->get();

        if (!$this->selectedProjectId && $projects->isNotEmpty()) {
            $this->selectedProjectId = $projects->first()->id;
        }

        return view('livewire.all-projects-timeline', [
            'projects' => $projects,
            'selectedProject' => $this->selectedProjectId ? Project::find($this->selectedProjectId) : null,
        ]);
    }
}
