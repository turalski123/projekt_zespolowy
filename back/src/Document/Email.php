<?php

namespace App\Document;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\EmbeddedDocument()
 */
class Email
{
    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({
     *      "emailSchedule_detail"
     * })
     */
    private $title;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({
     *      "emailSchedule_detail"
     * })
     */
    private $message;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Email
     */
    public function setTitle(string $title): Email
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
     * @return Email
     */
    public function setMessage(string $message): Email
    {
        $this->message = $message;
        return $this;
    }
}
