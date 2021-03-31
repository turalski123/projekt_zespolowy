<?php

namespace App\DTO;

use App\Document\Email;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class EmailDTO
{
    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="Email title",
     *     example="Lorem Ipsum."
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
    private string $title;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="Email main text content with escape charslike '\n'",
     *     example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eget lorem vitae urna interdum interdum ac tincidunt nisi. Duis aliquam maximus nulla, sit amet posuere enim tristique sed. Duis imperdiet aliquet nibh, vel finibus elit mollis et. Nulla a accumsan lorem, nec sodales lorem."
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
    private string $message;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return EmailDTO
     */
    public function setTitle(string $title): EmailDTO
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return EmailDTO
     */
    public function setMessage(string $message): EmailDTO
    {
        $this->message = $message;
        return $this;
    }

    public static function fromEntity(Email $email)
    {
        $dto = new self();

        return $dto
            ->setTitle($email->getTitle())
            ->setMessage($email->getMessage());
    }
}
