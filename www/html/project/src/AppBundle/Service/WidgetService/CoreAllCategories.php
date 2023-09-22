<?php

namespace AppBundle\Service\WidgetService;

class CoreAllCategories {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {
        
        $allCatSubcat = array();
        $categories = $this->wm->doctrine->getRepository('AppBundle:Category')->findAllCategories();
        
        foreach ($categories as $category) {
            $catId = $category->getId();
            $allCatSubcat[$category->getId()]['name']   = utf8_decode( $category->getName() );
            $allCatSubcat[$category->getId()]['url']    = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $category->getNameUrl() ) );
            $allCatSubcat[$category->getId()]['img']    = $this->wm->container->getParameter( 'app.folder_img_category' ).$category->getImg();
            $allCatSubcat[$category->getId()]['hasProducts']    = $category->getHasProducts();
            $x = 0;
            foreach ( $category->getSubcategories() as $key => $subCat ) {
                $x++;
                $typologies = $subCat->getTypology();
                if( $catId != 8  && count( $typologies ) > 0 ) {
                    foreach ( $typologies as $typology ) {

                        if ( $typology->getIsTop() == 1 && ( $typology->getHasProducts() > 0  || $typology->getHasModels() > 0 )) {
                            $allCatSubcat[$category->getId()]['subCatTypology'][$typology->getId()]['name'] = utf8_decode( $typology->getName() );                            
                            $allCatSubcat[$category->getId()]['subCatTypology'][$typology->getId()]['hasProducts']  = $typology->getHasProducts();
                            $allCatSubcat[$category->getId()]['subCatTypology'][$typology->getId()]['isTop']  = $typology->getIsTop();
                            if ( $typology->getHasModels() > 0 ) {
                                $allCatSubcat[$category->getId()]['subCatTypology'][$typology->getId()]['url']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array(
                                    'section1' => $category->getNameUrl(),
                                    'section2' => $subCat->getNameUrl(),
                                    'section3' => $typology->getNameUrl()                                        
                                ) );
                            } else {
                                $allCatSubcat[$category->getId()]['subCatTypology'][$typology->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getnameUrl(), 'typology' => $typology->getNameUrl() ) );                                
                            }
                        }
                    }
                } else {
                    //Se non ci sono le sottotipologie recupera le sottocategorie della categoria
                    if( $subCat->getIsTop() == 1 && ( $subCat->getHasProducts() > 0  || $subCat->getHasModels() > 0 )  ) { 
                        
                        $allCatSubcat[$category->getId()]['subCatTypology'][$subCat->getId()]['name'] =  $subCat->getName() ;                        
                        $allCatSubcat[$category->getId()]['subCatTypology'][$subCat->getId()]['hasProducts']  = $subCat->getHasProducts();
                        $allCatSubcat[$category->getId()]['subCatTypology'][$subCat->getId()]['isTop']  = $subCat->getIsTop();
                        
                        if ( $subCat->getHasModels() > 0 ) {                            
                            $allCatSubcat[$category->getId()]['subCatTypology'][$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $category->getNameUrl(),
                                'subcat' => $subCat->getNameUrl(),
                            ) );
                        } else {
                            if( $category->getId() == $this->wm->container->getParameter( 'categoryIdAbbigliamento' ) ) {
                                if( strpos( $subCat->getSex(), 'donna', 0 ) !== false ) {
                                    $allCatSubcat[$category->getId()]['subCatTypology'][$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getNameUrl(), 'sex' => 'donna' ) );
                                } else {
                                    $allCatSubcat[$category->getId()]['subCatTypology'][$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getNameUrl() ) );
                                }
                                
                            } else {
                                $allCatSubcat[$category->getId()]['subCatTypology'][$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getNameUrl() ) );
                            }
                        }
                    }
                }
            }
        }
        
        $this->wm->twig->addGlobal('h1Section', 'Mappa Categorie');
        return array( 
            'allCatSubcat'      => $allCatSubcat
        );
    } 
}