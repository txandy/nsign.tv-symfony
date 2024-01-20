<?php

namespace App\Services\Stackoverflow;

use App\Repository\PostRepository\PostRepository;
use App\Services\Response\PostCollectionResponse;
use App\Services\Stackoverflow\Exception\LimitMustBePositiveException;
use App\Services\Stackoverflow\Exception\SortAcceptedParamsException;
use PHPUnit\Framework\TestCase;

class GetPostsTest extends TestCase
{
    public function testLimitFilterThrowExceptionWithNegativeOrString(): void
    {
        $this->expectException(LimitMustBePositiveException::class);

        $postRepository = $this->createMock(PostRepository::class);
        $getPosts = new GetPosts($postRepository);
        $getPosts->__invoke(0, 0, 'ASC');
        $getPosts->__invoke(-1, 0, 'ASC');
        $getPosts->__invoke('asd', 0, 'ASC');
    }

    public function testLimitFilterMustBeNumberAndPositive(): void
    {
        $this->expectNotToPerformAssertions();

        $postRepository = $this->createMock(PostRepository::class);
        $getPosts = new GetPosts($postRepository);
        $getPosts->__invoke(1, 0, 'ASC');
    }

    public function testSortThrowExceptionWithString(): void
    {
        $this->expectException(SortAcceptedParamsException::class);

        $postRepository = $this->createMock(PostRepository::class);
        $getPosts = new GetPosts($postRepository);
        $getPosts->__invoke(1, 0, 'asdasd');
    }

    public function testSortMustBeASCOrDESC(): void
    {
        $this->expectNotToPerformAssertions();

        $postRepository = $this->createMock(PostRepository::class);
        $getPosts = new GetPosts($postRepository);
        $getPosts->__invoke(1, 0, 'DESC');
        $getPosts->__invoke(1, 0, 'ASC');
    }

    public function testReturnValueIsPostCollectionResponse(): void
    {
        $postRepository = $this->createMock(PostRepository::class);
        $getPosts = new GetPosts($postRepository);
        $element = $getPosts->__invoke(1, 0, 'DESC');

        $this->assertInstanceOf(PostCollectionResponse::class, $element);
    }


}
