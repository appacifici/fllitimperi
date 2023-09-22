<?php

namespace AppBundle\Command;

use AppBundle\Controller\SportradarDataController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveTopNewsImgCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('removeTopNewsImg')
                ->setDescription('Rimuove le foto delle Top News pubblicate da più di un mese');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $removeTopNewsImg = $this->getContainer()->get('app.removeTopNewsImg');
        
        $removeTopNewsImg->deleteTopNewsImg();
    }
    
}