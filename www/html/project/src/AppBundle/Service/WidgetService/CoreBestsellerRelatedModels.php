<?php

namespace AppBundle\Service\WidgetService;

class CoreBestsellerRelatedModels {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {     
        $route = $this->wm->container->get('app.routerManager')->match( $this->wm->getRequestUri() );
        
        if( !empty( $this->wm->container->getParameter( 'app.debugLinkLinkAssistant' ) ) ) {
            return array();
        }
        
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
        $model = $this->globalQueryUtility->getModelByNameUrl( $route['name'] );       
        if( empty( $model ) )
            return array();
            
        $subcategoryId = !empty( $model->getSubcategory() ) ? $model->getSubcategory()->getId() : false;
        $typologyId    = !empty( $model->getTypology() ) ? $model->getTypology()->getId() : false;
        $price       = $model->getPrice();
                
        $boolQuery = new \Elastica\Query\BoolQuery();   
            
//        $trademarkIds = array();
//        $trademarks = $this->wm->doctrine->getRepository('AppBundle:TopTrademarksSection')->findBySubcatTypoTrademark( $subcategoryId, $typologyId );                                          
//        foreach( $trademarks AS $trademark ) {
//            $trademarkIds[] = $trademark->getTrademarkId();
//        }
        
        if( !empty( $subcategoryId ) ) {                       
            $subcategoryQuery = new \Elastica\Query\Terms();
            $subcategoryQuery->setTerms('subcategory.id', array($subcategoryId));
            $boolQuery->addFilter($subcategoryQuery);
        }
        
        if( !empty( $typologyId ) ) { 
            $typologyQuery = new \Elastica\Query\Terms();
            $typologyQuery->setTerms('typology.id', array($typologyId));
            $boolQuery->addFilter($typologyQuery);                        
        }
        
//        if( !empty( $trademarkIds ) ) { 
//            $trademarkQuery = new \Elastica\Query\Terms();
//            $trademarkQuery->setTerms('trademark.id', $trademarkIds );
//            $boolQuery->addMust($trademarkQuery);                            
//        }
        
        $perc = floor($price / 100 * 20);
   
        $aPrice = array();
        $aPrice['gte'] = (int)$price - $perc;
        $aPrice['lte'] = (int)$price + $perc;        
        
        
        if(!empty( $aPrice['gte'] ) && !empty( $aPrice['lte'] ) && $aPrice['gte'] > $aPrice['lte']  ) {
           $lgt = $aPrice['gte'];
           $aPrice['gte'] = $aPrice['lte'];
           $aPrice['lte'] = $lgt;
        }        
        $filtersActive['prices'] = $aPrice;
                
        if( !empty( $aPrice ) )  {           
            $priceQuery = new \Elastica\Query\Range();
            $priceQuery->addField('price', $aPrice );
            $boolQuery->addFilter( $priceQuery );        
        }        
        
        $finder = $this->wm->container->get('fos_elastica.finder.cmsmodel');        
        $finalQuery = new \Elastica\Query($boolQuery);
        
        $finalQuery->setSort(array('dateImport' => array('order' => 'desc')));
        
        try {            
            
                $finalQuery->setSize(5);
                $finalQuery->setFrom(0);
                $models = $finder->find($finalQuery);            
            

        } catch (\Elastica\Exception\Connection\HttpException $e) {
            return array();
        }
        
        
        $label = new \stdClass;
        $label->name = 'Potrebbero anche interessarti';
        $label->nameUrl = '';
        
        $aModel = array();
        foreach( $models AS &$item ) {
            if( $item->getId() != $model->getId() ) {
                $item->setPrice( $this->wm->setPrice( $item->getPrice() ) );
                $aModel[] = $item;
            }
        }
        if( count( $aModel ) == 4 ) {
//            unset( $aModel[3] );
        }
        
        return array( 
            'models'      => $aModel,
            'label'  => $label
        );
    } 
}