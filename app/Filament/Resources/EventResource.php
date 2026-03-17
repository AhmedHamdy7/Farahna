<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon  = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Events';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Couple Details')->schema([
                TextInput::make('groom_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('bride_name')
                    ->required()
                    ->maxLength(255),

                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('template_id')
                    ->relationship('template', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
            ])->columns(2),

            Section::make('Event Details')->schema([
                DatePicker::make('event_date')
                    ->required(),

                TimePicker::make('event_time'),

                TextInput::make('venue_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('venue_address')
                    ->maxLength(255),

                TextInput::make('venue_map_link')
                    ->url()
                    ->maxLength(500),
            ])->columns(2),

            Section::make('Publication')->schema([
                TextInput::make('subdomain')
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->hint('e.g. ahmed-and-sara (for ahmed-and-sara.farahna.com)')
                    ->alphaDash(),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->maxLength(255),

                TextInput::make('password_hint')
                    ->maxLength(255),

                DateTimePicker::make('expires_at')
                    ->label('Expires At'),

                Toggle::make('is_published')
                    ->default(false),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                TextColumn::make('groom_name')
                    ->label('Couple')
                    ->formatStateUsing(fn (Event $record) => $record->coupleName())
                    ->searchable(['groom_name', 'bride_name']),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->sortable(),

                TextColumn::make('template.name')
                    ->sortable(),

                TextColumn::make('event_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('subdomain')
                    ->formatStateUsing(fn ($state) => $state ? "{$state}.farahna.com" : '—'),

                IconColumn::make('is_published')
                    ->boolean(),

                TextColumn::make('wishes_count')
                    ->counts('wishes')
                    ->label('Wishes'),

                TextColumn::make('rsvp_responses_count')
                    ->counts('rsvpResponses')
                    ->label('RSVPs'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('template')
                    ->relationship('template', 'name'),

                Filter::make('is_published')
                    ->label('Published only')
                    ->query(fn ($query) => $query->where('is_published', true)),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
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
            'index'  => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit'   => Pages\EditEvent::route('/{record}/edit'),
            'view'   => Pages\ViewEvent::route('/{record}'),
        ];
    }
}
