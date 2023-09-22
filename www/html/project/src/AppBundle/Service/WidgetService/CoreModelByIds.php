<?php

namespace AppBundle\Service\WidgetService;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\AmazonService\AmazonApi;


class CoreModelByIds {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData() {        
        
      
    }    
    
    public function  getByIds( $items ) {
        $ids = array();
        $labels = array();
        foreach( $items AS $item ) {
            $elements = explode( '[#]', $item );
            if( !empty( $elements[0] ) && !empty( $elements[1] ) ) {
                $ids[]      = $elements[0];
                $labels[]   = $elements[1];
            }
        }
                
        $models = array();
        $this->models = $this->wm->doctrine->getRepository( 'AppBundle:Model' )->findModelByIds( $ids );        
                
        
        $keys = array();
        $i = 0;
        foreach( $ids AS $model ) {
            $keys[trim($model)] = $i;
            $i++;
        }
        
        foreach( $this->models AS $model ) {            
            $x = $keys[$model->getId()];
            $models[$x]['label'] = $labels[$x];    
            
            if( !empty( $model->getBulletPointsGuide() && !is_array( $model->getBulletPointsGuide()  ) ) ) {
                $model->setBulletPointsGuide( preg_split( "/;/", $model->getBulletPointsGuide(), -1, PREG_SPLIT_NO_EMPTY ) );
            } else {
                $model->setBulletPointsGuide('');
            }
            
            $models[$x]['model'] = $model;
                        
            $aProducts = array();
            $aDisabledProduct = array();
            $products = $this->wm->doctrine->getRepository('AppBundle:Product')->findProductsByModel( $model->getId(), 5, 0 );  
//            echo '<br>'.$model->getName();
            foreach ( $products AS $product ) {
                $currentPrice =  number_format( (float) $product->getPrice(),2 );
                
                if( !empty( $product->getToUpdate() ) && $product->getIsActive() == 1 ) {                    
                    $price = str_replace( ',','.', $currentPrice );                    
                    $product->setPrice( $this->wm->setPrice( $price ) );
                    
                    
                    //Trick per rimuovere il codice di tracciamento sui prodotti amazon quando siamo noi a navigare
                    if( !empty( $products ) && !empty( $_SERVER['HTTP_HOST'] ) ) {
                        switch( $_SERVER['HTTP_HOST'] ) {
                            case 'tricchetto.homepc.it':
                            case 'staging.acquistigiusti.it':
//                                foreach( $products AS &$product ) {
                                    $deepLink = explode( '?', $product->getDeepLink() );
                                    $product->setDeepLink( $deepLink[0] );
                                    $product->setImpressionLink( '' );
//                                }
                            break;
                        }
                    }
                    
                    
                    
                    $aProducts[] =  $product;

                } else {
                    $aDisabledProduct[] = $product;
                }
            }
            
            $models[$x]['product'] =  $aProducts;
            $models[$x]['disabledProduct'] =  $aDisabledProduct;
                       
        }
        
        ksort( $models );
        return $models;
    }
    
}


