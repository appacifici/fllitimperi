<?php

namespace AppBundle\Service\WidgetService;


class CoreSeoH1ListArticles_Template {
    
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
        
        $h1 = false;
        
        if( !empty( $category ) && !empty( $category->getMetaTitle() ) ) {
            $h1 = $category->getMetaTitle();
        }
        
        if( !empty( $subcategoryUrlName ) ) {
            $h1 = 'Notizie ' .ucfirst( $subcategoryUrlName ). ' calcio aggiornate 24H';
        }
        
        if( $categoryName == 'mercato' && !empty( $subcategoryUrlName ) ) {
            $h1 = ucfirst( str_replace( 'mercato', 'Calciomercato', $categoryName ) ). ' '.ucfirst( $subcategoryUrlName ). ' - News e Approfondimenti in tempo reale';
        }
        
        return array( 'h1' => $h1 );
    }
    
    
}
