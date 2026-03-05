<div class="fi-fo-kanban-container">
    <div class="fi-fo-kanban overflow-hidden rounded-xl bg-[#09090b] p-6 shadow-2xl border border-gray-800">
        <div class="flex overflow-x-auto pb-6 gap-x-6 custom-scrollbar scroll-smooth">
            @foreach($statuses as $statusKey => $status)
                <div class="flex flex-col flex-shrink-0 w-80 min-w-[20rem] gap-y-6">
                    <!-- Column Header -->
                    <div class="flex items-center justify-between px-4 py-3 bg-[#18181b] rounded-xl border-l-4 shadow-lg transition-all hover:brightness-110" style="border-left-color: {{ $status['color'] }}">
                        <div class="flex items-center gap-x-3">
                            <div class="w-3 h-3 rounded-full animate-pulse" style="background-color: {{ $status['color'] }}"></div>
                            <h3 class="text-xs font-black uppercase tracking-widest text-gray-200">
                                {{ $status['label'] }}
                            </h3>
                        </div>
                        <span class="px-2.5 py-0.5 text-xs font-bold bg-black/40 text-gray-400 rounded-lg border border-gray-800">
                            {{ $tickets->has($statusKey) ? $tickets->get($statusKey)->count() : 0 }}
                        </span>
                    </div>

                    <!-- Column Body -->
                    <div 
                        wire:key="status-{{ $statusKey }}"
                        class="kanban-column flex flex-col gap-y-4 min-h-[500px] p-2 rounded-2xl bg-black/20 backdrop-blur-sm border border-dashed border-gray-800 transition-colors hover:bg-black/30"
                        data-status="{{ $statusKey }}"
                    >
                        @if($tickets->has($statusKey))
                            @foreach($tickets->get($statusKey) as $ticket)
                                <div 
                                    wire:key="ticket-{{ $ticket->id }}"
                                    data-id="{{ $ticket->id }}"
                                    class="kanban-item group relative p-5 bg-[#18181b] border border-gray-800 rounded-xl shadow-md cursor-grab active:cursor-grabbing hover:border-gray-600 hover:scale-[1.02] hover:shadow-cyan-900/10 hover:shadow-xl transition-all duration-300 active:scale-95 active:rotate-1"
                                >
                                    <div class="flex flex-col gap-y-4">
                                        <!-- Card Header -->
                                        <div class="flex items-start justify-between gap-x-3">
                                            <h4 class="text-sm font-semibold text-gray-100 line-clamp-2 leading-relaxed group-hover:text-white transition-colors">
                                                {{ $ticket->title }}
                                            </h4>
                                            <div class="flex flex-shrink-0 -space-x-2 overflow-hidden">
                                                @if($ticket->assignee)
                                                    <div class="inline-flex h-7 w-7 items-center justify-center rounded-full border-2 border-[#18181b] bg-gradient-to-br from-indigo-500 to-purple-600 text-[10px] font-bold text-white shadow-sm group-hover:scale-110 transition-transform" title="{{ $ticket->assignee->name }}">
                                                        {{ substr($ticket->assignee->name, 0, 1) }}
                                                    </div>
                                                @else
                                                    <div class="inline-flex h-7 w-7 items-center justify-center rounded-full border-2 border-[#18181b] bg-gray-800 text-[10px] text-gray-500">
                                                        ?
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Card Content/Meta -->
                                        <div class="flex items-center gap-x-4 text-gray-500">
                                            <div class="flex items-center gap-x-1.5 hover:text-gray-300 transition-colors">
                                                <x-heroicon-o-information-circle class="w-4 h-4" />
                                                <span class="text-[11px] font-medium tracking-wide">#{{ $ticket->id }}</span>
                                            </div>
                                            <div class="flex items-center gap-x-1.5 hover:text-gray-300 transition-colors">
                                                <x-heroicon-o-calendar class="w-4 h-4" />
                                                <span class="text-[11px] font-medium tracking-wide">{{ $ticket->created_at->format('M d') }}</span>
                                            </div>
                                            @if($ticket->project)
                                                <div class="flex items-center gap-x-1.5 px-2 py-0.5 bg-gray-800/50 rounded text-gray-400 group-hover:bg-gray-700/50 transition-colors max-w-[80px] truncate">
                                                    <span class="text-[10px] font-bold uppercase">{{ $ticket->project->name }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Card Footer -->
                                        <div class="flex items-center justify-between pt-2 border-t border-gray-800/50 mt-1 group-hover:border-gray-700/50 transition-colors">
                                            <div class="flex items-center gap-x-2">
                                                <div class="w-2 h-2 rounded-full" style="background-color: {{ $status['color'] }}"></div>
                                                <span class="text-[10px] font-bold tracking-widest uppercase opacity-70" style="color: {{ $status['color'] }}">
                                                    {{ $status['label'] }}
                                                </span>
                                            </div>
                                            <a href="{{ App\Filament\Resources\TicketResource::getUrl('edit', ['record' => $ticket]) }}" class="inline-flex items-center gap-x-1 text-[11px] font-bold text-gray-500 hover:text-primary-400 transition-colors uppercase tracking-widest">
                                                Editar
                                                <x-heroicon-m-chevron-right class="w-3 h-3 translate-x-0 group-hover:translate-x-1 transition-transform" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Quick Add Action (Backlog Only) -->
                        @if($statusKey === 'backlog')
                            <div>
                                {{ $this->createTicketAction(['status' => $statusKey]) }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
            <script>
                document.addEventListener('livewire:navigated', () => {
                    initKanban();
                });

                document.addEventListener('DOMContentLoaded', () => {
                    initKanban();
                });

                function initKanban() {
                    const columns = document.querySelectorAll('.kanban-column');
                    
                    columns.forEach(column => {
                        new Sortable(column, {
                            group: 'tickets',
                            animation: 250,
                            easing: "cubic-bezier(1, 0, 0, 1)",
                            ghostClass: 'sortable-ghost',
                            dragClass: 'sortable-drag',
                            onEnd: function (evt) {
                                const items = [];
                                document.querySelectorAll('.kanban-column').forEach(col => {
                                    const status = col.getAttribute('data-status');
                                    const colItems = col.querySelectorAll('.kanban-item');
                                    colItems.forEach((item, index) => {
                                        items.push({
                                            value: item.getAttribute('data-id'),
                                            status: status,
                                            order: index
                                        });
                                    });
                                });

                                @this.call('updateTicketOrder', items);
                            }
                        });
                    });
                }
            </script>
        @endpush
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #09090b;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #18181b;
            border: 2px solid #09090b;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #27272a;
        }

        .sortable-ghost {
            opacity: 0.2;
            transform: scale(0.95);
            background: #2563eb !important;
        }

        .sortable-drag {
            cursor: grabbing !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            rotate: 2deg;
            z-index: 1000;
        }

        .kanban-item {
            user-select: none;
        }
    </style>

    <x-filament-actions::modals />
</div>