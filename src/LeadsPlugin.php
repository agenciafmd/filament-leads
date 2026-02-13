<?php

declare(strict_types=1);

namespace Agenciafmd\Leads;

use Agenciafmd\Leads\Resources\Leads\LeadResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

final class LeadsPlugin implements Plugin
{
    public static function make(): static
    {
        return app(self::class);
    }

    public function getId(): string
    {
        return 'leads';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                LeadResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
