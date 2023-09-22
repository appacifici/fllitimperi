<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomController extends TemplateController {            
    
    /**
     * Gestisce tutte le rotte rimanenti in maniera naturale e custom con php
     * @param Request $request
     * @return Response
     */
    public function customDetectAction( Request $request ) {    
        //Se arriva con nella rotta images/ è un immagine non trovata e faccio exit
        if( strpos( $request->server->get( 'REQUEST_URI' ), '/images', '0' ) !== false  )
           exit;
   
        $route = $this->get( 'app.routerManager' )->match( $request->server->get( 'REQUEST_URI' ) );     
        if( $route['_route'] != 'customRoute' ) {
            $function = $route['_route'].'Action';
            return $this->{$function}( $request );            
        }            
            
        $params = new \stdClass;  
        $params->forceRouteCss = 'listProduct';   
        $resp = $this->init( "notFound.xml", $request, $params );        
        $response =  new Response($resp);  
        $response->setStatusCode(404);        
        return $response;        
    }
    
    /**
     * Motodo rotta per il dettaglio prodotto in comparazione
     * ES: Scheda Prodotto TOP ES: /apple_iphone_8_plus_prezzo
     * @return Response
     */
    public function listProductAction( Request $request ) {
        $params = new \stdClass;  
        $params->forceRouteCss = 'listProduct';            
        
//        $response = new Response();
//        $params->responsePage = $response;        
//        $response->setContent( $this->init( "listProduct.xml", $request, $params ) );                
//        return $response;    
//        
        return $this->getPageFromHttpCache( $request, "listProduct.xml", true, $params  );
    }
       
    /**
     * Motodo rotta per il dettaglio prodotto in comparazione
     * ES: Controllo per la rotta: Marchi Categoria Prezzi: cellulari_apple_prezzi
     * @return Response
     */
    public function categoryTrademarkPricesAction( Request $request) {
        $params = new \stdClass;  
        $params->forceRouteCss = 'categoryTrademarkPrices';            
        
//        $response = new Response();
//        $params->responsePage = $response;        
//        $response->setContent( $this->init( "categoryTrademarkPrices.xml", $request, $params ) );                
//        return $response; 
        
        return $this->getPageFromHttpCache( $request, "categoryTrademarkPrices.xml", true, $params  );
    }
    
}