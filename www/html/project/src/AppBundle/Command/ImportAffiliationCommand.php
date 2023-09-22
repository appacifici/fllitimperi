<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportAffiliationCommand extends ContainerAwareCommand
{
    protected function configure() 
    {
        $this
            ->setName('deamonAffiliation')
            ->setDescription('Importa un affiliazione')
            ->addArgument('typeImport', InputArgument::REQUIRED, 'Tipo di file da leggere')
            ->addArgument('id', InputArgument::REQUIRED, 'Id dell\'affiliato da parsare')
            ->addArgument('pathFile', InputArgument::REQUIRED, 'Path dove scaricare i file')
            ->addArgument('importOnlySection', InputArgument::REQUIRED, 'Importare solo le sezioni del feed')
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Limite', '' );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importOnlySection  = false;
        $deamonAffiliation  = $this->getContainer()->get('app.deamonAffiliation');
        $id                 = $input->getArgument('id');               
        $typeImport         = $input->getArgument('typeImport');               
        $pathFile           = $input->getArgument('pathFile');               
        $limit              = $input->getOption('limit');               
        $importOnlySection  = $input->getArgument('importOnlySection');               
        
        $dbHost = $this->getApplication()->getKernel()->getContainer()->getParameter('database_host');
        $dbName = $this->getApplication()->getKernel()->getContainer()->getParameter('database_name');
        $dbUser = $this->getApplication()->getKernel()->getContainer()->getParameter('database_user');
        $dbPswd = $this->getApplication()->getKernel()->getContainer()->getParameter('database_password');
        $dbPort = $this->getApplication()->getKernel()->getContainer()->getParameter('database_port');
        $container = $this->getApplication()->getKernel()->getContainer();
        
        $deamonAffiliation->run( $container, $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $limit, $typeImport, $id, $pathFile, $importOnlySection);
    }

}
