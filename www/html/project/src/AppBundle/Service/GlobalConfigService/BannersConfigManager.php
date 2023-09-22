<?php

namespace AppBundle\Service\GlobalConfigService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Environment as Environment;
use AppBundle\Menu\Menu;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpFoundation\Session\Session; 

/**
 * @author alessandro pacifici
 */
class BannersConfigManager {
    
    protected $twig;    
    protected $container;    
    protected $requestStack;    
    protected $request;
    protected $versionSite;
    protected $positions = array( 'matchDetailTop', 'matchDetailBottom', 'leaderboard', 'columnRight1', 'menuTournaments1' );
    
    /**
     * Metodo costruttore della classe che instanzia anche la classe padre
     */
    public function __construct( 
            Environment $twig,
            RequestStack $requestStack,
            Container $container,
            ObjectManager $doctrine
    ) {
        
        $this->twig             = $twig;
        $this->requestStack     = $requestStack;
        $this->container        = $container;        
        $this->doctrine         = $doctrine;        
        $this->request          = $this->requestStack->getCurrentRequest();  
        $this->versionSite      = 'livescore24';
    }
    
    /**
     * Metodo che avvia il recupero dei banners da visualizzare per le varie versioni del sito
     * @param string $versionSite
     * @param boolean $versionSite
     */
    public function init( $versionSite, $isMobile ) {   
        $this->container->get( 'twig' )->addGlobal( 'banners', (!(empty($activeBanners)) ? $activeBanners : '' ));
        $this->container->get( 'twig' )->addGlobal( 'headerCodeBanners', (!(empty($headerCodeBanners)) ? $headerCodeBanners : '' ));
        $this->container->get( 'twig' )->addGlobal( 'callsCode', (!(empty($callsCode)) ? $callsCode : '' ));
        return;
        
        $matchUri = explode( '?', $this->request->server->get( 'REQUEST_URI' ) );
        $this->route = $this->container->get('router')->match( $matchUri[0] );                   
        $this->currentRoute = $this->route['_route'];
        
        if( strpos( $this->request->server->get( 'HTTP_HOST' ), 'calciomercato.it', '0' ) !== false ) {
            $versionSite = 'calciomercato.it';            
        } else if( strpos( $this->request->server->get( 'HTTP_HOST' ), 'chedonna.pro', '0' ) !== false ) {
            $versionSite = 'chedonna.it';            
        } else if( strpos( $this->request->server->get( 'HTTP_HOST' ), 'chedonna.it', '0' ) !== false ) {
            $versionSite = 'chedonna.it';            
        } 
        
        if( strpos( $versionSite, 'app_', '0' ) !== false ) {
            $screen = array( 'app', 'all' );
        } else if( strpos( $versionSite, 'amp_', '0' ) !== false ) {
            $screen = array( 'amp', 'all' );            
        } else if( !empty( $isMobile ) ) {
            $screen = array( 'mobile', 'all' );            
        } else {
            $screen = array( 'desktop', 'all' );
        }
    
        $bannersTest = null;
        $test = isset( $_GET['test'] ) ? true : false;
                
        $versionSite = str_replace( array('m_','app_','amp_'), '', $versionSite ); 
        $banners = $this->doctrine->getRepository( 'AppBundle:Banner' )->findByParams( $versionSite, 1, $screen, $this->currentRoute);
        
        if( !empty($test) ) {
            $bannersTest = $this->doctrine->getRepository( 'AppBundle:Banner' )->findByParams( $versionSite, 2, $screen, $this->currentRoute); 
            $banners = array_merge( $banners, $bannersTest );
        }
        
        $headerCodeBanners = array();
        $callsCode = array();
        foreach( $banners AS $banner ) {
            $img = '';
            if( !empty( $banner->getImg() ) && !empty( $banner->getUrl() ) ) {
                $img = '<a href="'.$banner->getUrl().'"><img src="'.$this->container->getParameter('app.folder_img_banners').$banner->getImg().'"></a>';
            }
            $activeBanners[strtolower($banner->getPosition())]['img'] = $img;   
            $activeBanners[strtolower($banner->getPosition())]['code'] = $banner->getCode();   
            $activeBanners[strtolower($banner->getPosition())]['codeAmp'] = $banner->getCodeAmp();   
            $activeBanners[strtolower($banner->getPosition())]['text'] = $banner->getText();    
            
            if( !empty(  $banner->getHeaderCode() ) )
                $headerCodeBanners[] = $banner->getHeaderCode();
            
            if( !empty(  $banner->getCallsCode() ) )
                $callsCode[strtolower($banner->getPosition())] = $banner->getCallsCode();            
        }
        
        $this->container->get( 'twig' )->addGlobal( 'banners', (!(empty($activeBanners)) ? $activeBanners : '' ));
        $this->container->get( 'twig' )->addGlobal( 'headerCodeBanners', (!(empty($headerCodeBanners)) ? $headerCodeBanners : '' ));
        $this->container->get( 'twig' )->addGlobal( 'callsCode', (!(empty($callsCode)) ? $callsCode : '' ));
    }
    
}//End Class


//insert into banners ( position, code, active, header_code, site ) VALUES( 'matchDetailTop','<script type="text/javascript">sas.call("std", { siteId: 117987, pageId: 700562, formatId: 41979, target:''});</script><noscript><a href="http://www8.smartadserver.com/ac?jump=1&nwid=1924&siteid=117987&pgname=articolo&fmtid=41979&visit=m&tmstp=[timestamp]&out=nonrich" target="_blank"><img src="http://www8.smartadserver.com/ac?out=nonrich&nwid=1924&siteid=117987&pgname=articolo&fmtid=41979&visit=m&tmstp=[timestamp]" border="0" alt="" /></a></noscript>', 1, '', 'direttagoal');
