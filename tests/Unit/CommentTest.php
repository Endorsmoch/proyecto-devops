<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function comment_has_text(): void
    {
        $comment = factory(Comment::class)->make();
        $text = $comment->text;

        $this->assertNotEmpty($text);
    }
}
