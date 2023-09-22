<?php

namespace AppBundle\Service\WidgetService;

class CoreTopTrademarks {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {     
        $limit      = !empty( $options->limitNews ) ? $options->limitNews : 3; 
        $topTrademarks   = $this->wm->doctrine->getRepository('AppBundle:Trademark')->getTopTrademarks( $limit );
        $styleImgTrademarks = array();
        
        foreach ($topTrademarks as $topTrademark) {
            $styleImgTrademarks[$topTrademark->getIdTrademark()] = $this->wm->imageUtility->resizeImg('250', '200', $topTrademark->getWidth(), $topTrademark->getHeight() );
        }
        
        return array( 
            'topTrademarks'       => $topTrademarks,
            'styleImgTrademarks' => $styleImgTrademarks
        );
    } 
}