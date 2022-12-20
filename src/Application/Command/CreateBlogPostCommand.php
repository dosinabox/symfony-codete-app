<?php

namespace App\Application\Command;

use App\Entity\User;
use Webmozart\Assert\Assert;

class CreateBlogPostCommand
{
    public function __construct(public ?string $title, public ?string $content, public array $tags, public User $author)
    {
        assert(!is_null($this->title));
        assert(!is_null($this->content));
        Assert::allAlpha($tags);
    }
}
