<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Resources\Leads\Pages;

use Agenciafmd\Admix\Resources\Concerns\RedirectBack;
use Agenciafmd\Leads\Resources\Leads\LeadResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateLead extends CreateRecord
{
    use RedirectBack;

    protected static string $resource = LeadResource::class;
}
