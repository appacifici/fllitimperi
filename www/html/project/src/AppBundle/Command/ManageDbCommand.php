<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ManageDbCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('manageDb')
            ->setDescription('gestisce il db')
            ->addArgument('action', InputArgument::REQUIRED, 'Azione da lanciare')
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Limite', '' );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $manageDb= $this->getContainer()->get('app.manageDb');
        $action = $input->getArgument('action');               
        $limit = $input->getOption('limit');               
        
        $dbHost = $this->getApplication()->getKernel()->getContainer()->getParameter('database_host');
        $dbName = $this->getApplication()->getKernel()->getContainer()->getParameter('database_name');
        $dbUser = $this->getApplication()->getKernel()->getContainer()->getParameter('database_user');
        $dbPswd = $this->getApplication()->getKernel()->getContainer()->getParameter('database_password');
        $dbPort = $this->getApplication()->getKernel()->getContainer()->getParameter('database_port');
        $container = $this->getApplication()->getKernel()->getContainer();
        $routerManager = $this->getApplication()->getKernel()->getContainer()->get('app.routerManager');
        
        $manageDb->run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $routerManager, $action, $container, $limit  );
    }

}
