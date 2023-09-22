<?php

namespace AppBundle\Service\WidgetService;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\AmazonService\AmazonApi;


class CoreDetailProduct {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData() {            
        $extraModel = array();
        $products = array();
        $route = $this->wm->container->get('app.routerManager')->match( $this->wm->getRequestUri() );
                
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
        $model = $this->globalQueryUtility->getModelByNameUrl( $route['name'] );       
        

        
        if( empty( $model ) )  {
            return array( 'errorPage' => 404 );
        }
                
        $model->setPeriodViews( $model->getPeriodViews() + 1  );
        $model->setViews( $model->getViews() + 1  );   
        
        $this->wm->doctrine->persist( $model );
        $this->wm->doctrine->flush();
        
        
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totProductDetailList' ) );
        $sectionProductname     =  '';
        $sectionProductNameEnd  =  '';
        $comparisonSectionName  = '';
        
        $parmas = $this->wm->getCatSubcatTypology();
        
        $catSubcatTypology = $parmas['catSubcatTypology'];
        
//        $responseCat = $this->globalQueryUtility->getRedisOrDBCatSubcatTypology( $catSubcatTypology );        
//        $categoryId       = $responseCat->category;
//        $subcategoryId    = $responseCat->subcategory;
//        $typologyId       = $responseCat->typology;
        
        $categoryId       = !empty( $model->getCategory() ) ? $model->getCategory()->getId() : false;
        $subcategoryId    = !empty( $model->getSubcategory() ) ? $model->getSubcategory()->getId() : false;
        $typologyId       = !empty( $model->getTypology() ) ? $model->getTypology()->getId() : false;
        
        
        $subcategory = false;
        $typology = false;

        if( empty( $model ) || ( empty( $subcategory ) && empty( $typology ) && empty( $categoryId ) &&  empty( $subcategoryId ) && empty( $typologyId ) ) ){
            return array( 'errorPage' => 404 );
        }
                
        if( !empty( trim( $model->getMetaH1() ) ) )
            $this->wm->container->get( 'twig' )->addGlobal( 'metaH1DetailModel', $model->getMetaH1() );
        
        
        $pathModel  = $this->wm->container->getParameter( 'app.folder_img_models' );
        
        if( !empty( $model->getImg() ) ) {
            $domain = 'www.'.$this->wm->globalConfigManager->getCurrentDomain();
            $base = 'https://'.str_replace( 'app.', 'www.',$domain);
            $this->wm->container->get( 'twig' )->addGlobal( 'ogImage', $base.$pathModel.$model->getImg() );
        }
        
//        $this->getSeeAlsoLink( $subcategoryId, $typologyId );
        
        //INSERIRE PAGINAZIONE PRODOTTI
//        $products = $this->wm->doctrine->getRepository('AppBundle:Product')->findProductsByModel( $model->getId(), $pagination->getLimit() );        
//        $countProducts = $this->wm->doctrine->getRepository('AppBundle:Product')->countProductsByModel( $model->getId() );
        
        $products = $this->wm->doctrine->getRepository('AppBundle:Product')->findProductsByModel( $model->getId(), 30 );
        $countProducts = 30;
        
        if ( !empty( $products ) )
            $extraModel['saving'] = $this->calculateSaving( $model, $products[0] );
        else
            $extraModel['saving'] = $this->calculateSaving( $model, false );

        //Trick per rimuovere il codice di tracciamento sui prodotti amazon quando siamo noi a navigare
        if( !empty( $products ) && !empty( $_SERVER['HTTP_HOST'] ) ) {
            switch( $_SERVER['HTTP_HOST'] ) {
                case 'tricchetto.homepc.it':
                case 'staging.acquistigiusti.it':
                    foreach( $products AS &$product ) {
                        $deepLink = explode( '?', $product->getDeepLink() );
                        $product->setDeepLink( $deepLink[0] );
                        $product->setImpressionLink( '' );
                    }
                break;
            }
        }
        
        
        $extraModel['technicalSpecifications'] = preg_split( "/;/", $model->getTechnicalSpecifications(), -1, PREG_SPLIT_NO_EMPTY );
                 
//        echo $model->getTecnicalTemplateId();exit;
//        
        $finalTecnical = array();
        $tecnical = explode( ';', $model->getTechnicalSpecifications() );
        $i = 0;
        foreach( $tecnical AS $itemTecnical ) {
            $item = explode( ':', $itemTecnical );           
            if( empty(  $item[0] ) )
                continue;
            
            $val2 = !empty( $item[2] ) ? ':'.$item[2] : '';
            
            $finalTecnical[$i]['name'] = $item[0]; 
            $finalTecnical[$i]['value'] = !empty( $item[1] ) ? ucfirst( $item[1].$val2 ) : ''; 
            $finalTecnical[$i]['isLabel'] = !empty( $item[1] ) ?  false : true; 
            $i++;
        }
        $extraModel['technicalSpecifications'] = $finalTecnical ;
        $extraModel['technicalSpecifications'] = $this->replaceDictionary( $extraModel['technicalSpecifications'], $model );
        

//        print_r( $finalTecnical );
//        $aTecnicals = $this->wm->globalConfigManager->getTecnicalTemplates();
//        $getTecnicalTemplateId = !empty( $aTecnicals[$model->getTecnicalTemplateId()] ) ? $aTecnicals[$model->getTecnicalTemplateId()] : false;
//        $extraModel['technicalSpecifications'] = $this->wm->globalUtility->getTecnicalTemplates( $getTecnicalTemplateId, $model->getTechnicalSpecifications() );
//        $extraModel['bulletPoints'] = $this->wm->globalUtility->getBulletPoints( $getTecnicalTemplateId, $extraModel['technicalSpecifications'] );
//        if( empty( $extraModel['bulletPoints'] ) )
            $extraModel['bulletPoints'] = preg_split( "/;/", $model->getBulletPoints(), -1, PREG_SPLIT_NO_EMPTY );
        
        $sectionPreProductName = '';
        $sectionProductNameEnd = '';  
        
        $comparisonSectionName = ucfirst( $model->getSubcategory()->getName() ); 
        
        $sectionProductName = ucfirst( $model->getSubcategory()->getSingularName() );                
        if( !empty( $model->getTypology() ) ) {
            $sectionProductName = ucfirst( $model->getTypology()->getSingularName() );
            $comparisonSectionName = ucfirst( $model->getTypology()->getName() ); 
        }
        
        if( empty( $sectionProductName ) ) {
//            $sectionProductNameEnd = 'Offerte';      
            $sectionPreProductName = '';
        }
        
        $filterSimilarModels = $model->getSubcategory()->getFilterSimilarModels();
        if( !empty( $model->getTypology() ) ) {
            $filterSimilarModels = $model->getTypology()->getFilterSimilarModels();
        }

        $this->wm->container->get( 'twig' )->addGlobal( 'catSubcatTypologySearch', strtolower( $model->getCategory()->getName() ) );
        $this->wm->container->get( 'twig' )->addGlobal( 'search', $model->getName() );
        
        $finalComparison = false;
        //Recupera i modelli in comparazione con questo dettaglio modello
        $x = 0;
//        if( !empty( $model->getComparisonModels() ) ) {
//            $comparisonModels = $this->globalQueryUtility->getModelsComparison( $model->getComparisonModels() );             
//            foreach( $comparisonModels As $comparisonModel ) {
//                $indexModel  = $comparisonModel->getId() < $model->getId() ? 1 : 0;
//                $indexModel2 = $indexModel == 1 ? 0 : 1;
//                
//                
//                $finalComparison[$x]['id'][$indexModel] = $model->getId();
//                $finalComparison[$x]['name'][$indexModel] = $model->getName();
//                $finalComparison[$x]['nameUrl'][$indexModel] = $model->getNameUrl();
//                $finalComparison[$x]['img'][$indexModel] = $model->getImg();
//                $finalComparison[$x]['widthSmall'][$indexModel] = ( $model->getWidthSmall() / 100 ) * 50 ;
//                $finalComparison[$x]['heightSmall'][$indexModel] = ( $model->getHeightSmall() / 100 ) * 50 ;
//                
//                $finalComparison[$x]['id'][$indexModel2] = $comparisonModel->getId();
//                $finalComparison[$x]['name'][$indexModel2] = $comparisonModel->getName();
//                $finalComparison[$x]['nameUrl'][$indexModel2] = $comparisonModel->getNameUrl();
//                $finalComparison[$x]['img'][$indexModel2] = $comparisonModel->getImg();
//                $finalComparison[$x]['widthSmall'][$indexModel2] = ( $comparisonModel->getWidthSmall() / 100 ) * 50 ;
//                $finalComparison[$x]['heightSmall'][$indexModel2] = ( $comparisonModel->getHeightSmall() / 100 ) * 50 ;
//                
//                $sModels =  $finalComparison[$x]['nameUrl'][0].'-vs-'.$finalComparison[$x]['nameUrl'][1];
//                $finalComparison[$x]['url'] = $this->wm->routerManager->generate( 'modelComparison', array( 'idModels' => $sModels ) );
//                $x++;
//            }                       
//        }
//        
        
        $acomparisons    = $this->wm->doctrine->getRepository( 'AppBundle:Comparison' )->getComparisonByModel( $model->getId()  );
        if( !empty( $acomparisons ) ) {         
            foreach( $acomparisons As $comparison ) {
                $comparisonModel = $comparison->getModelOne();
                $modelTwo = $comparison->getModelTwo();
            
                $indexModel  =  1;
                $indexModel2 = 0;

                $finalComparison[$x]['id'][$indexModel] = $modelTwo->getId();
                $finalComparison[$x]['price'][$indexModel] = $modelTwo->getPrice();
                $finalComparison[$x]['name'][$indexModel] = $modelTwo->getName();
                $finalComparison[$x]['nameUrl'][$indexModel] = $modelTwo->getNameUrl();
                $finalComparison[$x]['img'][$indexModel] = $modelTwo->getImg();
                $finalComparison[$x]['widthSmall'][$indexModel] = ( $modelTwo->getWidthSmall() / 100 ) * 50 ;
                $finalComparison[$x]['heightSmall'][$indexModel] = ( $modelTwo->getHeightSmall() / 100 ) * 50 ;
                $finalComparison[$x]['bulletPoint'][$indexModel] = trim( trim( str_replace( ";", ", ", $modelTwo->getBulletPoints() ) ), ',' );                                
                $finalComparison[$x]['category'][$indexModel] = $modelTwo->getCategory()->getName();
                $finalComparison[$x]['categoryColor'][$indexModel] = $modelTwo->getCategory()->getBgColor();
                $finalComparison[$x]['categoryLink'][$indexModel] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $modelTwo->getCategory()->getNameUrl() ) );
                $finalComparison[$x]['subcategory'][$indexModel] = $modelTwo->getSubcategory()->getName();
                $finalComparison[$x]['subcategoryLink'][$indexModel] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                    'section1' => $modelTwo->getCategory()->getNameUrl(), 'section2' => $modelTwo->getSubcategory()->getNameUrl() ) 
                );
                
                if( !empty( $model->getTypology ) ) {
                    $finalComparison[$x]['typology'][$indexModel] = $model->getTypology()->getName();
                    $finalComparison[$x]['typologyLink'][$indexModel] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl(), 'section3' => $model->getTypology()->getNameUrl() ) 
                    );
                }
                
                $finalComparison[$x]['id'][$indexModel2] = $comparisonModel->getId();
                $finalComparison[$x]['price'][$indexModel2] = $comparisonModel->getPrice();
                $finalComparison[$x]['name'][$indexModel2] = $comparisonModel->getName();
                $finalComparison[$x]['nameUrl'][$indexModel2] = $comparisonModel->getNameUrl();
                $finalComparison[$x]['img'][$indexModel2] = $comparisonModel->getImg();
                $finalComparison[$x]['widthSmall'][$indexModel2] = ( $comparisonModel->getWidthSmall() / 100 ) * 50 ;
                $finalComparison[$x]['heightSmall'][$indexModel2] = ( $comparisonModel->getHeightSmall() / 100 ) * 50 ;
                $finalComparison[$x]['bulletPoint'][$indexModel2]    = trim( trim( str_replace( ";", ", ", $comparisonModel->getBulletPoints() ) ), ',' );
                $finalComparison[$x]['category'][$indexModel2] = $comparisonModel->getCategory()->getName();
                $finalComparison[$x]['categoryColor'][$indexModel2] = $comparisonModel->getCategory()->getBgColor();
                $finalComparison[$x]['categoryLink'][$indexModel2] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $comparisonModel->getCategory()->getNameUrl() ) );
                $finalComparison[$x]['subcategory'][$indexModel2] = $comparisonModel->getSubcategory()->getName();
                $finalComparison[$x]['subcategoryLink'][$indexModel2] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                    'section1' => $comparisonModel->getCategory()->getNameUrl(), 'section2' => $comparisonModel->getSubcategory()->getNameUrl() ) 
                );
                
                if( !empty( $comparisonModel->getTypology() ) ) {
                    $finalComparison[$x]['typology'][$indexModel2] = $comparisonModel->getTypology()->getName();
                    $finalComparison[$x]['typologyLink'][$indexModel2] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $comparisonModel->getCategory()->getNameUrl(), 'section2' => $comparisonModel->getSubcategory()->getNameUrl(), 'section3' => $comparisonModel->getTypology()->getNameUrl() ) 
                    );
                }

                $sModels =  $finalComparison[$x]['nameUrl'][0].'-vs-'.$finalComparison[$x]['nameUrl'][1];
                $finalComparison[$x]['url'] = $this->wm->routerManager->generate( 'modelComparison', array( 'idModels' => $comparison->getNameUrl() ) );                
                
                $x++;
            }                       
        }
        
        
        
        $highPrice      = false;
        $aProducts      = array();
        $boughtTogether = array();
        $elem = 0;
        $numberProduct = false;
        $amazonProductTop = false;
        $ean = false;
        
        if ( !empty( $products ) ) {
            foreach( $products  AS &$product ) {     
                                
                //Recupera a parte il primo prodotto amazon
                if( empty( $amazonProductTop ) && in_array( $product->getAffiliation()->getId(), array(3,4) ) ) {
                    $amazonProductTop = $product;
                }
                if( !empty( $product->getNumber() ) && empty( $numberProduct ) ) {
                    $numberProduct = $product->getNumber();
                }
                if( empty( $ean ) && !empty( $product->getEan() ) ) {
                    $ean = $product->getEan();
                }
                $product->setPeriodViews( $product->getPeriodViews() + 1  );
                $product->setViews( $product->getViews() + 1  );
                if( $elem == 2 ) {                    
//                    $this->wm->doctrine->flush();
                }
                
//                $price = $product->getPrice();   
//                $price = explode( '.', $price );
//                $decimal = !empty(  $price[1] ) ?  '.'.( strlen( $price[1] ) == 2  ? $price[1] : '0'.$price[1] ) : '.99';
//                $newPrice =  $price[0].( $decimal );
//                $product->setPrice( $newPrice );                
                
                
                $product->setPrice( $this->wm->setPrice( $product->getPrice() ) );
                $setHandlingCost = trim( $this->wm->setPrice( $product->getHandlingCost() ) );

                $product->setHandlingCost( trim( sprintf( '%0.2f', str_replace( ',','.', $setHandlingCost ) ) ) );
//                exit;

                $totalPrice = $this->wm->getTotalPrice( $product->getPrice(), $product->getHandlingCost() );
                
                
                if( empty( $highPrice ) || $highPrice < $totalPrice )
                    $highPrice = $totalPrice;
                
//                if( strlen( $product->getDescription() ) > 170 )  {
//                    echo substr( utf8_encode($product->getDescription()), 0, 150 ).'...<br>' ;
//                    $product->setDescription( substr( $product->getDescription(), 0, 150 ).'...' );
//                }
                
                
                if( !empty( $product->getToUpdate() ) ) {
                    $aProducts[$product->getNumber()] = $product;
                } else {
                    $boughtTogether[$product->getNumber()] = $product;
                }
                $elem++;
            }                        
        }
        
        
        if( !empty( $model->getReleatedCodeAmazon() ) ) {
            $codes = explode( ';', $model->getReleatedCodeAmazon() );            
            $products = $this->wm->doctrine->getRepository('AppBundle:Product')->findProductsByReleatedCodeAmazon( $codes );
            foreach( $products AS $product ) {
                $product->setPrice( $this->wm->setPrice( $product->getPrice() ) );
                $boughtTogether[$product->getNumber()] = $product;
            }
        }
        
        $pagination->init( $countProducts['tot'] ); 
        $paginationArt = $pagination->makeList();
        
        
        $longDesc = $this->replaceBody( $model->getLongDescription() );
        $model->setLongDescription( $longDesc );
        
        
//        usort( $aProducts, function($a, $b) { //Sort the array using a user defined function
//            return ( ( $this->wm->getTotalPrice( $a->getPrice(), $a->getHandlingCost() ) ) < ( $this->wm->getTotalPrice( $b->getPrice(), $b->getHandlingCost() ) )  );
//        });
//        
//        usort( $aProducts, function($a, $b) { //Sort the array using a user defined function
//            return ( (int)$a->getPrice() > (int)$b->getPrice() );
//        });
        
                
        reset( $aProducts );
        $firstKey = key( $aProducts );
        
        if( !empty( $aProducts ) && !empty( $aProducts[$firstKey] ) ) {             
            $this->getJsonLdProduct( $aProducts[$firstKey], $highPrice, $model, count( $aProducts ), $ean );
        }
            
        
        $products = array();
//        if( !empty( $amazonProductTop ) ) {
//            foreach( $aProducts AS $key => $p ) {                
//                if( $p->getNumber() == $amazonProductTop->getNumber() ) {
//                    unset( $aProducts[$key]);
//                }
//            }                        
//            $products[] = $amazonProductTop;
//        }
        
        $amazonProductTop = false;
        foreach( $aProducts AS $p ) {
            $products[] = $p;
        }
        
        //Avvia divisione in gruppi di modelli
        $groupingProduct = false;
        if( !empty( $model->getGroupingProduct() ) ) {
            $a = explode( '[#]', $model->getGroupingProduct() );
//            print_R($a);
            foreach( $a AS $item ) {
                $b = explode( ';', $item );
//                print_R($b);
                foreach( $b AS $bItem ) {
                    $bItem = trim($bItem);
//                    echo $bItem."\n";                    
                    foreach( $products AS $product ) {
                        if( empty( $bItem ) ) 
                            continue;
                        if( strpos( strtolower( ' '.$product->getName().' ' ), strtolower( $bItem ), '0' ) !== false ) {
                            $groupingProduct[trim($b[0])][trim($product->getName())] = $product;
                        }                        
                    }                    
                }
                if( !empty( $groupingProduct[trim($b[0])] ) ) {
                    usort( $groupingProduct[trim($b[0])], function($a, $b) { //Sort the array using a user defined function
                        return ( $a->getPrice() > $b->getPrice() );
//                        return ( ( $this->wm->getTotalPrice( $a->getPrice(), $a->getHandlingCost() ) ) > ( $this->wm->getTotalPrice( $b->getPrice(), $b->getHandlingCost() ) )  );
                    });                
                }
            }
        }
        
        
        //METODO CHE AGGIUNGE LE VARIANTE CHE NON è STATO POSSIBILE RAGGRUPPARE
        if( !empty( $groupingProduct ) ) {
            $otherGroup = array();
            foreach( $products AS $product ) {      
                $check = false;
                foreach( $groupingProduct AS $key => $group ) {                
                    foreach( $group AS $gProduct ) {                                                            
                        if( trim( $gProduct->getName() ) == trim($product->getName()) ) {
                            $check = true;
                        }                        
                    }
                }
                if( empty( $check ) ) {
                    $groupingProduct['altre varianti '. $model->getName()][trim($product->getName())] = $product;
                }            
            }
        }
        
        
        $imagesGallery = !empty( $model->getImagesGallery()  ) ? json_decode( $model->getImagesGallery() ) : false;        
        
        
        //PER ACCENDERE LA COMPARAZIONE UTENTE ALLE SEZIONI SPECIFICHE
        $enabledUserComparisonSubcategory   = array();
        $enabledUserComparisonTypology      = array( 6 );
        
        $enabledUserComparison = false;
        if( !empty( $model->getTypology() ) && in_array( $model->getTypology()->getId(), $enabledUserComparisonTypology ) ) {
            $enabledUserComparison = true;
        }
        
        $enabledLinkGuide               = array();
        $enabledLinkGuideTypology       = array( 4 );        
        $enabledLinkGuide = false;        
        $guide = false;
        if( !empty( $model->getTypology() ) && in_array( $model->getTypology()->getId(), $enabledLinkGuideTypology ) ) {            
            $guide = $this->wm->doctrine->getRepository('AppBundle:DataArticle')->findOneBy( array( 'typology' => $model->getTypology(), 'isCategoryGuide' => 1  ) );                        
        }
        
        
        //Per il debug dei link
        if( !empty( $this->wm->container->getParameter( 'app.debugLinkLinkAssistant' ) ) ) {
            $model->setLongDescription( str_replace( 'https://www.acquistigiusti.it', 'https://tricchetto.homepc.it', $model->getLongDescription() ) );
        }
       
        
        return array(
            'guide'                 => $guide,
            'products'              => $products,
            'groupingProduct'       => $groupingProduct,
            'boughtTogether'        => $boughtTogether,
            'extraModel'            => $extraModel,
            'model'                 => $model,
            'pagination'            => $paginationArt,
            'sectionProductName'    => ( !empty( $sectionProductName ) ? ' '.$sectionProductName : ''),
            'sectionProductNameEnd' => $sectionProductNameEnd,
            'sectionPreProductName' => $sectionPreProductName,
            'comparisonSectionName' => $comparisonSectionName,
            'filterSimilarModels'   => $filterSimilarModels,
            'comparisonModels'      => $finalComparison,
            'amazonProductTop'      => $amazonProductTop,
            'imagesGallery'         => $imagesGallery,
            'enabledUserComparison' => $enabledUserComparison
        );
    }
    
    /**
     * metodo che effettua il replace dei vocabili con le spiegazioni
     * @param type $technicalSpecifications
     * @param type $model
     */
    public function replaceDictionary( $technicalSpecifications, $model ){
        $subcategory    =  $model->getSubcategory()->getId();
        $typology       =  !empty( $model->getTypology() ) ? $model->getTypology()->getId() : '';
        
        
        $dictionaryUtility  = $this->wm->container->get( 'app.dictionaryUtility' );
        $technicalSpecifications = $dictionaryUtility->replaceTechnicalSpecifications( $technicalSpecifications, $subcategory, $typology );
        return $technicalSpecifications;
    }
    
    
     /**
     * Effettua il replace dei modelli che devono essere linkati nel testo
     * @param type $longDesc
     * @return type
     */
    private function replaceBody( $longDesc ) {     
        if( !empty( $this->wm->globalConfigManager->getAmpActive() ) ) 
            $longDesc =  $this->wm->globalUtility->html5toampImage( $longDesc, 'responsive' );                
        
        
        $longDesc =  $this->wm->replacePlaceholderInternalLink( $longDesc );                
        return $longDesc;
    }
    
    /**
     * Crea il microdato per il dettaglio prodotto del modello
     * @param type $product
     * @param type $highPrice
     * @param type $model
     */
    private function getJsonLdProduct( $product, $highPrice, $model, $count, $numberProduct ) {
        $shortDescription =  !empty( $model->getMetaDescription() ) ? '"description": "'.$this->cleanString( str_replace( '"', '', $model->getMetaDescription() ) ).'",' : false;
        
        $domain = 'www.'.$this->wm->globalConfigManager->getCurrentDomain();
        $base = 'https://'.str_replace( 'app.', 'www.',$domain);
        
        $pathModelGallery  = $this->wm->container->getParameter( 'app.folder_img_models_gallery' );
        $pathModel  = $this->wm->container->getParameter( 'app.folder_img_models' );
        $pathProduct = $this->wm->container->getParameter( 'app.folder_imgProductsSmall' );
        
        $image = !empty( $model->getImg() ) ? $pathModel.$model->getImg() : (  !empty( $product->getPriorityImg()) ? $pathProduct.$product->getPriorityImg()->getImg() : false );
        
        if( !empty( $model->getImagesGallery()  ) ) {
            $strImage = '"image":[';
            foreach(json_decode( $model->getImagesGallery() ) AS $images ) {
                $strImage .=  '"'.$base.$pathModelGallery.$images->src.'",';
            }
            $strImage = trim( $strImage, ',' ).'],';
        } else {
            $strImage = '';
        }        
        
        
        $this->wm->container->get( 'twig' )->addGlobal( 'ogImage', $base.$image );
        
        $len = strlen( $numberProduct );
        $gtin = '';
        switch( $len ) {
            case 8: 
                $gtin = '"gtin8":"'.$numberProduct.'",';
            break;
            case 12: 
                $gtin = '"gtin12":"'.$numberProduct.'",';
            break;
            case 13: 
                $gtin = '"gtin13":"'.$numberProduct.'",';
            break;
            case 14: 
                $gtin = '"gtin14":"'.$numberProduct.'",';
            break;
        }
        
//        echo $product->getId();
        $json = '
           {
            "@context": "http://schema.org",
            "@type": "Product",
            "name": "'.$model->getName().'",
            '.$strImage.'
            '.$gtin.'
            '.$shortDescription.'
        ';
        
        if( !empty( $model->getTrademark() ) ) {
            $json.= '
            "brand": {
              "@type": "Thing",
              "name": "'.$model->getTrademark()->getName().'"
            },';
        }

        $lowPrice = $product->getPrice();
//        $availability = $product->getSizeStockStatus() == 'in stock' ? 'http://schema.org/InStock' : 'http://schema.org/OutInStock';
        $availability = $product->getSizeStockStatus() == 'in stock' ? 'http://schema.org/InStock' : 'http://schema.org/InStock';
        
        if( !empty( $model->getTypology() ) ) {
            $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl(), 'section3' => $model->getTypology()->getNameUrl() ), true );
        } else {
            $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl() ), true );
        }
        
        $lowPrice = str_replace( ',', '.', $lowPrice );
        $highPrice = str_replace( ',', '.', $highPrice );
        
        $json.= '
           "offers": {
              "@type": "AggregateOffer",
              "url": "'.$base.$urlModel.'",
              "lowPrice": "'.$lowPrice.'",
              "highPrice": "'.$highPrice.'",
              "priceCurrency": "EUR",
              "availability": "'.$availability.'",
              "offerCount":"'.$count.'"
            }
          }'
        ;
        $this->wm->container->get( 'twig' )->addGlobal( 'jsonDataRichSnippetDetailProduct', $json );
    }
    
    private function calculateSaving( $model, $product ) {
        $advisedPrice = $model->getAdvisedPrice();
        $price = !empty( $model->getPrice() ) ? $model->getPrice() : ( !empty( $product ) ? $product->getPrice() : false );
        
        $advisedPrice = (int) str_replace('.', '', $advisedPrice);
        $saving = ( (int)$advisedPrice - (int)$price );
        
        return $saving;
    }
    
    private function cleanString($text) {          
        $utf8 = array(
            'â','€ ','€','.','?','â','ã','ª','ä','Â','Ã','Ä','Î','Ï','î','ï','ê', 'ë','Ê','Ë','ô','õ','º','ö','Ô','Õ','Ö','û','ü','Û','Ü','�'
        );
        return preg_replace("/[^A-Za-z0-9\[\]\#\-\.\,\'\" ]/", '',str_replace($utf8, ' ', $text));   
    }
    
    private function getSeeAlsoLink( $subcategoryId, $typologyId ) {      
        $subcategoryById   = $this->globalQueryUtility->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'subcategoriesById' );
        $typologiesById    = $this->globalQueryUtility->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'typologiesById' );
        
        $seeAlso = false;
        if( !empty( $subcategoryId ) ) {            
            $subcategory    = array_key_exists($subcategoryId, (array)$subcategoryById) ? $subcategoryById->{$subcategoryId} : false;
            if( $subcategory ) {
                if( !empty( $subcategory->seeAlso ) ) {
                    $seeAlso = json_decode( $subcategory->seeAlso );
                }
            }
        }
        if( !empty( $typologyId ) ) {            
            $typology       = array_key_exists($typologyId, (array)$typologiesById) ? $typologiesById->{$typologyId} : false; 
             if( $typology ) {
                if( !empty( $typology->seeAlso ) ) {
                 $seeAlso = json_decode( $typology->seeAlso );
                }
            }
        }
        
        
        
        $linksSeeAlso = array();
        
        $x = 0;
        if( !empty( $seeAlso->subcategory ) ) {
            foreach( $seeAlso->subcategory AS $item ) {
                
                if( empty( $subcategoryById->{$item}->isactive ) )
                    continue;
                
                $linksSeeAlso[$x]['label'] = $subcategoryById->{$item}->name;
                if ( $subcategoryById->{$item}->hasModels > 0 ) {                            
                    $linksSeeAlso[$x]['url'] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $subcategoryById->{$item}->nameUrl ) );
                } else {
                    $linksSeeAlso[$x]['url'] = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subcategoryById->{$item}->nameUrl ) );
                }
                $x++;
            }
        }
        
        if( !empty( $seeAlso->typology ) ) {
            foreach( $seeAlso->typology AS $item ) {
                if( empty( $typologiesById->{$item}->isActive ) )
                    continue;
                
                $linksSeeAlso[$x]['label'] = $typologiesById->{$item}->name;
                
                if ( $typologiesById->{$item}->hasModels > 0 ) {
                    $linksSeeAlso[$x]['url'] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $typologiesById->{$item}->nameUrl ) );
                } else {                    
                    $linksSeeAlso[$x]['url'] = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $typologiesById->{$item}->subcategoryNameUrl, 'typology' => $typologiesById->{$item}->nameUrl ) );                                
                }                                
                $x++;
            }
        }                
        $this->wm->container->get( 'twig' )->addGlobal( 'linksSeeAlso', $linksSeeAlso );
    }    
    
}