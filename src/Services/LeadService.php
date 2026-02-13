<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Services;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Database\Eloquent\Builder;

final class LeadService
{
    public static function make(): static
    {
        return app(self::class);
    }

    private function queryBuilder(): Builder
    {
        return Lead::query();
    }
}
