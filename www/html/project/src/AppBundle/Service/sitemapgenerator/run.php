<?php

global $system, $mysql;
$system = parse_ini_file('sitemap.ini',true);
if(!$system){
   die("Impossibilie caricare le impostazioni di sistema");
}
require_once $system['system']['pathServer'].'lib/costanti.php';

if( isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == '-help' ){
   echo file_get_contents($system['system']['man_file'])."\n\n";
   exit;
}
$verbose = $system['system']['verbose_mode'];
$mysql = new PDO($system['mysql']['dsn'], $system['mysql']['user'], $system['mysql']['psw']);

$rigenera = isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == '-regenerate' ? true : false;

if ( $rigenera ) {
   println( "Rigenero l'intera sitemap\n\n", $verbose );
   rigenera();
}

################################################## news #######################################################
$table = 'news';
$startFromId = getStartId( $table );
$sitemap = getCurrentSitemap( $table );
println( "current sitemap: ".$sitemap['file'], $verbose );
println( "records: ".$sitemap['records'], $verbose );
println( "start from id: ".$startFromId, $verbose );

$urls = array();
$stn = $mysql->prepare( $system['mysql']['sql_url_news'] );
$stn->bindValue(':myId', $startFromId );
$e = $stn->execute();
if( !$e )
   die( "Impossibile recuperare i nuovi articoli da mysql\n" );
$rows = $stn->fetchAll(  PDO::FETCH_OBJ );
writeSitemap( $rows, $sitemap, $table, $verbose );

############################################### subcategory ###################################################
$table = 'subcategory';
$startFromId = getStartId( $table );
$sitemap = getCurrentSitemap( $table );
println( "current sitemap: ".$sitemap['file'], $verbose );
println( "records: ".$sitemap['records'], $verbose );
println( "start from id: ".$startFromId, $verbose );

$urls = array();
$stn = $mysql->prepare( $system['mysql']['sql_url_subcategory'] );
$stn->bindValue(':myId', $startFromId );
$e = $stn->execute();
if( !$e )
   die( "Impossibile recuperare i le sottocategorie da mysql\n" );

$rows = $stn->fetchAll(  PDO::FETCH_OBJ );
writeSitemap( $rows, $sitemap,  $table, $verbose );


################################################ trademarks ###################################################
$table = 'trademarks';
$startFromId = getStartId( $table );
$sitemap = getCurrentSitemap( $table );
println( "current sitemap: ".$sitemap['file'], $verbose );
println( "records: ".$sitemap['records'], $verbose );
println( "start from id: ".$startFromId, $verbose );

$urls = array();
$stn = $mysql->prepare( $system['mysql']['sql_url_trademarks'] );
$stn->bindValue(':myId', $startFromId );
$e = $stn->execute();
if( !$e )
   die( "Impossibile recuperare i prodotti da mysql\n" );
$rows = $stn->fetchAll(  PDO::FETCH_OBJ );
writeSitemap( $rows, $sitemap,  $table, $verbose );


############################################ productsTrademarks ###############################################
$table = 'productsTrademarks';
$startFromId = getStartId( $table );
$sitemap = getCurrentSitemap( $table );
println( "current sitemap: ".$sitemap['file'], $verbose );
println( "records: ".$sitemap['records'], $verbose );
println( "start from id: ".$startFromId, $verbose );

$urls = array();
$stn = $mysql->prepare( $system['mysql']['sql_url_productsTrademarks'] );
$stn->bindValue(':myId', $startFromId );
$e = $stn->execute();
if( !$e )
   die( "Impossibile recuperare i prodotti da mysql\n" );
$rows = $stn->fetchAll(  PDO::FETCH_OBJ );
writeSitemap( $rows, $sitemap,  $table, $verbose );


################################################# products ####################################################
$table = 'products';
$startFromId = getStartId( $table );
$sitemap = getCurrentSitemap( $table );
println( "current sitemap: ".$sitemap['file'], $verbose );
println( "records: ".$sitemap['records'], $verbose );
println( "start from id: ".$startFromId, $verbose );

$urls = array();
$stn = $mysql->prepare( $system['mysql']['sql_url_products'] );
$stn->bindValue(':myId', $startFromId );
$e = $stn->execute();
if( !$e )
   die( "Impossibile recuperare i prodotti da mysql\n" );
$rows = $stn->fetchAll(  PDO::FETCH_OBJ );
writeSitemap( $rows, $sitemap,  $table, $verbose );


/**
 * Metodo che crea i nodi della sitemap
 * @global type $system
 * @param type $rows
 * @param type $sitemap
 * @param type $table
 * @param type $verbose
 */
function writeSitemap( $rows, $sitemap, $table, $verbose ) {
    global $system;
    $x = 0;
    foreach( $rows AS $row ) {
       switch( $table ) {
            case 'news': 
                $title = arrangiaUrl( $row->title );
                $items[$x]['url'] = 'http://'.$system['sitemap']['site']."/news/".$title."-".$row->id.".html";
                $items[$x]['changefreq'] = 'never';
                $items[$x]['lastmod'] = $row->ora;
                /*
                $items[$x]['news']['name'] = replaceForSitemap( $row->title );
                $items[$x]['news']['language'] = 'it';
                //$items[$x]['news']['genres'] = 'blog';
                $items[$x]['news']['publication_date'] = replaceForSitemap( $row->ora );
                $items[$x]['news']['title'] = replaceForSitemap( $row->title );
                if ( !empty( $row->tags ) && strtolower( $row->tags ) != 'array' )
                    $items[$x]['news']['keywords'] = replaceForSitemap( $row->tags );
                */
                if ( !empty( $row->img ) ) {
                    $items[$x]['img'] = HOST."/".IMAGES.'/'.$row->img;
                    $items[$x]['imgTitle'] = replaceForSitemap( $row->title );
                }
            break;
            case 'products': $varPath = '';
                $name = arrangiaUrl( $row->name );
                $items[$x]['url'] = HOST."/".$name."-".$row->id.".html";
                $items[$x]['changefreq'] = 'yearly';
                $items[$x]['lastmod'] = replaceForSitemap( $row->ora );
                $items[$x]['img'] = HOST."/".IMAGES_PRODUCTS.$row->img;
                $items[$x]['imgTitle'] = replaceForSitemap( ucfirst( strtolower( $row->name ) ) );
            break;
            case 'subcategory':
                $category = arrangiaUrl( $row->category );
                $name = arrangiaUrl( $row->name );
                $items[$x]['url'] = HOST."/".$category."/".$name.".html";
                $items[$x]['changefreq'] = 'daily';
            break;
            case 'trademarks':
                $name = arrangiaUrl( $row->name );
                $items[$x]['url'] = 'http://'.$system['sitemap']['site']."/marchio/".$row->id."-".$name.".html";
                $items[$x]['changefreq'] = 'monthly';
                $items[$x]['img'] = HOST."/".IMAGES_MARCHI.$row->img;
                $items[$x]['imgTitle'] = replaceForSitemap( ucfirst( strtolower( $row->name ) ) );
            break;
            case 'productsTrademarks':
                $name = arrangiaUrl( $row->name );
                $items[$x]['url'] = 'http://'.$system['sitemap']['site']."/prodotti/".$name."-".$row->id.".html";
                $items[$x]['changefreq'] = 'monthly';
            break;
       }
       $sitemap['records']++;

       if( $sitemap['records'] >= $system['mysql']['limit_file_'.$table] ){
          write( $sitemap, $items );
          $item = array();
          $x = 0;
          println( "Chiudo sitemap ".$sitemap['file'], $verbose );
          closeSitemap( $sitemap, $row->id, $table  );
          createNewSitemap( $table );
          $sitemap = getCurrentSitemap( $table );
       }
       $x++;
    }
    write($sitemap, $items );
    rewriteIndex();
    ping();
}


// =========================================================================================================================== //

/**
 * Metodo che crea i nodi xml della sitemap
 * @global PDO $mysql
 * @global array $system
 * @param array $sitemap
 * @param array $items
 */
function  write( $sitemap, $items ) {
    global $mysql, $system;
    $path = $system['system']['root'].$system['system']['local_folder'].$sitemap['file'];
    $dom = new DOMDocument('1.0', 'utf-8');
    $dom->load($path);
    $urlset = $dom->getElementsByTagName('urlset')->item(0);
   
    foreach( $items as $item ){
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
                $imgTitle->appendChild( $dom->createTextNode( $item['imgTitle'] ) );
            }
        }      
        
        if( !empty( $item['news'] ) ) {
            $news = $node->appendChild( $dom->createElement( 'news:news' ) );
            $newsPub = $news->appendChild( $dom->createElement( "news:publication" ) );
            $newsPub->appendChild( $dom->createElement( "news:name", $item['news']['name'] ) );
            $newsPub->appendChild( $dom->createElement( "news:language", $item['news']['language'] ) );

            if( !empty( $item['news']['genres'] ) )
                $news->appendChild( $dom->createElement( "news:genres", $item['news']['genres'] ) );
            
            if( !empty( $item['news']['publication_date'] ) )
                $news->appendChild( $dom->createElement( "news:publication_date", $item['news']['publication_date'] ) );
            
            if( !empty( $item['news']['title'] ) )
                $news->appendChild( $dom->createElement( "news:title", $item['news']['title'] ) );
            
            if( !empty( $item['news']['keywords'] ) )
                $news->appendChild( $dom->createElement( "news:keywords", $item['news']['keywords'] ) );
        }
        
    }
    $e = $dom->save( $path );
    if( !$e )
    die("Impossibile creare il file ".$path."\n");
}

function getCurrentSitemap( $type ) {
   global $mysql, $system;
   $sql = " SELECT * FROM Sitemaps WHERE records < ".$system['mysql']['limit_file_'.$type]." AND type = '".$type."' LIMIT 1;";
   $statement = $mysql->query($sql);
   $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
   if( empty($arr) ){
      createNewSitemap( $type  );
      return getCurrentSitemap( $type );
   }
   return $arr[0];
}

function createNewSitemap( $type ){
   global $mysql, $system;
   $sql = "SELECT MAX(id) AS max FROM Sitemaps";
   $statement = $mysql->query($sql);
   $arr = $statement->fetchAll();
   if( empty($arr) ){
      $filename = str_replace('%i',1,$system['sitemap']['sitemap_file_name']);
   } else {
      $res = $arr[0]['max'];
      $filename = str_replace('%i',$arr[0]['max']+1,$system['sitemap']['sitemap_file_name']);
   }
   $sql = "INSERT INTO Sitemaps ( file, records, lastInsertId, type ) VALUES( '".$filename."', 0, 0, '".$type."' )";
   echo $sql."\n";
   $e = $mysql->query( $sql );
   if(!$e){
      die("Impossibile generare nuova sitemap\n");
   }
   
   $path = $system['system']['root'].$system['system']['local_folder'].$filename;
   if(file_exists( $path ) || !generateFile( $path, $type )){
      println( "Impossibile creare il file ".$path." poichè già esistente", $system['system']['verbose_mode']);
      $sql = "DELETE FROM Sitemaps WHERE file = '".$filename."' LIMIT 1";
      $e = $mysql->query( $sql );
      exit;
   }
   
   println("Nuova sitemap generata: ".$filename."\n", $system['system']['verbose_mode']);
   return $filename;
}

function closeSitemap( $sitemap , $lastId, $table ){
   global $mysql, $system;
   $sql = "UPDATE Sitemaps SET records = ".$sitemap['records']." , lastInsertId = '".$lastId."' WHERE file = '".$sitemap['file']."' AND type = '".$table."' ";
   println($sql,$system['system']['verbose_mode']);
   $e = $mysql->query($sql);
   if(!$e){
      die("Impossibile chiudere la sitemap '".$sitemap['file']."'\n");
   }
}


function generateFile( $path, $type = '' ) {
    $xmlnsNews = $type == 'news' ? 'xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"': '';
    $xmlnsNews = '';
    $baseContent = '<?xml version="1.0" encoding="UTF-8"?>
                  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
                  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
                  '.$xmlnsNews.'>
                  </urlset>';
    $h = fopen( $path, 'w' );
    if( !$h )
       return false;
    fwrite( $h, $baseContent );
    fclose( $h );
    return file_exists( $path ) ? true : false;
}


function rigenera(){
    global $mysql, $system;
    $files = scandir($system['system']['root'].$system['system']['local_folder']);
    foreach( $files as $file ){
        if($file != "." && $file != ".."){
           echo "elimino ".$system['system']['root'].$system['system']['local_folder'].$file."  -- >  ";
           echo unlink($system['system']['root'].$system['system']['local_folder'].$file) ? 'OK' : 'FAIL!';
           echo "\n";
        }
    }
   
    $sql = "TRUNCATE TABLE Sitemaps";
    $e = $mysql->query($sql);
    if(!$e){
       die("Impossibile svuotare il database");
    }
    println("Database svuotato!", $system['system']['verbose_mode']);
}

function getStartId( $table ){
   global $mysql, $system;
   $sql = "SELECT MAX(lastInsertId) as max FROM Sitemaps WHERE type = '".$table."'";
   $e = $mysql->query($sql);
   if(!$e){
      die("Si è verificato un errore durante il recupero dell'ultimo id articolo inserito\n");
   }
   $arr = $e->fetchAll();
   if( empty($arr) ){
      println("Impossibile recuperare l'id dell'articolo di partenza. Rigenero tutta la sitemap", $system['system']['verbose_mode']);
      return 0;
   }
   
   return is_numeric($arr[0]['max']) ? $arr[0]['max'] : 0;
}

function rewriteIndex(){
   global $mysql, $system;
   $sql = "SELECT * FROM Sitemaps";
   $statement = $mysql->query($sql);
   if(!$statement){
      die("Impossibile aggiornare l'indice. Non è stato possibile leggere l'elenco sitemap presenti in mysql\n");
   }
   $sitemaps = $statement->fetchAll(PDO::FETCH_ASSOC);
   
   $path = $system['system']['root'].$system['system']['local_folder'].$system['sitemap']['sitemap_index_file_name'];
   if(file_exists($path)){
      unlink($path);
   }
   
   $dom = new DOMDocument('1.0', 'utf-8');
   $sitemapindex = $dom->createElement('sitemapindex');
   $sitemapindex->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
   $dom->appendChild($sitemapindex);
   
   foreach( $sitemaps as $sitemap ){
      
      if( !file_exists($system['system']['root'].$system['system']['local_folder'].$sitemap['file']) ){
         println("Il file sitemap ".$sitemap['file']." non esiste in ".$system['system']['root'].$system['system']['local_folder'].$sitemap['file']);
         continue;
      }
      
      $fileLastMod = date("Y-m-d", filemtime($system['system']['root'].$system['system']['local_folder'].$sitemap['file']));
      
      $name = 'http://'.$system['sitemap']['site']."/".$system['system']['local_folder'].$sitemap['file'];
      $nodo = $dom->createElement('sitemap');
      $sitemapindex->appendChild($nodo);
      
      $loc = $dom->createElement('loc');
      $loc->appendChild($dom->createTextNode($name));
      $nodo->appendChild($loc);
      
      $lastmod = $dom->createElement('lastmod');
      $lastmod->appendChild($dom->createTextNode($fileLastMod));
      $nodo->appendChild($lastmod);
   }
   
   $e = $dom->save($path);
    if(!$e){
      die("Impossibile creare il file ".$path."\n");
   }
}


function ping(){
   global $system;
   $sitemapIndex = urldecode("http://".$system['sitemap']['site']."/".$system['system']['local_folder'].$system['sitemap']['sitemap_index_file_name']);
   $pings[] = str_replace('[sitemap_location]', $sitemapIndex, $system['sitemap']['ping_url_google']);
   $pings[] = str_replace('[sitemap_location]', $sitemapIndex, $system['sitemap']['ping_url_msn']);
   $pings[] = str_replace('[sitemap_location]', $sitemapIndex, $system['sitemap']['ping_url_yahoo']);
   $pings[] = str_replace('[sitemap_location]', $sitemapIndex, $system['sitemap']['ping_url_bing']);
   $pings[] = str_replace('[sitemap_location]', $sitemapIndex, $system['sitemap']['ping_url_windows_live']);
   $pings[] = str_replace('[sitemap_location]', $sitemapIndex, $system['sitemap']['ping_url_ask']);
      
   if($system['system']['enable_ping']){
        foreach( $pings AS $ping ) {
          println("PING $ping.....", $system['system']['verbose_mode']);
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $ping);
          curl_setopt($curl, CURLOPT_HEADER, 0);
          curl_exec($curl);
          curl_close($curl);
          println("FATTO!", $system['system']['verbose_mode']);
        }
    }
}

function println($str, $verbose=true){
   if($verbose){
      echo $str."\n";
   }
}

function replaceForSitemap( $string ) {
    $r1 = array('&','<','>');
    $r2 = array('');
    $string = str_replace( $r1, $r2, $string );
    return html_entity_decode( trim( utf8_encode( $string ) ) );
}

function arrangiaUrl( $string ) {
    $string = trim( $string );
    $string = strip_tags( $string );
    $string = utf8_decode( $string );
    $string = strtr($string, "çâãàáäåéèêëíìîïñóòôõöøðúùûüýÇÂÃÀÁÄÅÉÈÊËÍÌÎÏÑÓÒÔÕÖØÐÚÙÛÜÝ", "caaaaaaeeeeiiiinooooooouuuuyCAAAAAAEEEEIIIINOOOO0OOUUUUY");
    $string = str_replace( array('à','á','é','è','í','ì','ó','ò','ú','ù'),array('a','a','e','e','i','i','o','o','u','u'),$string ); 
    $string = str_replace( array('À','Á','É','È','Í','Ì','Ó','Ò','Ú','Ù'),array('A','A','E','E','I','I','O','O','U','U'),$string );
    $string = strtolower( $string );
    $string = preg_replace( "#[^A-Za-z0-9àáéèíìóòúù/]#", "-", $string );
    $string = str_replace( '/',"-",$string );
    $string = preg_replace( '/-+/',"-",$string );
    $string = preg_replace( '/-$/',"",$string );
    $string = str_replace( '-'," ",$string );
    $string = str_replace( ' ',"-",$string );
    return $string;
}

?>