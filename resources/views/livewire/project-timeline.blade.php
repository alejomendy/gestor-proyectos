<div class="space-y-12 py-6">
    @forelse($groupedActivities as $date => $activities)
        <div class="relative">
            <!-- Minimal Date Header -->
            <div class="sticky top-0 z-10 flex items-center mb-8 bg-white dark:bg-[#121214] py-2">
                <div class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('d M, Y') }}
                </div>
                <div class="h-px bg-gray-100 dark:bg-gray-800 flex-grow ml-6"></div>
            </div>

            <div class="ml-2 space-y-10 border-l-[1px] border-gray-100 dark:border-gray-800 pb-2">
                @foreach($activities as $activity)
                    <div class="relative pl-10 group transition-all duration-300">
                        <!-- Tiny Dot Connector -->
                        <div
                            class="absolute -left-[4.5px] top-1.5 w-2 h-2 rounded-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 group-hover:bg-primary-500 group-hover:border-primary-500 transition-colors">
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center gap-2 text-xs">
                                @if($activity->causer)
                                    <span class="font-bold text-gray-900 dark:text-gray-100">{{ $activity->causer->name }}</span>
                                @else
                                    <span class="font-medium text-gray-400">Sistema</span>
                                @endif
                                <span class="text-gray-300 dark:text-gray-700">•</span>
                                <span class="text-gray-400 dark:text-gray-500">{{ $activity->created_at->format('H:i') }}</span>
                            </div>

                            <div class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed font-medium">
                                {!! $activity->description !!}
                            </div>

                            @if($activity->properties->has('attributes'))
                                <div
                                    class="mt-2 flex flex-wrap gap-4 p-3 bg-gray-50/50 dark:bg-black/10 rounded-lg border border-gray-100/50 dark:border-gray-800/50">
                                    @foreach($activity->properties['attributes'] as $key => $value)
                                        @if(!in_array($key, ['created_at', 'updated_at', 'id', 'project_id']))
                                            <div class="flex items-center gap-1.5">
                                                <span
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ str($key)->replace('_', ' ') }}:</span>
                                                <span class="text-[11px] text-gray-600 dark:text-gray-400 font-semibold italic">
                                                    {{ is_array($value) ? '...' : ($value ?: '---') }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="py-20 text-center">
            <p class="text-sm text-gray-400 italic">No hay historial disponible para este proyecto.</p>
        </div>
    @endforelse
</div>