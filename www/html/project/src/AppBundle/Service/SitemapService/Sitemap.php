<?php

namespace AppBundle\Service\SitemapService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Service\SitemapService\FullSitemap\RunSitemap;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class Sitemap {
    
    
    public function __construct( ObjectManager $doctrine, Container $container, \AppBundle\Service\UtilityService\GlobalUtility $globalUtility )  {                
        $this->doctrine         = $doctrine;
        $this->container        = $container;
        $this->globalUtility    = $globalUtility;
        
    }
    
    public function run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $action, $routerManager, $regenerate = false, $enabledPing = false ) {
        
        switch ( $action ) {
            case 'createFullSitemap':
                $runSitemaps = new RunSitemap( $this->globalUtility, $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $routerManager, $regenerate, $enabledPing );
                $runSitemaps->init( 'category' );
                $runSitemaps->init( 'subcategory' );
                $runSitemaps->init( 'typology' );                
                $runSitemaps->init( 'models' );                
                $runSitemaps->init( 'guide' );                
                $runSitemaps->init( 'comparazione' );                
                
                
                ////                $runSitemaps->init( 'modelSubcategory' );                
////                $runSitemaps->init( 'modelTypology' );                
            break;
        }
        
    }
    
    /**
     * Metodo che genera la sitemaps per google news
     * @return string
     */
    public function sendGoogleNewsSitemap() {                
        $params = array();
        $params['start-date-seo'] = date('Y-m-d H:i:s', strtotime('-2 days'));
        $params['end-date-seo'] = date('Y-m-d H:i:s');
        $params['status'] = 1;        
        $news = $this->doctrine->getRepository('AppBundle:DataArticle')->filterArticlesWithParams( $params, 1000 );   
        
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" 
            xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
        ';
        
        
        $base = 'https://'.$_SERVER['HTTP_HOST'];
        
        foreach( $news AS $item ) {
            $item->getContentArticle()->urlArticle = $item->getContentArticle()->getPermalink() ;            
            $url = $this->container->get('router')->generate(
                'detailNews',
                array('articleId' => $item->getId(), 'title' => $item->getContentArticle()->urlArticle )            
            );  
            
            $xmlImg = '';
            if( !empty( $item->getPriorityImg() ) ) {
                $image = $base.$this->container->getParameter( 'app.folder_img_medium' ).$item->getPriorityImg()->getSrc();
                $xmlImg = '<image:image>
                    <image:loc>'.$image.'</image:loc>
                </image:image>';
            }
            
            $keywords =  !empty(  $item->getCategory() )  ? $item->getCategory()->getName().',' : '';
            $keywords .=  !empty( $item->getSubcategoryOne() )  ? $item->getSubcategoryOne()->getName().',' : '';
            $keywords .=  !empty( $item->getSubcategoryTwo() )  ? $item->getSubcategoryTwo()->getName().',' : '';
            
            $xml .= '
                <url>
                    <loc>'.$base.$url.'</loc>
                    <news:news>
                        <news:publication>
                            <news:name>'. ucfirst( str_replace( array( 'http://','https://', 'www.'), '', $base ) ).'</news:name>
                            <news:language>it</news:language>
                        </news:publication>
                        <news:publication_date>'.$item->getPublishAt()->format('Y-m-d\TH:i:sP').'</news:publication_date>
                        <news:keywords>'.str_replace( '&', '', trim( $keywords, ',' ) ).'</news:keywords>
                        <news:title>'.str_replace( '&', '', $item->getContentArticle()->getTitle() ).'</news:title>                           
                    </news:news>
                    '.$xmlImg.'
                </url>';
        };
        $xml .= '
            </urlset>
            ';
        return $xml;
    }
    
}//End Class
