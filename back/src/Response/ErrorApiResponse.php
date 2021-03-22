<?php


namespace App\Response;


class ErrorApiResponse extends \Symfony\Component\HttpFoundation\JsonResponse
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
