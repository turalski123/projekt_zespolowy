<?php

namespace App\DTO;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as MyAssert;
use App\Document\User;

class RegisterDTO
{
    /**
     * @var string
     * @OA\Property(type="string", description="username used to login an User")
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
     * @OA\Property(type="string", description="password used to login an User")
     *
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="string"
     * )
     */
    private string $password;

    /**
     * @var string
     * @OA\Property(type="string", description="email of the User")
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
