<?php

namespace AppBundle\Service\WidgetService;

class CoreAdminListDinamycPages {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('dinamycPage', 'read' ) )
            return array();
            
        $dinamycPages = $this->wm->doctrine->getRepository('AppBundle:DinamycPage')->findAll(); 
          
        return array(
            'dinamycPages'   => $dinamycPages,     
        );
    }
     
}
