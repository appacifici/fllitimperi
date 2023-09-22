<?php

namespace AppBundle\Service\WidgetService;


class CoreReplaceWidgetAjax {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $option = false ) {   
        $varAttrAjax = !empty( $option->varAttrAjax ) ? $option->varAttrAjax : false;
        return array(
            'varAttrAjax' => $varAttrAjax
        );
        
    }
    
}
