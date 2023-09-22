<?php

namespace AppBundle\Service\WidgetService;


class CoreListNews {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function getDataToAjax() {
        $categoryId = null;
        $subcategoryId = null;
        $topNews = false;
        //TODO D A RIMUOVERE
        $exclusive = false;
        $printSubHeading = true;
        $uri = $this->wm->getUri();
        $this->route = $this->wm->container->get('router')->match( $uri );        
        
        if( !empty( $_GET['q'] ) ){
            return $this->getArticlesBySearch( $_GET['q'], true, 'date' );           
        }
        
        $category   = $this->wm->doctrine->getRepository( 'AppBundle:Category' )->findByNameUrl($this->route['category']);                                    
        if ( !empty( $category ) ) {            
            $category   = $category;
            $categoryId = $category->getId();
        }
        
        //Avvio la paginazione
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
        $pagination->getLimit();
        
        //Recupera tutte le news senza categoria
        if ( !empty( $this->route['category'] ) && $this->route['category'] == 'news' ) {
            $category = false;
            $aSubcategory = $this->getSubcategoryByName( $this->route['subcategory'] );
                if ( !empty( $aSubcategory ) )
                    $subcategoryId = $aSubcategory->getId();
                
            $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticleByCategoryAndTeam( false, $subcategoryId, $pagination->getLimit(), false ); 
        } else {
            
            if( $this->route['category'] == 'in-primo-piano' ) {
                $topNews = true;
                $categoryId = false;
                $category = new \stdClass();
                $category->name = 'Primo Piano';
                $category->color = 'Red';
            }
            
            //TODO D A RIMUOVERE
            if( $this->route['category'] == 'esclusivo' ) {
                $this->extraConfigs = $this->wm->globalConfigManager->getExtraConfigs();
                
                $pageTitleExclusiveNews = $this->extraConfigs['facebookFollowUs']->getValue();
                $exclusive = true;
                $categoryId = false;
                $category = new \stdClass();
                $category->name = 'Esclusiva';
                $category->color = 'Red';

                $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', 'News in esclusiva | Calciomercato.it' );
                $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', 'Notizie in esclusiva in tempo reale' );                                    
            }
            
            // ecupero il teamId per la lista degli articoli per squadra
            if (!empty($this->route['subcategory'])) {
                $subcategory   = $this->wm->doctrine->getRepository( 'AppBundle:Subcategory' )->findOneByNameUrl($this->route['subcategory']);

                if ( !empty( $subcategory ) )
                    $subcategoryId = $subcategory->getId();
            }
            
            $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticleByCategoryAndTeam( $categoryId, $subcategoryId, $pagination->getLimit(), $topNews, $exclusive );   
            if( empty( count( $articles ) ) )
                return '';        
        }
        
        
        
        if (!empty($articles)) {
            foreach ($articles as &$article) {
                if( !empty( $article->getPriorityImg() ) ) {
                    $image = $article->getPriorityImg();
                    $this->wm->imageUtility->formatPath( $image, array('small','medium','big'), 1 );
                    $image->styleMedium = "width:360px; height:165px";
                }                                   
                $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getTitle() );
            }
        }        
            
        $twigT = $this->wm->getVersionSite().'/widget_InfiniteScrollNewsGlobal.html.twig';

        
        return $this->wm->container->get('twig')->render( $twigT, 
                array( 'articles' => $articles, 
                    'category' => $category, 
                    'printSubHeading' => $printSubHeading, 
                    'ajax' => true, 
                    'page' => $this->wm->getPage() )
        );
    }
    
    public function processData( $option = false ) {    
        $articles = null;
        $category = null;
        $subcategory = null;
        $subcategoryId = null;
        $limit = null;
        $paginationArt = null;
        $countArticles = null;
        $topNews = false;
        $exclusive = false;
        $printSubHeading = false;
        $categoryId = false;        
        
        // parametri presi dal template manager quindi a categoria fissa e limite fisso
        if ( !empty( $option->categoryNews ) && $option->categoryNews != 'allnews'  ) {
            $categoryId = $option->categoryNews;
            
            $limit = $option->limitNews != 0 ? $option->limitNews : 20;
            $topNews = false;
            $exclusive = false;
            //TODO D A RIMUOVERE
            if( $option->categoryNews == 6 ) {
                $exclusive = true;
            }
            
        } else {
            if( !empty( $_GET['q'] ) ){
                return $this->getArticlesBySearch( $_GET['q'], false, 'date' );
            }
            
            // recupero gli articoli per la lista degli articoli per categoria
            $articleId = $this->wm->getUrlArticleId();
            $categoryName = $this->wm->getUrlCategory();
            $subcategoryUrlName = $this->wm->getUrlSubcategory();
            $printSubHeading = true;            
            
            
########################################################################################################################################
########################################## INIZIO SEZIONE PER LA GESTIONE DI ALLNEWS ###################################################
########################################################################################################################################
            if( !empty( $option->categoryNews ) && $option->categoryNews == 'allnews' ) {                
                $categoryName = $option->categoryNews;
            }
            
            if ( !empty( $categoryName ) && $categoryName == 'allnews' ) {
                $categoryName = false;
                $limit = $option->limitNews != 0 ? $option->limitNews : 20;
                
                //controlla se sia la richiesta delle all news si una sottocategoria
                $aSubcategory = $this->getSubcategoryByName( $subcategoryUrlName );
                if ( !empty( $aSubcategory ) )
                    $subcategoryId = $aSubcategory->getId();
                
                
                if( !empty( $subcategoryUrlName ) && empty( $subcategoryId ) )
                    return array( 'errorPage' => 404 );
                
                
                $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticleByCategoryAndTeam( false, $subcategoryId, $limit, false ); 
                
                if( !empty( $aSubcategory ) ) {
                    $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', $aSubcategory->getMetaTitle() );
                    $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', $aSubcategory->getMetaDescription() );                
                    $this->wm->container->get( 'twig' )->addGlobal( 'pagekwds', $aSubcategory->getMetaKeyword() );
                }
                
########################################################################################################################################
########################################## FINE SEZIONE PER LA GESTIONE DI ALLNEWS #####################################################
########################################################################################################################################
                
            } else {          
               
########################################################################################################################################
###################################### INIZIO SEZIONE PER STANDARD PER NAVIGAZIONE CATEGRIE ############################################
########################################################################################################################################                
                
                $aSubcategory = $this->getSubcategoryByName( $subcategoryUrlName );
                if ( !empty( $aSubcategory ) )
                    $subcategoryId = $aSubcategory->getId();

                
                #################################################################################
                ######## Recupero articoli correlati per categoria dal dettaglio articolo #######
                #################################################################################
                if (!empty ( $articleId )){
                    $dataArticle = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->find( $articleId );

                    if ( !empty ( $dataArticle->getCategory() ) )
                        $categoryName = $dataArticle->getCategory()->getNameUrl();
                    $limit  = 6;
                }

                
                #################################################################################
                ########################## Apertura fake url primo piano ########################
                #################################################################################
                if( $categoryName == 'in-primo-piano' ) {
                    $topNews = true;
                    $categoryId = false;
                    $category = new \stdClass();
                    $category->name = 'Primo Piano';
                    $category->color = 'Red';
                    
                    $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', 'News in primo piano | Calciomercato.it' );
                    $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', 'Notizie in primo piano aggiornate in tempo reale' );                
                    
                }
                
                #################################################################################
                ########################## Apertura fake url esclusivo ##########################
                #################################################################################
                if( $categoryName == 'esclusivo' ) {
                    $exclusive = true;
                    $categoryId = false;
                    $category = new \stdClass();
                    $category->name = 'Esclusiva';
                    $category->color = 'Red';
                    
                    $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', 'News in esclusiva | Calciomercato.it' );
                    $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', 'Notizie in esclusiva in tempo reale' );                                    
                }

                $categoryEntity   = $this->wm->doctrine->getRepository( 'AppBundle:Category' )->findByNameUrl( $categoryName );                                    
                if ( !empty( $categoryEntity ) ) {
                    if( $categoryName != 'esclusivo' ) {
                    $category   = $categoryEntity;
                    $categoryId = $categoryEntity->getId();
                    }
                }
            }
        }
        
        
        //PARTE UGUALE PER TUTTO
        if ( empty ( $category ) && !empty ( $categoryId ) ){
            $category = $this->wm->doctrine->getRepository( 'AppBundle:Category' )->findById( $categoryId );            
        }   
        
        
#######################################################################################################################################
################################################# INIZIO RECUPER ARTICOLI EFFETTIVO ###################################################
#######################################################################################################################################                
        
        
        if ( $limit == null ) {             
            //se la categoria non esiste lancio il 404
            if( !empty( $categoryName ) && $categoryName != 'in-primo-piano' && $categoryName != 'esclusivo' && empty( $categoryId ) )
                return array( 'errorPage' => 404 );
            
            if( !empty( $subcategoryUrlName ) && empty( $subcategoryId ) )
                return array( 'errorPage' => 404 );
            
            ### ARTICOLI IMPAGINATI ###
            $pagination    = $this->wm->container->get( 'app.paginationUtility' );
            $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
            $countArticles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->countArticleByCategoryAndTeam( $categoryId, $subcategoryId, $topNews, $exclusive );        
            
            $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticleByCategoryAndTeam( $categoryId, $subcategoryId, $pagination->getLimit(), $topNews, $exclusive );    
            $pagination->init( $countArticles['tot'], $this->wm->container->getParameter( 'app.toLinksPagination' ) );                        
            $paginationArt = $pagination->makeList();
            
            if( !$topNews && !$exclusive && !empty( $category ) && is_object( $category ) ) {
                $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', html_entity_decode( $category->getMetaTitle() ) );
                $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', html_entity_decode( $category->getMetaDescription() ) );                
                $this->wm->container->get( 'twig' )->addGlobal( 'pagekwds', html_entity_decode( $category->getMetaKeyword() ) );
            }
            
            if( !empty( $aSubcategory ) && is_object( $aSubcategory ) ) {
                $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', html_entity_decode( $aSubcategory->getMetaTitle() ) );
                $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', html_entity_decode( $aSubcategory->getMetaDescription() ) );                
                $this->wm->container->get( 'twig' )->addGlobal( 'pagekwds', html_entity_decode( $aSubcategory->getMetaKeyword() ) );
            }
            
            if( !$topNews && !$exclusive && !empty( $category ) && strtolower(  $category->getName() ) == 'mercato' && !empty( $aSubcategory ) && is_object( $aSubcategory ) ) {
                $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', html_entity_decode( $aSubcategory->getMetaTitleTM() ) );
                $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', html_entity_decode( $aSubcategory->getMetaDescriptionTM() ) );                
                $this->wm->container->get( 'twig' )->addGlobal( 'pagekwds', html_entity_decode( $aSubcategory->getMetaKeywordTM() ) );
            }
            
        } else if ( !empty( $categoryId ) ) {  
            //TODO D A RIMUOVERE
            if( $categoryId == 6 )
                $categoryId = $subcategoryId = false;
            $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticleByCategoryAndTeam( $categoryId, $subcategoryId, $limit, $topNews, $exclusive );                
        }
        
        
        //Cicla e finalizza l'arrey degli articoli
        if (!empty($articles)) {
            foreach ($articles as &$article) {
                if( !empty( $article->getPriorityImg() ) ) {
                    $image = $article->getPriorityImg();
                    $this->wm->imageUtility->formatPath( $image, array('small','medium','big'), 1 );
                    $image->styleMedium = "width:360px; height:165px";
                }                                
                $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getTitle() );
            }
        }       
        
        if( $option->categoryNews == 6 ) {
            print_r( $articles );
        }
        
        return array(
            'articles' => !empty( $articles ) ? $articles : array(),
            'category' => $category,
            'pagination' => $paginationArt,
            'countArticles' => $countArticles,
            'printSubHeading' => $printSubHeading,
            'page' => $this->wm->getPage()
        );
    }
    
    /**
     * Metodo che avvia un ricerca su elasticsearch
     * @param type $search
     * @return type
     * ES: ( curl -XGET 'http://localhost:9200/cmsadmin/_search' -d '{"query":{"query_string":{"query":"dopo aver recitato"}},"size":1} )
     */
    private function getArticlesBySearch( $search, $isAjax = false,  $order = 'relevance' ) {  
        $countArticles = 0;
        $finder = $this->wm->container->get('fos_elastica.finder.cmsadmin');        
        
        $search = preg_replace("#([^a-z0-9])#i", ' ', $search);        
        $searchArticles = $finder->find( $search, 1000 );

        ### ARTICOLI IMPAGINATI ###
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
     
        
        $limit =  explode( ',', $pagination->getLimit() );        
        if( !empty( $searchArticles ) ) {
             foreach ( $searchArticles as $article ) {
                $idsFilteredArticles[$article->getId()] = $article->getId();                 
            }

            if( $order == 'relevance') {
                $idsFilteredArticles = array_slice($idsFilteredArticles, $limit[0], $limit[1], true) ;
                $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticlesByIds( $idsFilteredArticles, false );   
                
                $newArticles = array();
                foreach( $articles as $article ) {
                    $newArticles[$article->getId()] = $article;                    
                }                
                
                $finalArticles =  array();
                foreach( $idsFilteredArticles as $id ) {
                    if( !empty( $newArticles[$id] ) )
                        $finalArticles[] = $newArticles[$id];
                }
                
                $articles = $finalArticles;
                
            } else {            
                $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticlesByIds( $idsFilteredArticles, $pagination->getLimit() );              
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
                    $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getTitle() );
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
    
    private function getSubcategoryByName( $subcategoryUrlName ) {
        $subcategory = false;
        // recupero il subcategoryId per la lista degli articoli per sottocategoria
        if (!empty($subcategoryUrlName)) {
            $subcategory   = $this->wm->doctrine->getRepository( 'AppBundle:Subcategory' )->findOneByNameUrl($subcategoryUrlName);           
        }
        return $subcategory;
    }
    
}
