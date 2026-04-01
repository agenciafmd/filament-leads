<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Exports;

use Agenciafmd\Admix\Exports\Concerns\DefaultNotificationAndFileName;
use Agenciafmd\Leads\Models\Lead;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;

final class LeadExporter extends Exporter
{
    use DefaultNotificationAndFileName;

    protected static ?string $model = Lead::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label(__('Name')),
            ExportColumn::make('email')
                ->label(__('Email')),
            ExportColumn::make('phone')
                ->label(__('Phone')),
            ExportColumn::make('source')
                ->label(__('Source')),
            ExportColumn::make('description')
                ->label(__('Description')),
            ExportColumn::make('is_active')
                ->label(__('Is active'))
                ->formatStateUsing(function (string $state): string {
                    return match ($state) {
                        '1' => __('Yes'),
                        '' => __('No'),
                    };
                }),
            ExportColumn::make('created_at')
                ->label(__('Created at')),
        ];
    }
}
