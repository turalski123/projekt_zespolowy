<?php

namespace App\Document;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\EmbeddedDocument()
 */
class Recipient
{
    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({
     *      "emailSchedule_detail"
     * })
     */
    private $name;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({
     *      "emailSchedule_detail"
     * })
     */
    private $surname;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({
     *      "emailSchedule_detail"
     * })
     */
    private $email;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Recipient
     */
    public function setName(string $name): Recipient
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
     * @return Recipient
     */
    public function setSurname(string $surname): Recipient
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
     * @return Recipient
     */
    public function setEmail(string $email): Recipient
    {
        $this->email = $email;
        return $this;
    }
}
