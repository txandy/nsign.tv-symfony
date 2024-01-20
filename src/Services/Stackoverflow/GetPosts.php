<?php

declare(strict_types=1);

namespace App\Services\Stackoverflow;

use App\Repository\PostRepository\PostRepository;
use App\Services\Response\PostCollectionResponse;
use App\Services\Stackoverflow\Exception\LimitMustBePositiveException;
use App\Services\Stackoverflow\Exception\SortAcceptedParamsException;

readonly class GetPosts
{
    public function __construct(private PostRepository $postRepository)
    {

    }

    /**
     * @throws LimitMustBePositiveException|SortAcceptedParamsException
     */
    public function __invoke(int $limit, int $offset, string $sort): PostCollectionResponse
    {
        if ($limit <= 0) {
            throw new LimitMustBePositiveException('Limit must be numeric and greater than 0');
        }

        if(!in_array($sort, ['ASC', 'DESC'])) {
            throw new SortAcceptedParamsException('Sort must be ASC or DESC');
        }

        return $this->postRepository->find($limit, $offset, $sort);
    }
}