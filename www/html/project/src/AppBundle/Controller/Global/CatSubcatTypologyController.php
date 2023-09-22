<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class CatSubcatTypologyController extends TemplateController {
        
    /**
     * Rotta per la lista di tutte le categorie
     * @param Request $request
     * @return Response
     */
    public function allCategoriesProductAction( Request $request ) {        
        return $this->getPageFromHttpCache( $request, 'allCategories.xml', true );
    }
    
    public function catSubcatTypologyProductTwoAction( Request $request ) {
        return $this->catSubcatTypologyProductAction( $request );
    }
    
    /**
    * @Route("/{section1}/{section2}/prezzo_{name}", name="detailProduct")    
    * @Route("/{section1}/{section2}/{section3}/prezzo_{name}")    
    * @Route("/{section1}/{section2}/{section3}/{section4}/prezzo_{name}")
    */
    public function detailProductAction( Request $request, $section1, $section2 = false, $section3 = false, $section4 = false, $name ) {
        $this->setParameters();
        $params = new \stdClass;  
        
         if( !empty( $section4 ) ) {
            $catSubcatTypology  = $section4;
        } else if( !empty( $section3 ) ) {
            $catSubcatTypology  = $section3;
        } else if( !empty( $section2 ) ) {
            $catSubcatTypology  = $section2;
        } else if( !empty( $section1 ) ) {
            $catSubcatTypology  = $section1;
        }
        
        $initCatSubcatTypology = explode( '-', $catSubcatTypology );
        $catSubcatTypology = $initCatSubcatTypology [0];        
        $search = !empty( $initCatSubcatTypology [1] ) ? $initCatSubcatTypology [1] : false;
                
        $categoryByName = $this->globalConfigManager->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesByName' );
        $subcategoryByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesByName' );
        $typologyByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesByName' );
        $microSectionByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'microSectionsByName' );
                
        $checkSection = false;
        if ( array_key_exists($catSubcatTypology, (array)$subcategoryByName) ) {
            $checkSection = array_key_exists($section1, (array)$categoryByName) ? true : false;

        } else if ( array_key_exists($catSubcatTypology, (array)$typologyByName) ) {
            $checkSection = array_key_exists($section2, (array)$subcategoryByName) && array_key_exists($section1, (array)$categoryByName) ? true : false;

        } else if ( array_key_exists($catSubcatTypology, (array)$microSectionByName) ) {                
            $checkSection = array_key_exists($section2, (array)$subcategoryByName) && array_key_exists($section1, (array)$categoryByName) && array_key_exists($section3, (array)$typologyByName) ? true : false;
        }          
        
        if( empty( $checkSection ) ) {
            $redirectManager = $this->get( 'app.redirectService' );
            $redirectManager->checkRedirect( $catSubcatTypology );
                
            $response = new Response();
            $params->forceRouteCss = 'listProduct';
            $response->setStatusCode(404);                                            
            $response->setContent( $this->init( "notFound.xml", $request, $params ) );        
            return $response;
        }
        
        if( !empty( $_GET['AB'] ) && $_GET['AB'] == 2 ) {
            $params->forceRouteCss = 'ABTest_detailProduct';            
            return $this->getPageFromHttpCache( $request, "ABTest/detailProduct.xml", true, $params  );
        }
        
        $params->forceRouteCss = 'detailModel';            
        return $this->getPageFromHttpCache( $request, "detailProduct.xml", true, $params  );
    }
    
    /**
    * @Route("/{section1}/{section2}/{section3}/{section4}", name="catSubcatTypologyProduct")
    */
    public function catSubcatTypologyProductAction( Request $request, $section1, $section2 = false, $section3 = false, $section4 = false ) {
        $params = new \stdClass;     
        $this->setParameters();
        $hasModels = false;
        $xml = 'catSubcatTypologyProduct.xml';
        
      
        $params = new \stdClass;  
        $params->forceRouteCss = 'catSubcatTypologyProduct';
         
        if( !empty( $section4 ) ) {
            $catSubcatTypology  = $section4;
        } else if( !empty( $section3 ) ) {
            $catSubcatTypology  = $section3;
        } else if( !empty( $section2 ) ) {
            $catSubcatTypology  = $section2;
        } else if( !empty( $section1 ) ) {
            $catSubcatTypology  = $section1;
        }
        
        $initCatSubcatTypology = explode( '-', $catSubcatTypology );
        $catSubcatTypology = $initCatSubcatTypology [0];        
        $search = !empty( $initCatSubcatTypology [1] ) ? $initCatSubcatTypology [1] : false;
                
        $categoryByName = $this->globalConfigManager->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesByName' );
        $subcategoryByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesByName' );
        $typologyByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesByName' );
        $microSectionByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'microSectionsByName' );
        
        if (array_key_exists($catSubcatTypology, (array)$categoryByName) ) {
                $xml = 'catSubcatTypologyProduct.xml';                
        } else  {
            $checkSection = false;
            if ( array_key_exists($catSubcatTypology, (array)$subcategoryByName) ) {
                $checkSection = true;
                $checkSection = array_key_exists($section1, (array)$categoryByName) ? true : false;
                
            } else if ( array_key_exists($catSubcatTypology, (array)$typologyByName) ) {
                $checkTypology = true;
                $checkSection = array_key_exists($section2, (array)$subcategoryByName) && array_key_exists($section1, (array)$categoryByName) ? true : false;
            
            } else if ( array_key_exists($catSubcatTypology, (array)$microSectionByName) ) {
                $checkTypology = false;
                $hasModels = true;
                $checkSection = array_key_exists($section2, (array)$subcategoryByName) && array_key_exists($section1, (array)$categoryByName) && array_key_exists($section3, (array)$typologyByName) ? true : false;
            }
            
            if( !empty( $checkTypology ) ) {
                if ($typologyByName->$catSubcatTypology->hasModels)
                    $hasModels = true;
            } else {
                if ( !empty( $subcategoryByName->$catSubcatTypology ) && $subcategoryByName->$catSubcatTypology->hasModels)
                    $hasModels = true;
            }
            
            
            if ($hasModels) {
                $xml = 'catSubcatTypologyProduct.xml';                
                
//                $params = new \stdClass;  
//                $params->forceRouteCss = 'listProduct';
//                $xml = 'listProduct.xml';
            } else {
                $params = new \stdClass;  
                $params->forceRouteCss = 'listProduct';                
                $xml = 'listProduct.xml';
            }
            
            
            if( empty( $search )  && empty( $checkSection ) ) {                
                $redirectManager = $this->get( 'app.redirectService' );
                $redirectManager->checkRedirect( $catSubcatTypology );
                
                $this->get('twig')->addGlobal('error404Page', true );
                $response = new Response();
                $response->setStatusCode(404);                                            
                $response->setContent( $this->init( "notFound.xml", $request, $params ) );                                       
                return $response;
            }
            
        }                
        
        
        // se è una ricerca ma la prima parola non è search darà 404 
        if( !empty( $search ) ) {
            if( trim( $initCatSubcatTypology [0] ) != 'search' && empty( $checkSection ) ) {
                $this->get('twig')->addGlobal('error404Page', true );
                
                $response = new Response();
                $response->setStatusCode(404);                                            
                $response->setContent( $this->init( "notFound.xml", $request, $params ) );        
                return $response;
            }
            return $this->getSearch( $search, $hasModels, $catSubcatTypology, $request );
        }
                
        
        $this->get('twig')->addGlobal( 'catSubcatTypologySearch', str_replace( '_', ' ', $catSubcatTypology ) );            
        return $this->getPageFromHttpCache( $request, $xml, true, $params  );
    }
    
    
    
    
    private function getSearch( $search, $hasModels, $catSubcatTypology, $request ) {               
        $this->get('twig')->addGlobal( 'catSubcatTypologySearch', str_replace( '_', ' ', $catSubcatTypology ) );
        $this->get('twig')->addGlobal( 'search', str_replace( '_', ' ', $search ) );
        
        $params = new \stdClass;  
        $params->forceRouteCss = 'listProduct';
        $xml = 'listProduct.xml';        
        
//        $response = new Response();
//        $params->responsePage = $response;        
//        $response->setContent( $this->init( $xml, $request, $params ) );                       
//        return $response;
        
        return $this->getPageFromHttpCache( $request, $xml, true, $params  );
    }
    
}