<?php

namespace App\Services\Response;

use App\Entity\Post;

class PostCollectionResponse
{

    private array $posts = [];

    /**
     * @param Post[] $posts
     */
    public function __construct(array $posts = [])
    {
        foreach ($posts as $post) {
            $this->addPost($post);
        }
    }

    public function addPost(Post $post): void
    {
        $this->posts[] = $post;
    }

    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    public function toArray(): array
    {
        $posts = [];
        foreach ($this->posts as $post) {
            $posts[] = $post->__toArray();
        }
        return $posts;
    }

}