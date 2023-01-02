<?php

namespace App\Application\Command;

use Webmozart\Assert\Assert;

class UpdateBlogPostCommand
{
    public function __construct(public string $title, public string $content, public array $tags, public int $id)
    {
        assert(!is_null($this->title), 'Title is missing!');
        assert(!is_null($this->content), 'Content is missing!');
        Assert::allAlpha($tags);
    }
}
