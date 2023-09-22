<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class ArticleController extends TemplateController {
      
    /**
    * @Route("/amp/guida_acquisto/{baseArticle}/{title}", name="AMPdetailNews2")          
    * @Route("/amp/guida_acquisto/{title}", name="AMPdetailNews1")          
    * @Route("/amp/recensione/{title}", name="AMPdetailNews3")          
    * @Route("/guida_acquisto/{baseArticle}/{title}", name="detailNews2")          
    * @Route("/guida_acquisto/{title}", name="detailNews1")          
    * @Route("/recensione/{title}", name="detailNews3")          
    */
    public function indexAction( $title, Request $request ) {                  
        $this->setParameters();
        
        $params = new \stdClass;  
        $params->forceRouteCss = 'detailNews';        
        return $this->getPageFromHttpCache( $request, "detailNews.xml", true, $params  );        
    }     
    
    /**    
    * @Route("/amp/guida_acquisto/{section1}", name="AMPlistArticles1")
    * @Route("/amp/recensione/{section1}", name="AMPlistArticles2")
    * @Route("/guida_acquisto/{section1}", name="listArticles1")
    * @Route("/recensione/{section1}", name="listArticles2")
    */
    public function listArticlesAction( $catSubcatTypology = null,  Request $request, $section1 = false, $megazineSection = false ) {  
        
        //VERIFICA SE è PRESENTE UNO SLASH ALLA FINE DELLA URL IN CASO FA LA 301 ALLA NUOVA URL
        $aUrl = parse_url( $request->server->get( 'REQUEST_URI' ) );
        $lastChar = substr( $aUrl['path'], 0 -1 );
        if( $lastChar == '/' ) {
            $query   = empty( $aUrl['query'] ) ? '' : '?'.$aUrl['query'];
            $newUrl  = rtrim($aUrl['path'], '/').$query;
            Header( "HTTP/1.1 301 Moved Permanently" ); 
            Header( "Location: $newUrl " ); 
            exit;
        }        
        
        $this->setParameters();        
        $params = new \stdClass; 
        $params->forceRouteCss = 'listArticles';   
        //recupera la risposta e la setta in cache        
        
        return $this->getPageFromHttpCache( $request, "listArticles.xml", true, $params  );        
    }
    
    /**
    * @Route( "/all/list/polls", name="listPolls" )     
    */
    public function listPollsAction( Request $request ) { 
        $response   = new Response();        
        $params     = new \stdClass;
        $params->controllerPage  = 'listPolls';  
        
        //Da passare se si vuol far gestire ai core l'header della pagina not found
        $params->responsePage             = $response;
        
        $html =  $this->init( "listPolls.xml", $request, $params );          
        $response->setContent( $html );
        return $response;
    }
    
}
