<?php

namespace AppBundle\Service\WidgetService;

class CoreAdminManagerMenus {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
        
        
    }
    
    public function processData( $options = false ) {
        $aSubcatTypologiesNew      = array();
        $allSubcategoriesName   = array();
        $aSubByCat              = array();
        $allCategoriesName      = array();
        
        $allCategories          = $this->wm->doctrine->getRepository('AppBundle:Category')->findAllCategories();
        
        foreach ( $allCategories as $category ) {
           $allCategoriesName[$category->getId()]['name']   = $category->getName(); 
           $allCategoriesName[$category->getId()]['id']     = $category->getId();           
        }
        
        $allSubcategories               = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAllSubcategories();
        
        //Ciclo tutte le sottocategorie e le loro tipologie e ne creo un array per categoria
        $x = 0;
        foreach ( $allSubcategories as $subcategory ) {
           $allSubcategoriesName[$subcategory->getId()]['name']    = $subcategory->getName();
           $allSubcategoriesName[$subcategory->getId()]['id']      = $subcategory->getId();           
           
           if( !empty( $subcategory->getCategory() ) ) {

                $aSubByCat[$subcategory->getCategory()->getId()][$x]['id']      = $subcategory->getId();
                $aSubByCat[$subcategory->getCategory()->getId()][$x]['name']    = $subcategory->getName();
                $aSubByCat[$subcategory->getCategory()->getId()][$x]['entity']   = 'Subcategory';
                $x++;

                foreach ($subcategory->getTypology() as $typology ) {
                    $aSubByCat[$subcategory->getCategory()->getId()][$x]['id']       = $typology->getId();
                    $aSubByCat[$subcategory->getCategory()->getId()][$x]['name']     = $typology->getName();
                    $aSubByCat[$subcategory->getCategory()->getId()][$x]['entity']   = 'Typology';
                    $x++;
                }
                //Riordino in ordine alfabetico l'array appena creato di sottocategorie e tipologie
                usort( $aSubByCat[$subcategory->getCategory()->getId()],function($a, $b){ return strcmp( ucfirst( $a["name"] ), ucfirst( $b["name"] ) ); } );
           }
        }
        
        $subcategories                  = $this->wm->doctrine->getRepository('AppBundle:Menu')->getMenuSubcategories();
        foreach ( $subcategories as $item ) {
            $aMenu2[] = $item;
        }
        
        $subCatMenu3        = $this->wm->doctrine->getRepository('AppBundle:Menu')->getMenuByPosition( 3 );
        foreach ( $subCatMenu3 as $item ) {
            $aMenu3[] = $item;
        }
        
        $categories             = $this->wm->doctrine->getRepository('AppBundle:Menu')->getMenuByPosition( 1 );
        foreach ( $categories as $category ) {
           $aMenu1[] = $category;
           $aSubcatTypologiesNew[$category->getCategory()->getId()] = array();
        }
        
        $subcatTypologiesOfMainMenu= $this->wm->doctrine->getRepository('AppBundle:Menu')->getSubcatTypologiesByParentIdNotNull();
        foreach ( $subcatTypologiesOfMainMenu as $subcatTypology ) { 
            if( !empty( $subcatTypology->getSubcategory() ) )
                $aSubcatTypologiesNew[$subcatTypology->getParentId()][$subcatTypology->getId()] = $subcatTypology->getSubcategory()->getName();
            else if ( !empty ( $subcatTypology->getTypology() ) )
                $aSubcatTypologiesNew[$subcatTypology->getParentId()][$subcatTypology->getId()] = $subcatTypology->getTypology()->getName();
        }
        
        return array(
            'mainMenu'                              => ( !empty( $aMenu1 ) ?  $aMenu1  :  null  ),
            'subcategories'                         => ( !empty( $aMenu2 ) ?  $aMenu2  :  null  ),
            'subcategoriesOfTopRightMenu'           => ( !empty( $aMenu3 ) ?  $aMenu3  :  null  ),
            'allCategories'                         => ( !empty( $allCategoriesName ) ?  $allCategoriesName  :  null  ),
            'allSubcategories'                      => ( !empty( $allSubcategoriesName ) ?  $allSubcategoriesName  :  null  ),
            'subcategoriesOfMainMenu'               => ( !empty( $aSubcatTypologiesNew ) ?  $aSubcatTypologiesNew  :  null  ),
            'aSubByCat'                             => ( !empty( $aSubByCat ) ?  $aSubByCat  :  null  )
        );
    }    
}
