<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Resources\Leads\Pages;

use Agenciafmd\Admix\Resources\Concerns\RedirectBack;
use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Leads\Resources\Leads\LeadResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditLead extends EditRecord
{
    use RedirectBack;

    #[Override]
    protected static string $resource = LeadResource::class;

    /**
     * @var array<int, string>
     */
    #[Override]
    protected $listeners = [
        'auditRestored',
    ];

    public function getRelationManagers(): array
    {
        $record = $this->getRecord();

        if ($record instanceof Lead && $record->trashed()) {
            return [];
        }

        return parent::getRelationManagers();
    }

    public function auditRestored(): void
    {
        $this->fillForm();
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
