<?php

namespace App\Application\Command;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class UpdateBlogPostCommandHandler
{
    public function __construct(
        private readonly GetBlogPostByIDQueryHandler $queryHandler,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(UpdateBlogPostCommand $command): Post
    {
        $post = $this->queryHandler->handle(new GetBlogPostByIDQuery($command->id));
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
