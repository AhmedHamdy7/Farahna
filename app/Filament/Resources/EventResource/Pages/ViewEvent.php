<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Couple')->schema([
                TextEntry::make('groom_name'),
                TextEntry::make('bride_name'),
                TextEntry::make('user.name')->label('Customer'),
                TextEntry::make('template.name')->label('Template'),
            ])->columns(2),

            Section::make('Event Details')->schema([
                TextEntry::make('event_date')->date(),
                TextEntry::make('event_time'),
                TextEntry::make('venue_name'),
                TextEntry::make('venue_address'),
            ])->columns(2),

            Section::make('Publication')->schema([
                TextEntry::make('subdomain')
                    ->formatStateUsing(fn ($state) => $state ? "{$state}.farahna.com" : 'Not set'),
                IconEntry::make('is_published')->boolean(),
                TextEntry::make('expires_at')->dateTime(),
                IconEntry::make('password')
                    ->label('Password Protected')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->isPasswordProtected()),
            ])->columns(2),
        ]);
    }
}
