<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListBlogPostByTagController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(string $tagName): JsonResponse
    {
        $postsRepository = $this->entityManager->getRepository(Post::class);
        $collection = $postsRepository->findByTag($tagName);
        $postsCollection = $collection->map(fn (Post $post): array => [
            'id'        => $post->getId(),
            'title'     => $post->getTitle(),
            'author'    => $post->getAuthor()->getUserName(),
            'tags'      => $post->getTags()->map(fn (Tag $tag): string =>
            $tag->getName())->toArray(),
        ]);

        return $this->json($postsCollection->toArray());
    }
}
