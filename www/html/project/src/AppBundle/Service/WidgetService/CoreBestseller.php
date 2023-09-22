<?php

namespace AppBundle\Service\WidgetService;

class CoreBestseller {
    
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
        $subcategory = !empty( $options->subcategory ) ? $options->subcategory : null;
        $typology = !empty( $options->typology ) ? $options->typology : null;
        
        $label = new \stdClass();
        
        $products = $this->wm->doctrine->getRepository('AppBundle:Product')->getBestsellerProducts( $limitNews, $category, $subcategory, $typology, $trademark, $affiliate );
        
        if( !empty( $category ) ) {
            $label->name = $products[0]->getCategory()->getName();
            $label->nameUrl = $products[0]->getCategory()->getNameUrl();
        }
        
        if( !empty( $subcategory ) ) {            
            $label->name = $products[0]->getSubcategory()->getName();
            $label->nameUrl = $products[0]->getSubcategory()->getNameUrl();        
        }
        
        if( !empty( $typology ) ) {            
            $label->name = $products[0]->getTypology()->getName();
            $label->nameUrl = $products[0]->getTypology()->getNameUrl();        
        }
        
        return array( 
            'products'      => $products,
            'label'  => $label
        );
    } 
}