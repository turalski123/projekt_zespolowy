<?php

namespace App\Service;

use App\Document\Email;
use App\Document\EmailSchedule;
use App\Document\Recipient;
use App\Document\User;
use App\DTO\EmailScheduleDTO;
use App\DTO\RegisterDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;

class EmailScheduleService
{
    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;

    /**
     * UserService constructor.
     * @param DocumentManager $documentManager
     */
    public function __construct(
        DocumentManager $documentManager
    )
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @param EmailScheduleDTO $emailScheduleDTO
     * @param User $owner
     * @return string
     * @throws MongoDBException
     */
    public function schedule(EmailScheduleDTO $emailScheduleDTO, User $owner)
    {
        $emailSchedule = new EmailSchedule();
        $emailSchedule
            ->setName($emailScheduleDTO->getName())
            ->setEmail(
                (new Email())
                    ->setTitle($emailScheduleDTO->getEmail()->getTitle())
                    ->setMessage($emailScheduleDTO->getEmail()->getMessage())
            )
            ->setScheduledOn(new \DateTime($emailScheduleDTO->getScheduledOn()))
            ->setIsSent(false)
            ->setOwner($owner);

        foreach ($emailScheduleDTO->getRecipients() as $index => $recipient) {
            $emailSchedule->addRecipients(
                (new Recipient())
                    ->setEmail($recipient->getEmail())
                    ->setName($recipient->getName())
                    ->setSurname($recipient->getSurname())
            );
        }

        $this->documentManager->persist($emailSchedule);
        $this->documentManager->flush();

        return $emailSchedule->getId();
    }

    /**
     * @param EmailSchedule $emailSchedule
     * @param EmailScheduleDTO $emailScheduleDTO
     * @return string
     * @throws MongoDBException
     */
    public function update(EmailSchedule $emailSchedule, EmailScheduleDTO $emailScheduleDTO)
    {
        $emailSchedule
            ->setName($emailScheduleDTO->getName())
            ->setEmail(
                (new Email())
                    ->setTitle($emailScheduleDTO->getEmail()->getTitle())
                    ->setMessage($emailScheduleDTO->getEmail()->getMessage())
            )
            ->setScheduledOn(new \DateTime($emailScheduleDTO->getScheduledOn()));

        $recipients = new ArrayCollection();
        foreach ($emailScheduleDTO->getRecipients() as $index => $recipient) {
            $recipients->add(
                (new Recipient())
                    ->setEmail($recipient->getEmail())
                    ->setName($recipient->getName())
                    ->setSurname($recipient->getSurname())
            );
        }
        $emailSchedule->setRecipients($recipients);

        $this->documentManager->flush();
        return $emailSchedule->getId();
    }

    /**
     * @param EmailSchedule $emailSchedule
     * @param EmailScheduleDTO $emailScheduleDTO
     * @return string
     * @throws MongoDBException
     */
    public function delete(EmailSchedule $emailSchedule)
    {
        $this->documentManager->remove($emailSchedule);
        $this->documentManager->flush();

        return $emailSchedule->getId();
    }
}
