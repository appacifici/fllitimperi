<?php

namespace AppBundle\Command;

use AppBundle\Controller\SportradarDataController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SpiderPagomenoCommand extends ContainerAwareCommand {

    protected function configure() {
         $this
            ->setName('spiderPagomeno')
            ->setDescription('avvia il recupero modelli da pagomeno')
            ->addArgument('action', InputArgument::REQUIRED, 'Azione da lanciare')
            ->addOption('fkCatgory', null, InputOption::VALUE_OPTIONAL, 'Id Catgory', '' )
            ->addOption('getTop', null, InputOption::VALUE_OPTIONAL, 'getTop', '' );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $manageDb= $this->getContainer()->get('app.spiderPagomeno');
        $action = $input->getArgument('action');               
        $fkCatgory = $input->getOption('fkCatgory');               
        $getTop = $input->getOption('getTop');               
        
        $dbHost = $this->getApplication()->getKernel()->getContainer()->getParameter('database_host');
        $dbName = $this->getApplication()->getKernel()->getContainer()->getParameter('database_name');
        $dbUser = $this->getApplication()->getKernel()->getContainer()->getParameter('database_user');
        $dbPswd = $this->getApplication()->getKernel()->getContainer()->getParameter('database_password');
        $dbPort = $this->getApplication()->getKernel()->getContainer()->getParameter('database_port');
        
        $manageDb->run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $action, $fkCatgory, $getTop  );
    }
    
} 