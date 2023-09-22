<?php

namespace AppBundle\Service\WidgetService;


class CoreListNewsOP {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function getDataToAjax() {
        
    }
    
    public function processData( $option = false ) {                                       
        $route = $this->wm->container->get('app.routerManager')->match( $this->wm->getRequestUri() );
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
        
        $parmas = $this->wm->getCatSubcatTypology();        
        $catSubcatTypology = $parmas['catSubcatTypology'];
        
        $megazineSection    = $this->wm->getMegazineSection( 'megazineSection' );                
        $megazineSection    =  trim( $this->wm->getRequestUri(), '/' );
        
        $megazineSection    = $this->wm->doctrine->getRepository( 'AppBundle:MegazineSection' )->findOneByNameUrl( $megazineSection );
        $megazineSectionId  = !empty( $megazineSection ) ? $megazineSection->getId() : false;
        $megazineHome       =  $route['_route'] == 'listArticles1' || $route['_route'] == 'listArticles2' ? true : false; 
        
        $categoryId         = false;
        $subcategoryId      = false;
        $typologyId         = false;
        $paginationArt      = false;
        $countArticles      = false;
        
        if( $route['_route'] != 'detailProduct') {            
            if( !empty( $catSubcatTypology ) ) {
                $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );    
                $responseCat      = $this->globalQueryUtility->getRedisOrDBCatSubcatTypology( $catSubcatTypology );        
                $categoryId       = $responseCat->category;
                $subcategoryId    = $responseCat->subcategory;
                $typologyId       = $responseCat->typology;
            }

            $topNews = false;
            $exclusive = false;
            $paginationArt = false;
            $countArticles = false;
            
            $limit = $option->limitNews != 0 ? $option->limitNews : 99;            
//            if( !empty( $megazineHome )) {
//                $option->limitNews = 99;
//                $limit = 99;
//            }
            
            if( empty( $option->limitNews ) ) {
                
                ### ARTICOLI IMPAGINATI ###
                $pagination    = $this->wm->container->get( 'app.paginationUtility' );
                $pagination->getParamsPage( $this->wm->container->getParameter( 'app.toLinksPaginationGuide' ) );
                $countArticles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->countArticleByParams( $megazineSectionId, $categoryId, $subcategoryId, $typologyId, $topNews, $exclusive );        

                $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticleByParams( $megazineSectionId, $categoryId, $subcategoryId, $typologyId, $pagination->getLimit(), $topNews, $exclusive );    
                $pagination->init( $countArticles['tot'], $this->wm->container->getParameter( 'app.toLinksPaginationGuide' ) );                        
                $paginationArt = $pagination->makeList();            
                $this->wm->container->get( 'twig' )->addGlobal( 'lastPagePagination', $pagination->lastPage() );
                
            } else {
                $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findArticleByParams( $megazineSectionId, $categoryId, $subcategoryId, $typologyId, $limit, $topNews, $exclusive );    
                $countArticles = $limit;
            }


            if(  $route['_route'] == 'listArticles' ) {
                if( !empty( $catSubcatTypology ) ) {
                    $this->wm->container->get( 'twig' )->addGlobal( 'h1SectionListArticles', 'Informazioni e notizie di ' .$catSubcatTypology );                                                  
                }
            }
            if( $route['_route'] == 'catSubcatTypologyProduct' )
                $this->wm->container->get( 'twig' )->addGlobal( 'labelMagazine', 'Notizie, approfondimenti e curiosità '.ucfirst( $catSubcatTypology ).' ' );              
            
        } 
               
        
        //Nel dettaglio di un modello
        if( $route['_route'] == 'detailProduct' ) {
            $model = $this->globalQueryUtility->getModelByNameUrl( $route['name'] );       
            $modelId = !empty( $model ) ? $model->getId() : false;
            if( !empty( $modelId ) )
                $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findBy( array('modelId' => $modelId, 'status' => 1), array(), 4  );
            $countArticles = 4;
            $this->wm->container->get( 'twig' )->addGlobal( 'h1Section', false );
            if( !empty( $model ) )
                $this->wm->container->get( 'twig' )->addGlobal( 'labelMagazine', 'Notizie, approfondimenti e curiosità '.$model->getName().' ' );  
        }
        

        //Cicla e finalizza l'arrey degli articoli
        if (!empty($articles)) {
            foreach ($articles as &$article) {
                if( !empty( $article->getPriorityImg() ) ) {
                    $image = $article->getPriorityImg();
                    $this->wm->imageUtility->formatPath( $image, array('small','medium','big'), 1 );
                    $image->styleMedium = "width:360px; height:165px";
                }                   
                $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getPermalink() ); 
                
                
                //Gestione delle url per gli articoli di primo livello e di secondo livello 
                //ES: /passeggini/inglesina <== detailNews2
                $baseArticle = '';
                if( !empty( $article->getArticleId() ) ) {
                    $baseArticle = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findOneById( $article->getArticleId() );
                    $baseArticle =  $baseArticle->getContentArticle()->getPermalink();
                    
                    $article->getContentArticle()->urlArticle = $this->wm->routerManager->generate( 'detailNews2', array(                         
                        'baseArticle' => $baseArticle,
                        'title' => $article->getContentArticle()->urlArticle
                    )); 
                    
                } else {                                                                               
                    $article->getContentArticle()->urlArticle = $this->wm->routerManager->generate( 'detailNews'.$article->getMegazineSection()->getId(), array(                         
                        'title' => $article->getContentArticle()->urlArticle
                    ));     
                }
            }
        }                       
        
        $label                  = new \stdClass;
//        $label->img             = '/images/guide_acquisto.png';
        $label->name            = 'Guide all\'acquisto';
        $label->description     = 'Leggi le nostre guide all\'acquisto, informati, e scegli bene ciò che compri!';
        
        $sectionItems            = array();
//        $sectionItems[1]['img']  = '/images/guida_acquisto.png';
//        $sectionItems[1]['url']  = '/guida_acquisto';
//        $sectionItems[1]['name'] = 'Guide all\'acquisto';
//        
//        $sectionItems[0]['img']  = '/images/recensione.png';
//        $sectionItems[0]['url']  = '/recensione';
//        $sectionItems[0]['name'] = 'Recensioni';
        
        
        return array(
            'articles'      => !empty( $articles ) ? $articles : array(),
            'page'          => $this->wm->getPage(),
            'megazineHome'  => $megazineHome,
            'label'         => $label,
            'sectionItems'  => $sectionItems,
            'pagination'    => $paginationArt,
            'countArticles' => !empty( $countArticles ) ? $countArticles['tot'] : 0,
            'page'          => $this->wm->getPage()
        );
    }
}
