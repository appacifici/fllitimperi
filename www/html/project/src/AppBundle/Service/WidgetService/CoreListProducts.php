<?php

namespace AppBundle\Service\WidgetService;


class CoreListProducts {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );        
    }
    
     
    
    public function processData( $options = false ) {   
        $aCatSex = $this->wm->getCatSubcatTypology();        
        if( empty( $aCatSex['catSubcatTypology'] ) ) {
            $aCatSex = $this->wm->getParametersByCustomUrl();
        }        
        
        $search = !empty( $aCatSex['search'] ) ? $aCatSex['search'] : false;
        $this->wm->twig->addGlobal( 'search', str_replace( '_', ' ', $search ) );
        $catSubcatTypology = $aCatSex['catSubcatTypology'];                
        $order = !empty( $_GET['order'] ) ? $_GET['order'] : 'relevance';
        
//        //Avvia il recupero dei prodotti con elasticsearch
        if( !empty( $search ) ){
            $responseProducts = $this->getProductssBySearch( $catSubcatTypology, $search, false, $order  );
            if( !empty( $responseProducts ) ) {
                return $responseProducts;
            }
        }        
        
        $responseCat = $this->globalQueryUtility->getCatSubcatTypology( $catSubcatTypology );      
        $categoryId       = !empty( $responseCat->category ) ? $responseCat->category->getId() : false;
        $subcategoryId    = !empty( $responseCat->subcategory ) ?  $responseCat->subcategory->getId() : false;
        $typologyId       = !empty( $responseCat->typology ) ? $responseCat->typology->getId() : false;
        
        if( empty( $search ) && empty( $categoryId ) &&  empty( $subcategoryId ) && empty( $typologyId ) ) {                
            $this->wm->twig->addGlobal('error404Page', true );
            return array( 'errorPage' => 404 );
            exit;
        }
        
                                     
        $aPrice = array();
        if( !empty( $this->wm->getFilterMinPrice() ) )
            $aPrice['gte'] = $this->wm->getFilterMinPrice() ;

        if( !empty( $this->wm->getFilterMaxPrice() ) )
            $aPrice['lte'] = $this->wm->getFilterMaxPrice();
        
        
        //Avvio connessione diretta al DB senza doctrine
        $dbHost = $this->wm->container->getParameter('database_host');
        $dbName = $this->wm->container->getParameter('database_name');
        $dbUser = $this->wm->container->getParameter('database_user');
        $dbPswd = $this->wm->container->getParameter('database_password');        
        $this->mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);
        
        $aSearchTerms = false;
        $searchTerms = false;

        $where = '';
        if( !empty( $typologyId ) ) {
            $where .= " models.typology_id = $typologyId AND ( ";
        } else if( !empty( $subcategoryId ) ) {
            $where .= " models.subcategory_id = $subcategoryId AND ( ";            
        } else {
            $where .= "( ";
        }                
        
        
        $nameSearchTerms = $search;
        
        $search = preg_replace("#([^a-z0-9])#i", ' ', $search);   
        $initWords = array( ' i ',' lo ',' la ',' gli ', ' le ', ' di ', ' a ', ' da ', ' in ', ' con ', ' su ', ' per ', ' tra ', ' fra ' );        
        $stopWords = array( ' ',' ',' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' );        
        $search = trim( str_replace( $initWords, $stopWords, ' '.$search ) );    
        
        
        //Creazione query di sicurezza per ricerca, in caso di down di elasticsearch
        $where .= $this->createWhere( $search, 'models.name' );
        $where .= $this->createWhere( $search, 'models.bullet_points' );
        $where .= $this->createWhere( $search, 'models.long_description' );
        $where .= $this->createWhere( $search, 'models.technical_specifications' );
        $where .= $this->createWhere( $search, 'models.synonyms' );
        $where .= $this->createWhere( $search, 'models.alphaCheckModel' );
        $where .= $this->createWhere( $search, 'external_tecnical_template.tecnical_tp' );
        $where .= $this->createWhere( $search, 'external_tecnical_template.tecnical_ide' );
        $where = trim( $where ,' OR' );       
        
        $sql = "SELECT COUNT(1) AS tot
                FROM $dbName.models
                LEFT JOIN $dbName.categories on models.category_id = categories.id
                LEFT JOIN $dbName.subcategories on models.subcategory_id = subcategories.id
                LEFT JOIN $dbName.typologies on models.typology_id = typologies.id
                LEFT JOIN $dbName.external_tecnical_template on models.external_tecnical_id = external_tecnical_template.id
        WHERE $where ) ";
        
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $count = $sth->fetch( \PDO::FETCH_OBJ );
        $countProducts =  $count->tot;
        
        ### PRODOTTI PAGINATI ###       
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );     
        $pagination->init( $countProducts, $this->wm->container->getParameter( 'app.toLinksPagination' ), false, false, true );                             
        $paginationProd = $pagination->makeList(); 
        
        $sql = "SELECT models.*, categories.name_url as catNameUrl, subcategories.name_url as subcatNameUrl, typologies.name_url AS typologyNameUrl
                FROM $dbName.models
                LEFT JOIN $dbName.categories on models.category_id = categories.id
                LEFT JOIN $dbName.subcategories on models.subcategory_id = subcategories.id
                LEFT JOIN $dbName.typologies on models.typology_id = typologies.id
                LEFT JOIN $dbName.external_tecnical_template on models.external_tecnical_id = external_tecnical_template.id
        WHERE $where ) LIMIT ".$pagination->getLimit() ;
        
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $models = $sth->fetchAll( \PDO::FETCH_OBJ );   
        
        //Formatto risultati modelli per compatibilità dei risultati forniti con elasticsearch e doctrine
        foreach( $models AS &$model ) {
            $model->widthSmall = $model->width_small;
            $model->heightSmall = $model->height_small;
            $model->nameUrl = $model->name_url;
            $model->bulletPoints = trim( trim( str_replace( ";", ", ", $model->bullet_points ) ),',') ;
            
            if( !empty( $model->typologyNameUrl ) ) {
                $model->nameUrl = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->nameUrl, 'section1' => $model->catNameUrl, 'section2' => $model->subcatNameUrl, 'section3' => $model->typologyNameUrl ) );
            } else {
                $model->nameUrl = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->nameUrl, 'section1' => $model->catNameUrl, 'section2' => $model->subcatNameUrl ) );
            }            
            $model->price = $this->wm->setPrice( $model->price ) ;
        }
        
                
        //Recupero ricercjhe SEO
        if( !empty( $subcategoryId ) || !empty( $typologyId ) ) {
            $searchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getCurrentSearchTerms( $categoryId, $subcategoryId, $typologyId, 'catSubcatTypologyProduct', $nameSearchTerms );        
            if( !empty( $searchTerms ) && empty( $searchTerms['releatedId'] ) ) {
                $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( $categoryId, $subcategoryId, $typologyId, 'catSubcatTypologyProduct', false, $searchTerms['id'] );
                
                if( !empty( trim( $searchTerms['metaTitle'] ) ) )
                    $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', trim( $searchTerms['metaTitle']  ) ); 

                if( !empty( trim( $searchTerms['metaDescription'] ) ) )
                    $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', trim( $searchTerms['metaDescription']  ) );  
                
                
            } else {                
                return array( 'errorPage' => 404 );
                exit;
            }
        }
        
        $label = new \stdClass;
        $label->name = !empty( $searchTerms ) ? $searchTerms['title'] : str_replace( '_', ' ', $nameSearchTerms );
        $label->bg = false;
        $label->description = !empty( $searchTerms ) ? $searchTerms['description'] : str_replace( '_', ' ', $nameSearchTerms );
        
        $body = htmlspecialchars_decode($searchTerms['body'], ENT_QUOTES);        
        $label->body = !empty( $searchTerms ) ? html_entity_decode( $body ) : '';
        $label->img = $searchTerms['img'];
        
        //Se non trova nulla da tutti i tipi di ricerca mostra pagina 404 
        if( empty( $model ) ) {
            return array( 'errorPage' => 'notResultSearchFoundPage' );
        }
                
        
        return array( 
            'label'       => $label,
            'models'       => $models,
            'pagination' => $paginationProd,
            'countArticles' => $countProducts,
            'page' => $this->wm->getPage(),            
            'order' => $order,
            'aSearchTerms' => $aSearchTerms,
            'searchTerms' => $searchTerms,
            'printBullet' => true
        );
        
    }
    
    private function createWhere( $search, $field ) {
        $items = explode( ' ', $search );
        $where = '(';
        foreach ( $items AS $item ) {
            if( empty( $item ) )
                continue;
            if( strlen( $item ) > 2 )
                $item = ''.substr( $item, 0, -1 ).'';
            else
                $item = $item.' ';
            
            $where .= "$field like '%$item%' AND ";
        }
        $where = trim( $where ,' AND' ); 
        return $where.' ) OR ';
    }
    
     /**
     * Metodo che avvia un ricerca su elasticsearch
     * @param type $search
     * @return type
     * ES: ( curl -XGET 'http://localhost:9200/cmsadmin/_search' -d '{"query":{"query_string":{"query":"dopo aver recitato"}},"size":1} )
     * http://elastica.io/getting-started/search-documents.html#section-search
     */
    private function getProductssBySearch( $catSubcatTypology, $search, $isAjax = false,  $order = 'relevance', $condition = 'and' ) {  
        $countArticles = 0;     
        $filtersActive = array();
        
        if( empty( $search ) && !empty( $_GET['search'] ) )
            $search = $_GET['search'];        
                
                
        $responseCat = $this->globalQueryUtility->getCatSubcatTypology( $catSubcatTypology );      
        $categoryId       = !empty( $responseCat->category ) ? $responseCat->category->getId() : false;
        $subcategoryId    = !empty( $responseCat->subcategory ) ?  $responseCat->subcategory->getId() : false;
        $typologyId       = !empty( $responseCat->typology ) ? $responseCat->typology->getId() : false;
        
        
        if( empty( $categoryId ) &&  empty( $subcategoryId ) && empty( $typologyId ) && empty( $search ) ) {
            return array();
        }
                        
        $this->wm->container->get( 'twig' )->addGlobal( 'catSubcatTypologySearch', $catSubcatTypology );
        
        ### ARTICOLI IMPAGINATI ###
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );     
        
        $limit =  explode( ',', $pagination->getLimit() );  
        $search = preg_replace("#([^a-z0-9])#i", ' ', $search);         
        
        $nameSearchTerms = $search;
        
        $initWords = array( ' i ',' lo ',' la ',' gli ', ' le ', ' di ', ' a ', ' da ', ' in ', ' con ', ' su ', ' per ', ' tra ', ' fra ', ' e ' );        
        $stopWords = array( ' ',' ',' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' );        
        $search = trim( str_replace( $initWords, $stopWords, ' '.$search ) );    
        
        $boolQuery = new \Elastica\Query\BoolQuery();   
        
        
        
        $ssearch = explode( ' ', $search);
        $search = '';
        foreach( $ssearch AS $item ) {
            if( empty( $item ) )
                continue;
            if( strlen( $item ) > 2 )
                $search .= ''.substr( $item, 0, -1 ).'* ';
            
            else
                $search .= $item.' ';
            
//            $search .= $item.' ';
        }
        
        
        if( !empty( trim( $search ) ) ) {            
//            $fieldQuery = new \Elastica\Query\MultiMatch();
//            $fieldQuery->setOperator('and');
//            $fieldQuery->setFields('name');
//            $fieldQuery->setQuery($search);        
//            $boolQuery->addMust($fieldQuery);   
            $fieldQuery = new \Elastica\Query\QueryString();
            $fieldQuery->setDefaultOperator($condition);
            
//            $fieldQuery->setOperator('and');
            //se non è vuoto uno dei due id significa che siamo in una ricerca da url che attiviamo noi
            //quindi effettuerà la ricerca solo nei tag inseriti
            if( !empty( $subcategoryId ) || !empty( $typologyId ) ) {                
                $fieldQuery->setFields(array('searchTagTerms' ));                
            }
            
            $fieldQuery->setQuery( trim( str_replace( $initWords, $stopWords, ' '.$nameSearchTerms ) ) );        
//            $fieldQuery->setType('');        
            $boolQuery->addMust($fieldQuery);   
        }
        
        if( !empty( $categoryId ) ) {
            $categoryQuery = new \Elastica\Query\Terms();
            $categoryQuery->setTerms('category.id', array( $categoryId ) );
            $boolQuery->addFilter( $categoryQuery );        
        }
        
        if( !empty( $subcategoryId ) ) {                        
            $subcategoryQuery = new \Elastica\Query\Terms();
            $subcategoryQuery->setTerms('subcategory.id', array($subcategoryId));
            $boolQuery->addFilter($subcategoryQuery);
        }
        
        if( !empty( $typologyId ) ) { 
//            echo $typologyId;exit;
            $typologyQuery = new \Elastica\Query\Terms();
            $typologyQuery->setTerms('typology.id', array($typologyId));
            $boolQuery->addFilter($typologyQuery);                        
        }
   
        $aPrice = array();
        if( !empty( $this->wm->getFilterMinPrice() ) )
            $aPrice['gte'] = $this->wm->getFilterMinPrice() ;

        if( !empty( $this->wm->getFilterMaxPrice() ) )
            $aPrice['lte'] = $this->wm->getFilterMaxPrice();
        
        
        if(!empty( $aPrice['gte'] ) && !empty( $aPrice['lte'] ) && $aPrice['gte'] > $aPrice['lte']  ) {
           $lgt = $aPrice['gte'];
           $aPrice['gte'] = $aPrice['lte'];
           $aPrice['lte'] = $lgt;
        }        
        $filtersActive['prices'] = $aPrice;
                
        if( !empty( $aPrice ) )  {           
            $priceQuery = new \Elastica\Query\Range();
            $priceQuery->addField('price', $aPrice );
            $boolQuery->addFilter( $priceQuery );        
        }        
        
//        $trademarkQuery = new \Elastica\Query\Terms();
//        $trademarkQuery->setTerms('trademark.id', array(3));
//        $boolQuery->addFilter($trademarkQuery);
//              
        
//        if( !empty( $sex ) ) {
//            $sexQuery = new \Elastica\Query\Terms();
//            $sexQuery->setTerms('sex.id', $sex );
//            $boolQuery->addFilter($sexQuery);        
//        }
//        
//        $filtersActive['sex'] = $sex;        
//        e
//      
        
//        exit;
        $finder = $this->wm->container->get('fos_elastica.finder.cmsmodel');
        
        $finalQuery = new \Elastica\Query($boolQuery);
        
        $aWords = explode( ' ', trim($search ));        
//        if( count($aWords) < 3 ) {
            $finalQuery->setSort(array('price' => array('order' => 'desc')));
//        }

        if( $order != 'relevance' ) {
            switch ( $order ) {
                case 'date':
                        $finalQuery->setSort(array('dataImport' => array('order' => 'desc')));
                    break;
                case 'price_asc':
                        $finalQuery->setSort(array('price' => array('order' => 'asc')));
                    break;
                case 'price_desc':
                        $finalQuery->setSort(array('price' => array('order' => 'desc')));
                    break;
                default:
                        $finalQuery->setSort(array('subcategory.isTop' => array('order' => 'desc')));
                    break;
            }
        }
        
//        if( !empty( $subcategoryId ) || !empty( $typologyId ) ) {
            $finalQuery->setSort(array('dateRelease' => array('order' => 'desc')));
//        }
        
        $searchProducts = false;
        try {
            $userPaginator = $finder->createPaginatorAdapter($finalQuery);
            $userPaginator->getResults(0,1);
            $countProducts = $userPaginator->getTotalHits();
            
            if( !empty( $countProducts ) ) {
                $limit =  explode( ',', $pagination->getLimit() );  
                $finalQuery->setSize((int)$limit[1]);
                $finalQuery->setFrom((int)$limit[0]);
                $searchProducts = $finder->find($finalQuery);            
            } else {
                return false;
            }

        } catch (\Elastica\Exception\Connection\HttpException $e) {
            return false;
        }
        
                                
        if( !empty( $searchProducts ) ) {
            
            $products = $searchProducts;            
//            $countProducts =  count( $searchProducts );
            $pagination->init( $countProducts, $this->wm->container->getParameter( 'app.toLinksPagination' ), false, false, true );                        
            $paginationProd = $pagination->makeList();     
            
            $urlBasePrevNext = $this->wm->getRequestUri();

            
        }        

        if ( !empty( $search ) && $isAjax ) {
            $twigT = $this->wm->getVersionSite().'/widget_ProductListInfiniteScroll.html.twig';        
            return $this->wm->container->get('twig')->render( $twigT, 
                array( 'products'       => $products,
                    'ajax' => true, 
                        'page' => $this->wm->getPage() )
            );
        }
             
        $this->wm->globalConfigManager->setFiltersActive( $filtersActive );        
        $this->wm->container->get( 'app.coreFiltersProducts')->processData();
            
        
        //Se la ricerca non ha prodotto risultati
        if( empty( $products ) ) {
//            Da attivare una volta che sei sicuro che tutte le categorie abbiano prodotti
//            return array( 'errorPage' => 404 );            
            return array( 
                'products' => array(),
                'pagination' => '',
                'countArticles' => 0,
                'page' => $this->wm->getPage(),
                'filtersActive' => $filtersActive
            );
        }

        if( !empty( $_GET['test'] ) && !empty( $products ) ) {
            $searchTerm = $this->wm->doctrine->getRepository( 'AppBundle:SearchTerm' )->findOneById( $_GET['test'] );
            if( !empty( $searchTerm ) && !$searchTerm->getIsTested() ) {
                $searchTerm->setIsTested(1);
                $this->wm->doctrine->persist($searchTerm);
                $this->wm->doctrine->flush();
            }
        }
        
        $sexname = false;
        if( !empty( $sex ) )
            $sexname = $sex[0] == 1 ? 'donna' : 'uomo';        
        
        foreach( $products AS &$model ) {
            $model->setName( utf8_decode( ucwords( strtolower( $model->getName() ) ) ) );
            if( !empty( $model->getTypology() ) ) {
                $model->setNameUrl( $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(),'section2' => $model->getSubcategory()->getNameUrl(), 'section3' => $model->getTypology()->getNameUrl() ) ) );
            } else {
                $model->setNameUrl( $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl() ) ) );
            }                        
            $model->setBulletPoints( trim( trim( str_replace( ";", ", ", $model->getBulletPoints() ) ),',' ) );
            $model->setPrice( $this->wm->setPrice( $model->getPrice() ) );
        }
        
        $this->wm->twig->addGlobal( 'order', $order );
        
        $aSearchTerms = false;
        $searchTerms = false;
        
//        echo str_replace(' ','_',  $nameSearchTerms );
        
        //Recupera la ricerca corrente        
        if( !empty( $subcategoryId ) || !empty( $typologyId ) ) {
            $searchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getCurrentSearchTerms( $categoryId, $subcategoryId, $typologyId, 'catSubcatTypologyProduct', str_replace(' ','_',  $nameSearchTerms ) );        
            if( !empty( $searchTerms ) && empty( $searchTerms['releatedId'] ) ) {
                $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( $categoryId, $subcategoryId, $typologyId, 'catSubcatTypologyProduct', false, $searchTerms['id'] );
            } 
            
            if( empty( $searchTerms ) ) {                
                return array( 'errorPage' => 'notResultSearchFoundPage' );              
            }
            if( !empty( trim( $searchTerms['metaTitle'] ) ) )
                $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', trim( $searchTerms['metaTitle']  ) ); 

            if( !empty( trim( $searchTerms['metaDescription'] ) ) )
                $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', trim( $searchTerms['metaDescription']  ) );    
        }
        
        
        $label = new \stdClass;
        $label->name = !empty( $searchTerms ) ? $searchTerms['title'] : $nameSearchTerms;
        $label->bg = false;        
        $label->description = !empty( $searchTerms ) ? $searchTerms['description'] : $nameSearchTerms;
        
        $body = htmlspecialchars_decode($searchTerms['body'], ENT_QUOTES);        
        
        $dictionaryUtility  = $this->wm->container->get( 'app.dictionaryUtility' );
        $body = $dictionaryUtility->replaceText(  $body, $subcategoryId, $typologyId );
        
        $label->body = !empty( $searchTerms ) ? html_entity_decode( $body ) : '';
        $label->img = $searchTerms['img'];
        
        
        
        
        return array( 
            'label'       => $label,
            'models'       => $products,
            'pagination' => $paginationProd,
            'countArticles' => $countProducts,
            'page' => $this->wm->getPage(),            
            'filtersActive' => $filtersActive,
            'order' => $order,
            'aSearchTerms' => $aSearchTerms,
            'searchTerms' => $searchTerms,
            'printBullet' => true
        );
        
    }    
}
