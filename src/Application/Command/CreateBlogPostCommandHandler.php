<?php

namespace App\Application\Command;

use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class CreateBlogPostCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(CreateBlogPostCommand $command): Post
    {
        $post = new Post($command->uuid);
        $post->setTitle($command->title);
        $post->setContent($command->content);
        $post->setAuthor($command->author);

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
