<?php

namespace AppBundle\Service\WidgetService;

class CoreBreadCrumbs {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {
        $route          = $this->wm->routerManager->match( $this->wm->getBreadcrumb() );        
        $aBreadcrumbs   = array();
        $url            = '';
        $x              = 0;
        
        $this->seoConfigManager = $this->wm->container->get( 'app.seoConfigManager' );    
        switch( $route['_route'] ) {
            case 'dinamycPage':  
                
                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'dinamycPage', array( 'page' => $route['page'] ) );

                $aBreadcrumbs[$x]['name']    = ucfirst( str_replace( '-', ' ', $route['page'] ) );
                $aBreadcrumbs[$x]['link']    = false;
            
                $this->seoConfigManager->seoDinamycPage( $route['page'] );
            break;
            case 'detailNews1':  
            case 'detailNews2':  
            case 'detailNews3':  
            case 'detailNewsAmp1':  
            case 'detailNewsAmp2':  
            case 'detailNewsAmp3':  
                
                $params = array();
                
//                $aBreadcrumbs[0]['url']     = $this->wm->routerManager->generate( 'listArticles' );
//                $aBreadcrumbs[0]['name']    = 'Megazine';
//                $aBreadcrumbs[0]['link']    = true;           
//                $x = 1;                                  
                
                $parseUrl = explode( '/', trim( $this->wm->getRequestUri(),' /' ) );                
                $route['megazineSection'] = $parseUrl[0] != 'amp' ? $parseUrl[0] : $parseUrl[1];                                      
                
                switch( $route['megazineSection'] ) {
                    case 'recensione':
                        $id = 3;
                    break;
                    default:
                        $id = 1;
                    break;
                }  
                
                           
                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'listArticles'.$id );

                $aBreadcrumbs[$x]['name']    = ucfirst( str_replace( '_', ' ', $route['megazineSection'] ) );
                $aBreadcrumbs[$x]['link']    = true;
                $x++;
                
                if( $route['_route'] == 'detailNews2' ) {
                    $params['title']        = $route['baseArticle'];                
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( "detailNews1", $params );                                                
                    $aBreadcrumbs[$x]['name']    = ucfirst( str_replace( '_', ' ', $route['baseArticle'] ) );
                    $aBreadcrumbs[$x]['link']    = true;    
                    //Forzato per far generare la url di un articolo annidato in un altro
                    $id = 2;
                    $params['baseArticle']        = $route['baseArticle'];   
                    $x++;
                }
                
                $params['title']        = $route['title'];                
                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( "detailNews$id", $params );                                                
                $aBreadcrumbs[$x]['name']    = ucfirst( str_replace( '_', ' ', $route['title'] ) );
                $aBreadcrumbs[$x]['link']    = false;                                
                                                
            break;
            case 'listArticles1':  
            case 'AMPlistArticles1':  
            case 'listArticles2':  
            case 'AMPlistArticles2':  
                $parseUrl = explode( '/', trim( $this->wm->getRequestUri(),' /' ) );                
                $route['megazineSection'] = $parseUrl[0];    
                                
                switch( $route['megazineSection'] ) {
                    case 'recensione':
                        $id = 2;
                    break;
                    default:
                        $id = 1;
                    break;
                }  
                
                
//                $aBreadcrumbs[0]['url']     = $this->wm->routerManager->generate( 'listArticles'.$id );
//                $aBreadcrumbs[0]['name']    = 'Megazine';
//                $aBreadcrumbs[0]['link']    = empty( $route['megazineSection'] ) ? false : true;           
//                $x = 1;
                
//                $this->seoConfigManager->seoListArticles( false );
                
                $name = explode( '?', $route['megazineSection'] );
                
                if( !empty( $route['megazineSection'] ) ) {
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'listArticles'.$id );
                    $aBreadcrumbs[$x]['name']    = ucfirst( str_replace( '_', ' ', $name[0] ) );
                    $aBreadcrumbs[$x]['link']    = !empty( $route['section1'] ) ? true : false;
                    $x++;
                    $this->seoConfigManager->seoListArticles( ucfirst( str_replace( '_', ' ', $route['megazineSection'] ) ) );
                }
                
                                   
            break;
        
            case 'allCategoriesProduct':  
                $aBreadcrumbs[0]['url']     = $this->wm->routerManager->generate( 'allCategoriesProduct' );
                $aBreadcrumbs[0]['name']    = 'Tutte le categorie';
                $aBreadcrumbs[0]['link']    = false;                
                $aBreadcrumbs[$x]['h1']     = false;
                $this->seoConfigManager->setMetaAllCategoriesProduct();
                
            break;            
            case 'catSubcatTypologyProduct':            
//            case 'listModelsTrademark':   
                
                $type = 'MicroSection';
                if( !empty( $route['section4']  ) ) {
                    $catSubcatTypology  = $route['section4'];
                } else if( !empty( $route['section3'] ) ) {
                    $catSubcatTypology  = $route['section3'];
                    $type = 'Typology';
                } else if( !empty( $route['section2'] ) ) {
                    $catSubcatTypology  = $route['section2'];
                    $type = 'Subcategory';
                } else if( !empty( $route['section1'] ) ) {
                    $catSubcatTypology  = $route['section1'];
                    $type = 'Category';
                }
                $aCatSubcatTypology = explode( '-', $catSubcatTypology );
                $trademark = !empty( $route['trademark'] )  ? $route['trademark'] : false;
                
                $catSubcatTypology  = $aCatSubcatTypology[0];
                $search = !empty( $aCatSubcatTypology[1] ) ? $aCatSubcatTypology[1] : false;                
                
                $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
                $response = $this->globalQueryUtility->getCatSubcatTypology( $catSubcatTypology, false, $type );

                $category       = $response->category;
                $subcategory    = $response->subcategory;
                $typology       = $response->typology;
                $microSection   = $response->microSection;
              
                $x = 0;                
//                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'allCategoriesProduct' );
//                $aBreadcrumbs[$x]['name']    = 'Tutte le categorie';
//                $aBreadcrumbs[$x]['link']    = true;
//                $x++;
                
                if( !empty( $category ) ) {                    
                    $this->seoConfigManager->setCatSubcatTypologyProduct( 'category', $category );
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $route['section1'],  'section2' => $route['section2'], 'section3' => $route['section3'] ) 
                    );
                    $aBreadcrumbs[$x]['name']    = $category->getName();
                    $aBreadcrumbs[$x]['link']    = empty( $search ) ? false : true;
                    $x++;
                    
                    //Aggiungo il termine di ricerca
                    if( !empty( $search ) ) {
                        $this->seoConfigManager->setCatSubcatTypologyProduct( 'search', false, false, false, $search );                        
                                                
//                        $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $catSubcatTypology ) );
                        $aBreadcrumbs[$x]['url']     =  $this->wm->getRequestUri();
                        $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $search );
                        $aBreadcrumbs[$x]['link']    = false;
                        $x++;
                    }
                }
                
                $nameSection = '';
                if( !empty( $subcategory ) ) {                         
                    $nameSection                 = $subcategory->getName();                                                                                                    
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $subcategory->getCategory()->getNameUrl()                        
                    ));
                    $aBreadcrumbs[$x]['name']    = $subcategory->getCategory()->getName();
                    $aBreadcrumbs[$x]['link']    = true;
                    $x++;
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $subcategory->getCategory()->getNameUrl(),
                        'section2' => $subcategory->getNameUrl() 
                    ) );
                    $aBreadcrumbs[$x]['name']    = $subcategory->getName();
                    $aBreadcrumbs[$x]['link']    = empty( $search ) ? false : true;
                    $aBreadcrumbs[$x]['link']    = !empty( $trademark )  ? true : $aBreadcrumbs[$x]['link'];
                    $x++;
                    
                     //Aggiungo il termine di ricerca
                    if( !empty( $search ) ) {
//                        $this->seoConfigManager->setCatSubcatTypologyProduct( 'search', false, false, false, $search );                        
                        $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                            'section1' => $subcategory->getCategory()->getNameUrl(),
                            'section2' => $subcategory->getNameUrl() .'-'.$search
                        ) );
                        $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $search );
                        $aBreadcrumbs[$x]['link']    = false;
                        $x++;                                 
                        
                    } else {
                        $this->seoConfigManager->setCatSubcatTypologyProduct( 'subcategory', false, $subcategory );
                    }                    
                }
                
                if( !empty( $typology ) ) {   
                    $nameSection                 = $typology->getName();                    
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $typology->getCategory()->getNameUrl()                        
                    ));
                    $aBreadcrumbs[$x]['name']    = $typology->getSubcategory()->getCategory()->getName();
                    $aBreadcrumbs[$x]['link']    = true;
                    $x++;                   
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $typology->getCategory()->getNameUrl(),
                        'section2' => $typology->getSubcategory()->getNameUrl() 
                    ));
                    $aBreadcrumbs[$x]['name']    = $typology->getSubcategory()->getName();
                    $aBreadcrumbs[$x]['link']    = true;
                    $x++;                                                            
                    
//                   Aggiungo il termine di ricerca
                    if( !empty( $search ) ) {                        
                        $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array(
                            'section1' => $typology->getCategory()->getNameUrl(),
                            'section2' => $typology->getSubcategory()->getNameUrl(),
                            'section3' => $typology->getNameUrl() ) 
                        );
                        $aBreadcrumbs[$x]['name']    = $typology->getName();
                        $aBreadcrumbs[$x]['link']    = empty( $search ) ? false : true;
                        $aBreadcrumbs[$x]['link']    = !empty( $trademark )  ? true : $aBreadcrumbs[$x]['link'];
                        $x++;
                        
                        //TErmine di ricerca
                        $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array(
                            'section1' => $typology->getCategory()->getNameUrl(),
                            'section2' => $typology->getSubcategory()->getNameUrl(),
                            'section3' => $typology->getNameUrl().'-'.$search ) 
                        );
                        $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $search );
                        $aBreadcrumbs[$x]['link']    = false;
                        $aBreadcrumbs[$x]['link']    = !empty( $trademark )  ? true : $aBreadcrumbs[$x]['link'];
                        $x++;
                        
//                        $this->seoConfigManager->setCatSubcatTypologyProduct( 'typologySearch', false, false, $typology, $search );                        
                        
                    } else {                        
                        $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array(
                            'section1' => $typology->getCategory()->getNameUrl(),
                            'section2' => $typology->getSubcategory()->getNameUrl(), 
                            'section3' => $typology->getNameUrl()) 
                        );
                        $aBreadcrumbs[$x]['name']    = $typology->getName();
                        $aBreadcrumbs[$x]['link']    = false;
                        $x++;
                        $this->seoConfigManager->setCatSubcatTypologyProduct( 'typology', false, false, $typology );
                    }       
                    
                }    
                
                
                if( !empty( $microSection ) ) {   
                    $nameSection                 = $microSection->getName();
//                    $this->seoConfigManager->setCatSubcatTypologyProduct( 'typology', false, false, $typology );
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $microSection->getCategory()->getNameUrl(),                        
                    ));
                    $aBreadcrumbs[$x]['name']    = $microSection->getCategory()->getName();
                    $aBreadcrumbs[$x]['link']    = true;
                    $x++;
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $microSection->getCategory()->getNameUrl(),
                        'section2' => $microSection->getSubcategory()->getNameUrl() 
                    ));
                    $aBreadcrumbs[$x]['name']    = $microSection->getSubcategory()->getName();
                    $aBreadcrumbs[$x]['link']    = true;
                    $x++;                    
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $microSection->getCategory()->getNameUrl(),
                        'section2' => $microSection->getSubcategory()->getNameUrl(),
                        'section3' => $microSection->getTypology()->getNameUrl() 
                    ));
                    $aBreadcrumbs[$x]['name']    = $microSection->getTypology()->getName();
                    $aBreadcrumbs[$x]['link']    = true;
                    $x++;                    
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $microSection->getCategory()->getNameUrl(),
                        'section2' => $microSection->getSubcategory()->getNameUrl(),
                        'section3' => $microSection->getTypology()->getNameUrl(),
                        'section4' => $microSection->getNameUrl() 
                    ));
                    $aBreadcrumbs[$x]['name']    = $microSection->getName();
                    $aBreadcrumbs[$x]['link']    = empty( $search ) ? false : true;
                    $x++;                                                                        
                }    
                
                if( !empty( $trademark ) ) {                    
                    $this->seoConfigManager->setListModelsTrademark( $trademark, $nameSection );
                    
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'listModelsTrademark', array( 'catSubcatTypology' => $catSubcatTypology, 'trademark' => $trademark ) );
                    $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', ucfirst( $trademark ) );
                    $aBreadcrumbs[$x]['link']    = false;
                    $x++;
                }
                
                 //Aggiungo il termine di ricerca libera
                if( !empty( $search ) && empty( $typology ) && empty( $subcategory ) ) {
                    $this->seoConfigManager->setCatSubcatTypologyProduct( 'search', false, false, false, $search );                        

                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => 'search-'.$search ) );
                    $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $search );
                    $aBreadcrumbs[$x]['link']    = false;
                    $x++;
                }        
                
                
                if( $route['_route'] != 'listModelsTrademark' )
                    $aBreadcrumbs[$x-1]['h1']      = false;
                
            break;
            case 'listProduct':
                $x = 0;                                
                echo 'listProduct breadcrumbs';
                exit;
//                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'allCategoriesProduct' );
//                $aBreadcrumbs[$x]['name']    = 'Tutte le categorie';
//                $aBreadcrumbs[$x]['link']    = true;
//                $x++;
//                
//                
//                //GESTISCE LA BREADCRUBS DELLA RICERCA LIBERA SU TUTTE LE CATEGORIE
//                $allCategoriesSearch = false;
//                if( !empty( $route['subcategory'] ) && strpos( $route['path'] , $this->wm->container->getParameter( 'app.freeSearchPath' ), '0' ) !== false && !empty( $route['typology'] ) ) {
//                    $aBreadcrumbs[$x]['url']     = '/'.$route['path'];
//                    $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $route['typology'] );
//                    $aBreadcrumbs[$x]['link']    = false;
//                    $allCategoriesSearch = true;
//                    
//                    
//                    $aBreadcrumbs[$x]['h1']      = false;
//                    
//                    $this->seoConfigManager->setListProduct( 'free_search', false, $route['subcategory'].' ', false, str_replace( '_', ' ', $route['typology']) );  
//                    
//                } else if( strpos( $route['path'] , $this->wm->container->getParameter( 'app.freeSearchPath' ), '0' ) !== false ) {
//                    $aBreadcrumbs[$x]['url']     = '/'.$route['path'];
//                    $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $route['subcategory'] );
//                    $aBreadcrumbs[$x]['link']    = false;
//                    
//                    $this->seoConfigManager->setListProduct( 'free_search', false, false, false, str_replace( '_', ' ', $route['subcategory'] ) );  
//                    
//                    $aBreadcrumbs[$x]['h1']      = false;
//                    
//                    $breadcrumb = json_decode (json_encode ($aBreadcrumbs), FALSE);        
//                    $this->getDataRichSnippetBreadcrumbs( $breadcrumb );
//
//                    return array(
//                        'breadcrumbs' => $breadcrumb
//                    );
//                }               
//                
//                //GESTISCE LA LIST PRODUCTS QUANDO SI è IN UNA SOTTOCATEGORIA DI SOLITO SOLO PER DELL'ABBIGLIAMENTO
//                if( empty( $allCategoriesSearch) && !empty( $route['subcategory'] ) && empty( $route['typology'] ) ) {                                                            
//                    $subcategory = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findOneByNameUrl( $route['subcategory'] );
//                    if( empty( $subcategory ) )
//                        return array();
//                    // else query su category
//                    
//                    $this->seoConfigManager->setListProduct( 'subcategory', false, $subcategory );       
//                    
//                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $subcategory->getCategory()->getNameUrl() ) );
//                    $aBreadcrumbs[$x]['name']    = $subcategory->getCategory()->getName();
//                    $aBreadcrumbs[$x]['link']    = true;
//                    $x++;
//                    
//                    $paramsLink = array();
//                    $paramsLink['subcategory']  = $subcategory->getNameUrl();
//                    if( !empty( $route['sex'] ) )
//                        $paramsLink['sex'] = $route['sex'];
//                    
//                    
//                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'listProduct', $paramsLink );
//                    $aBreadcrumbs[$x]['name']    = empty( $route['sex'] ) ? $subcategory->getName() : $subcategory->getName(). ' / ' .ucfirst( $route['sex'] );
//                    $aBreadcrumbs[$x]['link']    = empty( $route['search'] ) ? false: true ;
//                    $x++;
//                                                            
//                    if( !empty( $route['sex'] ) ) {
//                        $this->seoConfigManager->setListProduct( 'subcategory_sex', false, $subcategory, false, false, $route['sex'] );                                                       
//                    }       
//                    
//                     //Aggiungo il termine di ricerca NB: $route['typology'] Sarebbe la ricerca
//                    if( !empty( $route['search'] ) ) {                                
//                        $this->seoConfigManager->setListProduct( 'subcategory_search_user', $subcategory->getCategory(), $subcategory, false, $route['search'] );  
//
//                        $aBreadcrumbs[$x]['url']     = $this->wm->getRequestUri();
//                        $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $route['search'] );
//                        $aBreadcrumbs[$x]['link']    = false;
//                        $x++;                                
//                    }                    
//                }
//                
//                
//                //GESTISCE LA BREADCRUMBS PER TIPOLOGIA
//                if( empty( $allCategoriesSearch ) && !empty( $route['typology'] ) ) { 
//                    
//                    //PROVA A VEDERE SE EFFETTIVAMENTE LA TYPOLOGIA SIA REALE 
//                    $typology = $this->wm->doctrine->getRepository('AppBundle:Typology')->findOneByNameUrl( $route['typology'] );
//                    if( empty( $typology ) ) {
//                        
//                        //RICERCA SEARCH TERMS PER SOTTOCATEGORIA ES:/telefonia-cover_per_cellulari-samsung
//                        if( !empty( $route['typology'] ) &&  !empty( $route['subcategory'] ) &&  !empty( $route['search'] ) ) {
//                            $subcategory = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findOneByNameUrl( $route['typology'] );                                               
//                            $nameSection = 'subcategory_search_user';
//                            
//                            $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $subcategory->getCategory()->getNameUrl() ) );
//                            $aBreadcrumbs[$x]['name']    = $subcategory->getCategory()->getName();
//                            $aBreadcrumbs[$x]['link']    = true;
//                            $x++;
//                            
//                            //Aggiungo il termine di ricerca NB: $route['typology'] Sarebbe la ricerca
//                            if( !empty( $route['search'] ) ) {                                
//                                $this->seoConfigManager->setListProduct( $nameSection, $subcategory, false, false, $route['search'] );  
//                                
//                                $aBreadcrumbs[$x]['url']     = $this->wm->getRequestUri();
//                                $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $subcategory->getNameUrl().' '.$route['search'] );
//                                $aBreadcrumbs[$x]['link']    = false;
//                                $x++;                                
//                            }
//                            
//                            $breadcrumb = json_decode (json_encode ($aBreadcrumbs), FALSE);        
//                            $this->getDataRichSnippetBreadcrumbs( $breadcrumb );
//
//                            return array(
//                                'breadcrumbs' => $breadcrumb
//                            );
//                        }
//                        
//                        
//                        // TRICK PER CREARE LA BREADCRUMB PER LA RICERCA UTENTE A PARTIRE DALLA CATEGORIA 
//                        $category = $this->wm->doctrine->getRepository('AppBundle:Category')->findOneByNameUrl( $route['subcategory'] );                                               
//                        $nameSection = 'category_search_user';                        
//                        
//                        if( empty( $category ) ) {
//                            $category = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findOneByNameUrl( $route['typology'] );                                               
//                            $nameSection = 'subcategory_search_user';
//                            
//                        }
//                        
//                        //ES: telefonia-iphone_7
//                        if( !empty( $category ) ) {
//                            $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $category->getNameUrl() ) );
//                            $aBreadcrumbs[$x]['name']    = $category->getName();
//                            $aBreadcrumbs[$x]['link']    = true;
//                            $x++;
//                            
//                            //Aggiungo il termine di ricerca NB: $route['typology'] Sarebbe la ricerca
//                            if( !empty( $route['typology'] ) ) {                                
//                                $this->seoConfigManager->setListProduct( $nameSection, $category, false, false, $route['typology'] );  
//                                
//                                $aBreadcrumbs[$x]['url']     = $this->wm->getRequestUri();
//                                $aBreadcrumbs[$x]['name']    = str_replace( '_', ' ', $route['typology'] );
//                                $aBreadcrumbs[$x]['link']    = false;
//                                $x++;                                
//                            }
//                            
//                            $breadcrumb = json_decode (json_encode ($aBreadcrumbs), FALSE);        
//                            $this->getDataRichSnippetBreadcrumbs( $breadcrumb );
//
//                            return array(
//                                'breadcrumbs' => $breadcrumb
//                            );
//                            /**************************** FINE ******************************************/
//                            
//                        } else {
//                            return array();
//                        }
//                    }
//                    
//                    //RIPARTE LA GESTIONE STANDARD PER LA TYPOLOGIA
//                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 'catSubcatTypology' => $typology->getSubcategory()->getCategory()->getNameUrl() ) );
//                    $aBreadcrumbs[$x]['name']    = $typology->getSubcategory()->getCategory()->getName();
//                    $aBreadcrumbs[$x]['link']    = true;
//                    $x++;
//                    
//                    
//                    //GESTISCE L'ULTIMA PARTE DI BREADCRUMBS E SEO PER ABBIGLIAMENTO
//                    if( $typology->getSubcategory()->getCategory()->getId() == 8 ) {
//                        //se non c'è il sesso quindi non è la sezione abbigliamento aggiungo la subcategory
//                        if( empty( $route['sex'] ) ) {                                        
//                            $this->seoConfigManager->setListProduct( 'typology_moda', false, false, $typology );       
//                            
//                            $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $typology->getSubcategory()->getNameUrl()  ) );
//                            $aBreadcrumbs[$x]['name']    = $typology->getSubcategory()->getName();
//                            $aBreadcrumbs[$x]['link']    = true;
//                            $x++;                            
//                        }                                                
//                        
//                        
//                        if( !empty( $route['sex'] ) ) {
//                            $this->seoConfigManager->setListProduct( 'typology_moda_sex', false, false, $typology, false, $route['sex']  );       
//                            
//                            $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'listProduct', array( 'subcategory' => $typology->getSubcategory()->getNameUrl().'-'.$route['sex'] ) );
//                            $aBreadcrumbs[$x]['name']    = $typology->getSubcategory()->getName(). ' / ' .ucfirst( $route['sex'] );
//                            $aBreadcrumbs[$x]['link']    = true;
//                            $x++;                                                                                    
//                        }
//                    } else {
//                        $this->seoConfigManager->setListProduct( 'typology', false, false, $typology );                                                
//                    }
//
//                    $paramsLink = array();
//                    
//                    //DIFFERENZIA LA BREADBCRUMS DELLA TIPOLOGIA LIVELLO SOTTOCATEGORIA SE HA DEI MODELLI OPPURE NO
//                    if( !empty( $typology->getHasModels() ) ) {                        
//                        $sectionRoute = 'catSubcatTypologyProduct';
//                        $paramsLink['catSubcatTypology']     = $typology->getNameUrl();  
//                    } else {
//                        $paramsLink['subcategory']  = $typology->getSubcategory()->getNameUrl();
//                        $paramsLink['typology']     = $typology->getNameUrl();                    
//                        $sectionRoute = 'listProduct';
//                    }
//                    
//                    
//                    if( !empty( $route['sex'] ) )
//                        $paramsLink['sex'] = $route['sex'];
//                    
//                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( $sectionRoute, $paramsLink );
//                    $aBreadcrumbs[$x]['name']    = $typology->getName();
//                    $aBreadcrumbs[$x]['link']    = !empty( $route['search'] ) ? true : false;
//                    $x++;      
//            
//                    //AGGIUNGE LA RICERCA PER LA TYPOLOGY
//                    if( !empty( $route['search'] ) ) {
//                        $searchReplace = ucwords( str_replace( '_', ' ', $route['search'] ) );
//                        $sexName = !empty( $route['sex'] ) ? ' '.ucfirst( $route['sex'] ).' ' : ' ';                        
//                        $this->seoConfigManager->setListProduct( 'typology_search', false, false, $typology, $searchReplace, $sexName );
//                        
//                        $aBreadcrumbs[$x]['url']     = $this->wm->getRequestUri();
//                        $aBreadcrumbs[$x]['name']    = $searchReplace;
//                        $aBreadcrumbs[$x]['link']    = false;
//                        $x++;
//                    } 
//                }         
//                if( $x > 1  )
//                    $aBreadcrumbs[$x-1]['h1']      = false;
            break;
            case 'detailProduct':               
                
                //Prova a recuperare il risultato dalla queri eseguita nel detail product
                $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
                $model = $this->globalQueryUtility->getModelByNameUrl( trim( $route['name'] ) );          
                
                if( empty( $model ) )
                    return array();
                $x = 0;
                
//                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'allCategoriesProduct' );
//                $aBreadcrumbs[$x]['name']    = 'Tutte le categorie';
//                $aBreadcrumbs[$x]['link']    = true;
//                $x++;
                
                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                    'section1' => $model->getCategory()->getNameUrl(),
                 ) );
                $aBreadcrumbs[$x]['name']    = $model->getCategory()->getName();
                $aBreadcrumbs[$x]['link']    = true;
                
                if(  !empty( $model->getSubcategory() ) ) {
                    $x++;
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $model->getCategory()->getNameUrl(),
                        'section2' => $model->getSubcategory()->getNameUrl() ) 
                    );
                    $aBreadcrumbs[$x]['name']    = $model->getSubcategory()->getName();
                    $aBreadcrumbs[$x]['link']    = true;                    
                    $this->seoConfigManager->setDetailProduct( 'subcategory', $model, $model->getSubcategory(), false );
                }
                
                if(  !empty( $model->getTypology() ) ) {                    
                    $x++;
                    $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $model->getCategory()->getNameUrl(),
                        'section2' => $model->getSubcategory()->getNameUrl(),
                        'section3' => $model->getTypology()->getNameUrl() ) 
                    );
                    $aBreadcrumbs[$x]['name']    = $model->getTypology()->getName();
                    $aBreadcrumbs[$x]['link']    = true;
                    $this->seoConfigManager->setDetailProduct( 'typology', $model, false, $model->getTypology() );
                    
                }
                
                $x++;
                
                if( !empty( $model->getTypology() ) ) {
                    $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(),'section2' => $model->getSubcategory()->getNameUrl(), 'section3' => $model->getTypology()->getNameUrl() ) );
                } else {
                    $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl() ) );
                }            
                $aBreadcrumbs[$x]['url']     = $urlModel;
                $aBreadcrumbs[$x]['name']    = trim( str_replace( array(' - '), array(' ', ''), utf8_decode( $model->getName() ) ) );
                $aBreadcrumbs[$x]['link']    = false;        
                
                if( !empty( $this->wm->globalConfigManager->ampActive ) ) 
                    $aBreadcrumbs[$x]['h1']      = false;
                
                
            break;
            case 'listModelComparison':
                 //Prova a recuperare il risultato dalla queri eseguita nel detail product
                $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
                
                $this->seoConfigManager->setMetaListModelComparison();
                
                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'listModelComparison' );
                $aBreadcrumbs[$x]['name']    = 'Comparazione' ;
                $aBreadcrumbs[$x]['link']    = false;
            break;
            case 'modelComparison':
                //Prova a recuperare il risultato dalla queri eseguita nel detail product
                $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
                $comparison = $this->globalQueryUtility->getModelsComparison( $this->wm->getIdModels() );   
                if( empty( $comparison ) ) {
                    return array();
                }
                
                //Se è un array il recupero e diretto sulla tabella comparison senno e la ricerca utente    
                if( is_array( $comparison ) ) {
                    $aModels = array();
                    foreach( $comparison AS $model ) {
                        $aModels[] = $model;
                    }
                } else {                
                    $aModels[0] = $comparison->getModelOne();
                    $aModels[1] = $comparison->getModelTwo();
                }
                
                $model = $aModels[0];

                
                 //Prova a recuperare il risultato dalla queri eseguita nel detail product
                $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
                
                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'listModelComparison' );
                $aBreadcrumbs[$x]['name']    = 'Comparazione' ;
                $aBreadcrumbs[$x]['link']    = true;
                $x++;
                
                $this->seoConfigManager->setModelsComparison( $aModels, $comparison );
                $name = '';
                foreach( $aModels AS $model ) {
                    $name .= $model->getName(). ' vs ';
                }
                $name = trim( $name, 'vs ' );
                
                $aBreadcrumbs[$x]['url']     = $this->wm->routerManager->generate( 'modelComparison', array( 'idModels' => $this->wm->getIdModels() ) );
                $aBreadcrumbs[$x]['name']    = $name ;
                $aBreadcrumbs[$x]['link']    = false;
                
            break;
        }
        
        
        $breadcrumb = json_decode (json_encode ($aBreadcrumbs), FALSE);        
        $this->getDataRichSnippetBreadcrumbs( $breadcrumb );
        
        
        if( !empty( $this->wm->globalConfigManager->ampActive ) ) {
            if( count( $aBreadcrumbs ) > 2  ) {
                $temp = array();
                $temp[] = $aBreadcrumbs[count($aBreadcrumbs)-2];
                $temp[] = $aBreadcrumbs[count($aBreadcrumbs)-1];
                $aBreadcrumbs = $temp;
            }
        }
        $breadcrumb = json_decode (json_encode ($aBreadcrumbs), FALSE);      
                
        return array(
            'breadcrumbs' => $breadcrumb
        );
    }
    
    /**
     * Genera il rich snippet per lla breadcrumbsarticolo
     * @param type $article
     * @return string
     */
    public function getDataRichSnippetBreadcrumbs( $breadcrumbs ) {
//        if( $this->wm->globalConfigManager->getCurrentRoute() == 'detailNews') 
//            return false;
        
        $httpProtocol = $this->wm->container->getParameter( 'app.hostProtocol' );
        $wwwProtocol = $this->wm->container->getParameter( 'app.wwwProtocol' );
        
        $domain = $wwwProtocol.$this->wm->globalConfigManager->getCurrentDomain();
        $base = $httpProtocol.'://'.str_replace( 'app.', 'www.',$domain);
        
        $base = '';
        
                
        $code = '';
        if( empty( $breadcrumbs ) )
            return;
        
//        print_r($breadcrumbs);
        
        foreach( $breadcrumbs AS $key => $breadcrumb ) {
//            if( empty( $breadcrumb->link ) )
//                continue;
            if( empty( $breadcrumb->name ) )
                return;
            
            $breadcrumb->name = str_replace( 'allnews', 'Tutte le news', $breadcrumb->name );
            
            $code .= '{
                "@type": "ListItem",
                "position": '.($key+1).',
                "item": {
                  "@id": "'.$base.$breadcrumb->url.'",
                  "name": "'.ucfirst($breadcrumb->name).'"
                }
              },';
        }
                
        $json = '
        {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
                '.trim( $code, ',' ).'
               
            ]
        }';                
        $this->wm->container->get( 'twig' )->addGlobal( 'jsonDataRichSnippetBreadcrumbs', $json );
    }   
}