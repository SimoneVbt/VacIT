<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use App\Service\UserService;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserServiceCommand extends Command
{
    private $us;

    public function __construct(UserService $us)
    {
        parent::__construct();
        $this->us = $us;
    }


    protected function configure()
    {
        $this->setName('app:import-user')
            ->setDescription('Imports a new user from an Excel spreadsheet')
            ->setHelp('This command creates a new user from an Excel spreadsheet')
            ->addArgument('file', InputArgument::REQUIRED, 'spreadsheet')
        ;
    }

    
    protected function execute(InputInterface $input,
                                OutputInterface $output)
    {
        $inputFileName = $input->getArgument('file');
        $spreadsheet = IOFactory::load("public/uploads/".$inputFileName);

        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        for ($i = 2; $i < $highestRow ; $i++){
            $params = array(
                "email" => $worksheet->getCell('A'.$i)->getValue(),
                "wachtwoord" => $worksheet->getCell('B'.$i)->getValue(),
                "naam" => $worksheet->getCell('C'.$i)->getValue(),
                "telefoonnummer" => $worksheet->getCell('D'.$i)->getValue(),
                "adres" => $worksheet->getCell('E'.$i)->getValue(),
                "postcode" => $worksheet->getCell('F'.$i)->getValue(),
                "plaats" => $worksheet->getCell('G'.$i)->getValue(),
                "afbeelding" => $worksheet->getCell('H'.$i)->getValue(),
                "tekst" => $worksheet->getCell('I'.$i)->getValue(),
                "roles" => array("ROLE_EMPLOYER")
            );

            $data = $this->us->saveUser($params);
            $output->writeln($params['email']." importeren gelukt");
        }
    }
}

