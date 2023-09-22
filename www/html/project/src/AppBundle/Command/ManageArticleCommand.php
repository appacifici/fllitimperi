<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ManageArticleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('manageArticle')
            ->setDescription('gestisce gli articoli')
            ->addArgument('action', InputArgument::REQUIRED, 'Azione da lanciare')
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Limite', '' );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $manageArticle= $this->getContainer()->get('app.manageArticle');
        $action = $input->getArgument('action');               
        $limit = $input->getOption('limit');               
        
        $dbHost = $this->getApplication()->getKernel()->getContainer()->getParameter('database_host');
        $dbName = $this->getApplication()->getKernel()->getContainer()->getParameter('database_name');
        $dbUser = $this->getApplication()->getKernel()->getContainer()->getParameter('database_user');
        $dbPswd = $this->getApplication()->getKernel()->getContainer()->getParameter('database_password');
        $dbPort = $this->getApplication()->getKernel()->getContainer()->getParameter('database_port');
        
        $manageArticle->run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $action, $limit  );
    }

}
