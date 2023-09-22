<?php

$longopts  = array (
	"help::",
	"f:",
	"l:",
	"i:",
	"d:",
	"fkSA:",
	"fkC:",
	"fkS:",
	"fkCNew:",
	"fkSNew:",
	"fkSAff:",
	"idsA:",
	"u:",
	"a:",
	"regenerate:"
);
$options = getopt( "f::",$longopts );
$user = $options['u'];
if ( empty( $user ) ) {
	echo 'nessun utene selezionato';
	exit;
}

require_once '/home/'.$user.'/site/miglioreprezzo.com/lib/InitSetting.class.php';
ObjectsSite::controlOptionScript( $options );
$config = ObjectsSite::init();
$oConfig = ObjectsSite::addConfig( $config );
require_once $oConfig->pathEnvironment.'/lib/Main.class.php';
require_once $oConfig->pathEnvironment.'/lib/BaseObject.class.php';

/**
 * Classe per la gestione delle sitemap
 */
class RunSitemaps extends BaseObject {
	private $table;	
	private $verbose_mode = true;
	private $enable_ping = false;
	private $limit = array();
	private $query = array();
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
	public function __construct( $regenerate = false ) {
		parent::__construct();
		$this->setConfig();
		
		if( $regenerate )
			$this->rigenera();
	}
	
	/**
	 * Metodo che setta le configurazioni per creare le sitemap
	 */
	private function setConfig() {		
		require_once $this->config->pathScriptBusiness.'/lib/BusinessObjects/Category.class.php';
		$this->rewrite = new Rewrite();
		$this->dbName = $this->config->dbSite;
		
		$this->local_folder = "/public/sitemaps/";
		
		$this->query['review']				= "SELECT idReview AS id, title, anchorTitle, fkCategory, LEFT(ORA,10) as ora, foto1 as img, tags FROM ".$this->dbName.".review WHERE idReview > :myId ORDER BY idReview ASC";
		$this->query['products']			= "SELECT product.idProduct AS id, product.fkCategory, LEFT(product.lastModify,10) as ora, product.name, imageProduct.img FROM product LEFT JOIN ".$this->dbName.".imageProduct ON imageProduct.fkProduct = product.idProduct WHERE idProduct > :myId AND product.fkCategory IS NOT NULL AND product.fkSubcategory IS NOT NULL AND isActive = 1 ORDER BY idProduct ASC";
		$this->query['category']			= "SELECT idCategory AS id, category.keyUrlCategory FROM ".$this->dbName.".category WHERE category.isActive = 1 AND category.numProducts > 0 AND category.idCategory > :myId ORDER BY idCategory ASC";
		$this->query['subcategory']			= "SELECT idSubcategory AS id, subcategory.name AS name, subcategory.keyUrlSubcategory, category.keyUrlCategory FROM ".$this->dbName.".subcategory JOIN category on category.idCategory = subcategory.fkCategory WHERE subcategory.isActive = 1 AND subcategory.numProducts > 0 AND subcategory.idSubcategory > :myId ORDER BY idSubcategory ASC";
		$this->query['typology']			= "SELECT idTypology AS id, typology.keyUrlTypology, subcategory.keyUrlSubcategory, category.keyUrlCategory FROM ".$this->dbName.".typology JOIN ".$this->dbName.".subcategory on subcategory.idSubcategory = typology.fkSubcategory JOIN category on category.idCategory = subcategory.fkCategory WHERE typology.isActive = 1 AND typology.numProducts > 0 AND typology.idTypology > :myId ORDER BY fkSubcategory ASC";
		$this->query['trademarks']			= "SELECT idTrademark AS id, name, img FROM ".$this->dbName.".trademark WHERE idTrademark > :myId ORDER BY idTrademark ASC";
		$this->query['productsTrademarks']	= "SELECT idTrademark AS id, name FROM ".$this->dbName.".trademark WHERE numProducts > 0 AND idTrademark > :myId ORDER BY idTrademark ASC";
		
		$this->limit['review']				= 20000;
		$this->limit['products']			= 20000;
		$this->limit['category']			= 20000;
		$this->limit['subcategory']			= 20000;
		$this->limit['typology']			= 20000;
		$this->limit['trademarks']			= 20000;
		$this->limit['productsTrademarks']	= 20000;
		
		$this->sitemap_index_file_name		= "sitemapsindex.xml";
		$this->sitemap_file_name			= "sitemap_%i.xml";
		
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
		$e = $stn->execute();
		if( !$e )
		   die( "Impossibile recuperare i nuovi articoli da mysql\n" );
				
		$this->rowsSitemap = $stn->fetchAll( PDO::FETCH_OBJ );	
		$this->writeSitemap();
	}
	
	/**
	 * Metodo che crea i nodi della sitemap
	 */
	private function writeSitemap() {
		$x = 0;		
		foreach( $this->rowsSitemap AS $row ) {
			$iRow = $this->rowsSitemap = $this->utility->objectToArray( $row );
			switch( $this->table ) {
				case 'review': 		
					$iRow['idReview'] = $row->id;
					$this->itemsSitemap[$x]['url'] = $this->rewrite->getUrlReview( $iRow );
					$this->itemsSitemap[$x]['changefreq'] = 'never';
					$this->itemsSitemap[$x]['lastmod'] = $row->ora;
					
//					$this->itemsSitemap[$x]['news']['name'] = $this->utility->replaceForSitemap( $row->title, false );
//					$this->itemsSitemap[$x]['news']['language'] = 'it';
//					$this->itemsSitemap[$x]['news']['genres'] = 'blog';
//					$this->itemsSitemap[$x]['news']['publication_date'] = $this->utility->replaceForSitemap( $row->ora );
//					$this->itemsSitemap[$x]['news']['title'] = $this->utility->replaceForSitemap( $row->title, false );
//					if ( !empty( $row->tags ) && strtolower( $row->tags ) != 'array' )
//						$this->itemsSitemap[$x]['news']['keywords'] = $this->utility->replaceForSitemap( $row->tags );
					
					if ( !empty( $row->img ) ) {
						$this->itemsSitemap[$x]['img'] = $this->rewrite->getUrlImageReview( $iRow, $this->config->imagesReview.$row->img );
						$this->itemsSitemap[$x]['imgTitle'] = $this->utility->replaceForSitemap( $row->title, false );
					}
				break;
				case 'products':						
					$iRow['idProduct'] = $row->id;
					$this->itemsSitemap[$x]['url'] = $this->rewrite->getUrlProduct( $iRow );
					$this->itemsSitemap[$x]['changefreq'] = 'yearly';
					$this->itemsSitemap[$x]['lastmod'] = $this->utility->replaceForSitemap( $row->ora );
					$this->itemsSitemap[$x]['img'] = $this->rewrite->getUrlImageProduct( $iRow, $this->config->imagesProducts.$row->img );
					$this->itemsSitemap[$x]['imgTitle'] = $this->utility->replaceForSitemap( ucfirst( strtolower( $row->name ) ) );
				break;
				case 'category':						
					$iRow['idCategory'] = $row->id;
					$this->itemsSitemap[$x]['url'] = $this->rewrite->getUrlCategory( $iRow );
					$this->itemsSitemap[$x]['changefreq'] = 'daily';
				break;
				case 'subcategory':							
					$iRow['idSubcategory'] = $row->id;
					$this->itemsSitemap[$x]['url'] = $this->rewrite->getUrlSubcategory( $iRow );
					$this->itemsSitemap[$x]['changefreq'] = 'daily';
				break;
				case 'typology':	
					$iRow = $this->isValidField( $iRow, array( 'keyUrlCategory', 'keyUrlSubcategory', 'keyUrlTypology' ) );					
					$iRow['idTypology'] = $row->id;					
					$this->itemsSitemap[$x]['url'] = $this->rewrite->getUrlTypology( $iRow );
					$this->itemsSitemap[$x]['changefreq'] = 'daily';
				break;
				case 'trademarks':
					$row = $this->isValidField( $row, array( 'name' ) );
					$iRow['idTrademark'] = $row->id;
					$iRow['name'] = utf8_decode( $row->name );
					$this->itemsSitemap[$x]['url'] = $this->rewrite->getUrlTrademark( $iRow, true );
					$this->itemsSitemap[$x]['changefreq'] = 'monthly';
					$this->itemsSitemap[$x]['img'] = $this->rewrite->getUrlImageTrademark( $this->config->imagesTrademarksRead.$row->img );
					$this->itemsSitemap[$x]['imgTitle'] = $this->utility->replaceForSitemap( ucfirst( strtolower( $row->name ) ) );
				break;
				case 'productsTrademarks':
					if ( !$this->isValidField( $row, array( 'name' ) ) )
						continue;
					
					$iRow['idTrademark'] = $row->id;
					$iRow['name'] = utf8_decode( $row->name );
					$this->itemsSitemap[$x]['url'] = $this->rewrite->getUrlProductsTrademark( $iRow, true );
					$this->itemsSitemap[$x]['changefreq'] = 'monthly';
				break;
		   }
		   
		   $this->sitemap['records']++;		   
		   if( $this->sitemap['records'] >= $this->limit[$this->table] ) {
			  $this->write();
			  $this->itemsSitemap = array();
			  $x = 0;
			  $this->debug( "Chiudo sitemap ".$this->sitemap['file'] );
			  
			  $this->lastId = $row->id;
			  $this->closeSitemap();
			  $this->createNewSitemap();
			  $this->sitemap = $this->getCurrentSitemap();
		   }
		   $x++;
		}
		$this->write();
		$this->rewriteIndex();
		$this->ping();
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

	// =========================================================================================================================== //

	/**
	 * Metodo che crea i nodi xml della sitemap
	 */
	private function write() {
		$this->path = $this->config->pathSiteServer.$this->local_folder.$this->sitemap['file'];
		$dom = new DOMDocument('1.0', 'utf-8');
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
				$lastmod->appendChild( $dom->createTextNode( $item['lastmod'] ) );
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
					$imgTitle->appendChild( $dom->createTextNode( '<![CDATA['.$item['imgTitle'].']]>' ) );
				}
			}      

			if( !empty( $item['news'] ) ) {
				@$news = $node->appendChild( $dom->createElement( 'news:news' ) );
				@$newsPub = $news->appendChild( $dom->createElement( "news:publication" ) );
				@$newsPub->appendChild( $dom->createElement( "news:name", '<![CDATA['.$item['news']['name'].']]>' ) );
				@$newsPub->appendChild( $dom->createElement( "news:language", $item['news']['language'] ) );

				if( !empty( $item['news']['genres'] ) )
					@$news->appendChild( $dom->createElement( "news:genres", $item['news']['genres'] ) );

				if( !empty( $item['news']['publication_date'] ) )
					@$news->appendChild( $dom->createElement( "news:publication_date", $item['news']['publication_date'] ) );

				if( !empty( $item['news']['title'] ) )
					@$news->appendChild( $dom->createElement( "news:title", '<![CDATA['.$item['news']['title'].']]>' ) );

				if( !empty( $item['news']['keywords'] ) )
					@$news->appendChild( $dom->createElement( "news:keywords", '<![CDATA['.$item['news']['keywords'].']]>' ) );
			}

		}
		$e = $dom->save( $this->path );
		if( !$e )
		die("Impossibile creare il file ".$this->path."\n");
	}

	/**
	 * Metodo che ritorna la sitemap corrente
	 */
	private function getCurrentSitemap() {
	   $sql = " SELECT * FROM  ".$this->dbName.".sitemaps WHERE records < ".$this->limit[$this->table]." AND type = '".$this->table."' LIMIT 1;";
	   //$this->debug( $sql );
	   $statement = $this->mySql->query( $sql );
	   $arr = $statement->fetchAll( PDO::FETCH_ASSOC );
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
	   $sql = "SELECT MAX(id) AS max FROM  ".$this->dbName.".sitemaps";
	   $statement = $this->mySql->query( $sql );
	   $arr = $statement->fetchAll();
	   if( empty( $arr) ) {
		  $this->filename = str_replace( '%i', 1, $this->sitemap_file_name );
	   } else {
		  $res = $arr[0]['max'];
		  $this->filename = str_replace( '%i', $arr[0]['max'] + 1, $this->sitemap_file_name );
	   }
	   $sql = "INSERT INTO ".$this->dbName.".sitemaps ( file, records, lastInsertId, type ) VALUES( '".$this->filename."', 0, 0, '".$this->table."' )";
	   //$this->debug( $sql );
	   $e = $this->mySql->query( $sql );
	   if( !$e )
		  die( "Impossibile generare nuova sitemap\n" );

	   $this->path = $this->config->pathSiteServer.$this->local_folder.$this->filename;	   
	   if( file_exists( $this->path ) || !$this->generateFile() ) {
		  $this->debug( "Impossibile creare il file ".$this->path." poichè già esistente", $this->verbose_mode );
		  $sql = "DELETE FROM  ".$this->dbName.".sitemaps WHERE file = '".$this->filename."' LIMIT 1";
		  $e = $this->mySql->query( $sql );
		  exit;
	   }
	   $this->debug( "Nuova sitemap generata: ".$this->filename."\n", $this->verbose_mode );
	}

	/**
	 * Metodo che chiude la sitemap nel db
	 */
	private function closeSitemap() {
	   $sql = "
		UPDATE ".$this->dbName.".sitemaps SET records = ".$this->sitemap['records']." , lastInsertId = '".$this->lastId."' 
		   WHERE file = '".$this->sitemap['file']."' AND type = '".$this->table."' ";
	   
	   //$this->debug( $sql );
	   $e = $this->mySql->query( $sql );
	   if( !$e )
		  die( "Impossibile chiudere la sitemap '".$this->sitemap['file']."'\n" );
	}

	/**
	 * Metodo che crea il file con la sitemap
	 * @return boolean
	 */
	private function generateFile() {
		$xmlnsNews = $this->table == 'review' ? 'xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"' : '';
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
	   $sql = "SELECT MAX(lastInsertId) as max FROM  ".$this->dbName.".sitemaps WHERE type = '".$this->table."'";
	   $e = $this->mySql->query( $sql );
	   //$this->debug( $sql );
	   if( !$e )
		  die( "Si è verificato un errore durante il recupero dell'ultimo id articolo inserito\n" );
	   
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
	   $sitemaps = $statement->fetchAll( PDO::FETCH_ASSOC );

	   $path = $this->config->pathSiteServer.$this->local_folder.$this->sitemap_index_file_name;
	   if(file_exists($path)){
		  unlink($path);
	   }

	   $dom = new DOMDocument( '1.0', 'utf-8' );
	   $sitemapindex = $dom->createElement( 'sitemapindex' );
	   $sitemapindex->setAttribute( 'xmlns', "http://www.sitemaps.org/schemas/sitemap/0.9" );
	   $dom->appendChild( $sitemapindex );

	   foreach( $sitemaps as $sitemap ) {
		  if( !file_exists( $this->config->pathSiteServer.$this->local_folder.$sitemap['file'] ) ) {
			 $this->debug( "Il file sitemap ".$sitemap['file']." non esiste in ".$this->config->pathSiteServer.$this->local_folder.$sitemap['file'] );
			 continue;
		  }

		  $fileLastMod = date( "Y-m-d", filemtime( $this->config->pathSiteServer.$this->local_folder.$sitemap['file'] ) );

		  $name = 'http://'.$this->config->basePath.'/sitemaps/'.$sitemap['file'];	
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

	/**
	 * Metodo che invia il ping ai motori di ricerca delle sitemap
	 */
	private function ping(){
	   $sitemapIndex = urldecode( "http://".$this->config->basePath.$this->local_folder.$this->sitemap_index_file_name );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['google'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['msn'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['yahoo'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['bing'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['windows_live'] );
	   $pings[] = str_replace( '[sitemap_location]', $sitemapIndex, $this->ping['ask'] );

	   if( $this->enable_ping ) {
			foreach( $pings AS $ping ) {
			  $this->debug( "PING $ping.....", $this->verbose_mode );
			  $curl = curl_init();
			  curl_setopt( $curl, CURLOPT_URL, $ping );
			  curl_setopt( $curl, CURLOPT_HEADER, 0);
			  curl_exec( $curl );
			  curl_close( $curl );
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

$regenerate = !empty( $options['regenerate'] ) ? true : false;
$runSitemaps = new RunSitemaps( $regenerate );
$runSitemaps->init( 'review' );
$runSitemaps->init( 'category' );
$runSitemaps->init( 'subcategory' );
$runSitemaps->init( 'typology' );
$runSitemaps->init( 'products' );
$runSitemaps->init( 'productsTrademarks' );
$runSitemaps->init( 'trademarks' );

