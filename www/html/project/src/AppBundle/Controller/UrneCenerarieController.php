<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class UrneCenerarieController extends TemplateController {
    
    /**
     * @Route( "/{page}", name="urneCenerarie" )          
     * @Route( "/amp/urne-cenerarie", name="AMPurneCenerarie" )          
     */
    public function BareAction( Request $request ) {                            
        $this->get('twig')->addGlobal('hedearBig', true );
        $this->get('twig')->addGlobal('urnecenerarie', true );        
        return $this->getPageFromHttpCache( $request, 'urnecenerarie.xml' );
          
    }   
        
}