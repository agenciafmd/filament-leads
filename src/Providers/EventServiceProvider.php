<?php

declare(strict_types=1);

namespace Agenciafmd\Leads\Providers;

use Agenciafmd\Leads\Listeners\CreateLead;
use Agenciafmd\Postal\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

final class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! class_exists(NotificationSent::class)) {
            return;
        }

        Event::listen(
            NotificationSent::class,
            CreateLead::class
        );
    }

    public function register(): void
    {
        //
    }
}
