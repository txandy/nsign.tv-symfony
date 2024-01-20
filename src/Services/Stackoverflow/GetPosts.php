<?php

declare(strict_types=1);

namespace App\Services\Stackoverflow;

use App\Repository\PostRepository\PostRepository;
use App\Services\Response\PostCollectionResponse;
use App\Services\Stackoverflow\Exception\LimitMustBePositiveException;
use App\Services\Stackoverflow\Exception\OffsetMustBePositiveException;
use App\Services\Stackoverflow\Exception\SortAcceptedParamsException;

readonly class GetPosts
{
    public const string ASC = 'ASC';
    public const string DESC = 'DESC';

    public function __construct(private PostRepository $postRepository) {}

    /**
     * @throws LimitMustBePositiveException|SortAcceptedParamsException|OffsetMustBePositiveException
     */
    public function __invoke(int $limit, int $offset, string $sort): PostCollectionResponse
    {
        if ($limit <= 0) {
            throw new LimitMustBePositiveException('Limit must be numeric and greater than 0');
        }

        if ($offset < 0) {
            throw new OffsetMustBePositiveException('Offer must be numeric and greater than 0');
        }

        if(!in_array($sort, [self::ASC, self::DESC])) {
            throw new SortAcceptedParamsException(sprintf('Sort must be %s or %s', self::ASC, self::DESC));
        }

        return $this->postRepository->find($limit, $offset, $sort);
    }
}