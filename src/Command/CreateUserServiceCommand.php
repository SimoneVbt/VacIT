<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use App\Service\CreateUserService;

class CreateUserServiceCommand extends Command
{
    private $us;

    public function __construct(CreateUserService $us)
    {
        parent::__construct();
        $this->us = $us;
    }

    protected function configure()
    {
        $this->setName('app:create-user')
            ->setDescription('Creates a new user')
            ->setHelp('This command creates a new user')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
        ;
    }
    
    protected function execute(InputInterface $input,
                                OutputInterface $output)
    {
        $output->writeln([
            'User Creator with Service',
            '========================='
        ]);

        $params = array(
            "username" => $input->getArgument('email'),
            "password" => $input->getArgument('password'),
            "email" => $input->getArgument('email'),
        );

        $user = $this->us->createUser($params);
        
        $output->writeln([$user]);
    }
}

