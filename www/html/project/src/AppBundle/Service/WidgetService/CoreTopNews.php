<?php

namespace AppBundle\Service\WidgetService;

class CoreTopNews {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {     
        $limitNews = !empty( $options->limitNews ) ? $options->limitNews : 3; 
        $topNews                = $this->wm->doctrine->getRepository('AppBundle:DataArticle')->getTopNews( $limitNews );
        
         foreach ( $topNews as &$article ) {
            $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl($article->getContentArticle()->getPermalink()  );
            if( !empty( $article->getPriorityImg() ) ) {                    
                    $image = $article->getPriorityImg();
                    $this->wm->imageUtility->formatPath( $image, array('small','medium'), 1 );
                }                                
                $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getPermalink()  );
        }
        
            
        
        return array( 
            'articles'       => $topNews
        );
    } 
}