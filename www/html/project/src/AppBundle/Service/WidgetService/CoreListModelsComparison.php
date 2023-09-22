<?php

namespace AppBundle\Service\WidgetService;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\AmazonService\AmazonApi;


class CoreListModelsComparison {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function getDataToAjax() {
        $subcategory    = $this->wm->getUrlSubcategory();
        $typology       = $this->wm->getUrlTypology();
        
        if( !empty( $typology ) )
            $models    = $this->wm->doctrine->getRepository( 'AppBundle:Model' )->findAllBySubcategoryTypology(  $subcategory,$typology );
        else
            $models    = $this->wm->doctrine->getRepository( 'AppBundle:Model' )->findAllBySubcategoryTypology(  $subcategory );
        
        return $models;
    }
    
    public function processData() {
               
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
//        $aModels = $this->globalQueryUtility->getModelsComparison( $this->wm->getIdModels() );   
//        
//        if( count($aModels) < 2 ) {            
//            return array( 'errorPage' => 404 );
//        }        
        
        
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( 12 );
        $countArticles = $this->wm->doctrine->getRepository( 'AppBundle:Comparison' )->getCountAllActive( );
        
        $pagination->init( $countArticles['tot'], $this->wm->container->getParameter( 'app.toLinksPaginationGuide' ) );                        
        $paginationArt = $pagination->makeList();            
        
        $acomparisons    = $this->wm->doctrine->getRepository( 'AppBundle:Comparison' )->getAllActive( $pagination->getLimit()  );
        
//        $models    = $this->wm->doctrine->getRepository( 'AppBundle:Model' )->getModelHasComparison(  $pagination->getLimit() );
        $finalComparison = array();
        
        $x = 0;
        foreach( $acomparisons AS $acomparison ) {
                $comparisonModel = $acomparison->getModelOne();
                $model = $acomparison->getModelTwo();
            
                $indexModel  =  1;
                $indexModel2 = 0;

                $finalComparison[$x]['id'][$indexModel] = $model->getId();
                $finalComparison[$x]['price'][$indexModel] = $model->getPrice();
                $finalComparison[$x]['name'][$indexModel] = $model->getName();
                $finalComparison[$x]['nameUrl'][$indexModel] = $model->getNameUrl();
                $finalComparison[$x]['img'][$indexModel] = $model->getImg();
                $finalComparison[$x]['widthSmall'][$indexModel] = ( $model->getWidthSmall() / 100 ) * 50 ;
                $finalComparison[$x]['heightSmall'][$indexModel] = ( $model->getHeightSmall() / 100 ) * 50 ;
                $finalComparison[$x]['bulletPoint'][$indexModel] = trim( trim( str_replace( ";", ", ", $model->getBulletPoints() ) ), ',' );                                
                $finalComparison[$x]['category'][$indexModel] = $model->getCategory()->getName();
                $finalComparison[$x]['categoryColor'][$indexModel] = $model->getCategory()->getBgColor();
                $finalComparison[$x]['categoryLink'][$indexModel] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $model->getCategory()->getNameUrl() ) );
                $finalComparison[$x]['subcategory'][$indexModel] = $model->getSubcategory()->getName();
                $finalComparison[$x]['subcategoryLink'][$indexModel] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                    'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl() ) 
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
                $finalComparison[$x]['url'] = $this->wm->routerManager->generate( 'modelComparison', array( 'idModels' => $acomparison->getNameUrl() ) );                
                
                $x++;
            
        }
        
        $x = 0;
        $aTopComparison    = $this->wm->doctrine->getRepository( 'AppBundle:Comparison' )->getTopComparison();
        
        $comparisonModel = $aTopComparison->getModelOne();
        $model = $aTopComparison->getModelTwo();

        $indexModel  = $comparisonModel->getId() < $model->getId() ? 1 : 0;
        $indexModel2 = $indexModel == 1 ? 0 : 1;

        $topComparison['id'][$indexModel] = $model->getId(); 
        $topComparison['price'][$indexModel] = $model->getPrice();
        $topComparison['name'][$indexModel] = $model->getName();
        $topComparison['nameUrl'][$indexModel] = $model->getNameUrl();
        $topComparison['img'][$indexModel] = $model->getImg();
        $topComparison['widthSmall'][$indexModel] = ( $model->getWidthSmall() / 100 ) * 50 ;
        $topComparison['heightSmall'][$indexModel] = ( $model->getHeightSmall() / 100 ) * 50 ;
        $topComparison['bulletPoint'][$indexModel] =explode( ',', trim( trim( str_replace( ";", ", ", $model->getBulletPoints() ) ), ',' ) ); 
        $topComparison['category'][$indexModel] = $model->getCategory()->getName();
        $topComparison['categoryColor'][$indexModel] = $model->getCategory()->getBgColor();
        $topComparison['categoryLink'][$indexModel] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $model->getCategory()->getNameUrl() ) );
        $topComparison['subcategory'][$indexModel] = $model->getSubcategory()->getName();
        $topComparison['subcategoryLink'][$indexModel] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
            'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl() ) 
        );
        
        if( !empty( $model->getTypology() ) ) {
            $topComparison['typology'][$indexModel] = $model->getTypology()->getName();
            $topComparison['typologyLink'][$indexModel] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl(), 'section3' => $model->getTypology()->getNameUrl() ) 
            );
        }

        $topComparison['id'][$indexModel2] = $comparisonModel->getId();
        $topComparison['price'][$indexModel2] = $comparisonModel->getPrice();
        $topComparison['name'][$indexModel2] = $comparisonModel->getName();
        $topComparison['nameUrl'][$indexModel2] = $comparisonModel->getNameUrl();
        $topComparison['img'][$indexModel2] = $comparisonModel->getImg();
        $topComparison['widthSmall'][$indexModel2] = ( $comparisonModel->getWidthSmall() / 100 ) * 50 ;
        $topComparison['heightSmall'][$indexModel2] = ( $comparisonModel->getHeightSmall() / 100 ) * 50 ;
        $topComparison['bulletPoint'][$indexModel2]    = explode( ',', trim( trim( str_replace( ";", ", ", $comparisonModel->getBulletPoints() ) ), ',' ) );
        $topComparison['category'][$indexModel2] = $comparisonModel->getCategory()->getName();
        $topComparison['categoryColor'][$indexModel2] = $comparisonModel->getCategory()->getBgColor();
        $topComparison['categoryLink'][$indexModel2] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $comparisonModel->getCategory()->getNameUrl() ) );
        $topComparison['subcategory'][$indexModel2] = $comparisonModel->getSubcategory()->getName();
        $topComparison['subcategoryLink'][$indexModel2] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
            'section1' => $comparisonModel->getCategory()->getNameUrl(), 'section2' => $comparisonModel->getSubcategory()->getNameUrl() ) 
        );
        
        if( !empty( $comparisonModel->getTypology() ) ) {
            $topComparison['typology'][$indexModel2] = $comparisonModel->getTypology()->getName();
            $topComparison['typologyLink'][$indexModel2] = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                'section1' => $comparisonModel->getCategory()->getNameUrl(), 'section2' => $comparisonModel->getSubcategory()->getNameUrl(), 'section3' => $comparisonModel->getTypology()->getNameUrl() ) 
            );
        }

        $sModels = $aTopComparison->getNameUrl();
        $topComparison['url'] = $this->wm->routerManager->generate( 'modelComparison', array( 'idModels' => $aTopComparison->getNameUrl() ) );
        $x++;        
        
        $label = new \stdClass;
        $label->name = 'Comprazione prodtti';
        $label->nameUrl = $this->wm->routerManager->generate( 'listModelComparison');
        $label->description = 'Confronta prezzi e caratteristiche dei prodotti e scegli il modello giusto per te';
        $label->bg          = '#3878ab';
        
//        print_r($finalComparison);
        
        return array(
            'topComparison' => $topComparison,
            'comparisonModels' => $finalComparison,
            'label' => $label,
            'pagination'    => $paginationArt,
            'countArticles' => !empty( $countArticles ) ? $countArticles['tot'] : 0,
            'page'          => $this->wm->getPage()
        );
    }
}    

