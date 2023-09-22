<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompressFilesCommand extends ContainerAwareCommand {
    
    protected function configure() {
        $this->setName( 'compressfiles' )
             ->addArgument( 'version', InputArgument::REQUIRED, 'Nome della versione da comprimere' )
             ->setDescription( 'Compressione dei file js e css');
    }
    
    /**
     * Execute the command asking the proper controller to parse the given feed.
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return NULL
     */
    protected function execute( InputInterface $input, OutputInterface $output ) {
        $dataService    = $this->getContainer()->get( 'livescoreServices.CompressFilesService' );

        try {
            $dataService->compress( $input->getArgument( 'version' ) );
        } catch(Exception $e) {
            $output->writeln('Exception thrown with code ' . $e->getCode() . ': ' . $e->getMessage());
        }
    }

}
