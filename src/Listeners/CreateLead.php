<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Listeners;

use Agenciafmd\Leads\Models\Lead;
use Agenciafmd\Postal\Events\NotificationSent;

final class CreateLead
{
    public function handle(NotificationSent $data): void
    {
        $fields = collect(config('filament-leads.fields'));
        $remappedData = collect($data->data)
            ->mapWithKeys(function ($value, $key) use ($fields) {
                $field = $fields->search(fn ($field) => in_array($key, $field, true));

                return [($field ?: $key) => $value];
            });

        Lead::query()
            ->create([
                'source' => $remappedData->pull('source'),
                'name' => $remappedData->pull('name'),
                'email' => $remappedData->pull('email'),
                'phone' => $remappedData->pull('phone'),
                'description' => $remappedData->map(fn ($value, $key) => str($key)
                    ->slug(separator: ' ')
                    ->ucfirst() . ": {$value}")
                    ->implode("\n"),
            ]);
    }
}
