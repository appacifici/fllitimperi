<?php

namespace AppBundle\Service\WidgetService;

class CoreTopAffiliations {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {     
        $limit      = !empty( $options->limitNews ) ? $options->limitNews : 3; 
        $topAffiliations   = $this->wm->doctrine->getRepository('AppBundle:Affiliation')->findBy( 
            array( 'isTop' => 1), array(), $limit 
        );
        
        return array( 
            'topAffiliations'       => $topAffiliations,
        );
    } 
}