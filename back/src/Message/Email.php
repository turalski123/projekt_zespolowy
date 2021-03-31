<?php

namespace App\Message;

use App\DTO\RecipientDTO;

final class Email
{
    private string $from;
    private string $title;
    private string $message;
    /** @var RecipientDTO[]  */
    private array $recipients;

    /**
     * Email constructor.
     * @param string $from
     * @param string $title
     * @param string $message
     * @param RecipientDTO[] $recipients
     */
    public function __construct(string $from, string $title, string $message, array $recipients)
    {
        $this->from = $from;
        $this->title = $title;
        $this->message = $message;
        $this->recipients = $recipients;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

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

    /**
     * @return RecipientDTO[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
