<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class AboutUsController extends TemplateController {
    
    /**
     * @Route( "/chi-siamo", name="aboutUs" )          
     * @Route( "/amp/chi-siamo", name="AMPAboutUs" )          
     */
    public function AboutUsAction( Request $request ) {                            
        $this->get('twig')->addGlobal('hedearBig', true );
        $this->get('twig')->addGlobal('allCategoriesProductLink', true );
        
        return $this->getPageFromHttpCache( $request, 'aboutUs.xml' );
          
    }   
         
}