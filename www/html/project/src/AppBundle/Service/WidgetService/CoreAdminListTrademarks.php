<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListTrademarks {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
//        if ( !$this->wm->getPermissionCore('trademark', 'read' ) )
//                return array();
        $aTrademarks = array();
        
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
        
        $trademarks       = $this->wm->doctrine->getRepository('AppBundle:Trademark')->findTrademarksWithLimit( $pagination->getLimit() );
        $countTrademarks  = $this->wm->doctrine->getRepository('AppBundle:Trademark')->countTrademarks();
        
        foreach ( $trademarks as $trademark ) {
            $aTrademarks[] = $trademark;
        }
        
        $pagination->init( $countTrademarks['tot'] ); 
        $paginationArt = $pagination->makeList();
        
        return array(
            'trademarks' => $aTrademarks,
            'pagination' => $paginationArt
        );
    }
}