<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use AppBundle\Service\SitemapService\SitemapNews;

class SitemapController extends TemplateController {
            
    /**
     * Avvia la sitemapnews
     * @param Request $request
     * @return Response
     */
    public function sitemapNewsGoogleAction( Request $request ) {  
        $sitemap = $this->get( 'app.sitemap' );
        $xml = $sitemap->sendGoogleNewsSitemap();
        $response = new Response($xml);
        $response->headers->set('Content-Type', 'xml');
        return $response;
    }   
    
    
    /**
     * Metodo che gestisce l'apertura dei file robots.txt per gli spider
     * @param Request $request
     */
    public function robotsTxtAction( Request $request ) {  
        $this->baseParameters();
        
        if( strpos( $request->server->get( 'HTTP_HOST' ), 'x-diretta.it', '0' ) !== false )  {
            header('Content-Type:text/plain');
            echo file_get_contents( 'templateRobotsXDiretta.txt' );
            exit;
        }
        
        if( strpos( $request->server->get( 'HTTP_HOST' ), 'app.calciomercato.it', '0' ) !== false )  {
            header('Content-Type:text/plain');
            echo file_get_contents( 'templateRobotsAppCalciomercato.txt' );
            exit;
        }
        
        header('Content-Type:text/plain');
        echo file_get_contents( 'templateRobots.txt' );
        exit;
    }   
}

//abase_host (direttagol.cgjtz1nav4zs.eu-west-1.rds.amazonaws.com): localhost
//database_port (3306): 
//database_name (direttagol): livescoreServices
//database_user (dgol_user): root
//database_password (dgol_0e830984): R9UXOvtK
//mailer_transport (smtp): 
 
