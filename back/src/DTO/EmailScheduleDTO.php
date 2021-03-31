<?php

namespace App\DTO;

use App\Document\EmailSchedule;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class EmailScheduleDTO
{
    /**
     * @var string
     * @OA\Property(
     *     description="Email Schedule ID",
     *     type="string"
     * )
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_list"
     * })
     */
    private string $id;

    /**
     * @var string
     * @OA\Property(
     *     description="Email from",
     *     type="string"
     * )
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     * @Assert\Email()
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_list",
     *      "emailSchedule_update",
     *      "emailSchedule_create"
     * })
     */
    private ?string $from;

    /**
     * @var bool
     * @OA\Property(
     *     description="Definies if message was sent to queue",
     *     type="boolean"
     * )
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_list"
     * })
     */
    private bool $isSent;

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
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_list",
     *      "emailSchedule_update",
     *      "emailSchedule_create"
     * })
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
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_list",
     *      "emailSchedule_update",
     *      "emailSchedule_create"
     * })
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
     * @Assert\Valid()
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_update",
     *      "emailSchedule_create"
     * })
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
     * @Assert\Valid()
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_update",
     *      "emailSchedule_create"
     * })
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
     * @param string $name
     * @return EmailScheduleDTO
     */
    public function setName(string $name): EmailScheduleDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getScheduledOn(): string
    {
        return $this->scheduledOn;
    }

    /**
     * @param string $scheduledOn
     * @return EmailScheduleDTO
     */
    public function setScheduledOn(string $scheduledOn): EmailScheduleDTO
    {
        $this->scheduledOn = $scheduledOn;
        return $this;
    }

    /**
     * @return RecipientDTO[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @param RecipientDTO[] $recipients
     * @return EmailScheduleDTO
     */
    public function setRecipients(array $recipients): EmailScheduleDTO
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * @return EmailDTO
     */
    public function getEmail(): EmailDTO
    {
        return $this->email;
    }

    /**
     * @param EmailDTO $email
     * @return EmailScheduleDTO
     */
    public function setEmail(EmailDTO $email): EmailScheduleDTO
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @param null|string $from
     * @return EmailScheduleDTO
     */
    public function setFrom(?string $from): EmailScheduleDTO
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return EmailScheduleDTO
     */
    public function setId(string $id): EmailScheduleDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsSent(): bool
    {
        return $this->isSent;
    }

    /**
     * @param bool $isSent
     * @return EmailScheduleDTO
     */
    public function setIsSent(bool $isSent): EmailScheduleDTO
    {
        $this->isSent = $isSent;
        return $this;
    }

    public static function fromEntity(EmailSchedule $emailSchedule)
    {
        $dto = new self();

        return $dto
            ->setId($emailSchedule->getId())
            ->setName($emailSchedule->getName())
            ->setFrom($emailSchedule->getFrom())
            ->setIsSent($emailSchedule->isSent())
            ->setRecipients($emailSchedule->getRecipients()->map(function ($item) { return RecipientDTO::fromEntity($item); })->toArray())
            ->setEmail(EmailDTO::fromEntity($emailSchedule->getEmail()))
            ->setScheduledOn($emailSchedule->getScheduledOn()->format(\DateTime::ATOM));
    }
}
