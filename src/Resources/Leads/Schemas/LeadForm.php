<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Resources\Leads\Schemas;

use Agenciafmd\Admix\Resources\Infolists\Components\DateTimeEntry;
use Agenciafmd\Leads\Services\LeadService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

final class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Group::make([
                            Section::make(__('General'))
                                ->schema([
                                    TextInput::make('name')
                                        ->translateLabel()
                                        ->maxLength(255),
                                    Select::make('source')
                                        ->translateLabel()
                                        ->options(LeadService::make()
                                            ->sources()
                                            ->toArray())
                                        ->required(),
                                    TextInput::make('email')
                                        ->translateLabel()
                                        ->rules([
                                            'email:rfc,dns',
                                        ])
                                        ->maxLength(255),
                                    TextInput::make('phone')
                                        ->translateLabel()
                                        ->mask(RawJs::make(<<<'JS'
                                            $input.length <= 14 ? '(99) 9999-9999' : '(99) 99999-9999'
                                        JS))
                                        ->maxLength(255),
                                    Textarea::make('description')
                                        ->translateLabel()
                                        ->rows(5)
                                        ->columnSpanFull(),
                                ])
                                ->collapsible()
                                ->columns()
                                ->columnSpan(2),
                        ])
                            ->columnSpan(2),
                        Group::make([
                            Section::make(__('Information'))
                                ->schema([
                                    Toggle::make('is_active')
                                        ->translateLabel()
                                        ->default(true)
                                        ->columnSpanFull(),
                                    DateTimeEntry::make('created_at'),
                                    DateTimeEntry::make('updated_at'),
                                ])
                                ->collapsible()
                                ->columns(),
                        ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
