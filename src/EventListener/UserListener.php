<?php

namespace App\EventListener;

use App\Event\UserCreatedEvent;
use App\Event\UserDeletedEvent;
use App\Event\UserUpdatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsEventListener(event: UserCreatedEvent::NAME, method: 'onUserCreated')]
#[AsEventListener(event: UserUpdatedEvent::NAME, method: 'onUserUpdated')]
#[AsEventListener(event: UserDeletedEvent::NAME, method: 'onUserDeleted')]
final class UserListener
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function __invoke(UserCreatedEvent $event): void
    {
    }

    public function onUserCreated(UserCreatedEvent $event): void
    {
        $message = 'User ' . $event->user->getId() . ' created: ' .
            $event->user->getFirstName() . ' ' .
            $event->user->getLastName();
        $this->sendEmail($message);
    }

    public function onUserUpdated(UserUpdatedEvent $event): void
    {
        $message = 'User ' . $event->user->getId() . ' updated: ' .
            $event->user->getFirstName() . ' ' .
            $event->user->getLastName();
        $this->sendEmail($message);
    }

    public function onUserDeleted(UserDeletedEvent $event): void
    {
        $message = 'User ' . $event->user->getId() . ' deleted: ' .
            $event->user->getFirstName() . ' ' .
            $event->user->getLastName();
        $this->sendEmail($message);
    }

    private function sendEmail(string $subject): void
    {
        $email = (new Email())
            ->from('admin@codete-app.com')
            ->to('manager@codete-app.com')
            ->subject($subject)
            ->text('Sent by Mailhog!');

        $this->mailer->send($email);
    }
}
