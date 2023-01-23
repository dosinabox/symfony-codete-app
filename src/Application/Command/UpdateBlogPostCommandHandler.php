<?php

namespace App\Application\Command;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateBlogPostCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly GetBlogPostByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(UpdateBlogPostCommand $command): Post
    {
        $post = $this->queryHandler->handle(new GetBlogPostByIDQuery($command->uuid));
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
