<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Database\Seeders;

use Agenciafmd\Leads\Database\Factories\LeadFactory;
use Agenciafmd\Leads\Models\Lead;
use Illuminate\Database\Seeder;

final class LeadSeeder extends Seeder
{
    public function run(): void
    {
        Lead::query()
            ->truncate();

        LeadFactory::new()
            ->count(50)
            ->create();
    }
}
