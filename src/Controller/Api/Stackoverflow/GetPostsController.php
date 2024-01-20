<?php

namespace App\Controller\Api\Stackoverflow;

use App\Repository\PostRepository\PostRepository;
use App\Services\Stackoverflow\GetPosts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Google\Cloud\BigQuery\BigQueryClient;

class GetPostsController extends AbstractController
{
    public function __construct(private readonly PostRepository $postRepository)
    {

    }
    #[Route('/api/stackoverflow/get-posts', name: 'app_api_stackoverflow_get_posts')]
    public function index(Request $request): JsonResponse
    {
        // Filters
        $limit = $request->query->get('limit', 10);
        $offset = $request->query->get('offset', 0);
        $sort = $request->query->get('sort', 'DESC');

        // Get posts
        try {
            $posts = (new GetPosts($this->postRepository))((int)$limit, (int) $offset, (string) $sort);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'posts' => $posts->toArray()
        ]);



        /*$bigQuery = new BigQueryClient();
        $query = <<<ENDSQL
SELECT
  CONCAT(
    'https://stackoverflow.com/questions/',
    CAST(id as STRING)) as url,
  view_count
FROM `bigquery-public-data.stackoverflow.posts_questions`
WHERE tags like '%google-bigquery%'
ORDER BY view_count DESC
LIMIT 10;
ENDSQL;
        $queryJobConfig = $bigQuery->query($query);
        $queryResults = $bigQuery->runQuery($queryJobConfig);

        if ($queryResults->isComplete()) {
            $i = 0;
            $rows = $queryResults->rows();
            foreach ($rows as $row) {
                printf('--- Row %s ---' . PHP_EOL, ++$i);
                printf('url: %s, %s views' . PHP_EOL, $row['url'], $row['view_count']);
            }
            printf('Found %s row(s)' . PHP_EOL, $i);
        } else {
            throw new \Exception('The query failed to complete');
        }

        die;*/

        $bigQuery = new BigQueryClient();
// Get an instance of a previously created table.

        $dataset = $bigQuery->dataset('bigquery-public-data.stackoverflow');
        //$table = $dataset->table('stackoverflow_posts');


// Run a query and inspect the results.
        $queryJobConfig = $bigQuery->query(
            'SELECT * FROM `bigquery-public-data.stackoverflow.stackoverflow_posts` LIMIT 10'
        );
        $queryResults = $bigQuery->runQuery($queryJobConfig);

        foreach ($queryResults as $row) {
            dump($row);
        }

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/Stackoverflow/GetPostsController.php',
        ]);
    }
}
