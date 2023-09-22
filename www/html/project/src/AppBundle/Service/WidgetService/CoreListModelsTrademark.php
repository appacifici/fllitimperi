<?php

namespace AppBundle\Service\WidgetService;

class CoreListModelsTrademark {
    
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
        
        $catSubcatTypology = $parmas['catSubcatTypology'];        
        $subcategory = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findByNameUrl($catSubcatTypology);
        
        if( empty( $category ) && empty( $subcategory ) )
            $typology = $this->wm->doctrine->getRepository('AppBundle:Typology')->findByNameUrl($catSubcatTypology);                
        
        $allCatSubcatTypology  = array();
        $allModels  = array();
        $section    = array();        
        
        $trademarksByName = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'trademarksByName' );
        $trademarkId       = array_key_exists($trademark, (array)$trademarksByName) ? $trademarksByName->{$trademark}->id : false;
        
        if( empty( $trademarkId ) ) {
            $aTrademark = $this->wm->doctrine->getRepository('AppBundle:Trademark')->findOneByNameUrl( $trademark );
            if( !empty( $aTrademark ) )                
                $trademarkId = $aTrademark->getId();            
        }
        
        if( empty( $trademarkId ) || ( empty( $category ) &&  empty( $subcategory ) && empty( $typology ) )  ) {     
            return array( 'errorPage' => 404 );
        }        
        
        
        //Avvio la paginazione
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totListModelsTrademark' ) );
        $pagination->getLimit();
        
        if( !empty( $subcategory ) ) {
            $x = 0;
            $count = 50;
//            $count = $this->wm->doctrine->getRepository('AppBundle:Model')->findCountModelsBySubcategoryTypologyTrademark( $subcategory->getId(), false, $trademarkId, $subcategory->getFilterModelCompleted() );
            $models = $this->wm->doctrine->getRepository('AppBundle:Model')->findModelsBySubcategoryTypologyTrademark( $subcategory->getId(), false, $trademarkId, $pagination->getLimit(), $subcategory->getFilterModelCompleted() );
            $models = $this->wm->doctrine->getRepository('AppBundle:Model')->findModelsBySubcategoryTypologyTrademark( $subcategory->getId(), false, $trademarkId, '0,50', $subcategory->getFilterModelCompleted() );
            if( !empty( $models[0] ) ) {
                $section[$models[0]->getTrademark()->getNameUrl()]['sectionName']       = $subcategory->getName();
                $section[$models[0]->getTrademark()->getNameUrl()]['sectionNameUrl']    = $subcategory->getNameUrl();
                $section[$models[0]->getTrademark()->getNameUrl()]['nameTrademark']     = $models[0]->getTrademark()->getName();
                $section[$models[0]->getTrademark()->getNameUrl()]['nameUrlTrademark']  = $models[0]->getTrademark()->getNameUrl();
                $this->wm->twig->addGlobal('h1Section', 'Le offerte di '.$subcategory->getName().' '.$models[0]->getTrademark()->getName() );        
            }
            foreach ( $models as $model ) {
                if( $model->getIsCompleted() == 1 || $model->getHasProducts() > 0  ) {
                    if( !empty( $model->getTypology() ) ) {
                        $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'typology' => $model->getTypology()->getNameUrl(), 'typologySingular' => $model->getTypology()->getSingularNameUrl() ) );
                    } else {
                        $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'subcategory' => $model->getSubcategory()->getNameUrl(), 'subcategorySingular' => $model->getSubcategory()->getSingularNameUrl() ) );
                    }
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['id']          = $model->getId();
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['name']        = utf8_decode( $model->getName() );
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['url']         = $urlModel;
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['hasProduct']  = $model->getHasProducts();
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['isTop']       = $model->getIsTop();                            
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['dateImport']  = $model->getDateImport();   
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['isCompleted'] = $model->getIsCompleted();   
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['advisedPrice']       = $model->getAdvisedPrice();   
                    $x++;
                    }                                
                }                    
                if( !empty( $allModels ) ) {
                    usort( $allModels[$model->getTrademark()->getNameUrl()], function($a, $b) { //Sort the array using a user defined function
                        return ( $a['name'] < $b['name'] );
                    });
                }            
            
        } else if ( !empty( $typology ) ) {
            $x = 0;
            $count = 50;
//            $count = $this->wm->doctrine->getRepository('AppBundle:Model')->findCountModelsBySubcategoryTypologyTrademark( $typology->getSubcategory()->getId(), $typology->getId(), $trademarkId, $typology->getFilterModelCompleted() );
//            $models = $this->wm->doctrine->getRepository('AppBundle:Model')->findModelsBySubcategoryTypologyTrademark( $typology->getSubcategory()->getId(), $typology->getId(), $trademarkId, $pagination->getLimit(), $typology->getFilterModelCompleted() );
            $models = $this->wm->doctrine->getRepository('AppBundle:Model')->findModelsBySubcategoryTypologyTrademark( $typology->getSubcategory()->getId(), $typology->getId(), $trademarkId,'0,50', $typology->getFilterModelCompleted() );
            if( !empty( $models[0] ) ) {
                $section[$models[0]->getTrademark()->getNameUrl()]['sectionName']       = $typology->getName();
                $section[$models[0]->getTrademark()->getNameUrl()]['sectionNameUrl']    = $typology->getNameUrl();
                $section[$models[0]->getTrademark()->getNameUrl()]['nameTrademark']     = $models[0]->getTrademark()->getName();
                $section[$models[0]->getTrademark()->getNameUrl()]['nameUrlTrademark']  = $models[0]->getTrademark()->getNameUrl();
                $this->wm->twig->addGlobal('h1Section', 'Le offerte di '.$typology->getName().' '.$models[0]->getTrademark()->getName() );        
            }
            foreach ( $models as $model ) {   
                if( $model->getIsCompleted() == 1 || $model->getHasProducts() > 0  ) {
                    if( !empty( $model->getTypology() ) ) {
                        $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'typology' => $model->getTypology()->getNameUrl(), 'typologySingular' => $model->getTypology()->getSingularNameUrl() ) );
                    } else {
                        $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'subcategory' => $model->getSubcategory()->getNameUrl(), 'subcategorySingular' => $model->getSubcategory()->getSingularNameUrl() ) );
                    }
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['id']              = $model->getId();
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['name']            = utf8_decode( $model->getName() )  ;
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['url']             = $urlModel;
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['hasProduct']      = $model->getHasProducts();
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['isTop']           = $model->getIsTop();         
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['dateImport']      = $model->getDateImport();   
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['isCompleted']     = $model->getIsCompleted();   
                    $allModels[$model->getTrademark()->getNameUrl()][$x]['advisedPrice']    = $model->getAdvisedPrice();   
                    $x++;
                }                
            }    
            if( !empty( $allModels ) ) {
                usort( $allModels[$model->getTrademark()->getNameUrl()], function($a, $b) { //Sort the array using a user defined function
                    return ( $a['name'] < $b['name'] );
                });
            }
        }
        
        $pagination->init( $count['tot'], $this->wm->container->getParameter( 'app.toLinksPagination' ) );
        $paginationProd = $pagination->makeList();                    
        $this->wm->container->get( 'twig' )->addGlobal( 'lastPagePagination', $pagination->lastPage() );                                       
        
        return array(
            'allCatSubcatTypology' => $allCatSubcatTypology,
            'allModels' => $allModels,
            'section' => $section,
            'pagination' => $paginationProd,
            'countArticles' => $count['tot'],
            'page' => $this->wm->getPage(),
            'listModelsTrademark' => true,
            'filterAllModelsTrademark' => false
        );
    } 
}