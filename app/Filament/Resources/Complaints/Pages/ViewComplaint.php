<?php

namespace App\Filament\Resources\Complaints\Pages;

use App\Filament\Resources\Complaints\ComplaintResource;
use App\Models\Complaint;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewComplaint extends ViewRecord
{
    protected static string $resource = ComplaintResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if ($this->record instanceof Complaint) {
            $this->record->markAsRead();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleRead')
                ->label(fn (): string => $this->record instanceof Complaint && $this->record->isRead()
                    ? 'Tandai Belum Dibaca'
                    : 'Tandai Dibaca')
                ->icon(fn (): Heroicon => $this->record instanceof Complaint && $this->record->isRead()
                    ? Heroicon::OutlinedEnvelope
                    : Heroicon::OutlinedEnvelopeOpen)
                ->color('gray')
                ->authorize('update')
                ->action(function (): void {
                    if (! $this->record instanceof Complaint) {
                        return;
                    }

                    if ($this->record->isRead()) {
                        $this->record->markAsUnread();
                    } else {
                        $this->record->markAsRead();
                    }

                    $this->refreshFormData(['read_at']);
                }),
            DeleteAction::make(),
        ];
    }
}
