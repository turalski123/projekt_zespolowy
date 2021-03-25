<?php

namespace App\DTO;

use OpenApi\Annotations as OA;
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
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
