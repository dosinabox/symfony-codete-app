<?php

namespace App\Application\Command;

use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class CreateBlogPostCommandHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(CreateBlogPostCommand $command): Post
    {
        $post = new Post();
        $post->setTitle($command->title);
        $post->setContent($command->content);

        foreach ($command->tags as $tagID) {
            //TODO replace
            $repository = $this->entityManager->getRepository(Tag::class);
            $tag = $repository->find($tagID);
            $post->addTag($tag);
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }
}
