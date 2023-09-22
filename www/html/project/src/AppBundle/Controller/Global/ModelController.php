<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class ModelController extends TemplateController {
        
//    
//    /**  
//     * @Route( "/priceTrendModel/{idModel}", name="priceTrendModel" )     
//     * @Route( "/amp/priceTrendModel/{idModel}", name="ampPriceTrendModel" )     
//     */
//    public function priceTrendModelAction( Request $request, $idModel ) { 
//        $this->setParameters();      
//        $model = $this->getDoctrine()->getRepository('AppBundle:Model')->findOneById( $idModel );               
//        
//        return $this->render(
//            'template/widget_PriceTrendModel.html.twig',
//            array('model' => $model, 'includeContainer' => true )
//        );                
//        exit;
//    }        
       
    public function modelComparisonAction( Request $request, $idModels ) {         
        return $this->getPageFromHttpCache( $request, 'modelComparison.xml' );
        exit;
    }
        
       
    public function listModelComparisonAction( Request $request ) {     
        $params = new \stdClass;
        $params->forceRouteCss = 'listModelsComparison';    
        
        return $this->getPageFromHttpCache( $request, 'listModelsComparison.xml', true, $params );
        exit;
    }
       
    public function getImpressionLinkAction( Request $request, $impressionLink ) { 
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->findOneByImpressionLink( $impressionLink );
        $product->setGoToClick( $product->getGoToClick() + 1 );        
        $this->getDoctrine()->getManager()->flush();        
        header( 'Location: '. $product->getDeepLink().'');                        
        exit;
    }
    
    
    public function ampSearchAction( Request $request ) {        
        if( empty( $request->query->get("search") ) )
            return false;
       
        $search = str_replace( array( ' ', '-'), array( '_', '_' ), $request->query->get("search") ); 
        
        if(is_numeric( $request->query->get("category") ) ) {
            $aCat = $this->getDoctrine()->getRepository('AppBundle:Category')->findOneById( $request->query->get("category") );
            $category = !empty( $aCat ) ? $aCat->getNameUrl().'-' : '';
            
        } else { 
            $category = !empty( $request->query->get("category") ) ? $request->query->get("category").'-' : '';
        }
        $url = $this->container->getParameter( 'app.freeSearchPath').'-'.trim( $search );
        
        
        header('Location: '.trim($url,'_').'');
        exit;
    }
    
    /**
     * Rotta per la lista di tutte le categorie
     * @param Request $request
     * @return Response
     */
    public function suggestionModelAction( Request $request ) {
        $this->setParameters();        
        
        $finder = $this->get('fos_elastica.finder.cmsmodel');
        
        $boolQuery = new \Elastica\Query\BoolQuery();        
//        $fieldQuery = new \Elastica\Query\MultiMatch();        
//        $fieldQuery->setOperator('and');
//        $fieldQuery->setFields('name');
//        $fieldQuery->setQuery( $request->query->get('search') );                
        if( empty( $request->query->get('search') ) ) {
            $response = new Response( '' );
            return $response;
        }
        
        $search = preg_replace("#([^a-z0-9])#i", ' ', $request->query->get('search') ); 
        
        $search = str_replace( array('-'), array('_'), $search);
        $search = explode( ' ', $search );        
        $aSearch = '';
        foreach( $search AS $item ) {
            if( strlen( $item ) > 2 )
                $aSearch .= ''.substr( $item, 0, -1 ).'* ';
            else
                $aSearch .= $item.' ';
        }      
        
        $query = new \Elastica\Query();
        $q = new \Elastica\Query\QueryString( $aSearch  );
        $q->setDefaultOperator( 'and' );       
        $query->setQuery( $q );       
//        $query->addSort(array('isTop' => array('order' => 'asc')));
        
//        $boolQuery->addMust($fieldQuery);
        
//        $finalQuery = new \Elastica\Query($boolQuery);
//        $finalQuery->setSort(array('isTop' => array('order' => 'asc')));
        
        $query->setSize( 6 );
        $query->setFrom( 0 );
        
        $models = $finder->find($query);        
            
        usort( $models, function($a, $b) { //Sort the array using a user defined function
            return ( $a->getImg() < $b->getImg() );
        });
                
        
        $search = explode( ' ', $request->query->get('search') );
        $aSearch = '';
        foreach( $search AS $item ) {
            if( strlen( $item ) > 2 )
                $aSearch .= ''.substr( $item, 0, -1 ).'* ';
            else
                $aSearch .= $item.'* ';
        }
        
        $finder = $this->get('fos_elastica.finder.cmsadmin');
        $query = new \Elastica\Query();
        
        $q = new \Elastica\Query\QueryString( $aSearch  );
        $q->setDefaultOperator( 'and' ); 
//        $q->setFields(array('name'));
        $query->setQuery( $q );       
       
        $query->setSize( 6 );
        $query->setFrom( 0 );
        
        $products = $finder->find($query);        
        
        
        
        $finder = $this->get('fos_elastica.finder.cmstypologies');
        $query = new \Elastica\Query();
        $q = new \Elastica\Query\QueryString( $aSearch  );
        $q->setDefaultOperator( 'and' );       
        $query->setQuery( $q );       
       
//        $query->setSize( 3 );
//        $query->setFrom( 0 );
        
        $typologies = $finder->find($query);        
        
        
        $html = $this->get('twig')->render( $this->versionSite.'/widget_SuggestionModel.html.twig', 
            array( 'models' => $models, 'megazine' => $products, 'typologies' => $typologies ) 
        );          
        $response = new Response( $html );
        return $response;
    }
    
    /**
     * @Route( "/advanced/autosuggest/search_list", name="autosuggestamp" )     
     * @Route( "/amp/advanced/autosuggest/search_list", name="autosuggestamp2" )      
     */
    public function autosuggestampAction( Request $request ) { 
//        $this->setParameters();        
        
        $finder = $this->get('fos_elastica.finder.cmsmodel');
        
        $boolQuery = new \Elastica\Query\BoolQuery();        
//        $fieldQuery = new \Elastica\Query\MultiMatch();        
//        $fieldQuery->setOperator('and');
//        $fieldQuery->setFields('name');
//        $fieldQuery->setQuery( $request->query->get('search') );                
        
        $search = explode( ' ', $request->query->get('q') );
        $aSearch = '';
        foreach( $search AS $item ) {
            if( strlen( $item ) > 2 )
                $aSearch .= ''.substr( $item, 0, -1 ).'* ';
            else
                $aSearch .= $item.' ';
        }
        
        $query = new \Elastica\Query();
        $q = new \Elastica\Query\QueryString( $aSearch  );
        $q->setDefaultOperator( 'and' );       
        $query->setQuery( $q );       
//        $query->addSort(array('isTop' => array('order' => 'asc')));
        
//        $boolQuery->addMust($fieldQuery);
        
//        $finalQuery = new \Elastica\Query($boolQuery);
//        $finalQuery->setSort(array('isTop' => array('order' => 'asc')));
        
        $query->setSize( 3 );
        $query->setFrom( 0 );
        
        $models = $finder->find($query);                
        
        $result = array();
        $result['items'] = array();
        $result['items'][0]['query'] = $aSearch;
        $result['items'][0]['results'] = array();
        
        $this->routerManager = $this->get( 'app.routerManager' );
        
        $x = 0;
       
        $finder = $this->get('fos_elastica.finder.cmstypologies');
        $query = new \Elastica\Query();
        $q = new \Elastica\Query\QueryString( $aSearch  );
        $q->setDefaultOperator( 'and' );       
        $query->setQuery( $q );              
//        $query->setSize( 3 );
//        $query->setFrom( 0 );        
        $typologies = $finder->find($query);   
        
        if( !empty( $typologies ) ) {
            $result['items'][0]['results'][$x]['separator'] = 'Sezioni';
            $result['items'][0]['results'][$x]['img'] = 'oo';
            foreach( $typologies AS $typology ) {                

                $result['items'][0]['results'][$x]['name'] = substr( $typology->getName(), 0, 30 );
                $result['items'][0]['results'][$x]['img'] = false;
                $result['items'][0]['results'][$x]['price'] = false;

                $result['items'][0]['results'][$x]['adviceprice'] = false;            
                $result['items'][0]['results'][$x]['url'] = $this->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $typology->getNameUrl() ) );
                $result['items'][0]['results'][$x]['targetBlank'] = false;
                $result['items'][0]['results'][$x]['class'] = 'section';
                $x++;
            }      
        }
        
        $result['items'][0]['results'][$x]['separator'] = 'Modelli';
        $result['items'][0]['results'][$x]['img'] = 'oo';
        $x++;
        
        foreach( $models AS $model ) {
            $result['items'][0]['results'][$x]['name'] = $model->getName();
            $result['items'][0]['results'][$x]['img'] = '/imagesModels/'.$model->getImg();
            $result['items'][0]['results'][$x]['price'] = $model->getPrice();
            
            $result['items'][0]['results'][$x]['adviceprice'] = !empty( $model->getAdvisedPrice() ) ? $model->getAdvisedPrice() : false;
            
            
            if( !empty( $model->getTypology() ) ) {
                $urlModel = $this->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'typology' => $model->getTypology()->getNameUrl(), 'typologySingular' => $model->getTypology()->getSingularNameUrl() ) );
            } else {
                $urlModel = $this->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'subcategory' => $model->getSubcategory()->getNameUrl(), 'subcategorySingular' => $model->getSubcategory()->getSingularNameUrl() ) );
            }
            
            $result['items'][0]['results'][$x]['url'] = $urlModel;
            $result['items'][0]['results'][$x]['targetBlank'] = false;
            $result['items'][0]['results'][$x]['class'] = '';
            $x++;
        }        
        
//        usort( $result['items'][0]['results'], function($a, $b) { //Sort the array using a user defined function
//            return ( $a['img'] < $b['img'] );
//        });
        
        
        
        $search = explode( ' ', $request->query->get('q') );
        $aSearch = '';
        foreach( $search AS $item ) {
            if( strlen( $item ) > 2 )
                $aSearch .= ''.substr( $item, 0, -1 ).'* ';
            else
                $aSearch .= $item.'* ';
        }
        
        $result['items'][0]['results'][$x++]['separator'] = 'Prodotti';
        
        $finder = $this->get('fos_elastica.finder.cmsproduct');
        $query = new \Elastica\Query();
        $q = new \Elastica\Query\QueryString( $aSearch  );
        $q->setDefaultOperator( 'and' );       
        $query->setQuery( $q );       
        $query->setSize( 3 );
        $query->setFrom( 0 );
        
        $products = $finder->find($query);   
        if( !empty( $products ) ) {
            foreach( $products AS $product ) {
                if( empty( $product->getPriorityImg() ) or empty( $product->getPriorityImg()->getImg() ) )
                    continue;

                $result['items'][0]['results'][$x]['name'] = substr( $product->getName(), 0, 30 );
                $result['items'][0]['results'][$x]['img'] = '/imagesProductsSmall/'.$product->getPriorityImg()->getImg();
                $result['items'][0]['results'][$x]['price'] = $product->getPrice();

                $result['items'][0]['results'][$x]['adviceprice'] = false;            
                $result['items'][0]['results'][$x]['url'] = $this->routerManager->generate( 'impressionLink', array( 
                    'impressionLink' => $product->getImpressionLink(),
                    'deepLink' => $product->getDeepLink() 
                    ) 
                );
                $result['items'][0]['results'][$x]['targetBlank'] = true;
                $result['items'][0]['results'][$x]['class'] = '';
                $x++;
            }      
        }
        
        

        return new JsonResponse( $result );
    }        
    
}