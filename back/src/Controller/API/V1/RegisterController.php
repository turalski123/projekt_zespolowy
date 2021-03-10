<?php

namespace App\Controller\API\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\DTO\RegisterDTO;
/**
 * Class RegisterController
 * @package App\Controller\API\V1
 * @OA\Tag(name="Register")
 */
class RegisterController extends AbstractController
{
    /**
     * @Route("/api/v1/register", methods={"POST"})
     *
     * @OA\RequestBody(
     *     @Model(type=RegisterDTO::class)
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="User registered"
     * )
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/API/V1/RegisterController.php',
        ]);
    }
}
