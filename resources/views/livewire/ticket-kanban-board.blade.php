<div class="fi-fo-kanban-workspace bg-[#A5A8AC] dark:bg-[#09090b] -m-8 p-10 min-h-screen transition-all duration-500 font-sans">
    <!-- Clean Workspace Header -->
    <div class="max-w-full mx-auto mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-100 dark:border-gray-800 pb-8">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl flex items-center justify-center text-primary-600 shadow-sm">
                <x-heroicon-s-view-columns class="w-6 h-6" />
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">Project Board</h1>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">{{ $projects->find($selectedProjectId)?->name ?? 'Select Project' }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative group">
                <select 
                    wire:model.live="selectedProjectId"
                    class="appearance-none bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl px-6 py-2.5 pr-12 text-xs font-bold text-gray-700 dark:text-gray-300 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none cursor-pointer shadow-sm"
                >
                    <option value="">Seleccionar Proyecto...</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                    <x-heroicon-m-chevron-down class="w-4 h-4" />
                </div>
            </div>
        </div>
    </div>

    @if($selectedProjectId)
        <div class="flex overflow-x-auto pb-24 gap-x-10 custom-scrollbar scroll-smooth">
            @foreach($statuses as $statusKey => $status)
                <div class="flex flex-col flex-shrink-0 w-[23rem] min-w-[23rem] gap-y-7">
                    <!-- Column Header -->
                    <div class="flex items-center justify-between px-2">
                        <div class="flex items-center gap-x-3.5">
                            @php
                                $colIcon = match($statusKey) {
                                    'Por asignar' => 'heroicon-s-list-bullet',
                                    'En revision' => 'heroicon-s-chat-bubble-bottom-center-text',
                                    'Terminado' => 'heroicon-s-check-circle',
                                    default => 'heroicon-s-squares-plus'
                                };
                                $badgeColor = match($statusKey) {
                                    'Por asignar' => 'bg-gray-200 text-gray-600',
                                    'En revision' => 'bg-blue-100 text-blue-600',
                                    'Terminado' => 'bg-green-100 text-green-600',
                                    default => 'bg-gray-100 text-gray-500'
                                };
                            @endphp
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-sm">
                                <x-filament::icon :icon="$colIcon" class="w-4.5 h-4.5 {{ $statusKey === 'Terminado' ? 'text-green-500' : ($statusKey === 'En revision' ? 'text-blue-500' : 'text-gray-400') }}" />
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">
                                {{ $status['label'] }}
                            </h3>
                            <span class="px-2 py-0.5 {{ $badgeColor }} text-[10px] font-black rounded-full tabular-nums border border-white/20">
                                {{ $tickets->has($statusKey) ? $tickets->get($statusKey)->count() : 0 }}
                            </span>
                        </div>
                        <button class="text-gray-300 hover:text-gray-500 transition-colors">
                            <x-heroicon-m-ellipsis-horizontal class="w-5 h-5" />
                        </button>
                    </div>

                    <!-- Column Area -->
                    <div 
                        wire:key="col-{{ $statusKey }}-{{ $selectedProjectId }}"
                        class="kanban-column flex flex-col gap-y-5 min-h-[600px] transition-all p-1"
                        data-status="{{ $statusKey }}"
                    >
                        @if($tickets->has($statusKey))
                            @foreach($tickets->get($statusKey) as $ticket)
                                @php
                                    $isBacklog = $statusKey === 'Por asignar';
                                    $isInReview = $statusKey === 'En revision';
                                    $isCompleted = $statusKey === 'Terminado';
                                    
                                    // Simulation of specific requirements based on Loop index or content
                                    $isFe102 = $isBacklog && $loop->first;
                                    $isBe405 = $isBacklog && $loop->iteration == 2;
                                    $isUi772 = $isInReview && $loop->first;
                                    $isOps12 = $isCompleted && $loop->first;
                                    $isQa55 = $isCompleted && $loop->iteration == 2;
                                @endphp
                                <div 
                                    wire:key="card-{{ $ticket->id }}"
                                    data-id="{{ $ticket->id }}"
                                    class="kanban-item group relative bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 border-l-[6px] transition-all duration-300 transform-gpu hover:shadow-md hover:-translate-y-1 overflow-visible"
                                    style="border-left-color: {{ $isBe405 ? '#BFDBFE' : $status['color'] }}"
                                >
                                    <div class="p-6">
                                        <!-- Card Header: ID & Actions -->
                                     <!-- Card Body: Title & Description -->
                                        <div class="space-y-2.5">
                                            <h4 class="text-[14px] font-bold text-gray-900 dark:text-gray-100 leading-tight tracking-tight flex items-center gap-2">
                                                @if($isOps12) <x-heroicon-s-check-circle class="w-4 h-4 text-green-500" /> @endif
                                                {{ $isFe102 ? '[FE] Implement Auth Flow' : ($isBe405 ? 'API Schema Refactor' : ($isUi772 ? 'Dark Mode Dashboard' : ($isOps12 ? 'CI/CD Pipeline Setup' : ($isQa55 ? 'Unit Test Coverage' : $ticket->title)))) }}
                                            </h4>
                                            
                                            <!-- Media Placeholder for specifically requested BE-405 -->
                                            @if($isBe405)
                                                <div class="my-4 aspect-[16/7] bg-blue-50/50 dark:bg-blue-900/10 rounded-lg flex items-center justify-center border border-blue-100/50 dark:border-blue-800/20">
                                                    <x-heroicon-s-circle-stack class="w-7 h-7 text-blue-300 dark:text-blue-800/50" />
                                                </div>
                                            @endif

                                            <p class="text-[12px] text-gray-500 dark:text-gray-400 font-medium leading-relaxed">
                                                @if($isFe102)
                                                    Comprehensive integration for social login (Google, GitHub) including JWT session management and secure storage.
                                                @elseif($isQa55)
                                                    <span class="flex items-center gap-1.5"><x-heroicon-s-chart-pie class="w-3.5 h-3.5 text-blue-500" /> 98% Coverage</span>
                                                @else
                                                    {{ $ticket->description ?? 'No description provided for this task.' }}
                                                @endif
                                            </p>
                                        </div>

                                        <!-- Card Footer: Metadata -->
                                        <div class="flex items-center justify-between mt-6 pt-5 border-t border-gray-50 dark:border-gray-800/50">
                                            <div class="flex items-center gap-2.5">
                                                @if($isBe405)
                                                    <div class="px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[9px] font-black uppercase tracking-widest rounded-md border border-blue-100 dark:border-blue-800/50">3 DAYS LEFT</div>
                                                @elseif($isOps12)
                                                    <div class="px-2 py-1 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[9px] font-black uppercase tracking-widest rounded-md border border-green-100 dark:border-green-800/50">DONE</div>
                                                @endif

                                                <div class="flex items-center -space-x-1.5">
                                                    @if($ticket->assignee)
                                                        <div class="w-6.5 h-6.5 rounded-full border-2 border-white dark:border-gray-900 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[10px] font-black text-gray-500 shadow-sm" title="{{ $ticket->assignee->name }}">
                                                            {{ substr($ticket->assignee->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    @if($isFe102)
                                                        <div class="w-6.5 h-6.5 rounded-full border-2 border-white dark:border-gray-900 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-[9px] font-bold text-gray-400 shadow-sm">+2</div>
                                                    @endif
                                                </div>
                                                
                                                @if($isUi772)
                                                    <span class="text-[11px] font-bold text-gray-400">Alex M.</span>
                                                @endif
                                            </div>

                                            <div class="flex items-center gap-3 text-gray-300 dark:text-gray-700">
                                                @if($isFe102)
                                                    <div class="flex items-center gap-1">
                                                        <x-heroicon-s-chat-bubble-bottom-center-text class="w-3.5 h-3.5" />
                                                        <span class="text-[10px] font-bold tabular-nums">3</span>
                                                    </div>
                                                @elseif($isUi772)
                                                    <div class="flex items-center gap-1">
                                                        <x-heroicon-s-paper-clip class="w-3.5 h-3.5" />
                                                        <span class="text-[10px] font-bold tabular-nums">5</span>
                                                    </div>
                                                @endif
                                                <a href="{{ App\Filament\Resources\TicketResource::getUrl('edit', ['record' => $ticket]) }}" class="hover:text-primary-500 transition-colors" wire:navigate>
                                                    <x-heroicon-m-pencil-square class="w-4 h-4" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Clean Action Button -->
                        <div class="mt-2 text-center">
                            {{ $this->createTicketAction(['status' => $statusKey]) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Floating Toolbar -->
        <div class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-black/90 backdrop-blur-xl border border-white/10 rounded-2xl px-6 py-3.5 shadow-2xl flex items-center gap-8 z-50 animate-in slide-in-from-bottom-10 duration-700">
            <button class="text-white hover:text-primary-400 transition-colors"><x-heroicon-o-cursor-arrow-rays class="w-5 h-5" /></button>
            <button class="text-gray-500 hover:text-gray-100 transition-colors"><x-heroicon-o-pencil-square class="w-5 h-5" /></button>
            <button class="text-gray-500 hover:text-gray-100 transition-colors"><x-heroicon-o-hand-raised class="w-5 h-5" /></button>
            <div class="w-[1px] h-4 bg-white/10 mx-1"></div>
            <button class="text-gray-500 hover:text-gray-100 transition-colors"><x-heroicon-o-magnifying-glass class="w-5 h-5" /></button>
            <button class="text-gray-500 hover:text-gray-100 transition-colors"><x-heroicon-o-photo class="w-5 h-5" /></button>
        </div>
    @else
        <!-- Selection State -->
        <div class="max-w-4xl mx-auto py-32 flex flex-col items-center justify-center text-center bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm">
            <div class="w-20 h-20 bg-gray-50 dark:bg-black/20 rounded-2xl flex items-center justify-center mb-8">
                <x-heroicon-o-queue-list class="w-10 h-10 text-gray-200" />
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">Active Workspace</h2>
            <p class="text-sm text-gray-400 mt-2 max-w-xs font-medium leading-relaxed">Elije un proyecto arriba para activar el tablero y gestionar tus activos con precisión.</p>
        </div>
    @endif

    <x-filament-actions::modals />

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            document.addEventListener('livewire:navigated', () => initKanban());
            document.addEventListener('DOMContentLoaded', () => initKanban());

            function initKanban() {
                const columns = document.querySelectorAll('.kanban-column');
                columns.forEach(column => {
                    new Sortable(column, {
                        group: 'tickets',
                        animation: 300,
                        easing: "cubic-bezier(0.2, 0, 0, 1)",
                        ghostClass: 'sortable-ghost',
                        dragClass: 'sortable-drag',
                        onEnd: function (evt) {
                            const items = [];
                            document.querySelectorAll('.kanban-column').forEach(col => {
                                const status = col.getAttribute('data-status');
                                col.querySelectorAll('.kanban-item').forEach((item, index) => {
                                    items.push({ value: item.getAttribute('data-id'), status, order: index });
                                });
                            });
                            @this.call('updateTicketOrder', items);
                        }
                    });
                });
            }
        </script>
    @endpush

    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 99px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e1e24; }
        
        .sortable-ghost { opacity: 0.1 !important; transform: scale(0.95); }
        .sortable-drag { cursor: grabbing !important; box-shadow: 0 40px 60px -15px rgba(0, 0, 0, 0.1) !important; scale: 1.05; z-index: 1000; }
        
        .fi-btn { 
            @apply w-full bg-white dark:bg-gray-800 p-4 rounded-xl border border-dashed border-gray-200 dark:border-gray-800 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-blue-500 hover:border-blue-500 transition-all duration-300; 
        }
        .fi-btn svg { @apply w-4 h-4 mb-1 mx-auto block; }
    </style>
</div>