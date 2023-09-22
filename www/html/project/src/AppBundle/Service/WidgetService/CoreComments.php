<?php

namespace AppBundle\Service\WidgetService;

class CoreComments {

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager) {
        $this->wm = $widgetManager;      
    }

    public function processData($options = false) {
        $articleId = $this->wm->getUrlArticleId();
        
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totCommentsArticle' ) );
        
        $countComments           = $this->wm->doctrine->getRepository('AppBundle:Comment')->countCommentsByDataArticle( $articleId );
        
        if ( !empty( $articleId ) )
            $comments = $this->wm->doctrine->getRepository('AppBundle:Comment')->findCommentsByDataArticle( $articleId, $pagination->getLimit() );

        $pagination->init( $countComments['tot'] ); 
        $paginationArt = $pagination->makeList();
        
        return array(
            'comments' => $comments,
            'pagination' => $paginationArt,
            'totComment' => $countComments['tot']
        );
    }

}
