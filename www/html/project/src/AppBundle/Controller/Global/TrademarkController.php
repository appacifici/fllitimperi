<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class TrademarkController extends TemplateController {
   
    
    /**
     * Rotta per la lista di una categoria
     * @param Request $request
     * @return Response
     */
    public function listModelsTrademarkAction( Request $request, $trademark = false ) {
        $params = new \stdClass;     
        $this->setParameters();
        $initCatSubcatTypology = explode( '-', $request->get( 'catSubcatTypology' ) );
        $catSubcatTypology = $initCatSubcatTypology[0];      
        
        $routeName = $request->get('_route') == 'AMPlistModelsTrademark' ? 'AMPcatSubcatTypologyProduct' : 'catSubcatTypologyProduct';       
        return $this->redirectToRoute( $routeName, array(
            'catSubcatTypology' => $catSubcatTypology
        ), 301); 
        exit;
        
        $hasModels = false;
        $xml = 'catSubcatTypologyProduct.xml';                      
                          
        if( !empty( $trademark ) ) {
            $trademarksByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'trademarksByName' );
            $trademarkId       = array_key_exists($catSubcatTypology, (array)$trademarksByName) ? $trademarksByName->{$catSubcatTypology}->id : false;
        }
        
        $xml = 'listModelsTrademark.xml';  
        //se è nella url per i prodotti di un solo marchio forse la rotta css
        if( !empty( $trademark ) ) {
            $params = new \stdClass;  
            $params->forceRouteCss = 'listModelsTrademark';
        }

//        $response = new Response();
//        $params->responsePage = $response;        
//        $response->setContent( $this->init( $xml, $request, $params ) );                
//        return $response;        

        return $this->getPageFromHttpCache( $request, $xml, true, $params  );
    }
    
}
