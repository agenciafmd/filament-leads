<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Tests\Feature\Listeners;

use Agenciafmd\Leads\Listeners\CreateLead;
use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Events\NotificationSent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseHas;

uses(TestCase::class, RefreshDatabase::class);

it('creates the lead mapping the known fields and describing the others', function (): void {
    new CreateLead()->handle(new NotificationSent([
        'source' => 'contato',
        'Nome' => 'Fulano',
        'e-mail' => 'fulano@example.com',
        'celular' => '11999999999',
        'mensagem' => 'Olá',
        'cidade' => 'São Paulo',
    ]));

    assertDatabaseHas(Lead::class, [
        'source' => 'contato',
        'name' => 'Fulano',
        'email' => 'fulano@example.com',
        'phone' => '11999999999',
        'description' => "Mensagem: Olá\nCidade: São Paulo",
    ]);
});
