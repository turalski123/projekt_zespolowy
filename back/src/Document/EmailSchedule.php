<?php

namespace App\Document;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

/**
 * @MongoDB\Document(repositoryClass=EmailSchedule::class, collection="EmailSchedule")
 */
class EmailSchedule
{
    use DateTrackingTrait;

    /**
     * @var string
     * @MongoDB\Id(strategy="UUID")
     * @Groups({
     *      "emailSchedule_list",
     *      "emailSchedule_detail"
     * })
     */
    private $id;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({
     *      "emailSchedule_list",
     *      "emailSchedule_detail"
     * })
     */
    private $name;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({
     *      "emailSchedule_list",
     *      "emailSchedule_detail"
     * })
     */
    private $from;

    /**
     * @var ?DateTime
     * @MongoDB\Field(type="date", nullable=true)
     * @Groups({
     *      "emailSchedule_list",
     *      "emailSchedule_detail"
     * })
     *
     * @OA\Property(
     *     type="string",
     *     description="DateTime of email being sent",
     *     example="2021-03-25T12:55:26+00:00"
     * )
     */
    private $scheduledOn;

    /**
     * @var ArrayCollection|PersistentCollection|Recipient[]
     * @MongoDB\EmbedMany(targetDocument=Recipient::class)
     * @Groups({
     *      "emailSchedule_detail"
     * })
     */
    private $recipients;

    /**
     * @var Email
     * @MongoDB\EmbedOne(targetDocument=Email::class)
     * @Groups({
     *      "emailSchedule_detail"
     * })
     */
    private $email;

    /**
     * @var boolean
     * @MongoDB\Field(type="bool")
     * @Groups({
     *      "emailSchedule_list",
     *      "emailSchedule_detail"
     * })
     */
    private $isSent;

    /**
     * @var User|null
     * @MongoDB\ReferenceOne(targetDocument=User::class, inversedBy="emailSchedules")
     */
    private $owner;

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
     * @return PersistentCollection
     */
    public function getRecipients(): PersistentCollection
    {
        return $this->recipients;
    }

    /**
     * @param ArrayCollection $recipients
     * @return EmailSchedule
     */
    public function setRecipients(ArrayCollection $recipients): self
    {
        $this->recipients = $recipients;

        return $this;
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

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @param Email $email
     * @return EmailSchedule
     */
    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSent(): bool
    {
        return $this->isSent;
    }

    /**
     * @param bool $isSent
     * @return EmailSchedule
     */
    public function setIsSent(bool $isSent): EmailSchedule
    {
        $this->isSent = $isSent;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @param null|string $from
     * @return EmailSchedule
     */
    public function setFrom(?string $from): EmailSchedule
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User|null $owner
     * @return EmailSchedule
     */
    public function setOwner(?User $owner): EmailSchedule
    {
        $this->owner = $owner;
        return $this;
    }
}
