<?php

namespace AppBundle\Service\WidgetService;

class CoreWidgetMenu {
     
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {          
        $menu1              = $this->wm->doctrine->getRepository('AppBundle:Menu')->getMenuByPosition( 1, true );                
        $menu1SubcatTypo    = $this->wm->doctrine->getRepository('AppBundle:Menu')->getAllSubCatTypologiesByPosition( true );        
        
//        $menu2              = $this->wm->doctrine->getRepository('AppBundle:Menu')->getMenuSubcategories( 2, true );                
//        $menu3              = $this->wm->doctrine->getRepository('AppBundle:Menu')->getMenuByPosition( 3, true );
        
        $aMenu1             = array();
        $aMenu1SubcatTypo   = array();        
        $aMenu2             = array();
        $aMenu3             = array();
        
        foreach ( $menu1 as $category ) {
            $category->getCategory()->url = $this->wm->container->get('router')->generate(
                'catSubcatTypologyProduct',
                array('section1' => $category->getCategory()->getNameUrl())
            );
            $aMenu1[] = $category->getCategory();
        }
        
        foreach ( $menu1SubcatTypo as $subCatTypology ) {
            if( !empty( $subCatTypology->getSubcategory() ) )
                $aMenu1SubcatTypo[$subCatTypology->getParentId()][] = $subCatTypology->getSubcategory();
            else
                $aMenu1SubcatTypo[$subCatTypology->getParentId()][] = $subCatTypology->getTypology();
        }
        
//        foreach ( $menu2 as $itemSubcategory ) {
//            $aMenu2[$itemSubcategory->getId()] = $itemSubcategory->getSubcategory();
//        }
//        
//        foreach ( $menu3 as $category ) {
//            $aMenu3[] = $category->getCategory(); 
//        }
                
        return array( 
            'menu3'                 => $aMenu3,     
            'menu2'                 => $aMenu2,  
            'menu1'                 => $aMenu1,      
            'menu1Sub'              => $aMenu1SubcatTypo,      
            
            
        );
    } 
}