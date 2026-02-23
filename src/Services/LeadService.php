<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Services;

use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Models\Postal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class LeadService
{
    public static function make(): static
    {
        return app(self::class);
    }

    public static function sources(): Collection
    {
        $sources = collect();
        if (class_exists(Postal::class)) {
            $sources = Postal::query()
                ->select(['name', 'slug'])
                ->get()
                ->mapWithKeys(fn ($postal) => [
                    $postal->slug => $postal->name,
                ])
                ->collect();
        }

        return $sources->merge(collect(config('filament-leads.sources', [])))
            ->sort();
    }

    private function queryBuilder(): Builder
    {
        return Lead::query();
    }
}
