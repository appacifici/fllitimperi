<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListFeedsImport {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        
        //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('banner', 'read' ) )
                return array();
        
        //Avvio la paginazione
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
        $pagination->getLimit();
        
        $count = $this->wm->doctrine->getRepository('AppBundle:StatsFeedAffiliation')->findCountAll();        
        $stats = $this->wm->doctrine->getRepository('AppBundle:StatsFeedAffiliation')->findAll( $pagination->getLimit() );        
        
        $pagination->init( $count['tot'], $this->wm->container->getParameter( 'app.toLinksPagination' ) );                        
        $pagination = $pagination->makeList();
        
        $affiliations = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'affiliationById' );        
        
        return array(
            'stats' => $stats,
            'pagination' => $pagination,
            'affiliations' => (array)$affiliations
        );
    }
    
}