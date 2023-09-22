<?php

namespace AppBundle\Service\WidgetService;

class CoreCatSubcatTypology {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {
        $parmas = $this->wm->getCatSubcatTypology();
        $trademark = $this->wm->getTrademark();
        $aOtherTrademarks           = array();
        $aSearchTerms               = array();
        $isAbbigliamento            = false;
        $filterAllModelsTrademark   = false;
        
        $catSubcatTypology = $parmas['catSubcatTypology'];
        
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
        $response = $this->globalQueryUtility->getCatSubcatTypology( $catSubcatTypology );
        $allTrademarks = $this->globalQueryUtility->getRedisOrDbTrademarksById( $catSubcatTypology );
        
        $category    = $response->category;
        $subcategory = $response->subcategory;
        $typology    = $response->typology;
        
        if( empty( $category ) &&  empty( $subcategory ) && empty( $typology ) ) {            
            return array( 'errorPage' => 404 );
        }
        
        $allCatSubcatTypology  = array();
        $allModels  = array();
        $section    = array();
        
        if( !empty( $category ) ) {
            if( $category->getId() == 8 )
                $isAbbigliamento = true;
            
            foreach ( $category->getSubcategories() as $subCat ) {
//                echo $subCat->getName().' '.$subCat->getHasProducts()."<br>";
                if ( ( $category->getId() == 8 &&  $subCat->getHasProducts() < 15 ) ) {
                    continue;
                }
                if ( $subCat->getHasProducts() < 1 &&  empty( $subCat->getHasModels() ) ) {
                    continue;
                }
                if ( empty( $subCat->getIsActive()  ) ) {
                    continue;
                }
                
                $allCatSubcatTypology[$subCat->getId()]['id'] = $subCat->getId() ;
                $allCatSubcatTypology[$subCat->getId()]['name'] = $subCat->getName();
                $allCatSubcatTypology[$subCat->getId()]['img'] = $subCat->getImg();
                //Se è per abbiliamento e moda cambia rotta da generare
                if( $category->getId() == $this->wm->container->getParameter( 'categoryIdAbbigliamento' ) && $subCat->getId() != 205 ) {
                    if( strpos( $subCat->getSex(), 'donna', 0 ) !== false ) {
                        $allCatSubcatTypology[$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getNameUrl(), 'sex' => 'donna' ) );
                    } else {
                        $allCatSubcatTypology[$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getNameUrl() ) );
                    }                    
                } else {
                    $allCatSubcatTypology[$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $subCat->getNameUrl() ) );                    
                }
                $allCatSubcatTypology[$subCat->getId()]['hasProduct']  = $subCat->getHasProducts();
                
                
                //Non stampo le tipologie per abbigliamento e moda perche vanno usato come filtri
                if( $category->getId() != $this->wm->container->getParameter( 'categoryIdAbbigliamento' ) ) {
                    foreach ( $subCat->getTypology() as $typo ) {
//                        echo $typo->getName().' '.$typo->getHasProducts()." ".$typo->getHasModels()."<br>";
                        
                        if ( empty( $typo->getIsActive()  ) ) {
                            continue;
                        }
                        
                        if ( $typo->getHasProducts() > 0 ||  !empty( $typo->getHasModels() ) ) {
                            $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['id'] = $typo->getId();
                            $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['name'] = $typo->getName();                                                        
                            $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['hasProduct']  = $typo->getHasProducts();
                            if ( $typo->getHasModels() > 0 ) {                                
                                $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['url']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $typo->getNameUrl() ) );
                            } else {
                                $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getNameUrl(), 'typology' => $typo->getNameUrl() ) );
                            }
                        }
                    }   
                }
            }
            $this->wm->twig->addGlobal('h1Section', ' '.$category->getName() );
        } else {
            if( !empty( $subcategory ) ) {
                $x = 0;          
                
//                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'typology' => $model->getTypology()->getNameUrl(), 'typologySingular' => $model->getTypology()->getSingularNameUrl() ) );
                
                $trademarks = $this->wm->doctrine->getRepository('AppBundle:TopTrademarksSection')->findBySubcatTypoTrademark( $subcategory->getId(), false );                                          
                
                foreach ( $trademarks as $trademark ) {      
                    $limit = '0,'.$trademark->getLimitModels();
                    $currentTrademarkName = false;
                    
                    $models = $this->wm->doctrine->getRepository('AppBundle:Model')->findModelsBySubcategoryTypologyTrademark( $subcategory->getId(), false, $trademark->getTrademarkId(), $limit );
                    
                    $currentTrademark = $allTrademarks->{$trademark->getTrademarkId()};
                    
                    if( !empty( $models ) ) {
                        $section[$currentTrademark->nameUrl]['sectionName']       = $subcategory->getName();
                        $section[$currentTrademark->nameUrl]['sectionNameUrl']    = $subcategory->getNameUrl();
                        $section[$currentTrademark->nameUrl]['nameTrademark']     = $currentTrademark->name;
                        $section[$currentTrademark->nameUrl]['nameUrlTrademark']  = $currentTrademark->nameUrl;
                    }
                    
                    foreach ( $models as $model ) {
//                        if( empty( $model->getIsTop() ) )
//                            continue;
                        
                        if( $model->getIsCompleted() == 1 || $model->getHasProducts() > 0 ) {
                            $currentTrademarkName = $currentTrademark->nameUrl;
                            if( !empty( $model->getTypology() ) ) {
                                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'typology' => $model->getTypology()->getNameUrl(), 'typologySingular' => $model->getTypology()->getSingularNameUrl() ) );
                            } else {
                                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'subcategory' => $model->getSubcategory()->getNameUrl(), 'subcategorySingular' => $model->getSubcategory()->getSingularNameUrl() ) );
                            }
                        
                            $allModels[$currentTrademark->nameUrl][$x]['id']                  = $model->getId();
                            $allModels[$currentTrademark->nameUrl][$x]['name']                = utf8_decode( $model->getName() );
                            $allModels[$currentTrademark->nameUrl][$x]['url']                 = $urlModel;
                            $allModels[$currentTrademark->nameUrl][$x]['hasProduct']          = $model->getHasProducts();
                            $allModels[$currentTrademark->nameUrl][$x]['isTop']               = $model->getIsTop();                            
                            $allModels[$currentTrademark->nameUrl][$x]['dateImport']          = $model->getDateImport();   
                            $allModels[$currentTrademark->nameUrl][$x]['isCompleted']         = $model->getIsCompleted();   
                            $x++;                                                                 
                        }   
                    }
                    if( !empty( $allModels ) && !empty( $currentTrademarkName ) ) {
                        usort( $allModels[$currentTrademarkName], function($a, $b) { //Sort the array using a user defined function
                            return ( $a['name'] < $b['name']  );
                        });
                    }
                }    
//                
                //Recupera i marchi meno importanti della sezione
                $otherTrademarks = $this->wm->doctrine->getRepository('AppBundle:Model')->findDistinctNameUlrTrademarkModelSubcategoryTypology( $subcategory->getId(), false );                        
                
                foreach( $otherTrademarks AS $other ) {
                    if( empty( $section[$other['nameUrl']] ) ) {
                        $aOtherTrademarks[$other['nameUrl']]['nameUrl']         = $other['nameUrl'];
                        $aOtherTrademarks[$other['nameUrl']]['sectionNameUrl']  = $subcategory->getNameUrl();
                    }
                }
                
                $this->wm->twig->addGlobal('h1Section', 'Modelli migliori marche '.$subcategory->getName() );
                $allListProductsSectionLink = $this->wm->routerManager->generate( 'allListProductsSection', array( 'catSubcatTypology' => $subcategory->getNameUrl() ) );
                $this->wm->twig->addGlobal('allListProductsSectionLink', $allListProductsSectionLink );
                $this->wm->twig->addGlobal('allListProductsSectionLabel', $subcategory->getName() );
                
                $filterAllModelsTrademark = $subcategory->getFilterAllModelsTrademark();
                
            } else if ( !empty( $typology ) ) {
                $x = 0;                                
                
                $trademarks = $this->wm->doctrine->getRepository('AppBundle:TopTrademarksSection')->findBySubcatTypoTrademark( $typology->getSubcategory()->getId(), $typology->getId() );                                          
                foreach ( $trademarks as $trademark ) {
                    if( empty( $trademark->getTrademarkId() ) )
                        continue;
                    
                    $limit = '0,'.$trademark->getLimitModels();
                    $models = $this->wm->doctrine->getRepository('AppBundle:Model')->findModelsBySubcategoryTypologyTrademark( $typology->getSubcategory()->getId(), $typology->getId(), $trademark->getTrademarkId(), $limit );
                    $currentTrademark = $allTrademarks->{$trademark->getTrademarkId()};
                    
                    $currentTrademarkName = false;
                    
                    if( !empty( $models ) ) {                        
                        $section[$currentTrademark->nameUrl]['sectionName']       = $typology->getName();
                        $section[$currentTrademark->nameUrl]['sectionNameUrl']    = $typology->getNameUrl();
                        $section[$currentTrademark->nameUrl]['nameTrademark']     = $currentTrademark->name;
                        $section[$currentTrademark->nameUrl]['nameUrlTrademark']  = $currentTrademark->nameUrl;
                    }
                    
                    foreach ( $models as $model ) {       
                        if( $model->getIsCompleted() == 1 || $model->getHasProducts() > 0 ) {
                            $currentTrademarkName = $currentTrademark->nameUrl;
                            if( !empty( $model->getTypology() ) ) {
                                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'typology' => $model->getTypology()->getNameUrl(), 'typologySingular' => $model->getTypology()->getSingularNameUrl() ) );
                            } else {
                                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'subcategory' => $model->getSubcategory()->getNameUrl(), 'subcategorySingular' => $model->getSubcategory()->getSingularNameUrl() ) );
                            }
                            $allModels[$currentTrademark->nameUrl][$x]['id']              = $model->getId();
                            $allModels[$currentTrademark->nameUrl][$x]['name']            = utf8_decode( $model->getName() );
                            $allModels[$currentTrademark->nameUrl][$x]['url']             = $urlModel;
                            $allModels[$currentTrademark->nameUrl][$x]['hasProduct']      = $model->getHasProducts();
                            $allModels[$currentTrademark->nameUrl][$x]['isTop']           = $model->getIsTop();         
                            $allModels[$currentTrademark->nameUrl][$x]['dateImport']      = $model->getDateImport();   
                            $allModels[$currentTrademark->nameUrl][$x]['isCompleted']     = $model->getIsCompleted();   
                            $x++;
                                                    
                        }
                    }
                    $this->wm->twig->addGlobal('h1Section', 'Modelli migliori marche '.$typology->getName() );
                    $allListProductsSectionLink = $this->wm->routerManager->generate( 'allListProductsSection', array( 'catSubcatTypology' => $typology->getNameUrl() ) );
                    $this->wm->twig->addGlobal('allListProductsSectionLink', $allListProductsSectionLink );
                    $this->wm->twig->addGlobal('allListProductsSectionLabel', $typology->getName() );
                    if( !empty( $allModels ) && !empty( $currentTrademarkName ) ) {
                        usort( $allModels[$currentTrademarkName], function($a, $b) { //Sort the array using a user defined function
                            return ( $a['name'] < $b['name']  );
                        });
                    }
                }
                
                //Recupera i marchi meno importanti della sezione
                $otherTrademarks = $this->wm->doctrine->getRepository('AppBundle:Model')->findDistinctNameUlrTrademarkModelSubcategoryTypology( $typology->getSubcategory()->getId(), $typology->getId() );                          
                foreach( $otherTrademarks AS $other ) {
//                    echo $other['nameUrl']."<br>";                    
                    if( empty( $section[$other['nameUrl']] ) ) {                        
                        $aOtherTrademarks[$other['nameUrl']]['nameUrl']         = $other['nameUrl'];
                        $aOtherTrademarks[$other['nameUrl']]['sectionNameUrl']  = $typology->getNameUrl();
                    }                    
                }
                usort( $aOtherTrademarks, function($a, $b) { //Sort the array using a user defined function
                    return ( $a['nameUrl'] > $b['nameUrl']  );
                });
                
                $filterAllModelsTrademark = $typology->getFilterAllModelsTrademark();
            }
        }            
        
        if( !empty( $category ) ) {
            $sex = $category->getId() == 8 ? 'donna' : false;
            $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( $category->getId(), false, false, 'catSubcatTypologyProduct', $sex );
        }
                
        if( empty( $category ) && !empty( $subcategory ) ) {
            $sex = $subcategory->getCategory()->getId() == 8 ? 'donna' : false;
            $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( false, $subcategory->getId(), false, 'catSubcatTypologyProduct', $sex );
        }
        
        if( empty( $category ) && empty( $subcategory ) ) {
            $sex = !empty( $typology->getCategory() ) &&  $typology->getCategory()->getId() == 8 ? 'donna' : false;
            $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( false, false, $typology->getId(), 'catSubcatTypologyProduct', $sex );
        }        
        
        return array(
            'allCatSubcatTypology' => $allCatSubcatTypology,
            'allModels' => $allModels,
            'section' => $section,
            'aOtherTrademarks' => $aOtherTrademarks,
            'searchTerms' => $aSearchTerms,
            'isAbbigliamento' => $isAbbigliamento,
            'filterAllModelsTrademark' => $filterAllModelsTrademark
        );
    } 
}