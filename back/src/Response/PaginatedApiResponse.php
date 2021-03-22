<?php


namespace App\Response;


class PaginatedApiResponse extends \Symfony\Component\HttpFoundation\JsonResponse
{
    public function __construct(int $page, int $count, array $data, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct(
            [
                'success' => $status >= 200 && $status < 300,
                'data' => [
                    'page' => $page,
                    'count' => $count,
                    'items' => $data
                ],
                'error' => null
            ],
            $status,
            $headers,
            $json
        );
    }
}
