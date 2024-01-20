<?php

namespace App\Services\Response;

use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class PostCollectionResponseTest extends TestCase
{
    public function testPostCollectionOnlyAcceptPostInConstructor(): void
    {
        $this->expectException(\InvalidArgumentException::class);

       new PostCollectionResponse([
            new Post(),
            new Post(),
            new Post(),
            null,
        ]);
    }

    public function testPostCollectionWithPostInConstructor(): void
    {
        $this->expectNotToPerformAssertions();

        new PostCollectionResponse([
            new Post(),
            new Post(),
            new Post(),
        ]);
    }

    public function testPostCollectionWithEmptyConstructor(): void
    {
        $this->expectNotToPerformAssertions();

        new PostCollectionResponse();
    }

    public function testToArrayReturnElements(): void
    {
        $postCollection = new PostCollectionResponse([
            new Post(),
            new Post(),
            new Post(),
        ]);

        $this->assertEquals(3,count($postCollection->toArray()) );

    }
}
