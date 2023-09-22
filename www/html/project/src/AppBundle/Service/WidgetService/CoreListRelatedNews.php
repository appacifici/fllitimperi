<?php

namespace AppBundle\Service\WidgetService;


class CoreListRelatedNews {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
   
    public function getDataToAjax( $option = false ) {   
        return $this->processData( $option );
    }     
    
    public function processData( $option = false ) {       
        $id = $this->wm->getUrlArticleId();      
        $varAttrAjax = !empty( $option->varAttrAjax ) ? $option->varAttrAjax : false;        
        $limit = $option->limitNews != 0 ? $option->limitNews : 20;
        $id = !empty( $_GET['id'] ) ? $_GET['id'] : $id;
                        
        $article = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findOneById( $id );   
        if( empty( $article ) || empty( $article->getContentArticle() ) )
            return array();
        
        return $this->getArticlesBySearch( $article->getContentArticle()->getPermalink() , $id );
        
        
        
        
        $category = !empty( $article->getCategory() ) ? $article->getCategory() : false;
        $categoryId = !empty( $article->getCategory() ) ? $article->getCategory()->getId() : false;
        $subcategoryId = !empty( $article->getSubcategoryOne() ) ? $article->getSubcategoryOne()->getId() : false;
        
        $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticleByCategoryAndTeam( $categoryId, $subcategoryId, $limit, true );         
        
        $filterArticles = array();
        
        if (!empty($articles)) {
            foreach ($articles as $key => &$article) {                
                if( $id == $article->getId() ) {                
                    continue;
                }                 
                
                if( !empty( $article->getPriorityImg() ) ) {
                    $image = $article->getPriorityImg();
                    $this->wm->imageUtility->formatPath( $image, array('small','medium','big'), 1 );
                    $image->styleMedium = "width:360px; height:165px";
                }                                  
                $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getPermalink()  );                
                $filterArticles[] = $article;
            }            
        }
        
        
//         //Gestione del seo
//        if( $titleByUrl && $this->wm->getCurrentRoute() !=  'resultsSeason' &&  $this->wm->getCurrentRoute() !=  'teamDetail'  ) {
//            $metaTitle = ucfirst( $teamUrlName ).' News' . ' | Notizie '.$teamTitle.' '.$seasonTitle;
//            if( !empty( ucfirst( $teamUrlName ) ) ) 
//                $metaDescription = 'Minuto per minuto le '.ucfirst( $teamUrlName ).' News riguardanti: Risultati, Classifica, Dirette, Esclusive, Interviste ai protagonisti';
//            else
//                $metaDescription = 'Notizie Aggiornate 24H - News Calcio '.$seasonTitle.' '.ucfirst( $categoryName ).' | Calciomercato.it';
//            
//            
//            $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', $metaTitle );
//            $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', $metaDescription );                
//            $this->wm->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
//        }
        
        
        return array(
            'articles' => $filterArticles,
            'category' => $category,
            'pagination' => false,
            'countArticles' => $limit,
            'printSubHeading' => false,
            'page' => $this->wm->getPage(),
            'varAttrAjax' => $varAttrAjax
        );
    }
    
    
     
    /**
     * Metodo che avvia un ricerca su elasticsearch
     * @param type $search
     * @return type
     * ES: ( curl -XGET 'http://localhost:9200/cmsadmin/_search' -d '{"query":{"query_string":{"query":"dopo aver recitato"}},"size":1} )
     * http://elastica.io/getting-started/search-documents.html#section-search
     */
    private function getArticlesBySearch( $search, $id, $isAjax = false,  $order = 'relevance' ) {          
        $countArticles = 0;
        
        ### ARTICOLI IMPAGINATI ###
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
     
        $limit =  explode( ',', $pagination->getLimit() );  
        
        $query = new \Elastica\Query();
        
        if( $order != 'relevance' )
            $query->addSort(array('contentArticle.dataArticle.publishAt' => array('order' => 'desc')));

        $search = preg_replace("#([^a-z0-9])#i", ' ', $search);        
        $q = new \Elastica\Query\QueryString($search);
        
        
        $query->setSize((int)6);
        $query->setFrom((int)0);
        $query->setQuery($q);
        
        $searchArticles = $this->wm->container->get('fos_elastica.finder.cmsadmin')->find($query);
        
              
        if( !empty( $searchArticles ) ) {
             foreach ( $searchArticles as $article ) {
                $idsFilteredArticles[$article->getId()] = $article->getId();                 
            }
            unset( $idsFilteredArticles[$id] );
            
            if( $order == 'relevance') {
                $idsFilteredArticles = array_slice($idsFilteredArticles, 0, 6, true) ;
                $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticlesByIds( $idsFilteredArticles, false );   
                
            } else {            
                $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticlesByIds( $idsFilteredArticles, false );              
                
            }
            
            $countArticles = count($idsFilteredArticles);
            $pagination->init( count($searchArticles), $this->wm->container->getParameter( 'app.toLinksPagination' ) );                        
            $paginationArt = $pagination->makeList();            


            //Cicla e finalizza l'arrey degli articoli
            if (!empty($articles)) {                
                foreach ($articles as &$article) {
                    if( !empty( $article->getPriorityImg() ) ) {
                        $image = $article->getPriorityImg();
                        $this->wm->imageUtility->formatPath( $image, array('small','medium','big'), 1 );
                        $image->styleMedium = "width:360px; height:165px";
                    }                                
                    $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getPermalink()  );
                }
            }
        }

        if ( !empty( $_GET['q'] ) && $isAjax ) {
            $twigT = $this->wm->getVersionSite().'/widget_InfiniteScrollNewsGlobal.html.twig';
            return $this->wm->container->get('twig')->render( $twigT, 
                array( 'articles' => $articles, 
                    'category' => false, 
                    'printSubHeading' => false, 
                    'ajax' => true, 
                    'page' => $this->wm->getPage() )
            );
        }
        
        return array(
            'articles' => !empty( $articles ) ? $articles : array(),
            'category' => false,
            'pagination' => !empty( $paginationArt ) ? $paginationArt : array(),
            'countArticles' => $countArticles,
            'printSubHeading' => false,
            'page' => $this->wm->getPage()
        );
        
    }
    
    
}