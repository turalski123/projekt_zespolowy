<?php

namespace App\Controller\API\V1;

use App\Document\User;
use App\Document\EmailSchedule;
use App\DTO\EmailScheduleDTO;
use App\Exception\ValidationException;
use App\Repository\EmailScheduleRepository;
use App\Response\ApiResponse;
use App\Response\PaginatedApiResponse;
use App\Service\EmailScheduleService;
use App\Service\UserService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
     * @var EmailScheduleService
     */
    private EmailScheduleService $emailScheduleService;
    /**
     * @var EmailScheduleRepository
     */
    private EmailScheduleRepository $emailScheduleRepository;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var Security
     */
    private Security $security;

    /**
     * RegisterController constructor.
     * @param EmailScheduleService $emailScheduleService
     * @param EmailScheduleRepository $emailScheduleRepository
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param Security $security
     */
    public function __construct(
        EmailScheduleService $emailScheduleService,
        EmailScheduleRepository $emailScheduleRepository,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        Security $security
    )
    {
        $this->emailScheduleService = $emailScheduleService;
        $this->emailScheduleRepository = $emailScheduleRepository;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->security = $security;
    }

    /**
     * @Route("/api/v1/email-schedule", methods={"POST"})
     *
     * @OA\RequestBody(
     *     @Model(type=EmailScheduleDTO::class, groups={"emailSchedule_create"})
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="User registered",
     *     @OA\JsonContent(
     *        properties={
     *          @OA\Property(property="success", type="boolean"),
     *          @OA\Property(property="data", type="object", properties={
     *              @OA\Property(property="id", type="string")
     *          }),
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

        return new ApiResponse(
            [
                'id' => $this->emailScheduleService->schedule($emailScheduleDto, $this->security->getUser())
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/api/v1/email-schedule/{id}", methods={"PUT"})
     *
     * @OA\RequestBody(
     *     @Model(type=EmailScheduleDTO::class, groups={"emailSchedule_update"})
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="User updated",
     *     @OA\JsonContent(
     *        properties={
     *          @OA\Property(property="success", type="boolean"),
     *          @OA\Property(property="data", type="object", properties={
     *              @OA\Property(property="id", type="string")
     *          }),
     *          @OA\Property(property="errors", example=null)
     *        }
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Email schedule not found"
     * )
     *
     * @throws ValidationException|\Doctrine\ODM\MongoDB\MongoDBException
     */
    public function updateAction(string $id, Request $request): Response
    {
        $emailScheduleDto = $this->serializer->deserialize(
            $request->getContent(),
            EmailScheduleDTO::class,
            'json'
        );
        if (($violations = $this->validator->validate($emailScheduleDto))->count() > 0) {
            throw new ValidationException($violations);
        }

        $emailSchedule = $this->emailScheduleRepository->findOneBy([
            'id' => $id,
            'owner' => $this->security->getUser()
        ]);

        if (null === $emailSchedule) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return new ApiResponse(
            [
                'id' => $this->emailScheduleService->update(
                    $emailSchedule,
                    $emailScheduleDto
                )
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/v1/email-schedule", methods={"GET"})
     *
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="page number",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="limit records per page",
     *     @OA\Schema(type="integer")
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Email schedule list",
     *     @OA\JsonContent(
     *        properties={
     *          @OA\Property(property="success", type="boolean"),
     *          @OA\Property(property="data", type="object", properties={
     *              @OA\Property(property="page", type="integer"),
     *              @OA\Property(property="limit", type="integer"),
     *              @OA\Property(property="count", type="integer"),
     *              @OA\Property(property="items", type="array", items=@OA\Items(ref=@Model(type=EmailScheduleDTO::class, groups={"emailSchedule_list"})))
     *          }),
     *          @OA\Property(property="errors", example=null)
     *        }
     *     )
     * )
     */
    public function fetchListAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 10);
        /** @var User $user */
        $user = $this->security->getUser();

        $emailSchedules = $this->emailScheduleRepository->findAllPaginatedForUser(
            ['createdAt' => 'DESC'],
            ($page - 1) * $limit,
            $limit,
            $user
        );

        return new PaginatedApiResponse(
            $page,
            $limit,
            $this->emailScheduleRepository->countAllForUser(
                $user
            ),
            $this->serializer->normalize(
                $emailSchedules->toArray(),
                null,
                [
                    AbstractNormalizer::GROUPS => ['emailSchedule_list']
                ]
            ),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/v1/email-schedule/{id}", methods={"GET"})
     *
     * @OA\Response(
     *     response=200,
     *     description="Email schedule detail",
     *     @OA\JsonContent(
     *        properties={
     *          @OA\Property(property="success", type="boolean"),
     *          @OA\Property(property="data", ref=@Model(type=EmailScheduleDTO::class, groups={"emailSchedule_detail"})),
     *          @OA\Property(property="errors", example=null)
     *        }
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Email schedule not found"
     * )
     */
    public function fetchDetailAction(string $id)
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $emailSchedule = $this->emailScheduleRepository->findOneBy([
            'id' => $id,
            'owner' => $user
        ]);

        if (null === $emailSchedule) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return new ApiResponse(
            $this->serializer->normalize(
                EmailScheduleDTO::fromEntity($emailSchedule)
            ),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/v1/email-schedule/{id}", methods={"DELETE"})
     *
     * @OA\Response(
     *     response=200,
     *     description="Email schedule deleted",
     *     @OA\JsonContent(
     *        properties={
     *          @OA\Property(property="success", type="boolean"),
     *          @OA\Property(property="data", type="object", properties={
     *              @OA\Property(property="id", type="string")
     *          }),
     *          @OA\Property(property="errors", example=null)
     *        }
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Email schedule not found"
     * )
     */
    public function deleteAction(string $id)
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $emailSchedule = $this->emailScheduleRepository->findOneBy([
            'id' => $id,
            'owner' => $user
        ]);

        if (null === $emailSchedule) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return new ApiResponse(
            [
                'id' => $this->emailScheduleService->delete($emailSchedule)
            ],
            Response::HTTP_OK
        );
    }
}
