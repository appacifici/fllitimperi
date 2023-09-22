<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class HomeController extends TemplateController {
    
    /**
     * @Route( "/", name="homepage" )          
     * @Route( "/amp/", name="AMPhomepage" )          
     */
    public function indexAction( Request $request ) {            
        
//        $response = new Response( $this->init( "homepage.xml", $request, $params ) );
//        return $response;
        
        $this->get('twig')->addGlobal('hedearBig', true );
        $this->get('twig')->addGlobal('allCategoriesProductLink', true );
        
        return $this->getPageFromHttpCache( $request, 'homepage.xml' );
          
    }   
        
}