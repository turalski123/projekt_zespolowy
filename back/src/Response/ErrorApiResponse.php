<?php


namespace App\Response;


use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorApiResponse extends JsonResponse
{
    public function __construct($error, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct(
            [
                'success' => false,
                'data' => null,
                'error' => $error
            ],
            $status,
            $headers,
            $json
        );
    }
}
