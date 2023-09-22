<?php

namespace AppBundle\Service\WidgetService;

class CoreBestsellerModels {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {     
        $limitNews = !empty( $options->limitNews ) ? $options->limitNews : 5; 
        $category  = !empty( $options->categoryNews ) ? $options->categoryNews : null; 
        $trademark = !empty( $options->trademark ) ? $options->trademark : null; 
        $affiliate = !empty( $options->affiliation ) ? $options->affiliation : null;
        $subcategory = !empty( $options->subcategory ) ? $options->subcategory : null;
        $typology = !empty( $options->typology ) ? $options->typology : null;
        $label = new \stdClass;
        $label->name = 'Prodotti più popolari';
        
        $route = $this->wm->container->get('app.routerManager')->match( $this->wm->getRequestUri() );                
        
        $extraClass = '';
        $notModelId = false;
        if( empty( $category ) && empty( $subcategory ) && empty( $typology ) && empty( $affiliate ) && empty( $trademark ) ) {
            $parmas = $this->wm->getCatSubcatTypology();
            $catSubcatTypology = $parmas['catSubcatTypology'];
            
            
            //Se questo core viene incluso da un dettaglio prodotto
            if( $route['_route'] == 'detailProduct'  ) {
                $route = $this->wm->container->get('app.routerManager')->match( $this->wm->getRequestUri() );        
                $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
                $model = $this->globalQueryUtility->getModelByNameUrl( $route['name'] ); 
                if( empty( $model ) )
                    return array( 'errorPage' => 404 );
                
                $subcategory = !empty( $model->getSubcategory() ) ? $model->getSubcategory()->getId() : false;
                $typology    = !empty( $model->getTypology() ) ? $model->getTypology()->getId() : false;                
                $extraClass = 'releatedModel';
                $notModelId = $model->getId();
            }
            
            $subcategoryByName = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'subcategoriesByName' );
            $typologyByName = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'typologiesByName' );
            $tardemarkByName = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'trademarksByName' );
            
            if ( array_key_exists($catSubcatTypology, (array)$subcategoryByName) ) {
                $subcategory = $subcategoryByName->{$catSubcatTypology}->id;
            } else if ( array_key_exists($catSubcatTypology, (array)$typologyByName) ) {
                $typology = $typologyByName->{$catSubcatTypology}->id;
            }
                        
            if ( !empty( $route['trademark'] ) && array_key_exists($route['trademark'], (array)$tardemarkByName) ) {
                $trademark = $tardemarkByName->{$route['trademark']}->id;
            }
            
//            if( empty( $subcategory ) && empty( $typology ) )
//                return array();
            
            
            $models = $this->wm->doctrine->getRepository('AppBundle:Model')->getBestsellerModels( $limitNews, $category, $subcategory, $typology, $trademark, $affiliate );
            if( empty( $models ) ) {            
                return array();
            }
                      
            $labelTrademark = !empty( $route['trademark'] ) ? $route['trademark'] : '';
            $label->name = ucwords( str_replace( '_', ' ', $catSubcatTypology. ' '.ucfirst($labelTrademark) ) );
            $label->nameUrl = false;
            
            $label->name = 'Prodotti più popolari';
            
            //Se questo core viene incluso da un dettaglio prodotto
            if( $route['_route'] == 'detailProduct'  ) {
                $nameLabelTop = !empty( $model->getTypology() ) ? $model->getTypology()->getName() : $model->getSubcategory()->getName(); 
                $label = new \stdClass;
                $label->name = 'Top '.$nameLabelTop;
                $label->nameUrl = false;
                $label->notBestseller = true;
            }
            
        } else {        
            $label = new \stdClass;        
                                                
            $models = $this->wm->doctrine->getRepository('AppBundle:Model')->getBestsellerModels( $limitNews, $category, $subcategory, $typology, $trademark, $affiliate );
            if( empty( $models ) ) {            
                return array();
            }

            if( !empty( $category ) ) {
                $label->name = $models[0]->getCategory()->getName();
                $label->nameUrl = $models[0]->getCategory()->getNameUrl();
            }

            if( !empty( $subcategory ) ) {            
                $label->name = $models[0]->getSubcategory()->getName();
                $label->nameUrl = $models[0]->getSubcategory()->getNameUrl();        
            }

            if( !empty( $typology ) ) {            
                $label->name = $models[0]->getTypology()->getName();
                $label->nameUrl = $models[0]->getTypology()->getNameUrl();        
            }
        }
        
        
                
//        
//        if( $route['_route'] == 'allListProductsSection'  ) {
//            $label->nameUrl = false;
//            $label->name = 'Prodotti '.$label->name.' più popolari';
//            $label->nameUrl = false;
//            $label->notBestseller = true;
//        }
                
        $finalModel = array();        
        $i = 1;
        foreach( $models AS $model ) {
            if( $model->getId() == $notModelId )
                continue;
            
            if( count($models) > 6 && count($models) < 12 && $i > 6 ) {
//                continue;
            }
            
            $model->setPrice( $this->wm->setPrice( $model->getPrice() ) );
            $finalModel[] = $model;
            $i++;
        }
                                
        return array( 
            'models'      => $finalModel,
            'label'  => $label,
            'extraClass' => $extraClass
        );
    } 
}