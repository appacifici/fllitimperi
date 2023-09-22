<?php

namespace AppBundle\Service\WidgetService;
use AppBundle\Service\UserUtility\UserManager;

class CoreAdminListArticles {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager, UserManager $userManager ) {
        $this->wm = $widgetManager;
        $this->um = $userManager;
    }
    
    public function processData( $options = false ) {
                      
                //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('article', 'read' ) )
                return array();
                
            $allArticlePermission = array( 'Direttore', 'Vice Direttore', 'Admin', 'Super Admin' );
        
            ### ARTICOLI IMPAGINATI ###
            $pagination    = $this->wm->container->get( 'app.paginationUtility' );
            $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
            
            $users = $this->wm->doctrine->getRepository('AppBundle:User')->findAll(); 
            
            $user = $this->um->getDataUser();
            $userId = $user->id;
            if( in_array( $user->role->name, $allArticlePermission ) ) {
                $userId = false;
            }
            
            $params = $this->wm->getAllParamsFromGetRequest();
            
            if( !isset( $params['status'] ) ) {
                $params['status'] = 1;
            }
            
            
            // Query che ritorna TUTTI gli articoli presenti
            $countArticles           = $this->wm->doctrine->getRepository('AppBundle:DataArticle')->countFilterArticles($params, $userId );
//            $countArticles = 1000;
            $listArticles           = $this->wm->doctrine->getRepository('AppBundle:DataArticle')->filterArticlesWithParams( $params, $pagination->getLimit(), $userId );
            
            $pagination->init( $countArticles['tot'] ); 
            $paginationArt = $pagination->makeList();
         
            
            if (!empty($listArticles)) {
                foreach ($listArticles as &$article) {                                                    
                    $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getPermalink() );
                    if( !empty( $article->getPriorityImg() ) ) {
                        $image = $article->getPriorityImg();
                        $this->wm->imageUtility->formatPath( $image, array('small','medium'), 1 );
                        $image->styleMedium = "width:360px; height:165px";
                    }       
                }
            }
          
        return array(
            'articles'   => $listArticles,
            'pagination' => $paginationArt,
            'users'      => $users,
            'keyword'    => ( !empty( $params['keyword'] ) ?  $params['keyword']  :  null  ),
            'userChoice' => ( !empty( $params['user'] ) ?  $params['user']  :  null  ),
            'startDate'  => ( !empty( $params['start-date'] ) ?  $params['start-date']  :  null  ),
            'endDate'    => ( !empty( $params['end-date'] ) ?  $params['end-date']  :  null  ),    
            'status'    =>   $params['status']             
        );
    }
     
}