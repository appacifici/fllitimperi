<?php

namespace AppBundle\Service\GlobalConfigService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Environment as Environment;
use AppBundle\Menu\Menu;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpFoundation\Session\Session; 
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author alessandro pacifici
 */
class RedirectService {
    
    protected $twig;    
    protected $container;    
    protected $requestStack;    
    protected $request;       
    
    /**
     * Metodo costruttore della classe che instanzia anche la classe padre
     */
    public function __construct( 
            Environment $twig,
            RequestStack $requestStack,
            Container $container,
            EntityManager $entityManager
    ) {
        
        $this->twig             = $twig;
        $this->requestStack     = $requestStack;
        $this->container        = $container;        
        $this->entityManager    = $entityManager;
        $this->request          = $this->requestStack->getCurrentRequest();          
    }
    
    /**
     * Metodo che avvia la redirect di una url se trovata nei match
     * @param type $catSubcatTypology
     */
    public function checkRedirectDB() {        
        $requestUri = $this->request->server->get('REQUEST_URI');
                
       
        $redirect = $this->entityManager->getRepository('AppBundle:Redirect')->findOneByOriginalUrl( $requestUri );
        if( !empty( $redirect ) && !empty( $redirect->getNewUrl() ) ) {
            $newRequestUri =  $redirect->getNewUrl();       
            
            $this->location301( $newRequestUri );
            exit;
        }
        
    }
    
    /**
     * Metodo che avvia la redirect di una url se trovata nei match
     * @param type $catSubcatTypology
     */
    public function checkRedirect( $catSubcatTypology ) {        
        $requestUri = $this->request->server->get('REQUEST_URI');
                
        //Rewrite per le url dei tv
        if( preg_match('/\/audio_video\/tv_video/s', $requestUri ) || preg_match('/\/audio_video/s', $requestUri ) ) {
            $newRequestUri =  str_replace( array('audio_video', 'tv_video'), array('multimedia', 'video'), $requestUri );
            $this->location301( $newRequestUri );
        }                
        
    }
    
    /**
     * Metodo che effeuttua la redirect sulla nuova url 301
     * @param type $newRequestUri
     */
    private function location301( $newRequestUri ) {
        Header( "HTTP/1.1 301 Moved Permanently" );
        header( 'Location: '.$newRequestUri );
        exit;
    }
    
}//End Class