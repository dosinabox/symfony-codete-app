<?php

namespace App\Application\Command;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class UpdateBlogPostCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(UpdateBlogPostCommand $command): Post
    {
        $post = $this->queryBus->dispatch(new GetBlogPostByIDQuery($command->uuid))
            ->last(HandledStamp::class)
            ->getResult();

        $post->setTitle($command->title);
        $post->setContent($command->content);
        $post->removeTags();

        foreach ($command->tags as $tagName) {
            $repository = $this->entityManager->getRepository(Tag::class);
            $tag = $repository->findOrCreate($tagName);

            $post->addTag($tag);
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }
}
