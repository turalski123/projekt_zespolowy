<?php


namespace App\Service;


use App\Document\User;
use App\DTO\RegisterDTO;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserService constructor.
     * @param DocumentManager $documentManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        DocumentManager $documentManager,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->documentManager = $documentManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param RegisterDTO $registerDto
     * @return string
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function register(RegisterDTO $registerDto)
    {
        $user = new User();
        $user
            ->setUsername($registerDto->getUsername())
            ->setEmail($registerDto->getEmail())
            ->setPassword(
                $this->passwordEncoder->encodePassword($user, $registerDto->getPassword())
            );

        $this->documentManager->persist($user);
        $this->documentManager->flush();

        return $user->getId();
    }
}
