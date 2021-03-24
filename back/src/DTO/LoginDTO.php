<?php

namespace App\DTO;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class LoginDTO
{
    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="username used to login an User",
     *     example="superuser21"
     * )
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     */
    private string $username;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="password used to login an User",
     *     example="my.secret.password#312"
     * )
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     */
    private string $password;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
