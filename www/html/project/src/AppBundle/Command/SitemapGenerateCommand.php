<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SitemapGenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sitemapGenerate')
            ->setDescription('gestisce le sitemap  del sito')
            ->addArgument('action', InputArgument::REQUIRED, 'Azione da lanciare')
            ->addArgument('regenerate', InputArgument::REQUIRED, 'Rigenerare da capo la sitemap')
            ->addArgument('enabledPing', InputArgument::REQUIRED, 'Rigenerare da capo la sitemap');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sitemap = $this->getContainer()->get('app.sitemap');
        $action = $input->getArgument('action');         
        $regenerate = $input->getArgument('regenerate') == 'true' ? true : false;         
        $enabledPing = $input->getArgument('enabledPing') == 'true' ? true : false;         
    
        $dbHost = $this->getApplication()->getKernel()->getContainer()->getParameter('database_host');
        $dbName = $this->getApplication()->getKernel()->getContainer()->getParameter('database_name');
        $dbUser = $this->getApplication()->getKernel()->getContainer()->getParameter('database_user');
        $dbPswd = $this->getApplication()->getKernel()->getContainer()->getParameter('database_password');
        $dbPort = $this->getApplication()->getKernel()->getContainer()->getParameter('database_port');
        
        $routerManager = $this->getApplication()->getKernel()->getContainer()->get('app.routerManager');
        
        $sitemap->run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $action, $routerManager, $regenerate, $enabledPing );
    }

}
