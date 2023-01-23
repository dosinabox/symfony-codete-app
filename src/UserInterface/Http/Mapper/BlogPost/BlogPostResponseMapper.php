<?php

namespace App\UserInterface\Http\Mapper\BlogPost;

use App\Entity\Post;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class BlogPostResponseMapper
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function map(Post $post): array
    {
        return [
            'id'        => $post->getId(),
            'uuid'      => $post->uuid,
            'title'     => $post->getTitle(),
            'content'   => $post->getContent(),
            'author'    => $post->getAuthor()->getUserName(),
            'tags'      => $post->getTags()->map(fn (Tag $tag): string =>
            $tag->getName())->toArray(),
        ];
    }

    public function serialize(Post $post): Response
    {
        return new Response($this->serializer->serialize($this->map($post), 'json'));
    }
}
