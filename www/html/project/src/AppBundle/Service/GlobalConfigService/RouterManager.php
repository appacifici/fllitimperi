<?php

namespace AppBundle\Service\GlobalConfigService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Environment as Environment;
use AppBundle\Menu\Menu;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpFoundation\Session\Session; 
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author alessandro pacifici
 */
class RouterManager {
    
    protected $twig;    
    protected $container;    
    protected $requestStack;    
    protected $request;
    protected $productDetailPrefix      = '_prezzo';
    protected $categoryTrademarkPrices  = '_prezzi';
    protected $baseUrl  = false;
    
    
    /**
     * Metodo costruttore della classe che instanzia anche la classe padre
     */
    public function __construct( 
            Environment $twig,
            RequestStack $requestStack,
            Container $container
    ) {
        
        $this->twig             = $twig;
        $this->requestStack     = $requestStack;
        $this->container        = $container;        
        $this->request          = $this->requestStack->getCurrentRequest();  
        
        $this->ampActive = false;        
    }
    
    public function setAmpActive( $ampActive = false ) {
        $this->ampActive = $ampActive;
    }
    
    public function setBaseUrl( $baseUrl = false ) {
        $this->baseUrl = $baseUrl;
    }
    
    /**
     * Metodo che recupera la rotta da una url
     * @param type $uri
     */
    public function match( $uri ) {        
        $matchUri = explode( '?', $uri );        
        
        $matchUri =  str_replace( '/amp', '', $matchUri[0] );        
        $this->route = $this->container->get('router')->match( rtrim( $matchUri, '/' ) );            
            
            
        if( $this->route['_route'] == 'app_catsubcattypology_detailproduct' ) {   
            $this->route['_route']  =  'detailProduct';      
            
        } else  if( $this->route['_route'] == 'customRoute' ) {            
            //Controllo per la rotta: Scheda Prodotto TOP ES: /apple_iphone_8_plus_prezzo
            if( substr( $this->route['path'], strlen( $this->route['path'] ) -7, 7  ) == $this->productDetailPrefix  ) {
                $this->route['_route']  =  'detailProduct';
                $path = explode( '_', $this->route['path'] );
                
//                $finalPath = str_replace( $path[0].'_', '', $this->route['path'] );                                
                $finalPath = preg_replace('/'.$path[0].'_/', '', $this->route['path'] , 1);
                $this->route['name']        =  str_replace( $this->productDetailPrefix, '', $finalPath );
                $this->route['section']     =  str_replace( '-', '_', $path[0] );
                
            //Controllo per la rotta: Scheda Prodotto TOP ES: /apple_iphone_8_plus_prezzo
            } else if( substr( $this->route['path'], strlen( $this->route['path'] ) -7, 7  ) == $this->categoryTrademarkPrices  ) {
                
                $this->route['_route'] =  'categoryTrademarkPrices';
                $paths = explode( '_', $this->route['path'] );                
                $this->route['category']  =  $paths[0];
                $this->route['trademark'] =  $paths[1];                
                
            } else if( strpos( $this->route['path'] , '/', '0' ) === false ) {                                
                $this->route['_route'] =  'listProduct';
                $patNormalize = str_replace( $this->container->getParameter( 'app.freeSearchPath' ).'-', '', $this->route['path'] );                
                $paths = explode( '-', $patNormalize );    
                
                $this->route['subcategory']  =  $paths[0];
                if( !empty( $paths[1] ) && $paths[1] != 'uomo' && $paths[1] != 'donna' ) {
                    $this->route['typology'] =  !empty( $paths[1] ) ? $paths[1] : false;
                    
                } else if( !empty( $paths[1] ) && ( $paths[1] == 'uomo' || $paths[1] == 'donna' ) ) {
                    $this->route['sex'] =  !empty( $paths[1] ) ? $paths[1] : false;
                } 
                if( !empty( $paths[2] ) )  {                    
                    if( !empty( $paths[2] ) && $paths[2] != 'uomo' && $paths[2] != 'donna' ) {
                        $this->route['search'] =  !empty( $paths[2] ) ? $paths[2] : false;
                    } else {
                        $this->route['sex'] =  !empty( $paths[2] ) ? $paths[2] : false;
                    }
                } 
                if( !empty( $paths[3] ) )  {
                    $this->route['search'] =  !empty( $paths[3] ) ? $paths[3] : false;
                }                 
            }         
        }        
        return $this->route;
    }
    
    
    
    /**
     * Metodo che genera le url relative ed assolute per il php e per i twig
     * @param type $routeName
     * @param type $params
     * @param type $absolute
     * @return type
     */
    public function generate( $routeName, $params = array(), $absolute = true ) {
        $absolute = !empty( $absolute ) ? UrlGeneratorInterface::ABSOLUTE_URL : $absolute; 
        
        switch( $routeName ) {
            case 'homepage':      
                $route = $this->container->get('router')->generate( $routeName, $params, $absolute );
                $route = $route == 'amp' ? '/amp/' : '/'; 
                
            break;
            case 'impressionLink':  
//                print_r($params);
                if( $params['impressionLink'] ) {      
                    unset( $params['deepLink'] );
                    $route = $this->container->get('router')->generate( $routeName, $params, $absolute );   
                } else {
                    unset( $params['impressionLink'] );
                    $route = $params['deepLink'];
                }
            break;
            case 'allCategoriesProduct':                
            case 'catSubcatTypologyProduct':                
            case 'listModelsTrademark':                        
            case 'modelComparison':        
            case 'dinamycPage':
            case 'storeDatasheet':
            case 'storeOffers':
            case 'storeOffers':            
            case 'AMPlistArticles1':                
            case 'AMPlistArticles2':                   
            case 'listArticles1':                
            case 'listArticles2':                            
            case 'listModelComparison':                            
                $route = $this->container->get('router')->generate( $routeName, $params, $absolute );
            break;        
            case 'detailNews1':
            case 'detailNews2':
            case 'detailNews3':
            case 'detailNewsAmp1':            
            case 'detailNewsAmp2':
            case 'detailNewsAmp3':
            case 'urneCenerarie':
            case 'AMPurneCenerarie':
//                $url = '';
//                if( !empty( $params[ 'megazineSection' ] ) ) {
//                    $url  .= '/'.$params[ 'megazineSection' ];
//                }
//                if( !empty( $params[ 'section1' ] ) ) {
////                    $url  .= '/'.$params[ 'section1' ];
//                } 
////                if( !empty( $params[ 'section3' ] ) ) {
////                    $url  .= '/'.$params[ 'section3' ];       
////                }
////                if( !empty( $params[ 'section4' ] ) ) {
////                    $url  .= '/'.$params[ 'section4' ];
////                }
//                $title = str_replace( '_', '_', $params[ 'title' ] );
////                $url .= '/'.$title.'-'.$params[ 'articleId' ];
//                $url .= '/'.$title;
//                
//                $route = 'https://tricchetto.homepc.it'.$url;  
                
                $route = $this->container->get('router')->generate( $routeName, $params, $absolute );
            break;        
            case 'detailProduct':                
//                if( !empty( $params['typology'] ) )
//                    $sectionName = !empty( $params['typologySingular'] ) ? $params['typologySingular'] : $params['typology'];
//                else
//                    $sectionName = !empty( $params['subcategorySingular'] ) ? $params['subcategorySingular'] : $params['subcategory'];  
                
                
                $url = '';
                if( !empty( $params[ 'section1' ] ) ) {
                    $url  .= '/'.$params[ 'section1' ];
                }
                
                if( !empty( $params[ 'section2' ] ) ) {
                    $url  .= '/'.$params[ 'section2' ];
                } 
                
                if( !empty( $params[ 'section3' ] ) ) {
                    $url  .= '/'.$params[ 'section3' ];       
                }
                
                if( !empty( $params[ 'section4' ] ) ) {
                    $url  .= '/'.$params[ 'section4' ];
                }
                
                
//                $sectionName = str_replace( '_', '_', $params[ 'name' ] );
                $url .= '/prezzo_'.$params[ 'name' ];
//                $this->baseUrl = false;
                if( !empty( $this->baseUrl ) ) {
                    $route = $url;
                } else {
                    $route = $url;
                }                
                
            break;        
            case 'categoryTrademarkPrices':
                $route = $this->container->get('router')->generate( 'customRoute', array( 'path' => $params['category'].'_'.$params['trademark'].$this->categoryTrademarkPrices ), $absolute );
            break;        
            case 'listProduct':
                $path = $params['subcategory'];                
                if( !empty( $params['typology'] ) ) {
                    $path .= '-'.$params['typology'];
                }
                
                if( !empty( $params['sex'] ) )
                    $path .= '-'.$params['sex'];
                if( !empty( $params['search'] ) )
                    $path .= '-'.$params['search'];
                
                $route = $this->container->get('router')->generate( 'customRoute', array( 'path' => $path ), $absolute );                
            break;        
        }
        
        if( !empty( $this->ampActive ) && $routeName != 'impressionLink' ) {
//            if( $absolute == UrlGeneratorInterface::ABSOLUTE_URL) {
//                $temp = explode( '/', $route );
//                $route = $temp[0].'//'.$temp[2].'/amp/'.trim( $temp[3], '/' );
//            } else {
//                $route = '/amp/'.trim( $route, '/' );
//            }
        }
                
        
        return rtrim( $route, '/' );
    }
    
    public function getAllRoutes() {        
        $routes = array(
            'allCategoriesProduct' => 'allCategoriesProduct',
            'catSubcatTypologyProduct' => 'catSubcatTypologyProduct',
            'listModelsTrademark' => 'listModelsTrademark',
            'storeOpinions' => 'storeOpinions',
            'storeDatasheet' => 'storeDatasheet',
            'storeOffers' => 'storeOffers',
            'detailProduct' => 'detailProduct',
            'categoryTrademarkPrices' => 'categoryTrademarkPrices',
            'listProduct' => 'listProduct'
        );
        
        return $routes;
        
    }
}//End Class