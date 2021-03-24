<?php

namespace App\Controller\API\V1;

use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\DTO\LoginDTO;

/**
 * Class RegisterController
 * @package App\Controller\API\V1
 * @OA\Tag(name="Security")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/api/v1/login", methods={"POST"})
     *
     * @OA\RequestBody(
     *     @Model(type=LoginDTO::class)
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="User logged in"
     * )
     */
    public function loginAction(): Response
    {
        return new Response(''); // NO-OP Handler is taking care of it
    }
}
