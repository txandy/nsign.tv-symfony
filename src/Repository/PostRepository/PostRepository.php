<?php

namespace App\Repository\PostRepository;

use App\Services\Response\PostCollectionResponse;

interface PostRepository
{
    public function find($limit, $offset, $sort): PostCollectionResponse;
}