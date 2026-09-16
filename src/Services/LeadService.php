<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Services;

use Agenciafmd\Postal\Models\Postal;
use Illuminate\Support\Collection;

final class LeadService
{
    public static function make(): static
    {
        return resolve(self::class);
    }

    public static function sources(): Collection
    {
        $sources = collect();
        if (class_exists(Postal::class)) {
            $sources = Postal::query()
                ->select(['name', 'slug'])
                ->get()
                ->mapWithKeys(fn ($postal): array => [
                    $postal->slug => $postal->name,
                ])
                ->collect();
        }

        return $sources->merge(collect(config('filament-leads.sources', [])))
            ->sort();
    }
}
