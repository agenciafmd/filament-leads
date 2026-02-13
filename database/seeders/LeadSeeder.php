<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Database\Seeders;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Database\Seeder;

final class LeadSeeder extends Seeder
{
    public function run(): void
    {
        Lead::query()
            ->truncate();

        Lead::factory()
            ->count(50)
            ->create();
    }
}
