<?php

namespace AppBundle\Service\SitemapService\FullSitemap;

/**
 * Classe per la gestione delle sitemap
 */
class RunSitemap  {
	private $table;	
	private $verbose_mode = true;
	private $enabledPing = true;
	private $limit = array();
	private $query = array();
	private $nameSitemaps = array();
	private $itemsSitemap = array();
	private $sitemap_index_file_name;	
	private $local_folder;
	private $site;
	private $ping;
	private $filename;
	private $startFromId; 
	public  $sitemap;
	private $rowsSitemap;
	private $lastId;
	
	/**
	 * Metodo costruttore che instanzia anche la classe padre
	 */
	public function __construct( $globalUtility, $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $routerManager, $regenerate = false, $enabledPing = false ) {
        
        $this->dbHost      = $dbHost;
        $this->dbPort      = $dbPort;
        $this->dbName      = $dbName;
        $this->dbUser      = $dbUser;
        $this->dbPswd      = $dbPswd;
        $this->regenerate  = $regenerate;       
        $this->enabledPing = $enabledPing;
        $this->globalUtility = $globalUtility;
        $this->routerManager = $routerManager;
        
        $this->config = new \stdClass;
        $this->config->pathSiteServer = $_SERVER['PWD'];
        
        $this->local_folder = "/sitemaps/";        
        $this->localFolderRead = "/sitemaps/";        
        $this->path = $this->config->pathSiteServer.$this->local_folder.'sitemap_1.xml';
        
        $this->config->basePath = 'https://www.acquistigiusti.it';
        
        $this->mySql = new \PDO('mysql:host='.$dbHost.';port='.$dbPort.';', $dbUser, $dbPswd);
        
		$this->setConfig();
		
		if( !empty( $this->regenerate ) ) {
            echo 'eccomi';
			$this->rigenera();
        }
        
        
        
	}
	
	/**
	 * Metodo che setta le configurazioni per creare le sitemap
	 */
	private function setConfig() {							
//		$this->query['news']			= "SELECT content_articles.*, images.*, data_articles.last_modify, data_articles.publish_at FROM ".$this->dbName.".data_articles
//                JOIN ".$this->dbName.".content_articles ON content_articles.data_article_id = data_articles.id 
//                JOIN ".$this->dbName.".images on images.id = data_articles.priorityImg_id  WHERE data_articles.id > :myId";
//        
		$this->query['category']   = "SELECT id, categories.name_url as keyUrlCategory FROM ".$this->dbName.".categories WHERE categories.is_active =1 and categories.id > :myId";
        
		$this->query['subcategory']= "SELECT subcategories.id, subcategories.name_url as keyUrlSubcategory,  categories.name_url as keyUrlCategory,
            subcategories.has_models
            FROM ".$this->dbName.".subcategories 
            LEFT JOIN ".$this->dbName.".categories on categories.id = subcategories.category_id
            WHERE subcategories.is_active =1  and categories.is_active =1 and subcategories.has_models> 0 
            and subcategories.id > :myId order by subcategories.id ASC";
        
        $this->query['typology']   = "SELECT typologies.id, typologies.name_url as keyUrlTypology, 
            typologies.has_products, typologies.has_models, subcategories.name_url as keyUrlSubcategory, categories.name_url as keyUrlCategory
            FROM ".$this->dbName.".typologies 
                LEFT JOIN ".$this->dbName.".categories on categories.id = typologies.category_id
                LEFT JOIN ".$this->dbName.".subcategories on subcategories.id = typologies.subcategory_id
            WHERE 
            typologies.is_active = 1 and
            categories.is_active = 1 and
            subcategories.is_active = 1 and
            typologies.has_models > 0 and 
            typologies.id > :myId order by typologies.id ASC";
        
        $this->query['modelSubcategory']   = "SELECT models.id, models.name_url, categories.name_url as keyUrlCategory,
            subcategories.name_url as subcategoryNameUrl, subcategories.singular_name_url as subcategorySingularNameUrl, models.images_gallry, models.last_modify,
            models.date_import
            FROM ".$this->dbName.".models
            LEFT JOIN ".$this->dbName.".categories on categories.id = models.category_id
            LEFT JOIN ".$this->dbName.".subcategories on subcategories.id = models.subcategory_id
            WHERE models.typology_id is null and categories.is_active = 1 and
            subcategories.is_active = 1 and models.is_active = 1 and models.is_completed = 1 and models.has_products > 0 and models.id > :myId
                order by models.last_modify DESC
            ";
        
        $this->query['modelTypology']   = "SELECT models.id, models.name_url, categories.name_url as keyUrlCategory,
            subcategories.name_url as subcategoryNameUrl, subcategories.singular_name_url as subcategorySingularNameUrl, 
            typologies.name_url as typologyNameUrl, typologies.singular_name_url as typologySingularNameUrl, models.images_gallry, models.last_modify,
            models.date_import
            FROM ".$this->dbName.".models
            LEFT JOIN ".$this->dbName.".categories on categories.id = models.category_id
            LEFT JOIN ".$this->dbName.".subcategories on subcategories.id = models.subcategory_id
            LEFT JOIN ".$this->dbName.".typologies on typologies.id = models.typology_id
            WHERE typologies.is_active = 1 and
            categories.is_active = 1 and
            subcategories.is_active = 1 and models.is_active = 1 and models.is_completed = 1 and models.has_products > 0 and models.id > :myId
            order by models.last_modify DESC";    
        
        $this->query['models']   = "SELECT models.id, models.name_url, categories.name_url as keyUrlCategory, models.date_import,
            subcategories.name_url as subcategoryNameUrl, subcategories.singular_name_url as subcategorySingularNameUrl, 
            typologies.name_url as typologyNameUrl, typologies.singular_name_url as typologySingularNameUrl, models.images_gallry, models.last_modify
            FROM ".$this->dbName.".models
            LEFT JOIN ".$this->dbName.".categories on categories.id = models.category_id
            LEFT JOIN ".$this->dbName.".subcategories on subcategories.id = models.subcategory_id
            LEFT JOIN ".$this->dbName.".typologies on typologies.id = models.typology_id
            WHERE categories.is_active = 1 and
            subcategories.is_active = 1 and models.is_active = 1 and models.is_completed = 1 and models.has_products > 0 and models.id > :myId
            order by models.last_modify DESC";    
        
        $this->query['guide']           = "SELECT * from ".$this->dbName.".data_articles
                JOIN ".$this->dbName.".content_articles on content_articles.data_article_id = data_articles.id  "
                . "LEFT JOIN ".$this->dbName.".images on priorityImg_id = images.id "
                . "WHERE status = 1 order by data_articles.id desc";
        
        $this->query['comparazione']           = "SELECT * from ".$this->dbName.".comparisons
                 WHERE is_active = 1 order by create_date desc";
              
		$this->limit['news']                     = 50000;
		$this->limit['category']                 = 50000;
		$this->limit['subcategory']              = 50000;
		$this->limit['typology']                 = 50000;
		$this->limit['modelSubcategory']         = 50000;
		$this->limit['modelTypology']            = 50000;		
		$this->limit['models']                   = 50000;		
		$this->limit['guide']                    = 50000;		
		$this->limit['comparazione']             = 50000;		
              
		$this->nameSitemaps['news']                     = 'news%i.xml';
		$this->nameSitemaps['category']                 = 'categorie%i.xml';
		$this->nameSitemaps['subcategory']              = 'sottocategorie%i.xml';
		$this->nameSitemaps['typology']                 = 'tipologie%i.xml';
		$this->nameSitemaps['modelSubcategory']         = 'modelli_sottocategorie%i.xml';
		$this->nameSitemaps['modelTypology']            = 'modelli_tipologie%i.xml';		
		$this->nameSitemaps['models']                   = 'modelli%i.xml';		
		$this->nameSitemaps['guide']                    = 'guide%i.xml';		
		$this->nameSitemaps['comparazione']             = 'comparazione%i.xml';		
				
		$this->sitemap_index_file_name           = "sitemap.xml";
		$this->sitemap_file_name                 = "sitemap%i.xml";
		
		$this->ping['google'] = "www.google.com/webmasters/tools/ping?sitemap=[sitemap_location]";
		$this->ping['msn'] = "http://api.moreover.com/ping?u=[sitemap_location]";
		$this->ping['yahoo'] = "http://search.yahooapis.com/SiteExplorerService/V1/ping?sitemap=[sitemap_location]";
		$this->ping['bing'] = "http://www.bing.com/webmaster/ping.aspx?siteMap=[sitemap_location]";
		$this->ping['windows_live'] = "http://webmaster.live.com/ping.aspx?siteMap=[sitemap_location]";
		$this->ping['ask'] = "http://submissions.ask.com/ping?sitemap=[sitemap_location]";
	}

	/**
	 * Metodo che inizializza la creazione della sitemap
	 * @param type $table
	 */
	public function init( $table ) {
		$this->sitemap = null;
		$this->itemsSitemap = null;
		$this->rowsSitemap = null;
		$this->table = $table;
		
		$this->getStartId();
		$this->sitemap = $this->getCurrentSitemap();		        
        
		$this->debug( "current sitemap: ".$this->sitemap['file'] );
		$this->debug( "records: ".$this->sitemap['records'] );
		$this->debug( "start from id: ".$this->startFromId );

		$urls = array();
		$stn = $this->mySql->prepare( $this->query[$this->table] );        
		$stn->bindValue( ':myId', $this->startFromId );
        
        echo $this->query[$this->table] .' '.$this->startFromId;
        
		$e = $stn->execute();
		if( !$e )
		   die( "Impossibile recuperare i nuovi articoli da mysql\n" );
				
		$this->rowsSitemap = $stn->fetchAll( \PDO::FETCH_OBJ );	
        if( empty( $this->rowsSitemap ) ) {
            return false;
        }
		$this->writeSitemap();
	}
	
     /**
	 * Versione 1 Metodo riscrittura url
	 */
	public function rewriteUrl_v1( $string, $options = false ) {
		$sep = !empty( $options->sep ) ? $options->sep : '_';
		$string = trim( $string );
		$string = strip_tags( $string );
		$string = str_replace( array( 'à','á','é','è','í','ì','ó','ò','ú','ù', 'ä', 'ö', 'ü', 'ë' ),array( 'a','a','e','e','i','i','o','o','u','u','a','o','u', 'e' ), $string ); 
		$string = str_replace( array( 'À','Á','É','È','Í','Ì','Ó','Ò','Ú','Ù','Ä','Ü','Ö','ß' ),array( 'A','A','E','E','I','I','O','O','U','U','A','U','O','B' ), $string );
		$string = preg_replace( '/[^\w\s]+/', $sep, $string);
		$string = str_replace( '/', $sep, $string );
		$string = preg_replace( '/-+/', $sep, $string );
		$string = preg_replace( '/-$/', $sep, $string );
		$string = str_replace( '-', $sep, $string );
		$string = str_replace( ' ', $sep, $string );
		$string = preg_replace( '/['.$sep.']+/', $sep,$string );
		$string = trim( $string, $sep );
		$string = strtolower( $string );	
		return $string; 
	}
    
	/**
	 * Metodo che crea i nodi della sitemap
	 */
	private function writeSitemap() {
		$x = 0;		
        
		foreach( $this->rowsSitemap AS $row ) {
			$iRow = $this->rowsSitemap = json_decode( json_encode($row ), true);
            
			switch( $this->table ) {                
				case 'news':						                    
					$currentId = $iRow['idProduct'] = $row->data_article_id;
					$this->itemsSitemap[$x]['url'] = $this->config->basePath."news/$row->data_article_id/".$row->permalink ;
					$this->itemsSitemap[$x]['changefreq'] = 'yearly';
					$this->itemsSitemap[$x]['lastmod'] = $this->replaceForSitemap( $row->last_modify );
					$this->itemsSitemap[$x]['img'] = $this->config->basePath."imagesArticleMedium/$row->src";
					$this->itemsSitemap[$x]['imgTitle'] = $this->replaceForSitemap( ucfirst( strtolower( html_entity_decode( $row->titleImg ) ) ) ) ;					
                    
                    $news = array();
					$news['name'] = '.it';
					$news['language'] = 'it';
                    $news['publication_date'] = $this->replaceForSitemap( $row->publish_at );
                    $news['title'] = $this->replaceForSitemap( ucfirst( strtolower( html_entity_decode($row->title ) ) ) ); 
                    
                    $this->itemsSitemap[$x]['news'] = $news;
				break;
				case 'category':	
                    if( $x == 0 ) {
                        $this->itemsSitemap[$x]['lastmod'] = date('Y-m-d');
                        $this->itemsSitemap[$x]['url'] = $this->config->basePath.$this->routerManager->generate( 'homepage', array(),false );
                        $this->itemsSitemap[$x]['changefreq'] = 'daily';					
                        $this->itemsSitemap[$x]['priority'] = '1';
                        $x++;
                    }
                    
                    //indice guida 
                    if( $x == 1 ) {
                        $sql = "select last_modify from  ".$this->dbName.".data_articles order by last_modify desc limit 1";
                        $stn = $this->mySql->prepare( $sql );        
                        $e = $stn->execute();
                        if( !$e )
                           die( "Impossibile recuperare i nuovi articoli da mysql\n" );
                        $lastMod = $stn->fetch( \PDO::FETCH_OBJ );	

                        $this->itemsSitemap[$x]['lastmod'] = $lastMod->last_modify;
                        $this->itemsSitemap[$x]['url'] = $this->config->basePath.$this->routerManager->generate( 'listArticles1', array(),false );
                        $this->itemsSitemap[$x]['changefreq'] = 'monthly';					
                        $this->itemsSitemap[$x]['priority'] = '0.9';
                        $x++;
                    }
                    
//                     //indice guida 
                    if( $x == 2 ) {
                        $sql = "SELECT create_date from ".$this->dbName.".comparisons WHERE is_active = 1 order by create_date desc limit 1";
                        $stn = $this->mySql->prepare( $sql );        
                        $e = $stn->execute();
                        if( !$e )
                           die( "Impossibile recuperare i nuovi articoli da mysql\n" );
                        $lastMod = $stn->fetch( \PDO::FETCH_OBJ );	

                        $this->itemsSitemap[$x]['lastmod'] = $lastMod->create_date;
                        $this->itemsSitemap[$x]['url'] = $this->config->basePath.$this->routerManager->generate( 'listModelComparison', array(),false );
                        $this->itemsSitemap[$x]['changefreq'] = 'monthly';					
                        $this->itemsSitemap[$x]['priority'] = '0.9';
                        $x++;
                    }
//                    
                    
                    $sql = "select models.last_modify from  ".$this->dbName.".models where category_id = $row->id order by last_read_price desc limit 1";
                    $stn = $this->mySql->prepare( $sql );        
                    $e = $stn->execute();
                    if( !$e )
                       die( "Impossibile recuperare i nuovi articoli da mysql\n" );
                    $lastMod = $stn->fetch( \PDO::FETCH_OBJ );	
                    
                    $this->itemsSitemap[$x]['lastmod'] = $lastMod->last_modify;
					$currentId = $iRow['idCategory'] = $row->id;
					$this->itemsSitemap[$x]['url'] = $this->config->basePath.$this->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $iRow['keyUrlCategory'] ), false );
					$this->itemsSitemap[$x]['changefreq'] = 'weekly';					
					$this->itemsSitemap[$x]['priority'] = '0.9';
                    
				break;
				case 'subcategory':							
                    $sql = "select last_modify from  ".$this->dbName.".models where subcategory_id = $row->id order by last_read_price desc limit 1";
                    $stn = $this->mySql->prepare( $sql );        
                    $e = $stn->execute();
                    if( !$e )
                       die( "Impossibile recuperare i nuovi articoli da mysql\n" );
                    $lastMod = $stn->fetch( \PDO::FETCH_OBJ );	
                    
                    $this->itemsSitemap[$x]['lastmod'] = $lastMod->last_modify;
                    
					$currentId = $iRow['idSubcategory'] = $row->id;
                    
					$this->itemsSitemap[$x]['url'] = $this->config->basePath.$this->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $iRow['keyUrlCategory'], 'section2' => $iRow['keyUrlSubcategory'] ), false );
					$this->itemsSitemap[$x]['changefreq'] = 'weekly';
                    $this->itemsSitemap[$x]['priority'] = '0.8';
                    
//                    if ( $row->has_models  > 0 ) {                                                    
//                        $x++;                    
//                        $urlTypologyItem = $this->config->basePath.$this->routerManager->generate( 'allListProductsSection', array( 'catSubcatTypology' => $iRow['keyUrlSubcategory'] ), false );
//                        $this->itemsSitemap[$x]['url'] = $urlTypologyItem;
//                        $this->itemsSitemap[$x]['changefreq'] = 'daily';
//                    }
				break;				
				case 'typology':							
                    $sql = "select last_modify from  ".$this->dbName.".models where typology_id = $row->id order by last_read_price desc limit 1";
                    $stn = $this->mySql->prepare( $sql );        
                    $e = $stn->execute();
                    if( !$e )
                       die( "Impossibile recuperare i nuovi articoli da mysql\n" );
                    $lastMod = $stn->fetch( \PDO::FETCH_OBJ );	
                    
                    $this->itemsSitemap[$x]['lastmod'] = $lastMod->last_modify;
                    
					$currentId = $iRow['idTypology'] = $row->id;
                    
                    $urlTypologyItem = $this->config->basePath.$this->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $iRow['keyUrlCategory'], 'section2' => $iRow['keyUrlSubcategory'], 'section3' => $iRow['keyUrlTypology'] ), false );
                    
                    
					$this->itemsSitemap[$x]['url'] = $urlTypologyItem;
					$this->itemsSitemap[$x]['changefreq'] = 'weekly';
                    $this->itemsSitemap[$x]['priority'] = '0.8';
                    
//                    if ( $row->has_models  > 0 ) {                                                    
//                        $x++;                    
//                        $urlTypologyItem = $this->config->basePath.$this->routerManager->generate( 'allListProductsSection', array( 'catSubcatTypology' => $iRow['keyUrlTypology'] ), false );
//                        $this->itemsSitemap[$x]['url'] = $urlTypologyItem;
//                        $this->itemsSitemap[$x]['changefreq'] = 'daily';
//                    }                    
				break;				
				case 'modelSubcategory':							
					$currentId = $iRow['idModel'] = $row->id;                                        
                    $urlModel = $this->routerManager->generate( 'detailProduct', array( 'name' => utf8_encode( $row->name_url ), 'section1' => $row->keyUrlCategory, 'section2' => $row->subcategoryNameUrl ), false );
                    
					$this->itemsSitemap[$x]['url'] = $this->config->basePath.$urlModel;
					$this->itemsSitemap[$x]['changefreq'] = 'monthly';
                    $this->itemsSitemap[$x]['priority'] = '0.7';
                    $this->itemsSitemap[$x]['lastmod'] = $row->last_modify;
                    
                    $gallery = json_decode($row->images_gallry);
                    if( !empty( $gallery ) ) {
                        foreach( $gallery AS $img ) {
                            $img->initPath = '/galleryImagesModel/';
                            $this->itemsSitemap[$x]['gallery'][] = $img;
                        }
                    }
                    
				break;				
				case 'modelTypology':							
					$currentId = $iRow['idModel'] = $row->id;                                        
                    $urlModel = $this->routerManager->generate( 'detailProduct', array( 'name' => utf8_encode( $row->name_url ), 'section1' => $row->keyUrlCategory, 'section2' => $row->subcategoryNameUrl, 'section3' => $row->typologyNameUrl ), false );                    
                    
					$this->itemsSitemap[$x]['url'] = $this->config->basePath.$urlModel;
					$this->itemsSitemap[$x]['changefreq'] = 'monthly';
                    $this->itemsSitemap[$x]['priority'] = '0.7';
                    $this->itemsSitemap[$x]['lastmod'] = $row->last_modify;
                    
                    $gallery = json_decode($row->images_gallry);
                    if( !empty( $gallery ) ) {
                        foreach( $gallery AS $img ) {
                            $img->initPath = '/galleryImagesModel/';
                            $this->itemsSitemap[$x]['gallery'][] = $this->config->basePath.$img->initPath.$img;
                        }
                    }
				break;		
                case 'models':							
					$currentId = $iRow['idModel'] = $row->id;                                        
                    if( !empty( $row->typologyNameUrl ) )
                        $urlModel = $this->routerManager->generate( 'detailProduct', array( 'name' => utf8_encode( $row->name_url ), 'section1' => $row->keyUrlCategory, 'section2' => $row->subcategoryNameUrl, 'section3' => $row->typologyNameUrl ), false );                    
                    else    
                        $urlModel = $this->routerManager->generate( 'detailProduct', array( 'name' => utf8_encode( $row->name_url ), 'section1' => $row->keyUrlCategory, 'section2' => $row->subcategoryNameUrl ), false );                    
                    
					$this->itemsSitemap[$x]['url'] = $this->config->basePath.$urlModel;
					$this->itemsSitemap[$x]['changefreq'] = 'monthly';
                    $this->itemsSitemap[$x]['priority'] = '0.7';
                    $this->itemsSitemap[$x]['lastmod'] = $row->last_modify;
                    
                    $gallery = json_decode($row->images_gallry);
                    if( !empty( $gallery ) ) {
                        foreach( $gallery AS $img ) {                            
                            $img->initPath = '/galleryImagesModel/';
                            $img->src = $this->config->basePath.$img->initPath.$img->src;
                            $this->itemsSitemap[$x]['gallery'][] = $img;
                        }
                    }
				break;		
                case 'comparazione':							
                    $currentId = $iRow['comparisonId'] = $row->id;       
					$this->itemsSitemap[$x]['url'] = $this->config->basePath.$this->routerManager->generate( 'modelComparison', array( 'idModels' => $row->name_url ), false );
					$this->itemsSitemap[$x]['changefreq'] = 'monthly';
                    $this->itemsSitemap[$x]['priority'] = '0.7';
                    $this->itemsSitemap[$x]['lastmod'] = $row->create_date;
                    
                   
				break;		
				case 'guide':							
					$currentId = $iRow['dataArticleId'] = $row->id;                                                            
                    if( empty( $row->article_id ) ) {
                        $urlModel = $this->routerManager->generate( 'detailNews'.$row->megazine_section_id, array( 'title' => $row->permalink ), false);  
                    } else {
                        $sql = "SELECT permalink, images.* from ".$this->dbName.".data_articles
                                JOIN ".$this->dbName.".content_articles on content_articles.data_article_id = data_articles.id 
                                LEFT JOIN ".$this->dbName.".images on priorityImg_id = images.id
                               WHERE data_articles.id = $row->article_id";
                        
                        $stn = $this->mySql->prepare( $sql );        
                        $e = $stn->execute();
                        if( !$e )
                           die( "Impossibile recuperare i ARTICOLO ASSOCIATO\n" );
                                                

                        $this->rowReleatedArticle = $stn->fetch( \PDO::FETCH_OBJ );	
                        
                        $baseArticle =  $this->rowReleatedArticle->permalink;                        
                        
                        $urlModel = $this->routerManager->generate( 'detailNews2', array( 'baseArticle' => $baseArticle, 'title' => $row->permalink ), false);  
                    }
                    
                    
                    
					$this->itemsSitemap[$x]['url'] = $this->config->basePath.$urlModel;
					$this->itemsSitemap[$x]['changefreq'] = 'monthly';
                    $this->itemsSitemap[$x]['priority'] = '0.7';
                    $this->itemsSitemap[$x]['lastmod'] = $row->last_modify;
                    
                    $this->itemsSitemap[$x]['gallery'] = $this->extractImages( $row->body, '/imagesArticleBig/' );      
                    
                    if( $row->id <= 40 ) {                        
                        $extractedImages = new \stdClass;
                        $extractedImages->src = 'https://www.acquistigiusti.it/imagesArticleBig/'.$row->src;
                        $extractedImages->alt = $this->sanitizeXML($row->title_img);
                        $extractedImages->title =  $this->sanitizeXML($row->title_img);
                        $extractedImages->initPath = '/imagesArticleBig/';
                        $this->itemsSitemap[$x]['gallery'][] = $extractedImages;
                    }
                    
				break;	                
		   }
           
//		   print_r( $this->itemsSitemap );
		   $this->sitemap['records']++;		   
		   if( $this->sitemap['records'] >= $this->limit[$this->table] ) {
			  $this->write();
			  $this->itemsSitemap = array();
			  $x = 0;
			  $this->debug( "Chiudo sitemap ".$this->sitemap['file'] );
			  
			  $this->lastId = $currentId;
			  $this->closeSitemap();              
			  $this->createNewSitemap();
			  $this->sitemap = $this->getCurrentSitemap();
		   }
		   $x++;
		}
		$this->write();
		$this->rewriteIndex();
		$this->ping();
        if( !empty( $row ) ) {
            $this->lastId = $currentId;
            $this->closeSitemap();
        }
	}
	
    private function replaceForSitemap($string, $utf8 = true) {        
		$r1 = array('&', '<', '>', 'è');
		$r2 = array('','','','e');
        
          
        
		$string = str_replace($r1, $r2, $string);        
        $string = preg_replace("/[^A-Za-z0-9\"\'\-\:\?\!\.\°\, ]/", '', $string);        
//		if (!$utf8)
        $string = utf8_encode($string);        
//        iconv(mb_detect_encoding($string, mb_detect_order(), true), "UTF-8", $text);        
		return html_entity_decode(trim($this->stripInvalidXml($string)));
	}
    
    
	function stripInvalidXml($value) {
		$ret = "";
		$current;
		if (empty($value)) {
			return $ret;
		}

		$length = strlen($value);
		for ($i = 0; $i < $length; $i++) {
			$current = ord($value{$i});
			if (($current == 0x9) ||
					($current == 0xA) ||
					($current == 0xD) ||
					(($current >= 0x20) && ($current <= 0xD7FF)) ||
					(($current >= 0xE000) && ($current <= 0xFFFD)) ||
					(($current >= 0x10000) && ($current <= 0x10FFFF))) {
				$ret .= chr($current);
			} else {
				$ret .= " ";
			}
		}
		return $ret;
	}

    
	private function isValidField( $row, $fields ) { 
		foreach( $fields AS $field ) {
			if ( is_array( $row ) ) {
				$encode = mb_detect_encoding( $row[$field] );			
				if( $encode != 'ASCII' ) {
					$row[$field] = utf8_decode( $row[$field] );
					$row[$field] = str_replace( array('?','Ã'), '', $row[$field] );
				}
			}
		}
		return $row;
	}

    private function extractImages( $htmlString, $initPath = false ) {
        $htmlDom = new \DOMDocument;
 
        //Load the HTML string into our DOMDocument object.
        @$htmlDom->loadHTML($htmlString);

        //Extract all img elements / tags from the HTML.
        $imageTags = $htmlDom->getElementsByTagName('img');

        //Create an array to add extracted images to.
        $extractedImages = array();

        //Loop through the image tags that DOMDocument found.
        foreach($imageTags as $imageTag){

            //Get the src attribute of the image.
            $imgSrc = $imageTag->getAttribute('src');
            

            //Get the alt text of the image.
            $altText = $this->sanitizeXML( $imageTag->getAttribute('alt') );

            //Get the title text of the image, if it exists.
            $titleText = $this->sanitizeXML( $imageTag->getAttribute('title') );

            //Add the image details to our $extractedImages array.
            $extractedImages[] = array(
                'src' => $imgSrc,
                'alt' => $altText,
                'title' => $altText,
                'initPath' => $initPath,
            );
        }
                
        
        $extractedImages = json_decode(json_encode($extractedImages), FALSE);

        return $extractedImages;
    }
    
    
    
	// =========================================================================================================================== //

	/**
	 * Metodo che crea i nodi xml della sitemap
	 */
	private function write() {        
		$this->path = $this->config->pathSiteServer.$this->local_folder.$this->sitemap['file'];        
        if( !file_exists( $this->path ) ) {
            $this->generateFile();
        }
        
        
		$dom = new \DOMDocument('1.0', 'utf-8');        
		$dom->load( $this->path );
		$urlset = $dom->getElementsByTagName('urlset')->item(0);
		
		if ( empty( $this->itemsSitemap ) )
			return true;
		
		foreach( $this->itemsSitemap as $item ){
			$node = $dom->createElement( 'url' );
			$urlset->appendChild( $node );

			$loc = $node->appendChild( $dom->createElement( 'loc' ) );
			$loc->appendChild( $dom->createTextNode( $item['url'] ) );

			if( !empty( $item['lastmod'] ) ) {
				$lastmod = $node->appendChild( $dom->createElement( 'lastmod' ) );
                $newDateLastMod = date( 'Y-m-d', strtotime( $item['lastmod'] ) );  
				$lastmod->appendChild( $dom->createTextNode( $newDateLastMod ) );
			}

			if( !empty( $item['changefreq'] ) ) {
				$freq = $node->appendChild( $dom->createElement( 'changefreq' ) );
				$freq->appendChild( $dom->createTextNode( $item['changefreq'] ) );
			}

			if( !empty( $item['priority'] ) ) {
				$priority = $node->appendChild( $dom->createElement( 'priority' ) );
				$priority->appendChild( $dom->createTextNode( $item['priority'] ) );
			}

			if( !empty( $item['img'] ) ) {
				$imgTag = $node->appendChild( $dom->createElement( 'image:image' ) );
				$imgTag->appendChild( $dom->createElement( "image:loc", $item['img'] ) );
				if( !empty( $item['imgTitle'] ) ) {
					$imgTitle = $imgTag->appendChild( $dom->createElement( "image:title" ) );
					$imgTitle->appendChild( $dom->createCDATASection( $this->replaceForSitemap( ucfirst( strtolower($this->sanitizeXML( $item['imgTitle']) ) ) ) ) );                    
				}
			}      

			if( !empty( $item['gallery'] ) ) {   
                foreach( $item['gallery'] AS $img ) {   
                    
//                    $pathImg = str_replace( 'https://www.acquistigiusti.it/imagesArticleBig/', '', $this->config->basePath.$img->initPath.$img->src );
                    $pathImg = $img->src;
                    @$image = $node->appendChild( $dom->createElement( 'image:image' ) );
                    @$imageLoc = @$image->appendChild( $dom->createElement( "image:loc", $pathImg ) );
                    if( !empty( $img->title ) ) 
                        @$imageTitle = @$image->appendChild( $dom->createElement( "image:title", $img->title ) );
                }
            }
            
			if( !empty( $item['news'] ) ) {
				@$news = $node->appendChild( $dom->createElement( 'news:news' ) );
				@$newsPub = $news->appendChild( $dom->createElement( "news:publication" ) );
                
//                $newsName = @$newsPub->appendChild( $dom->createElement( "news:name") );
//                $newsName->appendChild( $dom->createCDATASection( html_entity_decode( $item['news']['name'] ) ) );
                
				@$newsPub->appendChild( $dom->createElement( "news:name", $item['news']['name'] ) );
				@$newsPub->appendChild( $dom->createElement( "news:language", $item['news']['language'] ) );

				if( !empty( $item['news']['genres'] ) )
					@$news->appendChild( $dom->createElement( "news:genres", $item['news']['genres'] ) );

				if( !empty( $item['news']['publication_date'] ) ) {
                    $newDate = date( 'Y-m-d\TH:i:sP', strtotime( $item['news']['publication_date'] ) );                    
					@$news->appendChild( $dom->createElement( "news:publication_date", $newDate ) );
                }

				if( !empty( $item['news']['title'] ) )
					$newsTitle = @$news->appendChild( $dom->createElement( "news:title") );
                    $newsTitle->appendChild( $dom->createCDATASection( $item['news']['title'] ) ) ;

				if( !empty( $item['news']['keywords'] ) ) {                    
                    $newsKwds = @$news->appendChild( $dom->createElement( "news:keywords") );
                    $newsKwds->appendChild( $dom->createCDATASection( html_entity_decode( $item['news']['keywords'] ) ) );
                }
			}

		}
        
//        echo $this->path;
		$e = $dom->save( $this->path );
        
//         Name of the gz file we're creating
        $gzfile = $this->path.".gz";
//
//        // Open the gz file (w9 is the highest compression)
        $fp = gzopen ($gzfile, 'w9');
//
//        // Compress the file
        gzwrite ($fp, file_get_contents($this->path));
        
//
//        // Close the gz file and we're done
        gzclose($fp);
        
        
		if( !$e )
		die("Impossibile creare il file ".$this->path."\n");
	}

	/**
	 * Metodo che ritorna la sitemap corrente
	 */
	private function getCurrentSitemap() {
	   $sql = " SELECT * FROM  ".$this->dbName.".sitemaps WHERE records < ".$this->limit[$this->table]." AND type = '".$this->table."' LIMIT 1 ;";
	   //$this->debug( $sql );
	   $statement = $this->mySql->query( $sql );
	   $arr = $statement->fetchAll( \PDO::FETCH_ASSOC );
	   if( empty( $arr ) ) {
		  $this->createNewSitemap();
		  return $this->getCurrentSitemap();
	   }	   
	   return $arr[0];	   
	}

    
	/**
	 * Metodo che inserisce nel db le sitemap crate
	 */
	private function createNewSitemap() {
	   $sql = "SELECT count(id) AS max FROM  ".$this->dbName.".sitemaps where type = '$this->table'";
	   $statement = $this->mySql->query( $sql );
	   $arr = $statement->fetch();
	   if( $arr['max'] == 0 ) {
		  $this->filename = str_replace( '%i', '', $this->nameSitemaps[$this->table] );
	   } else {
		  $res = $arr['max'];
		  $this->filename = str_replace( '%i', '_'.( $arr['max'] + 1), $this->nameSitemaps[$this->table] );
	   }
       
       
	   $sql = "INSERT INTO ".$this->dbName.".sitemaps ( file, records, last_insert_id, type ) VALUES( '".$this->filename."', 0, 0, '".$this->table."' )";
	   //$this->debug( $sql );
	   $e = $this->mySql->query( $sql );
	   if( !$e )
		  die( "Impossibile generare nuova sitemap\n" );
       
	   if( !file_exists( $this->path ) && !$this->generateFile() ) {
		  $this->debug( "Impossibile creare il file ".$this->path." poichè già esistente", $this->verbose_mode );
		  $sql = "DELETE FROM  ".$this->dbName.".sitemaps WHERE file = '".$this->filename."' LIMIT 1";
		  $e = $this->mySql->query( $sql );
	   }
	   $this->debug( "Nuova sitemap generata: ".$this->filename."\n", $this->verbose_mode );
	}

	/**
	 * Metodo che chiude la sitemap nel db
	 */
	private function closeSitemap() {
	   $sql = "
		UPDATE ".$this->dbName.".sitemaps SET records = ".$this->sitemap['records']." , last_insert_id = '".$this->lastId."' 
		   WHERE file = '".$this->sitemap['file']."' AND type = '".$this->table."' ";
	   
	   $this->debug( $sql );
	   $e = $this->mySql->query( $sql );
	   if( !$e )
		  die( "Impossibile chiudere la sitemap '".$this->sitemap['file']."'\n" );
	}

	/**
	 * Metodo che crea il file con la sitemap
	 * @return boolean
	 */
	private function generateFile() {
		$xmlnsNews = $this->table == 'news' ? 'xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"' : '';
		$baseContent = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '.$xmlnsNews.' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"></urlset>';
		$h = fopen( $this->path, 'w' );
		if( !$h )
		   return false;
		fwrite( $h, $baseContent );
		fclose( $h );
		return file_exists( $this->path ) ? true : false;
	}
	
	/**
	 * Metodo che rigenera le sitemap
	 */
	private function rigenera() {
		$files = scandir( $this->config->pathSiteServer.$this->local_folder );
        
		foreach( $files as $file ) {
			if( $file != "." && $file != "..") {
			   echo "elimino ".$this->config->pathSiteServer.$this->local_folder.$file."  -- >  ";
			   echo unlink( $this->config->pathSiteServer.$this->local_folder.$file ) ? 'OK' : 'FAIL!';
			   echo "\n";
			}
		}

		$sql = "TRUNCATE TABLE ".$this->dbName.".sitemaps";
		$e = $this->mySql->query( $sql );
		if( !$e )
		   die("Impossibile svuotare il database");
		
		$this->debug("Database svuotato!", $this->verbose_mode );
	}

	/**
	 * Metodo che recupera l'id di partenza della sitemap corrente
	 * @return boolean
	 */
	private function getStartId() {
	   $sql = "SELECT MAX(last_insert_id) as max FROM  ".$this->dbName.".sitemaps WHERE type = '".$this->table."'";
	   $e = $this->mySql->query( $sql );
	   //$this->debug( $sql );
	   if(!$e ){
            return 0;
		  die( "Si è verificato un errore durante il recupero dell'ultimo id articolo inserito\n" );
       }
	   
	   $arr = $e->fetchAll();
	   if( empty( $arr ) ){
		  $this->debug( "Impossibile recuperare l'id di partenza. Rigenero tutta la sitemap" );
		  $this->startFromId = false;
	   }
	   $this->startFromId = is_numeric( $arr[0]['max'] ) ? $arr[0]['max'] : 0;
      
	}

	
	/**
	 * Metodo che aggiorna l'indice
	 */
	private function rewriteIndex() {
	   $sql = "SELECT * FROM  ".$this->dbName.".sitemaps";
	   $statement = $this->mySql->query( $sql );
	   if( !$statement )
		  die( "Impossibile aggiornare l'indice. Non è stato possibile leggere l'elenco sitemap presenti in mysql\n" );
	   $sitemaps = $statement->fetchAll( \PDO::FETCH_ASSOC );

	   $path = $this->config->pathSiteServer.$this->local_folder.$this->sitemap_index_file_name;
	   if(file_exists($path)){
		  unlink($path);
	   }

	   $dom = new \DOMDocument( '1.0', 'utf-8' );
	   $sitemapindex = $dom->createElement( 'sitemapindex' );
	   $sitemapindex->setAttribute( 'xmlns', "http://www.sitemaps.org/schemas/sitemap/0.9" );
	   $dom->appendChild( $sitemapindex );

	   foreach( $sitemaps as $sitemap ) {
		  if( !file_exists( $this->config->pathSiteServer.$this->local_folder.$sitemap['file'] ) ) {
			 $this->debug( "Il file sitemap ".$sitemap['file']." non esiste in ".$this->config->pathSiteServer.$this->local_folder.$sitemap['file'] );
			 continue;
		  }

		  $fileLastMod = date( "Y-m-d", filemtime( $this->config->pathSiteServer.$this->local_folder.$sitemap['file'] ) );

//		  $name = $this->config->basePath.'/'.$sitemap['file'].'.gz';	
		  $name = $this->config->basePath.'/'.$sitemap['file'];	
		  $nodo = $dom->createElement( 'sitemap' );
		  $sitemapindex->appendChild( $nodo );

		  $loc = $dom->createElement( 'loc' );
		  $loc->appendChild( $dom->createTextNode( $name ) );
		  $nodo->appendChild( $loc );

		  $lastmod = $dom->createElement( 'lastmod' );
		  $lastmod->appendChild( $dom->createTextNode( $fileLastMod ) );
		  $nodo->appendChild( $lastmod );
	   }

	   $e = $dom->save( $path );
		if( !$e )
		  die( "Impossibile creare il file ".$path."\n" );
	}
    
    public function sanitizeXML($string)
{
    if (!empty($string)) 
    {
        // remove EOT+NOREP+EOX|EOT+<char> sequence (FatturaPA)
        $string = preg_replace('/(\x{0004}(?:\x{201A}|\x{FFFD})(?:\x{0003}|\x{0004}).)/u', '', $string);
 
        $regex = '/(
            [\xC0-\xC1] # Invalid UTF-8 Bytes
            | [\xF5-\xFF] # Invalid UTF-8 Bytes
            | \xE0[\x80-\x9F] # Overlong encoding of prior code point
            | \xF0[\x80-\x8F] # Overlong encoding of prior code point
            | [\xC2-\xDF](?![\x80-\xBF]) # Invalid UTF-8 Sequence Start
            | [\xE0-\xEF](?![\x80-\xBF]{2}) # Invalid UTF-8 Sequence Start
            | [\xF0-\xF4](?![\x80-\xBF]{3}) # Invalid UTF-8 Sequence Start
            | (?<=[\x0-\x7F\xF5-\xFF])[\x80-\xBF] # Invalid UTF-8 Sequence Middle
            | (?<![\xC2-\xDF]|[\xE0-\xEF]|[\xE0-\xEF][\x80-\xBF]|[\xF0-\xF4]|[\xF0-\xF4][\x80-\xBF]|[\xF0-\xF4][\x80-\xBF]{2})[\x80-\xBF] # Overlong Sequence
            | (?<=[\xE0-\xEF])[\x80-\xBF](?![\x80-\xBF]) # Short 3 byte sequence
            | (?<=[\xF0-\xF4])[\x80-\xBF](?![\x80-\xBF]{2}) # Short 4 byte sequence
            | (?<=[\xF0-\xF4][\x80-\xBF])[\x80-\xBF](?![\x80-\xBF]) # Short 4 byte sequence (2)
        )/x';
        $string = preg_replace($regex, '', $string);
 
        $result = "";
        $current;
        $length = strlen($string);
        for ($i=0; $i < $length; $i++)
        {
            $current = ord($string{$i});
            if (($current == 0x9) ||
                ($current == 0xA) ||
                ($current == 0xD) ||
                (($current >= 0x20) && ($current <= 0xD7FF)) ||
                (($current >= 0xE000) && ($current <= 0xFFFD)) ||
                (($current >= 0x10000) && ($current <= 0x10FFFF)))
            {
                $result .= chr($current);
            }
            else
            {
                $ret;    // use this to strip invalid character(s)
                // $ret .= " ";    // use this to replace them with spaces
            }
        }
        $string = $result;
    }
    return $string;
}

	/**
	 * Metodo che invia il ping ai motori di ricerca delle sitemap
	 */
	private function ping(){
       
	   $sitemapIndex = urldecode( str_replace( '/', '', $this->config->basePath ).$this->localFolderRead.$this->sitemap_index_file_name );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['google'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['msn'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['yahoo'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['bing'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['windows_live'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['ask'] );

	   if( $this->enabledPing ) {
			foreach( $pings AS $ping ) {
			  $this->debug( "PING $ping.....", $this->verbose_mode );
			  $curl = curl_init();
			  curl_setopt( $curl, CURLOPT_URL, $ping );
			  curl_setopt( $curl, CURLOPT_HEADER, 0);
//			  curl_exec( $curl );
//			  curl_close( $curl );
			  $this->debug( "FATTO!" );
			}
		}
	}

	/**
	 * Metodo che stampa a video il debug
	 * @param type $str
	 */
	private function debug( $str ) {
	   if( $this->verbose_mode )
		  echo "\n".$str."\n";
	}
}