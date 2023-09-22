<?php

namespace AppBundle\Service\WidgetService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;
use Twig_Environment as Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Service\UtilityService\GlobalUtility;
use AppBundle\Service\FormService\FormManager;
use AppBundle\Service\UserUtility\UserManager;
use AppBundle\Service\GlobalConfigService\GlobalTwigExtension;
use AppBundle\Service\GlobalConfigService\GlobalConfigManager;
use AppBundle\Service\GlobalConfigService\RouterManager;

class WidgetManager {
    
    public $twig;
    public $doctrine;
    public $memcached;
    public $requestStack;
    public $mobileDetector;
    public $container;

    /**
     * Oggetti che devono essere disponibili su tutti i widget
     * @param \Symfony\Component\Templating\EngineInterface $templating
     */
    public function __construct( 
            RouterManager $routerManager,
            Environment $twig, 
            RequestStack $requestStack,
            ObjectManager $doctrine, 
            GlobalUtility  $globalUtility,
            Container $container,
            FormManager $formManager,
            UserManager $userManager,
            GlobalConfigManager $globalConfigManager            
        ) {
        $this->twig             = $twig;
        $this->requestStack     = $requestStack;
        $this->doctrine         = $doctrine;   
        $this->container        = $container;        
        $this->globalUtility    = $globalUtility;        
        $this->browserUtility   = $globalUtility->browserUtility;       
        $this->cacheUtility     = $globalUtility->cacheUtility;       
        $this->imageUtility     = $globalUtility->imageUtility;  
        $this->formManager      = $formManager;         
        $this->userManager      = $userManager;         
        $this->routerManager    = $routerManager;         

        $this->globalConfigManager = $globalConfigManager;
        
        $this->cacheUtility->initPhpCache();
        $this->memcached = $this->cacheUtility;
        
        $this->container->get( 'app.globalTwigExtension' );        
    }
    
    public function setPrice( $price ) {
        if( strpos( $price, '.', 0 ) !== false )  {
            $price = str_replace( ".", ",", $price );       
           
            $floatNum = $price;
            $length = strlen($floatNum);

            $pos = strpos($floatNum, ","); // zero-based counting.

            if( $num_of_dec_places = ($length - $pos) - 1 < 2 ) 
               $price = $price.'0';                 
        } else {
            $price = $price.',00';
        }
        return $price;
    }
    
    public function getTotalPrice( $price, $shippingPrice ) {
        $totalPrice = floatval( $price ) + floatval( $shippingPrice );
        return $totalPrice = $this->setPrice( $totalPrice );
    }
    
    public function getInternalProductAmazonCode( $string ) {
        
        preg_match_all("/\[\#\[([A-Za-z0-9; ]+?)\]\#\]/", $string, $matches);
        
        $ids = array();
        foreach( $matches[1] As $match ) {
            $ids[] = str_replace( array( '[[#', '#]]'), '', $match );
        }
        return $ids;
    }
    
    public function replaceInternalProductAmazonCode( $string ) {
        
        preg_match_all("/\[\#\[([A-Za-z0-9; ]+?)\]\#\]/", $string, $matches);
        
        $i = 0;
        foreach( $matches[1] As $match ) {
            $productId = str_replace( array( '[[#', '#]]'), '', $match );
            
            $strRep = "[#[$productId]#]";
            $strRep2 = "<p>[#[$productId]#]</p>";
            
            $aProduct = explode( ';', $productId );
            $productId      = $aProduct[0];
            $labelProduct   = !empty( $aProduct[1] ) && $aProduct[1] != 'false' ? $aProduct[1] : false;
            $typeCss        = !empty( $aProduct[2] ) ? $aProduct[2] : false;
            
            $entity = 'Product';
            $product = $this->doctrine->getRepository('AppBundle:'.$entity)->findElementById( $productId );
            if( empty( $product ) ) {
                $string = str_replace( $strRep, '', $string );
                continue;
            }
            $currentPrice =  number_format( (float) $product->getPrice(),2 );
            $price = str_replace( ',','.', $currentPrice );                    
            $product->setPrice( $this->setPrice( $price ) );
            
//            $product->setPrice( $this->setPrice( $product->getPrice() ) );
//            $product->setLastPrice( $this->setPrice( $product->getLastPrice() ) );
            
//            if( (int)$product->getLastPrice() < (int)$product->getPrice() ) {
//                $perc = ( floatval( $product->getPrice() ) / 100 ) * 20;
//                $lastPrice =  ( floatval( $product->getPrice() )  + $perc);                
//                $product->setLastPrice( $this->setPrice( $lastPrice ) );                                
//            }
            
            //Trick per rimuovere il codice di tracciamento sui prodotti amazon quando siamo noi a navigare
            if( !empty( $product ) && !empty( $_SERVER['HTTP_HOST'] ) ) {
                switch( $_SERVER['HTTP_HOST'] ) {
                    case 'tricchetto.homepc.it':
                    case 'staging.acquistigiusti.it':
                        $deepLink = explode( '?', $product->getDeepLink() );
                        $product->setDeepLink( $deepLink[0] );
                        $product->setImpressionLink( '' );
                    break;
                }
            }
          
            
            if( !empty( $product->getBulletPoints() ) && !is_array( $product->getBulletPoints() ) ) {
                $product->setBulletPoints( preg_split( "/;/", $product->getBulletPoints(), -1, PREG_SPLIT_NO_EMPTY ) );
                
            } else if( !empty( $product->getModel() ) &&  !empty( $product->getModel()->getBulletPointsGuide() && !is_array( $product->getModel()->getBulletPointsGuide()  ) ) ) {
                $product->setBulletPoints( preg_split( "/;/", $product->getModel()->getBulletPointsGuide(), -1, PREG_SPLIT_NO_EMPTY ) );
            }
            
            $labelCss = $i == 0 ? 'style="background-color: #ce481e;"' : 'style="background-color: #8bc34a;"';
            
            $finalItem = $this->twig->render( $this->globalConfigManager->versionSite.'/widget_NewsProductAmazon.html.twig', 
                array( 'product' => $product, 'labelProduct' => $labelProduct, 'typeCss' => $typeCss, 'labelCss' => $labelCss ) 
            );          
            
            $string = str_replace( $strRep2, $finalItem, $string );
            $string = str_replace( $strRep, $finalItem, $string );
            $i++;
        }
        
        //rimuovo il bug dell'editor che aggiuunge sempre quel cazzo di tag p
        $string = str_replace( '<p><table class="Offert">', '<table class="Offert">' , $string );
        $string = str_replace( '</table></p>', '</table>' , $string );
        $string = str_replace( '</table> </p>', '</table>' , $string );
        $string = str_replace( '</table>  </p>', '</table>' , $string );
        $string = str_replace( '</table>   </p>', '</table>' , $string );
        
        return $string;
    }
    
    public function replacePlaceholderInternalLink( $string ) {
        preg_match_all("/\[\[\#([A-Za-zìèùàòé0-9; ]+?)\#\]\]/", $string, $matches);
        foreach( $matches[0] As $match ) {
            $item = str_replace( array( '[[#', '#]]'), '', $match );
            $aItem = explode( ';', $item );
//            print_r($aItem);
            
            $entity = !empty( $aItem[2] ) ? ucfirst( strtolower( $aItem[2] ) ) : 'Model';                   
            $item = $this->doctrine->getRepository('AppBundle:'.$entity)->find( $aItem[1] );
            if( empty( $item ) ) {
                return $string;
            }
            
            
            if( $entity == 'Model' ) {
                if( !empty( $item->getTypology() ) ) {
                    $url = $this->routerManager->generate( 'detailProduct', array( 'name' => $item->getNameUrl(), 'section1' => $item->getCategory()->getNameUrl(), 'section2' => $item->getSubcategory()->getNameUrl(), 'section3' => $item->getTypology()->getNameUrl() ) );
                } else {
                    $url = $this->routerManager->generate( 'detailProduct', array( 'name' => $item->getNameUrl(), 'section1' => $item->getCategory()->getNameUrl(), 'section2' => $item->getSubcategory()->getNameUrl() ) );
                }
            } else if( $entity == 'Subcategory' ) {
                $url= $this->routerManager->generate( 'catSubcatTypologyProduct', array( 
                    'section1' => $item->getCategory()->getNameUrl(),
                    'section2' => $item->getNameUrl(),
                ));
            } else if( $entity == 'Typology' ) {
                $url= $this->routerManager->generate( 'catSubcatTypologyProduct', array( 
                    'section1' => $item->getCategory()->getNameUrl(),
                    'section2' => $item->getSubcategory()->getNameUrl(),
                    'section3' => $item->getNameUrl() 
                ));
            } else if( $entity == 'Searchterm' ) {
                 $search = !empty( $item->getName() ) ? $item->getName() : false;  
                    
                if( !empty( $item->getTypology() ) ) {
                     $url = $this->routerManager->generate( 'catSubcatTypologyProduct', array(
                         'section1' => $item->getCategory()->getNameUrl(),
                         'section2' => $item->getSubcategory()->getNameUrl(), 
                         'section3' => $item->getTypology()->getNameUrl().'-'.$search ) 
                     );
                 } else {
                     $url = $this->routerManager->generate( 'catSubcatTypologyProduct', array(
                         'section1' => $item->getCategory()->getNameUrl(),
                         'section2' => $item->getSubcategory()->getNameUrl().'-'.$search, 
                     ));
                 }
            }
                        
            $finalItem = "<a href='$url'>$aItem[0]</a>";            
            
            if( count( $aItem ) == 3 ) {
                $strRep = "[[#$aItem[0];$aItem[1];$aItem[2]#]]";
            } else {
                $strRep = "[[#$aItem[0];$aItem[1]#]]";
            }
            
            $string = str_replace( $strRep, $finalItem, $string );
        }
        return $string;
    }
    
    
    /**
     * Metodo che controlla se l'utente è loggato ed ha i permessi necessari a utilizzare il core
     * @param type $action
     * @param type $type
     */
    public function getPermissionCore( $action=false, $type=false ) {        
//        if( empty( $this->userManager->isLogged() ) ) {
//            echo 'si';
////            header( 'Location: /admin/login' );
//        }
        $this->userManager->getGroupPermission();
        $groupPermission = $this->userManager->getPermissionByGroup();      
        $this->twig->addGlobal( 'permission', $groupPermission );
        
        if( !empty( $action ) && ( empty( $groupPermission ) || empty( $groupPermission->{$action}->{$type} ) ) ) {
            return false;
        }
        return true;
    }    
    
    public function getVersionSite() {
       return  $this->globalConfigManager->getVersionsite();
    }
    
    /**
     * Metodo che recupera il matchId
     * @return boolean
     */
    public function getAllParamsFromGetRequest() {
        $request     = $this->requestStack->getCurrentRequest();
        if ( !empty ($_GET ) )
            return $_GET;
        return false;
    }
    
    /**
     * Metodo che recupera il matchId
     * @return boolean
     */
    public function getSetLikeArticle() {
        if ( !empty ( $_GET['setLike'] ) )
            return true;
        return false;
    }
    
    /**
     * Metodo che recupera il matchId
     * @return boolean
     */
    public function getSpeakArticleArticle() {
        if ( !empty ( $_GET['speakArticle'] ) )
            return true;
        return false;
    }
    
    /**
     * Metodo che recupera il matchId
     * @return boolean
     */
    public function getUrlId() {
        $request     = $this->requestStack->getCurrentRequest();
        $feedMatchId = $request->get( 'id' );
        if( !empty( $feedMatchId ) )
            return $feedMatchId;
        return false;
    }
    
    /**
     * Metodo che recupera il matchId
     * @return boolean
     */
    public function getPollId() {
        $request     = $this->requestStack->getCurrentRequest();
        $pollId = $request->get( 'pollId' );
        if( !empty( $pollId ) )
            return $pollId;
        return false;
    }
    /**
     * Metodo che recupera il matchId
     * @return boolean
     */
    public function getArticle() {
        $request     = $this->requestStack->getCurrentRequest();
        $article = $request->get( 'articolo' );
        if( !empty( $article ) )
            return $article;
        return false;
    }
    
    /**
     * Metodo che recupera la category
     * @return boolean
     */
    public function getUrlCategory() {
        $request     = $this->requestStack->getCurrentRequest();
        $urlCategory = $request->get( 'category' );
        if( !empty( $urlCategory ) )
            return $urlCategory;
        return false;
    }
    
    /**
     * Metodo che recupera la category
     * @return boolean
     */
    public function getUrlArticleId() {
        $request     = $this->requestStack->getCurrentRequest();
        $urlArticleId = $request->get( 'articleId' );
        if( !empty( $urlArticleId ) )
            return $urlArticleId;
        return false;
    }
    
    /**
     * Metodo che recupera gli $idModels
     * @return boolean
     */
    public function getIdModels() {
        $request     = $this->requestStack->getCurrentRequest();
        $idModels = $request->get( 'idModels' );
        if( !empty( $idModels ) )
            return $idModels;
        return false;
    }
    
    /**
     * Metodo che recupera la category
     * @return boolean
     */
    public function getUrlTitleNews() {
        $request     = $this->requestStack->getCurrentRequest();
        $title= $request->get( 'title' );
        if( !empty( $title ) )
            return $title;
        return false;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getUrlSubcategory() {
        $request     = $this->requestStack->getCurrentRequest();
        $urlSubcategory = $request->get( 'subcategory' );
        if( !empty( $urlSubcategory ) )
            return $urlSubcategory;
        return false;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getUrlTypology() {
        $request     = $this->requestStack->getCurrentRequest();
        $urlTypology = $request->get( 'typology' );
        if( !empty( $urlTypology ) )
            return $urlTypology;
        return false;
    }
    
    /**
     * Metodo che recupera la stringa di ricerca su getty images
     * @return boolean
     */
    public function getUrlSearchString() {
        $request            = $this->requestStack->getCurrentRequest();
        $urlSearchString    = $request->get( 'searchString' );
        if( !empty( $urlSearchString ) )
            return $urlSearchString;
        return false;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getPage() {
        $request     = $this->requestStack->getCurrentRequest();
        $page = $request->get( 'page' );
        if( !empty( $page ) )
            return $page;
        return 1;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getFilterColors() {
        $request     = $this->requestStack->getCurrentRequest();
        $colors = $request->query->get( 'colors' );
        if( !empty( $colors ) )
            return $colors;
        return false;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getFilterSizes() {
        $request    = $this->requestStack->getCurrentRequest();
        $sizes      = $request->query->get( 'sizes' );
        if( !empty( $sizes ) )
            return $sizes;
        return false;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getFilterMinPrice() {
        $request    = $this->requestStack->getCurrentRequest();
        $minPrice   = $request->query->get( 'minPrice' );
        if( !empty( $minPrice ) )
            return $minPrice;
        return false;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getFilterMaxPrice() {
        $request    = $this->requestStack->getCurrentRequest();
        $maxPrice   = $request->query->get( 'maxPrice' );
        if( !empty( $maxPrice ) )
            return $maxPrice;
        return false;
    }
    
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getSearch() {
        $request    = $this->requestStack->getCurrentRequest();
        $search   = $request->query->get( 'search' );
        if( !empty( $search ) )
            return $search;
        return false;
    }
    
    public function getMegazineSection() {
        $request    = $this->requestStack->getCurrentRequest();
        $megazineSection =   $request->get( 'megazineSection' );
        if( !empty( $megazineSection ) )
            return $megazineSection;
        return false;
    }
    
    /**
     * Metodo che parsa la url di una sottocategoria tipologia o ricerca dalla parametro base della rotta
     * @return boolean
     */
    public function getCatSubcatTypology() {
        $request     = $this->requestStack->getCurrentRequest();
//        $catSubcatTypology = $request->get( 'catSubcatTypology' );        
        
        $type = 'MicroSection';
        $catSubcatTypology = false;
        if( !empty( $request->get( 'section4' ) ) ) {
            $catSubcatTypology  = $request->get( 'section4' );
        } else if( !empty( $request->get( 'section3' ) ) ) {
            $catSubcatTypology  = $request->get( 'section3' );
            $type = 'Typology';
        } else if( !empty( $request->get( 'section2' ) ) ) {
            $catSubcatTypology  = $request->get( 'section2' ); 
            $type = 'Subcategory';
        } else if( !empty( $request->get( 'section1' ) ) ) {
            $catSubcatTypology  = $request->get( 'section1' );
            $type = 'Category';
        }
        
        $params = explode( '-', trim( $catSubcatTypology, '/' ) ); 
        $end =  end( $params );        
        $sexName = false;
        $search = false;        
        
        if( $end == 'uomo' || $end == 'donna' ) {
            array_pop( $params );
            $sexName = $end;
        } else {
            if( count( $params ) > 1 ) {
                $search = $end;
                array_pop( $params );
            }
        }
        return array( 'catSubcatTypology' => end( $params ), 'sex' => $sexName, 'search' => $search, 'typeSection' => $type );        
    }
    
    /**
     * Metodo che parsa la url di una sottocategoria tipologia o ricerca dalla url
     * @return type
     */
    public function getParametersByCustomUri() {
        $params = explode( '-', trim( $_GET['uri'], '/' ) );
        $end =  end( $params );       
        $sexName = false;        
        if( $end == 'uomo' || $end == 'donna' ) {
            array_pop( $params );
            $sexName = $end;
        }        
        return array( 'catSubcatTypology' => end( $params ), 'sex' => $sexName );
    }
    
    /**
     * Metodo che parsa la url di una sottocategoria tipologia o ricerca dalla REDIRECT_URL
     * @return type
     */
    public function getParametersByCustomUrl() {  
        $request     = $this->requestStack->getCurrentRequest();
        $requestUri     = str_replace( array('/amp', 'offerte_'), '', $request->server->get('REQUEST_URI' ) );
        $request_uri = trim( str_replace( $request->server->get('QUERY_STRING'), '', $requestUri ), '?' );
        $params = explode( '-', trim( $request_uri, '/' ) );
        
        $end =  end( $params );        
        $sexName = false;
        $search = false;        
        
        //PROVA PRIMA A FARE IL CHECK SE è LA SEZIONE ABBIGLIAMENTO RICERCANDO IL SESSO
        if( $end == 'uomo' || $end == 'donna' ) {
            array_pop( $params );
            $sexName = $end;
        } else {
            
            if( count( $params ) > 1 ) {
                $search = $end;
                array_pop( $params );                
                
                if( end( $params ) == 'uomo' || end( $params ) == 'donna' ) {
                    $sexName = end( $params );
                    array_pop( $params );
                }
            }
        }          
        
        //se non esiste il sex significa che è una sezione della list products non di abbigliamento
        $catSubcatTypology = end( $params );        
        if(  $catSubcatTypology != $this->container->getParameter( 'app.freeSearchPath' ) && empty( $sexName ) && !empty( $search )  ) {
            if( count( $params ) == 1 ) {
                
                $catSubcatTypology = $search;
                $search = false;
            }
        }
//        print_Cr(array( 'catSubcatTypology' => $catSubcatTypology, 'sex' => $sexName, 'search' => $search ) );
//        exit;
        return array( 'catSubcatTypology' => $catSubcatTypology, 'sex' => $sexName, 'search' => $search );     
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getTrademark() {
        $request     = $this->requestStack->getCurrentRequest();
        $trademark = $request->get( 'trademark' );
        if( !empty( $trademark ) )
            return $trademark;
        return false;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getAffiliate() {
        $request     = $this->requestStack->getCurrentRequest();
        $affiliate   = $request->get( 'store' );
        if( !empty( $affiliate ) )
            return $affiliate;
        return false;
    }
    
    /**
     * Metodo che recupera il team
     * @return boolean
     */
    public function getUri() {
        $request     = $this->requestStack->getCurrentRequest();
        $uri = $request->get( 'uri' );
        if( !empty( $uri ) )
            return $uri;
        return 1;
    }
    
    /**
     * Metodo che recupera il matchId
     * @return boolean
     */
    public function getTabLivescoreHome() {
        $request     = $this->requestStack->getCurrentRequest();
        $tabLivescore =  trim( $request->server->get( 'REQUEST_URI' ), '/' );
        
        if( !empty( $tabLivescore ) )
            return $tabLivescore;
        return '';
    }
    
    public function getBreadcrumb() {
        $request      = $this->requestStack->getCurrentRequest();
        $url          = $request->server->get('REQUEST_URI');       
        return $url;
    }
    
    public function getRequestUri() {
        $request      = $this->requestStack->getCurrentRequest();
        $url          = $request->server->get('REQUEST_URI');       
        return $url;
    }
       
}