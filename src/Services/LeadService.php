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

    /**
     * Origens dos leads: os formulários do postal e as origens extras do config.
     *
     * @return Collection<string, string> slug => nome
     */
    public static function sources(): Collection
    {
        $postalSources = class_exists(Postal::class)
            ? Postal::query()
                ->select(['name', 'slug'])
                ->get()
                ->mapWithKeys(static fn (Postal $postal): array => [
                    $postal->slug => $postal->name,
                ])
                ->all()
            : [];

        $configSources = config('filament-leads.sources');
        $configSources = collect(is_array($configSources) ? $configSources : [])
            ->filter(static fn (mixed $label): bool => is_string($label))
            ->mapWithKeys(static fn (string $label, int|string $source): array => [(string) $source => $label])
            ->all();

        return collect([...$postalSources, ...$configSources])
            ->sort();
    }
}
