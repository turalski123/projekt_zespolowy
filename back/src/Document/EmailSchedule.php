<?php

namespace App\Document;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(repositoryClass=UserRepository::class, collection="User")
 */
class EmailSchedule
{
    use DateTrackingTrait;

    /**
     * @var string
     * @MongoDB\Id(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @var ?DateTime
     * @MongoDB\Field(type="date", nullable=true)
     */
    private $scheduledOn;

    /**
     * @var ArrayCollection
     * @MongoDB\EmbedMany(targetDocument=Recipient::class)
     */
    private $recipients;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->recipients = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return EmailSchedule
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getScheduledOn(): ?DateTime
    {
        return $this->scheduledOn;
    }

    /**
     * @param DateTime|null $scheduledOn
     * @return EmailSchedule
     */
    public function setScheduledOn(?DateTime $scheduledOn): self
    {
        $this->scheduledOn = $scheduledOn;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRecipients(): ArrayCollection
    {
        return $this->recipients;
    }

    /**
     * @param Recipient $server
     * @return EmailSchedule
     */
    public function addRecipients(Recipient $server): self
    {
        $this->recipients->add($server);

        return $this;
    }
}
