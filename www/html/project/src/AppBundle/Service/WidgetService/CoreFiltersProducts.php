<?php

namespace AppBundle\Service\WidgetService;


class CoreFiltersProducts {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function getDataToAjax() {
        
    }
    
    public function processData( $options = false ) {   
        return false;
        $typologies = false;
        $aCatSex = $this->wm->getCatSubcatTypology();        
        if( empty( $aCatSex['catSubcatTypology'] ) ) {
            $aCatSex = $this->wm->getParametersByCustomUrl();
        }
        $sex = !empty( $aCatSex['sex'] ) ? $aCatSex['sex'] : false;
        $catSubcatTypology = $aCatSex['catSubcatTypology'];
        $categoryId     = false;
        $typologyId     = false;
        $subcategoryId  = false;
        $searchItem = !empty($aCatSex['search']) ? true : false;
        
        $subcategories = $this->wm->globalConfigManager->getSubcategories( 'name' );
        $stdTypologies = $this->wm->globalConfigManager->getTypologies( 'name' );

        $hasFilterDonna = $hasFilterUomo = false;
        
        $typologySelectedSex = 'donna,uomo';
        $aListproducts = array();
        if( !empty( $stdTypologies ) && !empty( $stdTypologies->{$catSubcatTypology} ) ) {
            $typologyId = $stdTypologies->{$catSubcatTypology}->id;
            $typology = $this->wm->doctrine->getRepository('AppBundle:Typology')->find( $stdTypologies->{$catSubcatTypology}->id );
            $typologies = $this->wm->doctrine->getRepository('AppBundle:Typology')->findBySubcategory( $typology->getSubcategory()->getId() );
            $subcategory = $typology->getSubcategory(); 
            $subcategoryId = $subcategory->getId();
            if( !empty( $typology->getCategory() ) )
                $categoryId = $typology->getCategory()->getId();            
            $aListproducts['subcategory']   = $subcategory->getNameUrl();         
            
            $hasFilterDonna = strpos( $subcategory->getSex(), 'donna', 0 ) !== false  ? true : false;
            $hasFilterUomo  = strpos( $subcategory->getSex(), 'uomo', 0 ) !== false  ? true : false;
            $typologySelectedSex = $typology->getSex();
        }
        
        
        //Se non ha fatto match con le tipologie etrova lo subcat    
        if( empty( $stdTypologies->{$catSubcatTypology} ) && !empty( $subcategories ) && !empty( $subcategories->{$catSubcatTypology} ) ) {
            $subcategory = $subcategories->{$catSubcatTypology};        
            $typologies = $this->wm->doctrine->getRepository('AppBundle:Typology')->findBySubcategory( $subcategory->id );   
            $subcategoryId = $subcategory->id;
            $aListproducts['subcategory']   = $subcategory->nameUrl;      
            $categoryId = !empty( $typologies ) ? $typologies[0]->getCategory()->getId() : false;
                        
            $hasFilterDonna = strpos( $subcategory->sex, 'donna', 0 ) !== false  ? true : false;
            $hasFilterUomo  = strpos( $subcategory->sex, 'uomo', 0 ) !== false  ? true : false;
            
        }
        
        $aTypologies = array();
        $x = 0;
        if( !empty( $typologies ) ) {            
            foreach( $typologies AS $typology ) {
                if( !empty( $sex ) && strpos( $typology->getSex(), $sex, 0 ) === false )
                    continue;
                        
                if( !empty( $typology->getIsActive() ) && $typology->getHasProducts() > 0 ) {
                    $aListproducts['typology']  = $typology->getNameUrl();
                    $aListproducts['sex']       = $sex;

                    $aTypologies[$x]['id']      = $typology->getId();
                    $aTypologies[$x]['name']    = $typology->getName();
                    
                    if ( $typology->getHasModels() > 0 ) {
                        $aTypologies[$x]['link']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $typology->getNameUrl() ) );
                    } else {
                        $aTypologies[$x]['link']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $typology->getSubcategory()->getNameUrl(), 'typology' => $typology->getNameUrl(), 'sex' => $sex ) );
                    }
                    
//                    $aTypologies[$x]['link']    = $this->wm->routerManager->generate( 'listProduct', $aListproducts );
                    $x++;
                }
            }        
        }        
        
        $filtersActive = $this->wm->globalConfigManager->getFiltersActive();           
        $sizes  = $this->wm->globalConfigManager->getSizes();
        $colors = $this->wm->globalConfigManager->getColors();
               
        foreach( $sizes AS &$size ) {                        
            $size->activeFilter = false;
            if( !empty( $filtersActive['sizes'] ) && in_array( trim( $size->name ) , $filtersActive['sizes'] ) ) {
                $size->activeFilter = true;                
            }
        }        
               
        foreach( $colors AS &$color ) {                        
            $color->activeFilter = false;            
            if( !empty( $filtersActive['colors'] ) && in_array( trim( strtolower( $color->name ) ) , $filtersActive['colors'] ) ) {
                $color->activeFilter = true;                
            }
        }    
        
//        $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( $categoryId, $subcategoryId, $typologyId, 'listProduct', $aCatSex['sex'] );
        
        $this->wm->twig->addGlobal( 'filtersActive' , $filtersActive );
        $this->wm->twig->addGlobal( 'typologiesFilter' , $aTypologies );
        $this->wm->twig->addGlobal( 'categoryId' , $categoryId );
        $this->wm->twig->addGlobal( 'hasFilterDonna' , $hasFilterDonna );
        $this->wm->twig->addGlobal( 'hasFilterUomo' , $hasFilterUomo );
        $this->wm->twig->addGlobal( 'typologySelectedSex' , $typologySelectedSex );
        $this->wm->twig->addGlobal( 'searchItem' , $searchItem );
//        $this->wm->twig->addGlobal( 'searchTerms', $aSearchTerms );
        
        
        
        return array( 
            'filtersActive' => $filtersActive,
            'typologiesFilter' => $aTypologies,
            'categoryId' => $categoryId,
            'hasFilterDonna' => $hasFilterDonna,
            'hasFilterUomo' => $hasFilterUomo,
            'typologySelectedSex' => $typologySelectedSex,
            'searchItem' => $searchItem,
        );

    }
}
