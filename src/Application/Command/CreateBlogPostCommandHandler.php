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
        $post->setAuthor($command->author);

        foreach ($command->tags as $tagID) {
            //TODO rework
            //TODO findOrCreate?
            $repository = $this->entityManager->getRepository(Tag::class);
            $tag = $repository->find($tagID);

            if(!$tag) {
                $tag = new Tag();
                $tag->setId($tagID);
                $tag->setName('tag' . $tagID);
                $this->entityManager->persist($tag);
                $this->entityManager->flush();
            }

            $post->addTag($tag);
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }
}
