<?php

namespace AppBundle\Service\WidgetService;

class CoreProductSale {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {     
        
        $limitNews = !empty( $options->limitNews ) ? $options->limitNews : 3; 
        $category  = !empty( $options->categoryNews ) ? $options->categoryNews : null; 
        $trademark = !empty( $options->trademark ) ? $options->trademark : null; 
        $affiliate = !empty( $options->affiliation ) ? $options->affiliation : null;
        
        $bestsellerProducts = $this->wm->doctrine->getRepository('AppBundle:Product')->getProductsSale( $limitNews, $category, $trademark, $affiliate );
        
        return array( 
            'products'       => $bestsellerProducts
        );
    } 
}