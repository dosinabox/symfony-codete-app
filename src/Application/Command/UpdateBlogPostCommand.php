<?php

namespace App\Application\Command;

use Webmozart\Assert\Assert;

class UpdateBlogPostCommand
{
    public function __construct(public string $title, public string $content, public array $tags, public int $id)
    {
        assert(!is_null($this->title));
        assert(!is_null($this->content));
        Assert::allAlpha($tags);
    }
}
