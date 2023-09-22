<?php

namespace AppBundle\Service\WidgetService;
use AppBundle\Service\FormService\FormManager;

class CoreAdminExternalUsers {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager, FormManager $formManager ) {
        $this->wm = $widgetManager;   
        $this->formManager      = $formManager;  
    }
    
    public function processData( $options = false ) {        
        $users             = $this->wm->doctrine->getRepository('AppBundle:ExternalUser')->findAll();
        
        return array(
            'users'          => $users
        );
    }
     
}