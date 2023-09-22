<?php

namespace AppBundle\Service\WidgetService;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\AmazonService\AmazonApi;


class CoreModelsComparison {
    
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
               
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
        $comparison = $this->globalQueryUtility->getModelsComparison( $this->wm->getIdModels() );   
        
        if( empty($comparison) ) {            
            return array( 'errorPage' => 404 );
        }        
                
        if( is_array( $comparison ) ) {
            $aModels = array();
            foreach( $comparison AS $model ) {
                $aModels[] = $model;
            }
        } else {                
            $aModels[0] = $comparison->getModelOne();
            $aModels[1] = $comparison->getModelTwo();
        }
        
        $tecnicalType = $aModels[0]->getTecnicalTemplate()->getId();
        
        $aTecnicals = $this->wm->globalConfigManager->getTecnicalTemplates();
        $getTecnicalTemplateId = !empty( $aTecnicals[$tecnicalType] ) ? $aTecnicals[$tecnicalType] : false;        
        $initTmplate =  explode( ';',$getTecnicalTemplateId->template );
        $aComparisonT = array();
        
        foreach( $initTmplate AS $item ) {
            if( strpos( ' '.$item, '[LABEL]' ) !== FALSE ) {
                $aItem = explode( '[LABEL]', $item );
//                    print_r($aItem);

//                    $keyA = trim( str_replace( '[LABEL]', '', $aItem[0] ) );
                $keyB = ucfirst( strtolower( trim( str_replace( '[LABEL]', '', $item ) ) ) );
                $keyB = trim( preg_replace("/\([^)]+\)/","",$keyB) );
                
                
//                    $accept[$keyA] = $keyB; 
                $aComparisonT[$keyB] = array();
                continue;
            }
            $aItem = explode( '[#]', $item ); 
            if( !empty( trim( $aItem[0] ) ) ){ 
                $aItem[0] = preg_replace("/\([^)]+\)/","",$aItem[0]);
                $aComparisonT[$keyB][ucfirst(strtolower( trim($aItem[0] )))] = array();
            }
        }
        
        
        $distinctModel = array();
        $models = array();
        $x = 0;
        
        $h1 = '';
        $xModel = 0;
        foreach( $aModels AS $itemModel ) {
            $finalTecnical = array();
            $tecnical = explode( ';', $itemModel->getTechnicalSpecifications() );
            $i = 0;
            $labelKey = false;
            foreach( $tecnical AS $itemTecnical ) {
                $item = explode( ':', $itemTecnical );
              
                if( empty(  $item[0] ) )
                    continue;

//                preg_replace("/\([^)]+\)/","",$item[0]);
                
                
                
                if( empty( $item[1] ) )
                    $labelKey = ucfirst( strtolower( trim($item[0]) ) ); 
                $i++;
                                
                $labelKey = trim( preg_replace("/\([^)]+\)/","",$labelKey) );                
                
                $item[0] = trim( preg_replace("/\([^)]+\)/","",$item[0]));
                
         
                $aComparisonT[$labelKey][ucfirst( strtolower(trim($item[0])))][$x] = !empty( $item[1] ) ? $item[1] : '';                       
            }                       
            
            $models[$x]['name'] = $itemModel->getName();                        
            $models[$x]['img'] = $itemModel->getImg();                        
            $models[$x]['widthSmall'] = $itemModel->getWidthSmall();
            $models[$x]['heightSmall'] = $itemModel->getHeightSmall();
            $models[$x]['id'] = $itemModel->getId();                        
            $models[$x]['price'] = $itemModel->getPrice();                        
            $models[$x]['video'] = $itemModel->getVideo();                        
            $models[$x]['imagesGallery'] = !empty( $itemModel->getImagesGallery()  ) ? json_decode( $itemModel->getImagesGallery() ) : false;                        
            $models[$x]['bulletPoints'] = preg_split( "/;/", $itemModel->getBulletPoints(), -1, PREG_SPLIT_NO_EMPTY );                     
            $models[$x]['products'] = $products = $this->wm->doctrine->getRepository('AppBundle:Product')->findProductsByModel( $itemModel->getId(), 3, 1 );
                        
            $cat = '';
            if( !empty( $itemModel->getTypology() ) ) {
                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $itemModel->getNameUrl(), 'section1' => $itemModel->getCategory()->getNameUrl(),'section2' => $itemModel->getSubcategory()->getNameUrl(), 'section3' => $itemModel->getTypology()->getNameUrl() ) );
                $cat = $itemModel->getTypology()->getName();
            } else {
                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $itemModel->getNameUrl(), 'section1' => $itemModel->getCategory()->getNameUrl(), 'section2' => $itemModel->getSubcategory()->getNameUrl() ) );
                $cat = $itemModel->getSubcategory()->getName();
            }
            
            $models[$x]['urlModel'] = $urlModel;
            
            $h1 .= ''.$itemModel->getName().' vs ';
            $x++;
            $xModel++;
            
            $distinctModel[$x] = $itemModel->getName();
        }        
        
        foreach( $aComparisonT AS $key => $comparisonT ) {
                foreach( $comparisonT AS $key2 => $item ) {                    
                    for( $p = 0; $p < count( $aModels ); $p++ ) {
                        if( empty( $aComparisonT[$key][$key2][$p] )  ){
                            $aComparisonT[$key][$key2][$p] = '-';
                        }
                    }
                }
            }
//        print_r( $aComparisonT );exit;
//        
        foreach( $aComparisonT AS &$item ) {
            foreach( $item AS &$item2 ) {
                
                if( empty( $item2[0] ) )
                   $item2[0] = ''; 
                if( empty( $item2[1] ) )
                   $item2[1] = '-'; 
               ksort( $item2 );
            }
        }             
        
        foreach( $aComparisonT AS $key1 => &$item ) {            
            foreach( $item AS $key2 => &$item2 ) {      
                $allEmpty = true;
                for( $p = 0; $p < count( $aModels ); $p++ ) {                       
                    if( !empty( $aComparisonT[$key1][$key2][$p] ) && $aComparisonT[$key1][$key2][$p] != '-' ) {
                        $allEmpty = false;
                    }                     
                }                
                if( $allEmpty ) {                 
                    unset( $aComparisonT[$key1][$key2] );
                }
            }            
        }
        
        $h1 = !is_array( $comparison ) && !empty( $comparison->getTitle() ) ? $comparison->getTitle() : 'Comparazione schede tecniche ' .$cat.' '.trim( $h1, 'vs ');
                
        $widthItem = 100 / ( count( $models ) + 1);
                
        if( !empty( $aModels[0]->getTypology() ) ) { 
            $urlSection  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                'section1' => $aModels[0]->getCategory()->getNameUrl(),  'section2' => $aModels[0]->getSubcategory()->getNameUrl(), 'section3' => $aModels[0]->getTypology()->getNameUrl() ) 
            );
            $nameSection = $aModels[0]->getTypology()->getName();
        } else {
            $urlSection  = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                'section1' => $aModels[0]->getCategory()->getNameUrl(),  'section2' => $aModels[0]->getSubcategory()->getNameUrl() ) 
            );
            $nameSection = $aModels[0]->getSubcategory()->getName();
        }
        
        $extraCss = '';
        $width = 85 / count( $aModels );
        $width = '200px';
        
        if( count( $aModels ) > 2 ) {
            switch( count( $aModels ) ) {
                case 3 :
                    $tableWidth = '100%';
                break;
                case 4:
                    $tableWidth = '120%';
                break;
                case 4:
                    $tableWidth = '130%';
                break;
                case 5:                  
                    $tableWidth = '150%';
                break;
                case 6:                  
                    $tableWidth = '170%';
                break;
                default:
                    $tableWidth = '230%';
                break;
            }
            $extraCss = '
                .tecnical-comparison-model {
                    padding: 10px 11%;
                    width: 92%;
                    overflow-y: scroll;
                    max-width:78%;
                    display: block;
                }
                .tecnical-comparison-model table {
                    width: '.$tableWidth.'!important;
                    border-spacing: 5px!important;
                    margin-left: -5px!important;
                }

                .tecnical-comparison-model table tr th, .tecnical-comparison-model table tr td, .tecnical-comparison-model table tr td {
                    width: '.$width.'!important;
                }
                .tecnical-comparison-model table tr th:nth-child(2), .tecnical-comparison-model table tr td:nth-child(2), .tecnical-comparison-model table tr td:nth-child(2) {
//                    width: auto;
                }
                .tecnical-comparison-model table tr th:nth-child(1), .tecnical-comparison-model table tr td:nth-child(1), .tecnical-comparison-model table tr td:nth-child(1) {               
                    width: 150px!important;
                } 
                
                @media (max-width: 1500px) {
                    .tecnical-comparison-model table {
                        width: 150%!important;
                    }
                }


            ';
        }
        
        if( count( $aModels ) > 2 )  {
            $h1 = '';
        }
        
        
        $aComparisonT = $this->replaceDictionary( $aComparisonT, $aModels[0] );
            
        return array(
            'aComparisonT' => $aComparisonT,            
            'models' => $models,            
            'distinctModel' => $distinctModel,            
            'widthItem' => $widthItem,            
            'h1' => $h1,            
            'body' => !is_array( $comparison ) ? $comparison->getBody() : '',            
            'cat' => $cat,            
            'urlSection' => $urlSection,            
            'nameSection' => $nameSection,    
            'extraCss' => $extraCss
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
        $technicalSpecifications = $dictionaryUtility->replaceTechnicalSpecificationsComparison( $technicalSpecifications, $subcategory, $typology );
        return $technicalSpecifications;
    }
}