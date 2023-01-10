<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateBlogPostCommand;
use App\Application\Command\CreateBlogPostCommandHandler;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use PHPUnit\Framework\MockObject\MockObject;

class CreateBlogPostCommandHandlerTest extends TestCase
{
    private MockObject|EntityManagerInterface $entityManager;

    private MockObject|CreateBlogPostCommandHandler $commandHandler;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->commandHandler = new CreateBlogPostCommandHandler($this->entityManager);
    }

    public function test__invoke()
    {
        $user = new User();
        $user->setFirstName('firstName');
        $user->setLastName('lastName');
        $user->setEmail('email@test.com');
        $user->setPassword('hashedPassword');

        $uuid = Uuid::v4();

        //TODO test tags
        //$tag = new Tag();
        //$tag->setName('cats');

        $post = new Post($uuid);
        $post->setTitle('title');
        $post->setContent('content');
        $post->setAuthor($user);
        //$post->addTag($tag);

        $this->entityManager->expects($this->once())->method('persist')->with($post);
        $this->entityManager->expects($this->once())->method('flush');

        $command = new CreateBlogPostCommand(
            'title', 'content', [], $user, $uuid
        );

        /*$command = new CreateBlogPostCommand(
            'title', 'content', [$tag->getName()], $user, $uuid
        );*/

        $handler = $this->commandHandler;
        $handledPost = $handler($command);

        $this->assertEquals($post, $handledPost);
        $this->assertEquals('title', $handledPost->getTitle());
        $this->assertEquals('content', $handledPost->getContent());
        $this->assertEquals($user, $handledPost->getAuthor());
        $this->assertInstanceOf(Collection::class, $handledPost->getTags());
    }
}
