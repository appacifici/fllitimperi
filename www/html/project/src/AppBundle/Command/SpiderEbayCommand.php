<?php

namespace AppBundle\Command;

use AppBundle\Controller\SportradarDataController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SpiderEbayCommand extends ContainerAwareCommand {

    protected function configure() {
         $this 
            ->setName('spiderEbay') 
            ->setDescription('gestisce il db')
            ->addArgument('action', InputArgument::REQUIRED, 'Azione da lanciare');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $manageDb= $this->getContainer()->get('app.spiderEbay');
        $action = $input->getArgument('action');                   
        
        $dbHost = $this->getApplication()->getKernel()->getContainer()->getParameter('database_host');
        $dbName = $this->getApplication()->getKernel()->getContainer()->getParameter('database_name');
        $dbUser = $this->getApplication()->getKernel()->getContainer()->getParameter('database_user');
        $dbPswd = $this->getApplication()->getKernel()->getContainer()->getParameter('database_password');
        $dbPort = $this->getApplication()->getKernel()->getContainer()->getParameter('database_port');
        
//        sara bianca anna
        $manageDb->run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $action  );
    }
    
} 