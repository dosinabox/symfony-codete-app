<?php

namespace App\EventListener;

use App\Event\UserCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: UserCreatedEvent::NAME, method: 'onUserCreated')]
final class UserListener
{
    public function __invoke(UserCreatedEvent $event): void
    {
    }

    public function onUserCreated(UserCreatedEvent $event): void
    {
        //dd($event);
    }
}
