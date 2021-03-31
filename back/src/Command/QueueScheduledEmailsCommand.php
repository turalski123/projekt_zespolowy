<?php

namespace App\Command;

use App\Document\EmailSchedule;
use App\Message\Email;
use App\Repository\EmailScheduleRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class QueueScheduledEmailsCommand extends Command
{
    protected static $defaultName = 'app:queue:scheduled:emails';
    protected static $defaultDescription = 'Command for putting on queue email which has been scheduled for time of execution';
    /**
     * @var EmailScheduleRepository
     */
    private EmailScheduleRepository $emailScheduleRepository;
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;
    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;

    public function __construct(
        EmailScheduleRepository $emailScheduleRepository,
        MessageBusInterface $messageBus,
        DocumentManager $documentManager
    )
    {
        parent::__construct();
        $this->emailScheduleRepository = $emailScheduleRepository;
        $this->messageBus = $messageBus;
        $this->documentManager = $documentManager;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $emails = $this->emailScheduleRepository->findScheduledAndNotSent();
        /** @var EmailSchedule $email */
        foreach ($emails as $index => $email) {
            $email->setIsSent(true);
            $this->messageBus->dispatch(new Email(
                $email->getFrom(),
                $email->getEmail()->getTitle(),
                $email->getEmail()->getMessage(),
                $email->getRecipients()->toArray()
            ));
        }

        $this->documentManager->flush();
        return Command::SUCCESS;
    }
}
