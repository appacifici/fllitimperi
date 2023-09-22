<?php

namespace AppBundle\Service\WidgetService;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\ApiGettyImageService\ApiGettyImageService;

class CoreAdminImageArticleGetty extends Controller{
    
     public function __construct( WidgetManager $widgetManager, ApiGettyImageService $apiGettyImageService ) {
        $this->wm               = $widgetManager;
        $this->apiGettyImages   = $apiGettyImageService;
    }
    
    public function getDataToAjax() {        
        
        $searchString = $this->wm->getUrlSearchString();
        
        $queryTerm = str_replace(" ", "%20", $searchString);
        
        $apikey = '4uuezdgvkea65vwp39nhzfhr';
        $token  = 'Bearer c8fda3oE/UtTG8Fs/RsZ2rjdAjQJoxPsqXdcQZsydt4BFPBiA0vHbfgYpz2nlBqgUOewjMl1Oq35waaJPnNxTMltREdvvHgIbku0o5dwORjrbr7NV68E0plaBuGRStBN8+1UgcLtuZ2yVeLZhxsavI0IOqwLG5iV1PNNpcL8/MY=|77u/QUduQ0d2cWdXUSsxdWdzTG8wTU0KMjUzODAKCnRxOTBDdz09CnZyWjBDdz09CjAKNHV1ZXpkZ3ZrZWE2NXZ3cDM5bmh6ZmhyCjk1LjI0MC44NC42MgowCjI1MzgwCgoyNTM4MAowCgoK|3';
        $imgSize = 'large';
        $orientations = 'Horizontal';
        $pageSize = $this->wm->container->getParameter( 'app.totImgGallery' );
        $headers = array(
            'Api-Key:'.$apikey
        );
        
        $page = $this->wm->getPage();
                
        if( !empty( $queryTerm ) )
            $url = 'https://api.gettyimages.com:443/v3/search/images/editorial?phrase='.$queryTerm.'&minimum_size='.$imgSize.'&orientations='.$orientations.'&page_size='.$pageSize.'&page='.$page.'&editorial_segments=sport';
        else
            $url = 'https://api.gettyimages.com:443/v3/search/images/editorial?minimum_size='.$imgSize.'&orientations='.$orientations.'&page='.$page.'&page_size='.$pageSize.'&editorial_segments=sport';
        
        $result = $this->apiGettyImages->useCurl($url, $headers);
                
        $result = json_decode( $result, true );

        return $this->wm->container->get('twig')->render( 'admin/snippet_InfiniteScrollImagesGetty.html.twig', 
                array('images' => $result['images'], 'versionSite' => '/admin', 'infiniteScroll' => true, 'page' => $page )
        );
    }
    
    public function processData( $options = false ) {
        
        $articleId  = $this->wm->getUrlId();
        $queryTerm = '';
        $apikey = '4uuezdgvkea65vwp39nhzfhr';
        $imgSize = 'xx_large';
        $orientations = 'Horizontal';
        $pageSize = $this->wm->container->getParameter( 'app.totImgGallery' );
        
        $headers = array(
            'Api-Key:'.$apikey
        );
        
        $url = 'https://api.gettyimages.com:443/v3/search/images/editorial?minimum_size='.$imgSize.'&orientations='.$orientations.'&page_size='.$pageSize.'&editorial_segments=sport';
        
        if ( !empty( $queryTerm ) ) {
            $url .= '&phrase='.$queryTerm;
        }
        
        $result = $this->apiGettyImages->useCurl($url, $headers);
        
        $result = json_decode( $result, true );

        return array( 
            'images'        => $result['images'],
            'articleId'     => $articleId,
            'infiniteScroll' => false,
            'page' => 1,
        );
    }     
}

//http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html
//http://symfony.com/doc/current/forms.html
//http://api.symfony.com/3.2/Symfony/Component/Form/Extension/Core/Type/UrlType.html



//curl https://api.gettyimages.com:443/v3/search/images -H 'API-KEY: 4uuezdgvkea65vwp39nhzfhr' 