<?php

namespace AppBundle\Service\WidgetService;


class CoreSeoH1ListArticles {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
   
    
    public function processData( $option = false ) {    
        $categoryName = $this->wm->getUrlCategory();
        $subcategoryUrlName = $this->wm->getUrlSubcategory();
                
        $category   = $this->wm->doctrine->getRepository( 'AppBundle:Category' )->findOneByNameUrl($categoryName);           
        $subcategory   = $this->wm->doctrine->getRepository( 'AppBundle:Subcategory' )->findOneByNameUrl($subcategoryUrlName);           
        
        $h1 = false;
        
        if( !empty( $category ) && !empty( $category->getMetaTitle() ) ) {
            $h1 = $category->getMetaTitle();
        }
        
        if( !empty( $subcategory ) && !empty( $subcategory->getMetaTitle() ) ) {
            $h1 = $subcategory->getMetaTitle() ;
        }
                
        return array( 'h1' => $h1 );
    }
    
    
}
