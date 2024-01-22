<?php

declare(strict_types=1);

namespace App\Repository\PostRepository;

use App\Entity\Post;
use App\Services\Response\PostCollectionResponse;
use Google\Cloud\BigQuery\BigQueryClient;

class BigQueryPostRepository implements PostRepository
{
    private BigQueryClient $bigQueryClient;

    public function __construct()
    {
        $this->bigQueryClient = new BigQueryClient();
    }
    public function find($limit, $offset, $sort) : PostCollectionResponse
    {
        $this->bigQueryClient->dataset('bigquery-public-data.stackoverflow');

        $query = sprintf(
            'SELECT * FROM `bigquery-public-data.stackoverflow.stackoverflow_posts` ORDER BY creation_date %s LIMIT %s OFFSET %s',
            $sort,
            $limit,
            $offset);

        $queryJobConfig = $this->bigQueryClient->query($query);
        $queryResults = $this->bigQueryClient->runQuery($queryJobConfig);


        $response = new PostCollectionResponse();
        foreach ($queryResults as $row) {

            $post = new Post();
            $post->setTitle($row['title']);
            $post->setBody($row['body']);
            $post->setCreatedAt(new \DateTimeImmutable((string)$row['creation_date']));

            $response->addPost($post);
        }

        return $response;
    }
}