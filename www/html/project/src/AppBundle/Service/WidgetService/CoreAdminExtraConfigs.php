<?php

namespace AppBundle\Service\WidgetService;

class CoreAdminExtraConfigs {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
        
        
    }
    
    public function processData( $options = false ) {
        $extraConfigs =  $this->wm->doctrine->getRepository('AppBundle:ExtraConfig')->findAll();
                
        return array(
           
            'extraConfigs'          => $extraConfigs
            
        );
    }
     
}