<?php

namespace AppBundle\Service\GlobalConfigService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Environment as Environment;
use Twig_SimpleFunction;
use Twig_SimpleFilter;
use AppBundle\Menu\Menu;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpFoundation\Session\Session; 
use AppBundle\Service\UtilityService\CacheUtility;
use AppBundle\Service\GlobalConfigService\GlobalTwigExtension;

use AppBundle\Service\GlobalConfigService\ExtraConfig;

require_once __DIR__.'/../../../../app/config/extraConfig.php';

/**********UA For Search Bots**************/
//$UA_SB_ACCOUNT_ID = "UA-121804415-1"; //Replace with the UA Web Property ID.
//$UA_SB_PATH = "ua-searchbots/ua-searchbots.php"; //location of the UA for Search Bots script
//include($UA_SB_PATH);
//https://www.evemilano.com/tracciare-i-bot-con-google-universal-analytics/
//https://www.evemilano.com/monitorare-log-web-server/
/**********UA For Search Bots**************/

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class GlobalConfigManager {
    
    //Determina se controllare la sessione nell'inclusione dei template
    public $controlSession; 
    
    //Determina se la sessione dell'utente Ã¨ attiva
    public $sessionActive;                
    
    //Determina se il browser Ã¨ IE e in caso quale versione
    public $isIeVersion; 
    
    protected $genericUtility;
    
    protected $twig;
    
    protected $container;
    
    protected $requestStack;
    
    protected $entityManager;
    
    protected $request;
    
    private $lang;
    
    private $currentDomain;
    
    private $aExtraConfigs;
    
    private $filtersActive;
    
    
    /**
     * Metodo costruttore della classe che instanzia anche la classe padre
     */
    public function __construct( 
            Environment $twig,
            RequestStack $requestStack,
            Container $container,
            \AppBundle\Service\UtilityService\GlobalUtility $globalUtility ,
            EntityManager $entityManager,
            CacheUtility $cacheUtility
    ) {

        $this->globalUtility    = $globalUtility;
        $this->twig             = $twig;
        $this->requestStack     = $requestStack;
        $this->container        = $container;
        $this->entityManager    = $entityManager;
        $this->cacheUtility     = $cacheUtility;
        $this->memcached        = $this->cacheUtility->initPhpCache();                
        
        //Crea l'istanza di redis per le cache di secondo livello di doctrine
        $this->secondLevelCacheUtility = $this->container->get( 'app.cacheUtilitySecondLevelCache' );    
        
        $params = new \stdClass();
        $params->subcategoriesType = $this->container->getParameter( 'admin.subcategoriesType' );
        $params->secondLevelCacheUtility = $this->secondLevelCacheUtility;
        
        //da spostare in extra config se symfony non fa los stronzo
        define( 'BESTSELLER_MODEL_REGION_TTL', 3600 ); 
        define( 'BESTSELLER_SEARCH_TERM_REGION_TTL', 3600 ); 
                                    
//        
//        $this->entityManager->getRepository('AppBundle:Banner')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:Category')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:ContentArticle')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:Group')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:Image')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:Menu')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:Subcategory')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:Typology')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:User')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:Poll')->setCacheUtility( $this->secondLevelCacheUtility );
//        $this->entityManager->getRepository('AppBundle:ExtraConfig')->setCacheUtility( $this->secondLevelCacheUtility );                                        
        
        $params = new \stdClass;
        $params->secondLevelCacheUtility = $this->secondLevelCacheUtility;
        $params->subcategoriesType = $this->container->getParameter( 'admin.subcategoriesType' );
        
        $this->entityManager->getRepository('AppBundle:DataArticle')->setParamsRepository( $params );        
        
        if( SECOND_LEVEL_CACHE_ENABLED ||  SECOND_LEVEL_CACHE_SET_EXPIRE_ENABLED  ) {
            $this->secondLevelCacheUtility->setExpire( 'banner', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'category', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'content_article', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'data_article', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'images_data_article', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'group', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'image', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'menu', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'subcategory', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'typology', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'user', IMAGE_REGION_TTL );
            $this->secondLevelCacheUtility->setExpire( 'poll', POLL_REGION_TTL );            
            $this->secondLevelCacheUtility->setExpire( 'extra_config', POLL_REGION_TTL );            
        }        
        
        $this->controlSession   = false; //Serve per determinare se il sistema manager dei tamplate debba verificare se un twig sia visibili solo se l'utente loggato
        
//        $session = new Session();
//        $email = $session->get( 'user' );
                
        $sessionActive = false;
        if (! empty( $email ) ) {
           $sessionActive = true;
        } 
        $this->sessionActive    =   !empty($_COOKIE['externalUserCode'] ) ? true : false;
        $this->userIsActive     = $sessionActive;         
        $this->isAppVersion     = false;
        $this->isIeVersion      = false;
        $this->ampActive        = false;
        $this->ampRouteActive   = false;
        $this->lang             = 'it_IT';       
        $this->request          = $this->requestStack->getCurrentRequest();        
        
        $mobileDetector         = $this->mobileDetector = $this->globalUtility->browserUtility;
        $this->mobile           = $mobileDetector->isMobile();
        
        $matchUri               = explode( '?', $this->request->server->get( 'REQUEST_URI' ) );
        $this->route            = $this->container->get('router')->match( $matchUri[0] );   
            
        $this->currentRoute     = $this->route['_route'];        
        
        $this->requestUriSite   = str_replace( array('?page=1' ), array(''), $matchUri[0] );
                
        $this->httpProtocol = $this->container->getParameter( 'app.hostProtocol' );
        $this->wwwProtocol = $this->container->getParameter( 'app.wwwProtocol' );
        
        $redirectManager = $this->container->get( 'app.redirectService' );
        $redirectManager->checkRedirectDB();
        
        $this->initExtraConfigs();
        $this->getCategories();                        
        $this->getSubcategories();                        
        $this->getTypologies();                        
        $this->getMicroSections();                        
        $this->getTrademarks();                        
        $this->getAffiliations();                        
        $this->getSizes();                        
        $this->getColors();                        
        $this->getTecnicalTemplates();                        
        $this->detectIsAmp();
        $this->detectDomain();
        $this->getAboveTheFoldCss();
        
        $this->detectSite();        
        $this->isIsVersion();
        $this->getGlobalVars();        
        $this->registerCustomExtensionTwig();        
        $this->setParamsByDomain();
        
        //Avvia gestione SEO se non Ã¨ una chiamata ajax
        if( $this->versionSite != 'admin' && !$this->request->isXmlHttpRequest() ) {
            $this->seoConfigManager = $this->container->get( 'app.seoConfigManager' );
            $this->seoConfigManager->getMeta( 'homepage' );
        }
        
        //Avvia gestione BANNERS se non Ã¨ una chiamata ajax
        if( $this->versionSite != 'admin' &&  !$this->request->isXmlHttpRequest() ) {
            $this->bannersConfigManager = $this->container->get( 'app.bannersConfigManager' );
            $this->bannersConfigManager->init( $this->versionSite, $this->mobile );
        }             
        
        $um = $this->container->get('app.usermanager'); 
        if( $um->isLogged() ) {
            $this->sessionActive    = true;
            $this->userIsAdmin      = true;            
        } else {
//            $this->sessionActive    = false;
            $this->userIsAdmin      = false;
        }
        
        $this->twig->addGlobal( 'sessionActive', $this->sessionActive );
        $this->twig->addGlobal( 'userIsAdmin', $this->userIsAdmin );
        $this->twig->addGlobal( 'currentBaseUrl', $matchUri[0] );
        $this->baseAbsoluteUrl = $canonicalUrl = $this->httpProtocol.'://'.str_replace( array('m.', '?page=1' ), array('www.', ''), $this->request->server->get( 'HTTP_HOST' ) );
        $this->twig->addGlobal( 'baseAbsoluteUrl', $this->baseAbsoluteUrl );
        $this->twig->addGlobal( 'hostImg', $this->baseAbsoluteUrl );
        
    }
    
    public function compressHtml($html) {
		$html = preg_replace("/\n ?+/", " ", $html);
		$html = preg_replace("/\n+/", " ", $html);
		$html = preg_replace("/\r ?+/", " ", $html);
		$html = preg_replace("/\r+/", " ", $html);
		$html = preg_replace("/\t ?+/", " ", $html);
		$html = preg_replace("/\t+/", " ", $html);
		$html = preg_replace("/ +/", " ", $html);
		$html = trim($html);
		return $html;
	}
    
    /**
     * Metodo che gestisce il css about the fold per la rotta corrente
     * @return type
     */
    public function getAboveTheFoldCss( $forceRouteCss = false ) {
        $this->currentRouteCss  = !empty( $forceRouteCss ) ? strtolower( $forceRouteCss ) : strtolower( $this->currentRoute );
        
        if( substr( $this->currentRouteCss, 0, 3 ) == 'amp' ) {
            $this->currentRouteCss = substr( $this->currentRouteCss, 3 , strlen( $this->currentRouteCss ) -3 );
        }
        
        $this->twig->addGlobal( 'currentRouteCss', $this->currentRouteCss );
                
        // if( $this->versionSite == 'admin' ) {
        //     return;
        // }
        
//        $css = @file_get_contents( 'css/template/Amp.ATF.'.strtolower( $this->currentRouteCss ).'.css' );
//        $css = str_replace( '@charset "UTF-8";', '', $css);
//        $this->twig->addGlobal( 'aboveTheFoldCss', $this->compressHtml( $css )  );
//        return true;
            
        //Recupera gli about thefold per AMP
        if( !empty( $this->ampActive ) ) {              
            $css = @file_get_contents( 'css/template/Amp.ATF.'.strtolower( $this->currentRouteCss ).'.css' );
            $css = str_replace( '@charset "UTF-8";', '', $css);
            $this->twig->addGlobal( 'aboveTheFoldCss', $this->compressHtml( trim( $css ))  );
            return true;
        }
        
        
        
        //Recupera gli about thefold per la desktop
//        if( empty( $this->mobileDetector->isMobile() ) && empty( $this->mobileDetector->isTablet() ) ) {                                                
            $css = @file_get_contents( 'css/template/Desk.ATF.'.strtolower( $this->currentRouteCss ).'.css' );
            $css = str_replace( '@charset "UTF-8";', '', $css);
            $this->twig->addGlobal( 'aboveTheFoldCss', $this->compressHtml( $css )  );
            return true;            
//        }
        
//        //Recupera gli about thefold per i tablet
//        if( empty( $this->mobileDetector->isMobile() ) && !empty( $this->mobileDetector->isTablet() ) ) {                                                
//            $css = @file_get_contents( 'css/template/Amp.ATF.'.strtolower( $this->currentRouteCss ).'.css' );
//            $css = str_replace( '@charset "UTF-8";', '', $css);
//            $this->twig->addGlobal( 'aboveTheFoldCss', $this->compressHtml( $css )  );
//            return true;
//         }
        
        
        
        
//        //Recupera gli about thefold per altri dispositivi mobile
////        $css = file_get_contents( 'css/template/Mobile.ATF.'.strtolower( $this->currentRouteCss ).'.css' );
//        $css = file_get_contents( 'css/template/Desk.ATF.'.strtolower( $this->currentRouteCss ).'.css' );
//        $css = str_replace( '@charset "UTF-8";', '', $css);
//        $this->twig->addGlobal( 'aboveTheFoldCss', $this->compressHtml( $css )  );
    }
    
    /**
     * Metodo che inizializza l'extra config
     * @return type
     */
    public function initExtraConfigs() {
        $aExtraConfigs = $this->entityManager->getRepository('AppBundle:ExtraConfig')->findAll();
        $newExtraConfigs = [];
        foreach ( $aExtraConfigs as $config ) {
            $newExtraConfigs[$config->getKeyName()] = $config;
        }
        $this->aExtraConfigs = $newExtraConfigs;
        $this->twig->addGlobal( 'extraConfigs', $this->aExtraConfigs );
        
        
//        $newExtraConfig = [];
//       
//        foreach( $aExtraConfigs as $config ) {
//            $newExtraConfig[$config->getKeyName()] = $config;
//        }
//        $this->aExtraConfigs = $newExtraConfig;
//        $this->twig->addGlobal( 'extraConfigs', $this->aExtraConfigs );
    }
    
    /**
     * Metodo che recupera tutte le categorie
     */
    private function getCategories() {
        $categoryById   = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesById' );
        $categoryByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesByName' );
        
        if( empty( $categoryById ) || empty( $categoryByName ) ) {
            $categories = $this->entityManager->getRepository( 'AppBundle:Category' )->findAllCategories( true );
            
            $categoryById = array();
            $categoryByName = array();            
            
            foreach ( $categories as $category ) {                
                $categoryById[$category->id]        = $category;
                $categoryByName[$category->nameUrl] = $category;
            }
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesById', $categoryById, 3600 );
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesByName', $categoryByName, 3600 );
        } 
        $this->twig->addGlobal( 'allCategories', (array)$categoryById );
    }
    
    /**
     * Metodo che recupera tutte le categorie
     */
    public function getSubcategories( $return = false ) {
        $subcategoryById   = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesById' );
        $subcategoryByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesByName' );
        
        if( empty( $subcategoryById ) || empty( $subcategoryByName ) ) {
            $subcategories = $this->entityManager->getRepository( 'AppBundle:Subcategory' )->findAllSubcategories( true );           
            $subcategoryById = array();
            $subcategoryByName = array();

            foreach ( $subcategories as $subcategory ) {
                $subcategoryById[$subcategory->id]        = $subcategory;
                $subcategoryByName[$subcategory->nameUrl] = $subcategory;
            }
            
        } 
        $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesById', $subcategoryById, 3600 );
        $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesByName', $subcategoryByName, 3600 );
        $this->twig->addGlobal( 'allSubcategories', (array)$subcategoryById );
        
        if( !empty( $return ) && $return == 'id' ) {
            return $subcategoryById;
        } else if( !empty( $return ) && $return == 'name' ) {
            return $subcategoryByName;
        }
    }
    
    /**
     * Metodo che recupera tutte le tipologie
     */
    public function getTypologies( $return = false ) {
        $typologyById   = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesById' );
        $typologyByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesByName' );
        $typologiesBySubcatId = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesBySubcatId' );
                       
        if( empty( $typologyById ) || empty( $typologyByName ) ) {                    
            $typologies = $this->entityManager->getRepository( 'AppBundle:Typology' )->findAllTypologies( true );            
//            print_R($typologies);
            $typologyById = array();
            $typologyByName = array();            
            $typologiesBySubcatId = array();            

            $x = 0;
            foreach ( $typologies as $typology ) {                
                $typology->categoryNameUrl = $typology->category->nameUrl;
                $typology->subcategoryId = $typology->subcategory->id;
                $typology->subcategoryNameUrl = $typology->subcategory->nameUrl;
                unset( $typology->subcategory );
                unset( $typology->category ); 
                
                $typologyById[$typology->id]        = $typology;
                $typologyByName[$typology->nameUrl] = $typology;
                $typologiesBySubcatId[$typology->subcategoryId][$x]['id'] = $typology->id;
                $typologiesBySubcatId[$typology->subcategoryId][$x]['name'] = $typology->name;
                $typologiesBySubcatId[$typology->subcategoryId][$x]['nameUrl'] = $typology->nameUrl;
                $typologiesBySubcatId[$typology->subcategoryId][$x]['catNameUrl'] = $typology->categoryNameUrl;
                $typologiesBySubcatId[$typology->subcategoryId][$x]['subcatNameUrl'] = $typology->subcategoryNameUrl;
                $typologiesBySubcatId[$typology->subcategoryId][$x]['anchorMenu'] = $typology->anchorMenu;
                $typologiesBySubcatId[$typology->subcategoryId][$x]['img'] = $typology->img;
                $x++;
                
                
                
//                $typologiesBySubcatId[$typology->subcategoryId] = $typology;
            }
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesById', $typologyById, 3600 );
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesByName', $typologyByName, 3600 );
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesBySubcatId', $typologiesBySubcatId, 3600 );            
        }        
        
        $this->twig->addGlobal( 'allTypologies', (array)$typologyById );
        $this->twig->addGlobal( 'typologiesBySubcatId',  json_decode(json_encode($typologiesBySubcatId),true) );
        
        
        if( !empty( $return ) && $return == 'id' ) {
            return $typologyById;
        } else if( !empty( $return ) && $return == 'name' ) {
            return $typologyByName;
        }
    }
    
    /**
     * Metodo che recupera tutte le tipologie
     */
    public function getMicroSections( $return = false ) {
        $microSectionsById   = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'microSectionsById' );
        $microSectionsByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'microSectionsByName' );
                       
        if( empty( $microSectionsById ) || empty( $microSectionsByName ) ) {                    
            $microSections = $this->entityManager->getRepository( 'AppBundle:MicroSection' )->findAllMicroSections( true );            
            $microSectionsById = array();
            $microSectionsByName = array();            

            foreach ( $microSections as $microSection ) {                
                $microSection->typologyId = $microSection->typology->id;
                $microSection->typologyNameUrl = $microSection->typology->nameUrl;
                unset( $microSection->subcategory );
                
                $microSectionsById[$microSection->id]        = $microSection;
                $microSectionsByName[$microSection->nameUrl] = $microSection;
            }
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'microSectionsById', $microSectionsById, 3600 );
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'microSectionsByName', $microSectionsByName, 3600 );
        }        
        $this->twig->addGlobal( 'allMicroSections', (array)$microSectionsById );
        
        if( !empty( $return ) && $return == 'id' ) {
            return $microSectionsById;
        } else if( !empty( $return ) && $return == 'name' ) {
            return $microSectionsByName;
        }
    }
    
    /**
     * Metodo che recupera tutte i marchi
     */
    private function getTrademarks() {
        $trademarkById   = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'trademarksById' );
        $trademarkByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'trademarksByName' );
        
        if( empty( $trademarkById ) || empty( $trademarkByName ) ) {
            $trademarks = $this->entityManager->getRepository( 'AppBundle:Trademark' )->findAllTrademarks( true );
            
            $trademarkById = array();
            $trademarkByName = array();            
            
            foreach ( $trademarks as $trademark ) {                
                $trademarkById[$trademark->id]        = $trademark;
                $trademarkByName[$trademark->nameUrl] = $trademark;
            }
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'trademarksById', $trademarkById, 3600 );
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'trademarksByName', $trademarkByName, 3600 );
        }         
        $this->twig->addGlobal( 'allTrademarks', (array)$trademarkById );
    }
    
    /**
     * Metodo che recupera tutte le affiliazioni
     */
    public function getAffiliations( $return  = false ) {
        $affiliationById   = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'affiliationById' );
        $affiliationByName = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'affiliationByName' );
        
        if( empty( $affiliationById ) || empty( $affiliationByName ) ) {
            $affiliations = $this->entityManager->getRepository( 'AppBundle:Affiliation' )->findAllAffiliations( true );
            $affiliationById = array();
            $affiliationByName = array();            
            
            foreach ( $affiliations as $affiliation ) {                
                $affiliationById[$affiliation->id]     = $affiliation;
                $affiliationByName[$affiliation->name] = $affiliation;
            }
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'affiliationById', $affiliationById, 3600 );
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'affiliationByName', $affiliationByName, 3600 );
        }   
        $this->twig->addGlobal( 'allAffiliations', (array)$affiliationById );
        
        if( !empty( $return ) && $return == 'id' ) {
            return $affiliationById;
        } else if( !empty( $return ) && $return == 'name' ) {
            return $affiliationByName;
        }
    }
    
    /**
     * Metodo che recupera tutte le taglie
     */
    public function getSizes() {
        $aSizes   = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'sizes' );
        
        if( empty( $aSizes ) ) {
            $sizes = $this->entityManager->getRepository( 'AppBundle:Size' )->findAllSizes( true );
            foreach ( $sizes as $size ) {                
                $aSizes[$size->id]     = $size;
            }
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'sizes', $aSizes, 3600 );
        }   
        
        $this->twig->addGlobal( 'aSizes', (array)$aSizes );
        return (array)$aSizes;
    }
    
    /**
     * Metodo che recupera tutte le taglie
     */
    public function getColors() {
        $aColors   = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'colors' );
        
        if( empty( $aColors ) ) {
            $colors = $this->entityManager->getRepository( 'AppBundle:Color' )->findAllColors( true );
            foreach ( $colors as $color ) {                
                $aColors[$color->id]     = $color;
            }
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'colors', $aColors, 3600 );
        }   
        $this->twig->addGlobal( 'aColors', (array)$aColors );
        return (array)$aColors;
    }
    
    /**
     * Metodo che recupera tutte le taglie
     */
    public function getTecnicalTemplates() {
        $aTecnicalTemplate  = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'tecnicalTemplate' );
        
        if( empty( $aTecnicalTemplate ) ) {
            $tecnicalsTemplate = $this->entityManager->getRepository( 'AppBundle:TecnicalTemplate' )->findAllTecnical( true );
            foreach ( $tecnicalsTemplate as $tecnical ) {                
                $aTecnicalTemplate[$tecnical->id]     = $tecnical;
            }
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'tecnicalTemplate', $aTecnicalTemplate, 3600 );
        }   
        $this->twig->addGlobal( 'aTecnicalTemplate', (array)$aTecnicalTemplate );
        return (array)$aTecnicalTemplate;
    }
    
    
    /**
     * Metodo che setta tutte le funzioni custom per Twig
     */
    private function registerCustomExtensionTwig() {        
        global $typeNews;

        //https://twig.sensiolabs.org/doc/advanced.html#functions
        $this->twig->addExtension( new \nochso\HtmlCompressTwig\Extension( true ) );        
        $globalTwigExtension = $this->container->get( 'app.globalTwigExtension' );
        $globalTwigExtension->routerManager->setAmpActive( $this->ampActive );
        
        $domain = 'www.'.$this->getCurrentDomain();
        $base = 'https://'.str_replace( 'app.', 'www.',$domain);
        $globalTwigExtension->routerManager->setBaseUrl( $base );
    }
    
    /**
     * Metodo che setta le della varibili global per twig
     */
    private function getGlobalVars() {        
        $currentUrl = $this->request->server->get( 'HTTP_HOST' ).$this->request->server->get( 'REQUEST_URI' );
        $this->twig->addGlobal( 'currentUrl', $currentUrl );
        $currentHostUrl = $this->request->server->get( 'HTTP_HOST' );
        $this->twig->addGlobal( 'currentHostUrl', $currentHostUrl );
        $this->twig->addGlobal( 'currentRoute', strtolower( $this->currentRoute ) );
                
        $this->setLanguage();
        $this->twig->addGlobal( 'analytics', $this->getAnalytics() );        
        $this->twig->addGlobal( 'fbPixel', $this->getFbPixel() );        
        $this->twig->addGlobal( 'googleSiteVerification', $this->getGoogleSiteVerification() );        
        $this->twig->addGlobal( 'bingSiteVerification', $this->getBingSiteVerification() );        
        $this->twig->addGlobal( 'isAppVersion', $this->getIsAppVersion() );
        $this->twig->addGlobal( 'ampActive', $this->ampActive );
        $this->twig->addGlobal( 'search', '' );
        $this->twig->addGlobal( 'currentDomain', str_replace( 'app.', 'www.', $this->currentDomain ) );

        $prefixAmp = $this->ampActive == true ? 'amp/' : '';
        $this->twig->addGlobal( 'prefixAmp', $prefixAmp  );
    }       
    
    /**
     * Metodo che setta la lingua del sit
     */
    private function setLanguage() {
        $this->twig->addGlobal( 'lang', $this->lang );
    }
    
    /**
     * Metodo che determina se deve essere attiva la versione amp
     */
    private function detectIsAmp() {
        $this->ampRouteActive   = false;
//        echo $this->route['_route'];
        //Abilita il link amphtml nell'head per le sezioni sottostanti
        switch( $this->route['_route'] ) {                
            case 'detailNews':
            case 'detailNews1':
            case 'detailNews2':
            case 'urneCenerarie':
            case 'homepage':
                $this->ampRouteActive   = true;                
            break;
        }
        
        if( strpos( ' '.$this->request->server->get( 'REQUEST_URI' ), '/amp' ) !== FALSE ) {     
            //GESTISCE URL AMP
            $this->ampActive = false;
            switch( $this->route['_route'] ) {
                case 'homepageAmp':
                case 'detailNewsAmp':
                case 'listArticlesAmp':
                case 'listArticlesTeamAmp':
                    $this->ampActive = true;
                break;         
                default:
                    $this->ampActive = true;
                break;
            }
            return false;
        }
        
        //gestisce la versione mobile classica
        if( $this->mobileDetector->isMobile()  &&  strpos( ' '.$this->request->server->get( 'HTTP_HOST' ), 'm_' ) === FALSE ) {     
            $this->ampActive        = false;            
            
            switch( $this->route['_route'] ) {                               
                case 'homepage':
                case 'detailNews':
                case 'listArticles':
                case 'listArticlesTeam':
                    $this->ampActive = false;//FORZA IN AMP ANCHE PER MOBILE METTI A TRUE                                        
                break;
                default:
                    $this->ampActive = false;
                break;
            }
            return true;
        }              
                 
    }
    
    /**
     * Determina quale dominio sta lanciando il cms
     */
    private function detectDomain() {
        $this->currentDomain = 'onoranzefunebritimperiguidonia.it';
        // if( strpos( $this->request->server->get( 'HTTP_HOST' ), 'acquistigiusti.it', '0' ) !== false ) {
        //     $this->currentDomain = 'acquistigiusti.it';            
        // } else if( strpos( $this->request->server->get( 'HTTP_HOST' ), 'tricchetto.homepc.it', '0' ) !== false ) {
        //     $this->currentDomain = 'tricchetto.homepc.it';             
        // }
    }
    
    /**
     * Metodo che ricava la versione del sito dal dominio che effettua la richiesta
     */
    private function detectSite() {        
        $this->versionSite = $this->container->getParameter( 'app.default_version_site' );               
        $this->container->get('translator')->setLocale($this->lang);        
                     
//        $this->ampActive = true;
//        $this->versionSite =  'amp_template';  
//        $canonicalUrl = 'https://'.str_replace( array( 'm.', '/amp/' ), array('www.','/'), $this->request->server->get( 'HTTP_HOST' ) ).str_replace( array( 'm.', '/amp/' ), array('www.','/'), $this->requestUriSite );
//        $this->twig->addGlobal( 'canonicalUrl', $canonicalUrl );
//        return true;
//        
//        //SE DI TRATTA DELLA URL DELL'APPLICAZIONE
//        if( strpos( $this->request->server->get( 'HTTP_HOST' ), 'app.', '0' ) !== false || strpos( $this->request->server->get( 'HTTP_HOST' ), 'www.x-diretta.it', '0' ) !== false ) {
//            $this->versionSite = 'app_'.str_replace( 'm_', '', $this->versionSite );
//            $this->isAppVersion = true;   
//            $this->ampActive = true;
//            return true;
//        }        
        
        //URL AMP SPECIFICA O VERSIONE MOBILE FORZATA IN AMP
        if( $this->ampActive ) {       
            $versionCurrent = str_replace( array('m_', 'app_', 'www.', 'amp_'), '',$this->versionSite ); 
            $this->versionSite =  'amp_'.$versionCurrent;                        
            
            $canonicalUrl = $this->httpProtocol.'://'.str_replace( array( 'm.', '/amp/' ), array('www.','/'), $this->request->server->get( 'HTTP_HOST' ) ).str_replace( array( 'm.', '/amp/' ), array('www.','/'), $this->requestUriSite );
            $this->twig->addGlobal( 'canonicalUrl', trim( $canonicalUrl, '/' ) );
            return true;
        }
        
       if( $this->mobileDetector->isTablet() ) {            
           $this->versionSite = 'amp_'.$this->versionSite;
//            $this->versionSite = $this->versionSite;
           
           $canonicalUrl = $this->httpProtocol.'://'.str_replace( 'm.', 'www.', $this->request->server->get( 'HTTP_HOST' ) ).$this->requestUriSite;
           $this->twig->addGlobal( 'canonicalUrl', trim( $canonicalUrl, '/' ) );
           $this->twig->addGlobal( 'alternateUrl', false );
           
       } else if( $this->mobileDetector->isMobile() && strpos( $this->request->server->get( 'HTTP_HOST' ), 'app.', '0' ) === false ) {            
           $this->versionSite = 'm_'.$this->versionSite;
           
//            exit;
            //Se il dispositivo è un mobile lo reindirizza alla url mobile
//            if( strpos( ' '.$this->request->server->get( 'HTTP_HOST' ), 'm.' ) === FALSE ) {
//                $url = 'http://m.'.str_replace( 'www.', '', $this->request->server->get( 'HTTP_HOST' ) ).$this->request->server->get( 'REQUEST_URI' );
//                header( 'Location: '.$url.'');
//                exit;
//            }    
           
           $canonicalUrl = $this->httpProtocol.'://'.str_replace( array('m.', '?m=1'), array('www.',''), $this->request->server->get( 'HTTP_HOST' ) ).$this->requestUriSite;
           $this->twig->addGlobal( 'canonicalUrl', str_replace( array('m.', '?m=1'), array('www.',''), trim( $canonicalUrl, '/' ) ) );
           $this->twig->addGlobal( 'alternateUrl', false );
           
       } else {            
//            
            if( empty( $this->ampActive ) ) {  
                
                $canonicalUrl = $this->httpProtocol.'://'.str_replace( array('m.', '?page=1' ), array('www.', ''), $this->request->server->get( 'HTTP_HOST' ) ).$this->requestUriSite;
                $this->twig->addGlobal( 'canonicalUrl', trim( $canonicalUrl, '/' ) );
                
                $alternateUrl = $this->httpProtocol.'://'.str_replace( 'www.', 'm.', $this->request->server->get( 'HTTP_HOST' ) ).$this->requestUriSite;
                if( $this->currentDomain == 'chedonna.it' )
                    $this->twig->addGlobal( 'alternateUrl', $alternateUrl );
                else
                    $this->twig->addGlobal( 'alternateUrl', false );
                    
                
                if( !empty( $this->ampRouteActive ) ) {                                        
                    $page = !empty( $_GET['page'] ) && $_GET['page'] != 1 ? '?page='.$_GET['page'] : '';
                    $ampHtmlUrl = $this->httpProtocol.'://'.str_replace( 'm.', 'www.', $this->request->server->get( 'HTTP_HOST' ) ).'/amp'.$this->requestUriSite.$page;
                    $this->twig->addGlobal( 'ampHtmlUrl', $ampHtmlUrl );                      
                }
           }     
        }    
        
        
//        //Se la url Ã¨ quella del mobile, la variabile non Ã¨ gia settata a mobile la setta
       if( strpos( ' '.$this->request->server->get( 'HTTP_HOST' ), 'm.' ) !== FALSE && strpos( ' '.$this->versionSite, 'm_' ) === FALSE  ) {
           $this->versionSite = 'm_'.$this->versionSite;
       }
                
//        //Se non Ã¨ mobile e la url Ã¨ mobile fa la redirect alla desktop
       if( !$this->mobileDetector->isMobile()  &&  strpos( ' '.$this->request->server->get( 'HTTP_HOST' ), 'm.' ) !== FALSE ) {
           $url = 'https://'.str_replace( 'm.', '', $this->request->server->get( 'HTTP_HOST' ) ).$this->request->server->get( 'REQUEST_URI' );
           header( 'Location: '.$url.'');
           exit;
       }                                     
        
        
        if( strpos( $this->request->server->get( 'REQUEST_URI' ), '/admin', '0') !== false ) {
            $this->versionSite = 'admin';
        }        
        
    }    
    
    
    public function forceMobileForTable() {
        switch( $this->currentDomain ) {
            case'chedonna.it': 
                return true;
            break;
        }
        return false;
    }
    
    /**
     * Gestisce quale versione garfica caricare in base al sito aperto
     */
    public function loadPlugin() {
        $versioneDependency =  str_replace( array( 'app_', 'm_', 'amp_' ), '', $this->versionSite ) ;
        switch( $versioneDependency ) {
            case 'calciomercato':
                $this->versionSite = str_replace( $versioneDependency, 'alchimist', $this->versionSite );
            break;
        }             
    }        
    
    /**
     * Determina se Ã¨ un mobile
     * @return type
     */
    public function isMobile() {
        $mobileDetector = $this->globalUtility->browserUtility->mobileDetector;
        return $mobileDetector->isMobile();
    }    
    
    /**
     * Ritorna la false se non Ã¨ explorer oppure la versione corrente di IE
     */
    private function isIsVersion() {  
        $this->isIeVersion = $this->globalUtility->browserUtility->getIsIeVersion();
    }
    
    /**
     * Metodo che ritorna la versione del sito determinata in base al dominio
     * @return type
     */
    public function getVersionSite() {
        return $this->versionSite;
    }
    /**
     * Metodo che ritorna la versione del sito determinata in base al dominio
     * @return type
     */
    public function getExtraConfigs() {
        return $this->aExtraConfigs;
    }
    
    /**
     * Ritorna la variabile che determina se nell'inclusione dinamica dei twig deve controllare  i
     * moduli che richiedono la sessione attiva
     * @return type
     */
    public function getControlSession() {
        return $this->controlSession;
    }
    
    /**
     * Ritorna la variabile che determina se la sessione utente Ã¨ attiva o no
     * @return type
     */
    public function getSessionActive() {
        return $this->sessionActive;
    }
    
    /**
     * Ritorna la variabile che determina se l'utente Ã¨ attivo o no
     * @return type
     */
    public function getUserIsActive() { 
        return $this->userIsActive;
    }
    
    /**
     * Ritorna se il browser 
     * @return type
     */
    public function getIsIeVersion() {
        return $this->isIeVersion;
    }
        
    /**
     * Ritorna se Ã¨ un app 
     * @return type
     */
    public function getIsAppVersion() {
        return $this->isAppVersion;
    }
        
    /**
     * Ritorna se il domonio che carica il cms 
     * @return type
     */
    public function getCurrentDomain() {
        return $this->currentDomain;
    }
    
    /**
     * Ritorna i parametri specifici di un dominio
     * @return type
     */
    public function getParamsByDomain() {
        return $this->paramsByDomain;
    }
    
    /**
     * Ritorna i parametri specifici di un dominio
     * @return type
     */
    public function getAmpActive() {
        return $this->ampActive;
    }
    
    /**
     * Ritorna i parametri specifici di un dominio
     * @return type
     */
    public function getCurrentRoute() {
        return $this->currentRoute;
    }
    
    /**
     * Ritorna i parametri specifici di un dominio
     * @return type
     */
    public function getCurrentRouteCss() {
        return $this->currentRouteCss;
    }
    
    /**
     * Setta i parametri specifici di un dominio
     * @return type
     */
    public function setCurrentRouteCss( $routeName ) {
        return $this->currentRouteCss = $routeName;
    }
    
    /**
     * Ritorna i parametri specifici di un dominio
     * @return type
     */
    public function getExtraConfig() {
        return $this->aExtraConfigs;
    }
    
    /**
     * Ritorna la url assoluta del dominio
     * @return type
     */
    public function getBaseAbsoluteUrl() {
        return $this->baseAbsoluteUrl;
    }
    /**
     * Ritorna che recuper i filtri attivi
     * @return type
     */
    public function getFiltersActive() {
        return $this->filtersActive;
    }
    
    /**
     * Ritorna che recuper i filtri attivi
     * @return type
     */
    public function setFiltersActive( $filtersActive ) {
        $this->filtersActive = $filtersActive;
    }
    
    /**
     * Metodo che setta il codice di webmastertools per la versione del sito
     */
    private function getGoogleSiteVerification() {    
        $code = '';
        switch( $this->currentDomain ) {
            case 'acquistigiusti.it':
            case 'tricchetto.homepc.it':
                $code =  'A91SoRAqUDPL1tjWWtrx_zx2PwJXVi2D9SRMd7rnztQ';
            break;
            
        }        
        return $code;
    }
    
    /**
     * Metodo che setta il codice di webmastertools per la versione del sito
     */
    private function getBingSiteVerification() {    
        $code = '';
        switch( $this->currentDomain ) {
            case 'acquistigiusti.it':
            case 'tricchetto.homepc.it':
                $code = 'ABC6EE076983C19103243A9F1BA2EDEA';                    
            break;
            
        }        
        return $code;
    }
    
    /**
     * Metodo che setta il pixel di facebook
     * @return boolean|string
     */
    private function getFbPixel() {
        $fbPixel = '';        
        
        if( $_SERVER['SERVER_NAME'] == 'staging.acquistigiusti.it' ) {
            return false;
        } 
//        return $fbPixel;
        
        switch( $this->currentDomain ) {
            case 'acquistigiusti.it':
//            case 'tricchetto.homepc.it':
                if( empty( $this->ampActive ) ) {
                    $fbPixel = "";                
                } else {
//                    $fbPixel = '<amp-pixel src="https://www.facebook.com/tr?id=336559373945147&ev=PageView&noscript=1" layout="nodisplay"></amp-pixel>';   
                }
            break;                           
            case 'tricchetto.homepc.it':
//                if( empty( $this->ampActive ) ) {
//                    $fbPixel = "";                
//                } else {
//                    $fbPixel = '<amp-pixel src="https://www.facebook.com/tr?id=336559373945147&ev=PageView&noscript=1" layout="nodisplay"></amp-pixel>';   
//                }
            break;                           
        } 
        return $fbPixel;
    }
    
    /**
     * Metodo che setta il codice di analytics per la versione del sito
     */
    private function getAnalytics() {
        $analyticsHead = '';
        $analyticsBody = '';       
        
        if( $_SERVER['SERVER_NAME'] == 'staging.acquistigiusti.it' ) {
            $this->twig->addGlobal( 'analyticsHead', false );
            $this->twig->addGlobal( 'analyticsBody', false );
            return false;
        } 

        switch( $this->currentDomain ) {
            case 'acquistigiusti.it':            
//            case 'tricchetto.homepc.it':
                if( empty( $this->ampActive ) ) {
                    $analyticsHead = "<!-- Google Tag Manager -->
                        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                        })(window,document,'script','dataLayer','GTM-PKNC7SL');</script>
                    ";

//                    $analyticsBody = '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N26SLDS" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';                                        
//                    $analyticsHead = '';
                    $analyticsBody = '<!-- Google Tag Manager (noscript) -->
                    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PKNC7SL"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                    <!-- End Google Tag Manager (noscript) -->';
                    
                } else {
                    $analyticsHead = '<!-- AMP Analytics --><script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>';
                    $analyticsBody = '<amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-5DCDJQX&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>';  
                }
            break;                           
            case 'tricchetto.homepc.it':
//                if( empty( $this->ampActive ) ) {
//                    $analyticsHead = "<!-- Google Tag Manager -->
//                        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
//                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
//                        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
//                        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
//                        })(window,document,'script','dataLayer','GTM-PKNC7SL');</script>
//                    ";
//
////                    $analyticsBody = '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N26SLDS" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';                                        
////                    $analyticsHead = '';
//                    $analyticsBody = '<!-- Google Tag Manager (noscript) -->
//                    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PKNC7SL"
//                    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
//                    <!-- End Google Tag Manager (noscript) -->';
//                    
//                } else {
//                    $analyticsHead = '<!-- AMP Analytics --><script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>';
//                    $analyticsBody = '<amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-5DCDJQX&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>';
//                }
            break;
        } 
        $this->twig->addGlobal( 'analyticsHead', $analyticsHead );
        $this->twig->addGlobal( 'analyticsBody', $analyticsBody );
        return $analyticsHead;
    }    
    
    /**
     * Metodo che ritorna lo skin da implementare nel css
     * @return type
     */
    public function setParamsByDomain() {
        $params = new \stdClass();
        $params->urlPlayStore = null;
        $params->urlIosStore = null;
        $params->logoImg = null;
        
        switch( $this->versionSite ) {
            case 'sd':
            case 'ds':
            case 'sd':
                $params->urlPlayStore = 'https://play.google.com/store/apps/details?id=com.nextmedia.direttagoal&hl=it';
                $params->urlIosStore = 'https://itunes.apple.com/it/app/direttagoal/id547046910?mt=8';
                $params->logoImg = 'https://www.direttagoal.it/images/miniLogoDirettagoal.png';
            break;
        }
        $this->paramsByDomain = $params;
        $this->twig->addGlobal( 'paramsByDomain', $this->paramsByDomain );
    }
    
    
}//End Class
