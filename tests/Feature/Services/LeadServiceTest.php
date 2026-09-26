<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Tests\Feature\Services;

use Agenciafmd\Leads\Services\LeadService;
use Agenciafmd\Postal\Models\Postal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('lists the postal forms and the configured sources in alphabetical order', function (): void {
    config()->set('filament-leads.sources', [
        'newsletter' => 'Newsletter',
        'invalid' => ['not a label'],
    ]);
    Postal::factory()->create(['slug' => 'contato', 'name' => 'Contato']);
    Postal::factory()->create(['slug' => 'trabalhe-conosco', 'name' => 'Trabalhe conosco']);

    expect(LeadService::sources()->all())->toBe([
        'contato' => 'Contato',
        'newsletter' => 'Newsletter',
        'trabalhe-conosco' => 'Trabalhe conosco',
    ]);
});

it('lets a configured source replace the name of a postal form', function (): void {
    config()->set('filament-leads.sources', ['contato' => 'Fale conosco']);
    Postal::factory()->create(['slug' => 'contato', 'name' => 'Contato']);

    expect(LeadService::sources()->all())->toBe(['contato' => 'Fale conosco']);
});
