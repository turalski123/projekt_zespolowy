<?php

namespace App\Command;

use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DatetimeFormatCommand extends Command
{
    protected static $defaultName = 'app:datetime:format';
    protected static $defaultDescription = '';

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('format', InputArgument::REQUIRED, 'Argument description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $format = $input->getArgument('format');

        $io->success(sprintf(
            "time in format %s is: %s",
            $format,
            (new \DateTime())->format($format)
        ));

        return Command::SUCCESS;
    }
}
