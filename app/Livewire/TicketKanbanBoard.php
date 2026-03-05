<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\Project;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class TicketKanbanBoard extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public $statuses = [];

    public function mount()
    {
        $this->statuses = Ticket::getStatuses();
    }

    public function createTicketAction(array $arguments = []): Action
    {
        return Action::make('createTicket')
            ->label('Añadir Tarea')
            ->form([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('project_id')
                    ->label('Proyecto')
                    ->options(Project::pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Select::make('assignee_id')
                    ->label('Asignado a')
                    ->options(User::pluck('name', 'id'))
                    ->searchable(),
            ])
            ->action(function (array $data, array $arguments): void {
                Ticket::create([
                    ...$data,
                    'status' => $arguments['status'] ?? 'todo',
                    'order_column' => Ticket::where('status', $arguments['status'] ?? 'todo')->max('order_column') + 1,
                    'reporter_id' => auth()->id(),
                ]);
            });
    }

    public function updateTicketOrder($items)
    {
        foreach ($items as $item) {
            Ticket::where('id', $item['value'])->update([
                'status' => $item['status'],
                'order_column' => $item['order'],
            ]);
        }
    }

    public function render()
    {
        $tickets = Ticket::with(['project', 'assignee'])
            ->orderBy('order_column')
            ->get()
            ->groupBy('status');

        return view('livewire.ticket-kanban-board', [
            'tickets' => $tickets,
        ]);
    }
}
