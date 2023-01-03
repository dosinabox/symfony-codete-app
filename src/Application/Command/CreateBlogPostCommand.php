<?php

namespace App\Application\Command;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class CreateBlogPostCommand
{
    public function __construct(public ?string $title, public ?string $content, public array $tags, public User $author, public Uuid $uuid)
    {
        assert(!is_null($this->title), 'Title is missing!');
        assert(!is_null($this->content), 'Content is missing!');
        Assert::allAlpha($tags);
    }
}
