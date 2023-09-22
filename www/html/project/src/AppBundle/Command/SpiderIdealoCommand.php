<?php

namespace AppBundle\Command;

use AppBundle\Controller\SportradarDataController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SpiderIdealoCommand extends ContainerAwareCommand {

    protected function configure() {
         $this
            ->setName('spiderIdealo')
            ->setDescription('avvia il recupero modelli da idealo')
            ->addArgument('action', InputArgument::REQUIRED, 'Azione da lanciare')
            ->addOption('fkCatgory', null, InputOption::VALUE_OPTIONAL, 'Id Catgory', '' )
            ->addOption('fkSubcatgory', null, InputOption::VALUE_OPTIONAL, 'Id SUbcategory', '' )
            ->addOption('fkTypology', null, InputOption::VALUE_OPTIONAL, 'Id typology', '' )
            ->addOption('url', null, InputOption::VALUE_OPTIONAL, 'Url', '' );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $manageDb= $this->getContainer()->get('app.spiderIdealo');
        $action = $input->getArgument('action');               
        $fkCatgory = $input->getOption('fkCatgory');               
        $fkSubcatgory = $input->getOption('fkSubcatgory');               
        $fkTypology = $input->getOption('fkTypology');               
        $url = $input->getOption('url');               
        
        $dbHost = $this->getApplication()->getKernel()->getContainer()->getParameter('database_host');
        $dbName = $this->getApplication()->getKernel()->getContainer()->getParameter('database_name');
        $dbUser = $this->getApplication()->getKernel()->getContainer()->getParameter('database_user');
        $dbPswd = $this->getApplication()->getKernel()->getContainer()->getParameter('database_password');
        $dbPort = $this->getApplication()->getKernel()->getContainer()->getParameter('database_port');
        
        $manageDb->run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $action, $fkCatgory, $fkSubcatgory, $fkTypology, $url  );
    }
    
} 