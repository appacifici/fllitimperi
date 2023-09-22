<?php

namespace AppBundle\Service\WidgetService;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\FormService\FormManager;

class CoreAdminImageArticle extends Controller{
    
     public function __construct( WidgetManager $widgetManager, FormManager $formManager ) {
        $this->wm = $widgetManager;
        $this->fm = $formManager;
    }
    
    public function getDataToAjax() {
        $pagination     = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totImgGallery' ) );
        
        //TODO cambiare con sistema symfony
        $articleId      = $_REQUEST['articleId'];
        $search         = $_REQUEST['keywords'];
        
        $limit          =  !empty( $_REQUEST['resetLimit'] ) && $_REQUEST['resetLimit'] == 'true' ? '0,'.$this->wm->container->getParameter( 'app.totImgGallery' )  :  $pagination->getLimit();
        $page           = !empty( $_REQUEST['resetLimit'] ) && $_REQUEST['resetLimit'] == 'true' ? 1  :  $this->wm->getPage();
        
        $images         = $this->wm->doctrine->getRepository( 'AppBundle:Image' )->findImg( $limit, $search );    
        
        if( empty( count($images) ) )
            return '';
                
        return $this->wm->container->get('twig')->render( 'admin/snippet_InfiniteScrollImages.html.twig', 
                array('images' => $images, 'versionSite' => '/admin', 'infiniteScroll' => true, 'page' => $page )
        );
    }
    
    public function processData( $options = false ) {
        $pagination     = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totImgGallery' ) );
        
        $priorityImgId = null;
        $articleId  = $this->wm->getUrlId();
        
        
        $images         = $this->wm->doctrine->getRepository( 'AppBundle:Image' )->findImg( $pagination->getLimit() );    
        $paginationImg = $pagination->getPaginationInfiniteScroll();

        $dataArticle    = $this->wm->doctrine->getRepository('AppBundle:DataArticle')->find($articleId);
        
        $imgArticle = array();
        if( !empty( $dataArticle ) )
            $imgArticle     = $dataArticle->getImages();
        
        if( !empty( $dataArticle ) && !empty( $dataArticle->getPriorityImg() ) )
            $priorityImgId = $dataArticle->getPriorityImg()->getId();
        
        return array( 
            'images'         => $images,
            'imgArticle'     => $imgArticle,
            'priorityImgId'  => $priorityImgId,
            'articleId'      => $articleId,
            'pagination'     => $paginationImg,
            'infiniteScroll' => false,
            'page' => 1,
            'enabledTab' => !empty( $articleId ) ? true : false,
        );
    }     
}

//http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html
//http://symfony.com/doc/current/forms.html
//http://api.symfony.com/3.2/Symfony/Component/Form/Extension/Core/Type/UrlType.html
