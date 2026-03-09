<div
    class="flex flex-col md:flex-row gap-8 min-h-[600px] bg-gray  rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
    <!-- Clean Vertical Sidebar -->
    <div class="w-full md:w-64 bg-gray-50/30 dark:bg-black/10 border-r border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-6">Proyectos
        </h3>
        <nav class="flex flex-col gap-1">
            @foreach($projects as $project)
                <button wire:click="selectProject({{ $project->id }})" @class([
                    'flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200',
                    'bg-gray-100 dark:bg-gray-800 text-primary-600 dark:text-primary-400 shadow-sm' => $selectedProjectId == $project->id,
                    'text-gray-500 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/50' => $selectedProjectId != $project->id
                ])>
                    <span class="truncate">{{ $project->name }}</span>
                    @if($selectedProjectId == $project->id)
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                    @endif
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Minimal Content Area -->
    <div class="flex-grow p-8">
        @if($selectedProject)
            <div class="mb-10 pb-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                        Historial: {{ $selectedProject->name }}
                    </h2>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-xs text-gray-400 font-medium italic">Actividad consolidada del proyecto</span>
                        <div class="w-1 h-1 rounded-full bg-gray-200 dark:bg-gray-800"></div>
                        <span
                            class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $selectedProject->status }}</span>
                    </div>
                </div>
            </div>

            <div class="animate-in fade-in duration-500">
                @livewire('project-timeline', ['project' => $selectedProject], key($selectedProject->id))
            </div>
        @else
            <div class="h-full flex flex-col items-center justify-center text-center p-12">
                <p class="text-sm font-medium text-gray-400 italic">Selecciona un proyecto para ver su actividad.</p>
            </div>
        @endif
    </div>
</div>