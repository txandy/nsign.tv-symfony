<?php

declare(strict_types=1);

namespace App\Repository\PostRepository;

use App\Services\Response\PostCollectionResponse;

interface PostRepository
{
    public function find($limit, $offset, $sort): PostCollectionResponse;
}