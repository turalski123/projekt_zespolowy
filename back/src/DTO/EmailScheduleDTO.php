<?php

namespace App\DTO;

use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\Constraints as Assert;

class EmailScheduleDTO
{
    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="Schedule name",
     *     example="MARKETING | NEW BOOK OF JOHN DOE"
     * )
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     */
    private string $name;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="DateTime of email being sent",
     *     example="2021-03-25T12:55:26+00:00"
     * )
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     */
    private string $scheduledOn;

    /**
     * @var RecipientDTO[]
     * @OA\Property(
     *     type="array",
     *     description="Recipients of scheduled email message",
     *     items=@OA\Items(ref=@Model(type=RecipientDTO::class))
     * )
     *
     * @Assert\NotBlank()
     */
    private array $recipients;

    /**
     * @var EmailDTO
     * @OA\Property(
     *     description="Email object",
     *     ref=@Model(type=EmailDTO::class)
     * )
     *
     * @Assert\NotBlank()
     */
    private EmailDTO $email;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getScheduledOn(): string
    {
        return $this->scheduledOn;
    }

    /**
     * @return RecipientDTO[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @return EmailDTO
     */
    public function getEmail(): EmailDTO
    {
        return $this->email;
    }
}
