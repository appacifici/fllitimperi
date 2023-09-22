<?php

namespace AppBundle\Service\WidgetService;
use AppBundle\Service\UserUtility\UserManager;

class CoreAdminListQuestion {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager, UserManager $userManager ) {
        $this->wm = $widgetManager;
        $this->um = $userManager;
    }
    
    public function processData( $options = false ) {
                      
                //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('article', 'read' ) )
                return array();
                            
            
            $params = $this->wm->getAllParamsFromGetRequest();
            
            if( !isset( $params['status'] ) ) {
                $params['status'] = 1;
            }
            
            $listQuestions          = $this->wm->doctrine->getRepository('AppBundle:Question')->findAll();
           
          
        return array(
            'listQuestions'   => $listQuestions,
                      
        );
    }
     
}