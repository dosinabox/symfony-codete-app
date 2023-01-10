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
        //TODO investigate findOneByUuid
        //$this->entityManager->expects($this->once())->method('getRepository')->with(Post::class)->willReturn($this->createMock(PostRepository::class));

        $post = $this->queryHandler->handle(new GetBlogPostByIDQuery($uuid));
        $this->assertEquals('Test post title', $post->getTitle());
        $this->assertEquals('Test post content', $post->getContent());
    }
}
