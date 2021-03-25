<?php

namespace App\DTO;

use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
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
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
