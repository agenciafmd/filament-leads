<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Resources\Leads\Tables;

use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Leads\Services\LeadService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('source')
                    ->translateLabel()
                    ->sortable()
                    ->state(function (Lead $lead): string {
                        $sources = LeadService::make()
                            ->sources();

                        return $sources[$lead->source] ?? $lead->source;
                    }),
                TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime(config('filament-admix.timestamp.format'))
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->translateLabel()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->translateLabel(),
                SelectFilter::make('source')
                    ->translateLabel()
                    ->options(fn (): array => LeadService::make()
                        ->sources()
                        ->toArray()),
                Filter::make('created_at')
                    ->schema([
                        DateTimePicker::make('created_from')
                            ->translateLabel(),
                        DateTimePicker::make('created_until')
                            ->translateLabel(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query->orderBy('is_active', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->orderBy('name');
            });
    }
}
