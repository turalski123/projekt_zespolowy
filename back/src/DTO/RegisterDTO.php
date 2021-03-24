<?php

namespace App\DTO;

use App\Document\User;
use App\Validator as MyAssert;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterDTO
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
     * @MyAssert\UniqueField(
     *     fieldName="username",
     *     entityClass=User::class
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
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="email of the User",
     *     example="superuser@email.com"
     * )
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     * @Assert\Email()
     * @MyAssert\UniqueField(
     *     fieldName="email",
     *     entityClass=User::class
     * )
     */
    private string $email;

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

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
