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
            $posts = (new GetPosts($this->postRepository))((int)$limit, (int)$offset, (string)$sort);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ], $e->getCode());
        }

        return $this->json([
            'posts' => $posts->toArray()
        ]);
    }
}
