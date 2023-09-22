<?php

namespace AppBundle\Command;

use AppBundle\Controller\SportradarDataController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportDbWordpressCommand extends ContainerAwareCommand {

    protected function configure() {
        $this->setName( 'importDbWordpress' )
            ->setDescription( 'Importa il database di wodpress' )
            //Dati connessione database originario wordpress
            ->addArgument( 'wpHost', InputArgument::REQUIRED, 'Host del db di wordpress' )
            ->addArgument( 'wpUser', InputArgument::REQUIRED, 'User del db di wordpress' )
            ->addArgument( 'wpPsw', InputArgument::REQUIRED, 'Password del db di wordpress' )                
            ->addArgument( 'wpDb', InputArgument::REQUIRED, 'Nome del vecchio database di wordpress')
                
            //Dati database cmsamidn nuovo
            ->addArgument( 'newHost', InputArgument::REQUIRED, 'Host del db di wordpress' )
            ->addArgument( 'newUser', InputArgument::REQUIRED, 'User del db di wordpress' )
            ->addArgument( 'newPsw', InputArgument::REQUIRED, 'Password del db di wordpress' )        
            ->addArgument( 'newDb', InputArgument::REQUIRED, 'Nome del nuovo database' )
            ->addArgument( 'limit', InputArgument::REQUIRED, 'Limite articoli' )
            ->addArgument( 'idMin', InputArgument::REQUIRED, 'Id Minimo Articolo import' )
            ->addArgument( 'envPath', InputArgument::REQUIRED, 'Cartella di lavoro' );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $wpHost         = $input->getArgument( 'wpHost' ); 
        $wpUser         = $input->getArgument( 'wpUser' ); 
        $wpPsw          = $input->getArgument( 'wpPsw'  ); 
        $wpDb           = $input->getArgument( 'wpDb'  ); 
                
        $newHost        = $input->getArgument( 'newHost' ); 
        $newUser        = $input->getArgument( 'newUser' ); 
        $newPsw         = $input->getArgument( 'newPsw'  );
        $newDb          = $input->getArgument( 'newDb'  ); 
        
        $limit        = $input->getArgument( 'limit'  ); 
        $idMin        = $input->getArgument( 'idMin'  ); 
        $envPath        = $input->getArgument( 'envPath'  ); 
        
        $wordpressImportDb = $this->getContainer()->get('app.wordpressImportDb');        
        $wordpressImportDb->init( $wpHost, $wpUser, $wpPsw, $wpDb, $newHost, $newUser, $newPsw, $newDb, $limit, $idMin, $envPath  );
    }
    
} 