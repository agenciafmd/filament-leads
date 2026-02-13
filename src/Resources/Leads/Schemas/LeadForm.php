<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Resources\Leads\Schemas;

use Agenciafmd\Admix\Resources\Infolists\Components\DateTimeEntry;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('General'))
                    ->schema([
                        TextInput::make('source')
                            ->translateLabel()
                            ->maxLength(255),
                        TextInput::make('name')
                            ->translateLabel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->translateLabel()
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->translateLabel()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->translateLabel()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columns()
                    ->columnSpan(2),
                Section::make(__('Information'))
                    ->schema([
                        Toggle::make('is_active')
                            ->translateLabel()
                            ->default(true),
                        DateTimeEntry::make('created_at'),
                        DateTimeEntry::make('updated_at'),
                    ])
                    ->collapsible()
                    ->columns(),
            ])
            ->columns(3);
    }
}
