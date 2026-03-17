<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WishResource\Pages;
use App\Models\Wish;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class WishResource extends Resource
{
    protected static ?string $model = Wish::class;

    protected static ?string $navigationIcon  = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Events';
    protected static ?int    $navigationSort  = 2;
    protected static ?string $navigationLabel = 'Wishes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('event_id')
                ->relationship('event', 'groom_name')
                ->required(),
            TextInput::make('guest_name')->required(),
            Textarea::make('message')->required()->rows(3),
            Toggle::make('is_approved')->label('Approved'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.groom_name')
                    ->label('Event')
                    ->formatStateUsing(fn ($record) => $record->event->coupleName())
                    ->searchable()
                    ->sortable(),

                TextColumn::make('guest_name')->searchable(),

                TextColumn::make('message')
                    ->limit(60)
                    ->tooltip(fn (Wish $record) => $record->message),

                IconColumn::make('is_approved')->boolean()->label('Approved'),

                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('pending')
                    ->label('Pending approval')
                    ->query(fn ($query) => $query->where('is_approved', false)),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Wish $record) => ! $record->is_approved)
                    ->action(fn (Wish $record) => $record->update(['is_approved' => true])),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (Wish $record) => $record->is_approved)
                    ->action(fn (Wish $record) => $record->update(['is_approved' => false])),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWishes::route('/'),
        ];
    }
}
