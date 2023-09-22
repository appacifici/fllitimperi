<?php

namespace AppBundle\Command;

use AppBundle\Controller\SportradarDataController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UtilityAppCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('utilityApp')
                ->setDescription('Invia i dati all\'applicazione')
                ->addArgument('action', InputArgument::REQUIRED, 'Azione da lanciare')
                ->addArgument('day', InputArgument::REQUIRED, 'Azione da lanciare')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $utilityApp = $this->getContainer()->get('livescoreServices.UtilityApp');
        $action = $input->getArgument('action'); 
        $day = $input->getArgument('day'); 
        
        switch( $action  ) {
            case 'deleteDevicesEndedMatches':
                $utilityApp->deleteDevicesEndedMatches( $day );
            break;
        }
        
    }
    
}