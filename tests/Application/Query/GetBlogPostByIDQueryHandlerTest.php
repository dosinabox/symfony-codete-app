<?php

namespace App\Tests\Application\Query;

use App\Application\Query\GetBlogPostByIDQuery;
use App\Application\Query\GetBlogPostByIDQueryHandler;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Uid\Uuid;

class GetBlogPostByIDQueryHandlerTest extends TestCase
{
    private GetBlogPostByIDQueryHandler $queryHandler;

    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->queryHandler = new GetBlogPostByIDQueryHandler($this->entityManager);
    }

    public function testHandle()
    {
        $uuid = Uuid::fromString('fc3b0519-6fc9-4461-9b63-44b7e05b9678');
        $repository = $this->createMock(PostRepository::class);

        $post = new Post($uuid);
        $post->setTitle('Test post title');
        $post->setContent('Test post content');

        $this->entityManager->expects($this->once())->method('getRepository')->with(Post::class)->willReturn($repository);
        $repository->expects($this->once())->method('findOneByUuid')->with($uuid)->willReturn($post);

        $handledPost = $this->queryHandler->__invoke(new GetBlogPostByIDQuery($uuid));
        $this->assertSame($handledPost, $post);
        $this->assertEquals('Test post title', $handledPost->getTitle());
        $this->assertEquals('Test post content', $handledPost->getContent());
    }
}
