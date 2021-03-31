<?php

namespace App\DTO;

use App\Document\Recipient;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class RecipientDTO
{
    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="Name of recipient",
     *     example="Foo"
     * )
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_update",
     *      "emailSchedule_create"
     * })
     */
    private string $name;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="Surname of recipient",
     *     example="Bar"
     * )
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     *
     * @Groups({
     *      "emailSchedule_detail",
     *      "emailSchedule_update",
     *      "emailSchedule_create"
     * })
     */
    private string $surname;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="Email address of recipient",
     *     example="supercontact@meail.com"
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
     *      "emailSchedule_update",
     *      "emailSchedule_create"
     * })
     */
    private string $email;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return RecipientDTO
     */
    public function setName(string $name): RecipientDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return RecipientDTO
     */
    public function setSurname(string $surname): RecipientDTO
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return RecipientDTO
     */
    public function setEmail(string $email): RecipientDTO
    {
        $this->email = $email;
        return $this;
    }

    public static function fromEntity(Recipient $recipient)
    {
        $dto = new self();

        return $dto
            ->setName($recipient->getName())
            ->setEmail($recipient->getEmail())
            ->setSurname($recipient->getSurname());
    }
}
