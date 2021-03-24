<?php


namespace App\Response;


use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct(
            [
                'success' => $status >= 200 && $status < 300,
                'data' => $data,
                'error' => null
            ],
            $status,
            $headers,
            $json
        );
    }
}
