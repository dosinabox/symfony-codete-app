<?php

namespace App\UserInterface\Http\BlogPosts;

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
