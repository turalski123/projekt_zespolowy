<?php

namespace App\Controller\API\V1;

use App\Exception\ValidationException;
use App\Response\ApiResponse;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\DTO\EmailScheduleDTO;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RegisterController
 * @package App\Controller\API\V1
 * @OA\Tag(name="Email Schedule")
 */
class EmailScheduleController extends AbstractController
{
    /**
     * @var UserService
     */
    private UserService $userService;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * RegisterController constructor.
     * @param UserService $userService
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(
        UserService $userService,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    )
    {
        $this->userService = $userService;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/v1/email-schedule", methods={"POST"})
     *
     * @OA\RequestBody(
     *     @Model(type=EmailScheduleDTO::class)
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="User registered",
     *     @OA\JsonContent(
     *        properties={
     *          @OA\Property(property="success", type="boolean"),
     *          @OA\Property(property="data", type="string"),
     *          @OA\Property(property="errors", example=null)
     *        }
     *     )
     * )
     *
     * @throws ValidationException|\Doctrine\ODM\MongoDB\MongoDBException
     */
    public function createAction(Request $request): Response
    {
        $emailScheduleDto = $this->serializer->deserialize(
            $request->getContent(),
            EmailScheduleDTO::class,
            'json'
        );
        if (($violations = $this->validator->validate($emailScheduleDto))->count() > 0) {
            throw new ValidationException($violations);
        }
dd($emailScheduleDto);
        return new ApiResponse(
            [
                'id' => $this->userService->register($emailScheduleDto)
            ],
            Response::HTTP_CREATED
        );
    }
}
