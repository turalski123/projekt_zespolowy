<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

class RegisterDTO
{
    /**
     * @var string
     * @OA\Property(type="string", description="username used to login an User")
     */
    private string $username;

    /**
     * @var string
     * @OA\Property(type="string", description="password used to login an User")
     */
    private string $password;

    /**
     * @var string
     * @OA\Property(type="string", description="email of the User")
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
