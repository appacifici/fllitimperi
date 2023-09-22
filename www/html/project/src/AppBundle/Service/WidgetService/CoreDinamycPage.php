<?php

namespace AppBundle\Service\WidgetService;

class CoreDinamycPage {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData() {     
        $page                     = $this->wm->getPage();    
        $dinamycPage              = $this->wm->doctrine->getRepository('AppBundle:DinamycPage')->findOneByPage( $page );
        if( empty( $dinamycPage ) ) {
            return array();
        }
//        
//        $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', $metaTitle );
//        $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', $metaDesc );                
//        $this->wm->container->get( 'twig' )->addGlobal( 'pagekwds', '' );                
//        $this->wm->container->get( 'twig' )->addGlobal( 'ogUrl', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );        
        
        
        $newBody = str_replace( 'http://', 'https://', $dinamycPage->getBody() );
        
        
        
        $dinamycPage->setBody( $newBody );
        
        
        
        return array( 
            'dinamycPage' => $dinamycPage,
        );
    } 
}