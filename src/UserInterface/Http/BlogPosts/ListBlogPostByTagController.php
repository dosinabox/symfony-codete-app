<?php

namespace App\UserInterface\Http\BlogPosts;

use App\Entity\Post;
use App\UserInterface\Http\Mapper\BlogPost\BlogPostResponseMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListBlogPostByTagController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly BlogPostResponseMapper $mapper)
    {
    }

    public function __invoke(string $tagName): JsonResponse
    {
        $postsRepository = $this->entityManager->getRepository(Post::class);
        $collection = $postsRepository->findByTag($tagName);
        $postsCollection = $collection->map(fn (Post $post): array => $this->mapper->map($post));

        return $this->mapper->serialize($postsCollection->toArray());
    }
}
