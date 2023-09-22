<?php

namespace AppBundle\Service\WidgetService;

class CoreCatSubcatTypologyList {
    
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
        $sectionItems = false;
        $paginationProd = false;
        
        $catSubcatTypology = $parmas['catSubcatTypology'];
        
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
        $response = $this->globalQueryUtility->getCatSubcatTypology( $catSubcatTypology );
        $allTrademarks = $this->globalQueryUtility->getRedisOrDbTrademarksById( $catSubcatTypology );
        
        $category       = $response->category;
        $subcategory    = $response->subcategory;
        $typology       = $response->typology;
        $microSection   = $response->microSection;
        
        if( empty( $category ) &&  empty( $subcategory ) && empty( $typology )  && empty( $microSection ) ) {            
            return array( 'errorPage' => 404 );
        }
        
        $allCatSubcatTypology  = array();
        $allModels  = array();
        $section    = array();
        $label = new \stdClass;        
        
        if( !empty( $category ) ) {
//            if( $category->getId() == 8 )
//                $isAbbigliamento = true;
            
            foreach ( $category->getSubcategories() as $subCat ) {
//                if ( ( $category->getId() == 8 &&  $subCat->getHasProducts() < 15 ) ) {
//                    continue;
//                }
                if (  empty( $subCat->getHasModels() ) ) {
                    continue;
                }
                if ( empty( $subCat->getIsActive()  ) ) {
                    continue;
                }
                
                $allCatSubcatTypology[$subCat->getId()]['id'] = $subCat->getId() ;
                $allCatSubcatTypology[$subCat->getId()]['name'] = $subCat->getName();
                $allCatSubcatTypology[$subCat->getId()]['img'] = $subCat->getImg();
                //Se è per abbiliamento e moda cambia rotta da generare
//                if( $category->getId() == $this->wm->container->getParameter( 'categoryIdAbbigliamento' ) && $subCat->getId() != 205 ) {
//                    if( strpos( $subCat->getSex(), 'donna', 0 ) !== false ) {
//                        $allCatSubcatTypology[$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getNameUrl(), 'sex' => 'donna' ) );
//                    } else {
//                        $allCatSubcatTypology[$subCat->getId()]['url']  = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $subCat->getNameUrl() ) );
//                    }                    
//                } else {
                    $allCatSubcatTypology[$subCat->getId()]['url']  =  $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $category->getNameUrl(), 'section2' => $subCat->getNameUrl() ) );
//                }
                $allCatSubcatTypology[$subCat->getId()]['hasProduct']  = $subCat->getHasProducts();
                
                //DA RIATTIVARE SE SI VIOLE RIATTIVARE ABBIGLIAMENTO
//                if( $category->getId() != $this->wm->container->getParameter( 'categoryIdAbbigliamento' ) ) {
                    foreach ( $subCat->getTypology() as $typo ) {
//                        echo $typo->getName().' '.$typo->getHasProducts()." ".$typo->getHasModels()."<br>";
                        
                        if ( empty( $typo->getIsActive()  ) ) {
                            continue;
                        }
                        
                        if ( $typo->getHasProducts() > 0 ||  !empty( $typo->getHasModels() ) ) {
                            $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['id'] = $typo->getId();
                            $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['name'] = $typo->getName();                                                        
                            $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['hasProduct']  = $typo->getHasProducts();
                            $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['img'] = $typo->getImg();
                            
                            if ( $typo->getHasModels() > 0 ) {                                
                                $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['url']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $category->getNameUrl(), 'section2' => $typo->getNameUrl() ) );
                            } else {
                                $allCatSubcatTypology[$subCat->getId()]['typology'][$typo->getId()]['url']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $category->getNameUrl(), 'section2' => $typo->getNameUrl() ) );
                            }
                        }
                    }   
//                }
            }
            $this->wm->twig->addGlobal('h1Section', ' '.$category->getName() );
            $label = new \stdClass;
            $label->name = $category->getName();
            $label->nameUrl = $category->getNameUrl();
            $label->description = $category->getDescription(); 
            $label->img =  $this->wm->container->getParameter( 'app.folder_img_category' ).$category->getImg(); 
            
        } else if( !empty( $subcategory ) && !empty( count( $subcategory->getTypology() )  ) ) {
            $allCatSubcatTypology[$subcategory->getId()]['id'] = $subcategory->getId() ;
            $allCatSubcatTypology[$subcategory->getId()]['name'] = $subcategory->getName();
            $allCatSubcatTypology[$subcategory->getId()]['img'] = $subcategory->getImg();
            foreach ( $subcategory->getTypology() as $typo ) {
//                        echo $typo->getName().' '.$typo->getHasProducts()." ".$typo->getHasModels()."<br>";

                        if ( empty( $typo->getIsActive()  ) ) {
                            continue;
                        }

                        if ( $typo->getHasProducts() > 0 ||  !empty( $typo->getHasModels() ) ) {
                            $allCatSubcatTypology[$subcategory->getId()]['typology'][$typo->getId()]['id'] = $typo->getId();
                            $allCatSubcatTypology[$subcategory->getId()]['typology'][$typo->getId()]['name'] = $typo->getName();                                                        
                            $allCatSubcatTypology[$subcategory->getId()]['typology'][$typo->getId()]['hasProduct']  = $typo->getHasProducts();
                            $allCatSubcatTypology[$subcategory->getId()]['typology'][$typo->getId()]['img'] = $typo->getImg();

                            if ( $typo->getHasModels() > 0 ) {                                
                                $allCatSubcatTypology[$subcategory->getId()]['typology'][$typo->getId()]['url']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $subcategory->getCategory()->getNameUrl(), 'section2' => $typo->getNameUrl() ) );
                            } else {
                                $allCatSubcatTypology[$subcategory->getId()]['typology'][$typo->getId()]['url']  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $subcategory->getCategory(), 'section2' => $typo->getNameUrl() ) );
                            }
                        }
                    }   
//                }

            $this->wm->twig->addGlobal('h1Section', ' '.$subcategory->getName() );
            $label = new \stdClass;
            $label->name = $subcategory->getName();
            $label->nameUrl = $subcategory->getNameUrl();
            $label->description = $subcategory->getDescription(); 
            $label->img =  $this->wm->container->getParameter( 'app.folder_img_subcategories' ).$subcategory->getImg(); 
            
        } else {            
             ### PRODOTTI IMPAGINATI ###
            $pagination    = $this->wm->container->get( 'app.paginationUtility' );
            $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totListModels' ) );

            $subcategoryId  = !empty( $subcategory ) ? $subcategory->getId() : false;
            $typologyId     = !empty( $typology ) ? $typology->getId() : false;
            $microSectionId     = !empty( $microSection ) ? $microSection->getId() : false;            
            
            
            //Se non siamo in una micro sezione le recupera
            if( empty( $microSectionId ) ) {
                $sectionItems       = $this->wm->doctrine->getRepository('AppBundle:MicroSection')->findMicroSectionWithLimit( $pagination->getLimit(), false, $subcategoryId, $typologyId );
                //Controlla se esistano micro sezioni per questa sezione in caso non prende tutti i modelli paginati ma solo gli ultimi 30
            }
            
            if( empty( $sectionItems ) ) {
                $count = $this->wm->doctrine->getRepository( 'AppBundle:Model' )->getCountModelsList( $subcategoryId, $typologyId, $microSectionId );        
                $models = $this->wm->doctrine->getRepository('AppBundle:Model')->getModelsList( $pagination->getLimit(), $subcategoryId, $typologyId, $microSectionId );

                $pagination->init( $count['tot'], $this->wm->container->getParameter( 'app.toLinksPagination' ), false, false, true );
                $paginationProd = $pagination->makeList();                    
                $this->wm->container->get( 'twig' )->addGlobal( 'lastPagePagination', $pagination->lastPage() );
            } else {              
                $models = $this->wm->doctrine->getRepository('AppBundle:Model')->getModelsList( 30, $subcategoryId, $typologyId, $microSectionId );
            }
            
            
            $x = 0;
            foreach ( $models as $model ) {       
                if( !empty( $model->getTypology() ) ) {
                    $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getTypology()->getNameUrl() ) );
                } else {
                    $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl() ) );
                }
                $allModels[$x]['id']              = $model->getId();
                $allModels[$x]['name']            = utf8_decode( $model->getName() );
                $allModels[$x]['url']             = $urlModel;
                $allModels[$x]['hasProduct']      = $model->getHasProducts();
                $allModels[$x]['isTop']           = $model->getIsTop();         
                $allModels[$x]['heightSmall']     = $model->getHeightSmall();  
                $allModels[$x]['bulletPoints']    = preg_split( "/;/", $model->getBulletPoints(), -1, PREG_SPLIT_NO_EMPTY );
                $allModels[$x]['hasProducts']     = $model->getHasProducts();  
                $allModels[$x]['advisedPrice']    = $model->getAdvisedPrice();  
                $allModels[$x]['price']           = $model->getPrice();  
                $allModels[$x]['lastPrice']       = $model->getLastPrice();  
                $allModels[$x]['saving']          = (int)$model->getAdvisedPrice() - (int)$model->getPrice();
                $x++;
            }
            
        }            
        
//        if( !empty( $category ) ) {
//            $sex = $category->getId() == 8 ? 'donna' : false;
//            $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( $category->getId(), false, false, 'catSubcatTypologyProduct', $sex );
//        }
//                
//        if( empty( $category ) && !empty( $subcategory ) ) {
//            $sex = $subcategory->getCategory()->getId() == 8 ? 'donna' : false;
//            $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( false, $subcategory->getId(), false, 'catSubcatTypologyProduct', $sex );
//        }
//        
//        if( empty( $category ) && empty( $subcategory ) ) {
//            $sex = !empty( $typology->getCategory() ) &&  $typology->getCategory()->getId() == 8 ? 'donna' : false;
//            $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( false, false, $typology->getId(), 'catSubcatTypologyProduct', $sex );
//        }        
        
        
        if( !empty( $models ) ) {            
                    
            if( !empty( $category ) ) {
                $label->name = $models[0]->getCategory()->getName();
                $label->nameUrl = $models[0]->getCategory()->getNameUrl();
                $label->description = $models[0]->getCategory()->getDescription();  
                $label->img = $this->wm->container->getParameter( 'app.folder_img_category' ).$models[0]->getCategory()->getImg(); 
            }

            if( !empty( $subcategory ) ) {            
                $label->name = $models[0]->getSubcategory()->getName();
                $label->nameUrl = $models[0]->getSubcategory()->getNameUrl();        
                $label->description = $models[0]->getSubcategory()->getDescription();  
                $label->img =  $this->wm->container->getParameter( 'app.folder_img_subcategories' ).$models[0]->getSubcategory()->getImg(); 
            }

            if( !empty( $typology ) ) {            
                $label->name = $models[0]->getTypology()->getName();
                $label->nameUrl = $models[0]->getTypology()->getNameUrl();        
                $label->description = $models[0]->getTypology()->getDescription();      
                $label->img =  $this->wm->container->getParameter( 'app.folder_img_typologies' ).$models[0]->getTypology()->getImg(); 
            }     

            if( !empty( $microSection ) ) {            
                $label->name = $models[0]->getMicroSection()->getName();
                $label->nameUrl = $models[0]->getMicroSection()->getNameUrl();        
                $label->description = $models[0]->getMicroSection()->getDescription();      
                $label->img = $models[0]->getTypology()->getImg(); 
            }     
        }
                
        return array(
            'allCatSubcatTypology'      => $allCatSubcatTypology,
            'allModels'                 => $allModels,
            'sectionItems'              => $sectionItems,
            'section'                   => $section,
            'label'                     => $label,
            'aOtherTrademarks'          => $aOtherTrademarks,
            'searchTerms'               => $aSearchTerms,
            'isAbbigliamento'           => $isAbbigliamento,
            'filterAllModelsTrademark'  => $filterAllModelsTrademark,
            'pagination'                => $paginationProd,
            'countArticles'             => !empty( $count ) ? $count['tot'] : 0,
            'page'                      => $this->wm->getPage()
        );
    } 
}