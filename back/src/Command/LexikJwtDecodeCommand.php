<?php

namespace App\Command;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LexikJwtDecodeCommand extends Command
{
    protected static $defaultName = 'lexik:jwt:decode';
    protected static $defaultDescription = 'Command for decoding jwt token, mostly for development purpose';
    /**
     * @var JWTTokenManagerInterface
     */
    private JWTTokenManagerInterface $JWTManager;

    public function __construct(
        JWTTokenManagerInterface $JWTManager
    )
    {
        parent::__construct();
        $this->JWTManager = $JWTManager;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('token', InputArgument::REQUIRED, 'Argument description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $token = $input->getArgument('token');

        $decoded = null;
        try {
            $decoded = $this->JWTManager->decode(
                new JWTUserToken(
                    [],
                    null,
                    $token
                )
            );
        } catch (\Exception $exception) {
            $io->error(sprintf(
                "Token can't be decoded because of error:\n\n%s",
                $exception->getMessage()
            ));
            return Command::FAILURE;
        }

        $io->success("Your decoded JWT token is:");
        dump($decoded);

        return Command::SUCCESS;
    }
}
