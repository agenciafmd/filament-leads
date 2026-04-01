<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Resources\Leads\Pages;

use Agenciafmd\Leads\Exports\LeadExporter;
use Agenciafmd\Leads\Resources\Leads\LeadResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

final class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(LeadExporter::class),
            CreateAction::make(),
        ];
    }
}
