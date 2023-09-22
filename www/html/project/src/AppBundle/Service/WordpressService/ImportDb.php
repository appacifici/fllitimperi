<?php

namespace AppBundle\Service\WordpressService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Environment as Environment;
use AppBundle\Menu\Menu;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpFoundation\Session\Session; 

/**
 * @author alessandro pacifici
 */
class ImportDb {
    
    protected $twig;    
    protected $container;    
    protected $requestStack;    
    protected $request;
    protected $versionSite;
    protected $positions = array( 'matchDetailTop', 'matchDetailBottom', 'leaderboard', 'columnRight1', 'menuTournaments1' );
    
    /**
     * Metodo costruttore della classe che instanzia anche la classe padre
     */
    public function __construct( 
            Environment $twig,
            RequestStack $requestStack,
            Container $container,
            ObjectManager $doctrine
    ) {
        
        $this->twig             = $twig;
        $this->requestStack     = $requestStack;
        $this->container        = $container;        
        $this->doctrine         = $doctrine;        
        $this->request          = $this->requestStack->getCurrentRequest();  
        $this->versionSite      = 'livescore24';
        session_start();
        $this->sessioneId = session_id();
    }
    
    public function init( 
        $wpHost, $wpUser, $wpPsw, $wpDb, $newHost, $newUser, $newPsw, $newDb, $limit, $idMin, $envPath = '/home/ale/site/calciomercato/branches/cmsadmin' ) {                 
        $this->wpDb  = new \PDO('mysql:host='.$wpHost.';', $wpUser, $wpPsw);
        $this->cmsDb = new \PDO('mysql:host='.$newHost.';', $newUser, $newPsw);
        
        $this->oldDb = $wpDb;
        $this->newDb = $newDb;
        $this->limit = $limit;
        $this->idMin = $idMin;
        $this->envPath = $envPath;
                
        $this->utility = new Utility (new \stdClass(), $this->newDb, $this->cmsDb, false);
        
//        $this->getCategories( );
//        $this->getSubcategories( );
//        $this->setMenuCategories( );
//        $this->setMenuSubcategories( );
//        $this->setUsers( );
//        $this->getCategoriesSubcategoriesPost( );
            $this->setPriorityImg();
    }
    
    public function getCategories() {
        $sql = "select * from $this->oldDb.aqwp_term_taxonomy "
                . "join $this->oldDb.aqwp_terms on aqwp_terms.term_id = aqwp_term_taxonomy.term_id  where taxonomy = 'category' and parent = 0";
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        
        foreach( $results AS $result ) {
            
            $name = explode( '-', $result->name );
            $nameCat = $name[0];
            $metaTile = !empty( $name[1] ) ? $name[1] : "";
            
            $query = 'INSERT INTO '.$this->newDb.'.categories ( last_db_id,last_term_id, name, name_url, meta_title, meta_keyword, meta_description, bg_color )
                    VALUES (
                        '.$this->cmsDb->quote( $result->term_taxonomy_id ).',
                        '.$this->cmsDb->quote( $result->term_id ).',
                        '.$this->cmsDb->quote( trim( $nameCat ) ).',
                        '.$this->cmsDb->quote( $result->slug ).',
                        '.$this->cmsDb->quote( trim( $result->name ) ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).'
                    )
            ';
            echo $query."\n";
            $this->cmsDb->query( $query );
        }
        
        print_r( $results );
    }
    
    public function getSubcategories() {
        $sql = "select * from $this->oldDb.aqwp_term_taxonomy "
                . "join $this->oldDb.aqwp_terms on aqwp_terms.term_id = aqwp_term_taxonomy.term_id  where taxonomy = 'category' and parent != 0";
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        foreach( $results AS $result ) {
            
            print_r( $result );
            
             $sql = "select * from $this->newDb.categories where last_term_id = $result->parent";
            $sth = $this->cmsDb->prepare( $sql );
            $sth->execute();
            $category = $sth->fetch( \PDO::FETCH_OBJ );
            $categoryId = !empty( $category ) ?  $category->id : 'NULL';
            PRINT_R( $category );
            
            $name = explode( '-', $result->name );
            $nameCat = $name[0];
            $metaTile = !empty( $name[1] ) ? $name[1] : "";
            
            $query = 'INSERT INTO '.$this->newDb.'.subcategories ( category_id,last_db_id,last_term_id, name, name_url, img, meta_title, meta_keyword, meta_description, meta_title_tm, meta_keyword_tm, meta_description_tm, bg_color, color )
                    VALUES (
                        '.$categoryId.',
                        '.$this->cmsDb->quote( $result->parent ).',
                        '.$this->cmsDb->quote( $result->term_taxonomy_id ).',
                        '.$this->cmsDb->quote( $nameCat ).',
                        '.$this->cmsDb->quote( $result->slug ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( $result->name ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).'
                    )
            ';
            echo $query."\n";
            $res = $this->cmsDb->query( $query );
            if( empty($res))
                echo $query.'<============'."\n";
        }
    }
    
    //id  | 
    public function setMenuCategories() {
        echo $sql = "select * FROM $this->newDb.categories ";
        $sth = $this->cmsDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        $x = 1;
        foreach( $results as $category ) {
            $query = 'INSERT INTO '.$this->newDb.'.menus ( order_menu, position, category_id, parent_id, subcategory_id, color )
                    VALUES (
                        '.$this->cmsDb->quote( $x ).',
                        '.$this->cmsDb->quote( 1 ).',
                        '.$this->cmsDb->quote( $category->id ).',
                        NULL,
                        NULL,
                        '.$this->cmsDb->quote( "" ).'
                    )
            ';
            echo $query."\n";
            $this->cmsDb->query( $query );
            $x++;
        }
    }
    
    public function setMenuSubcategories() {        
        echo $sql = "select * FROM $this->newDb.categories ";
        $sth = $this->cmsDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );
        $catMenu = array();
        foreach( $results as $category ) {
            $catMenu[$category->last_term_id] = $category;
        }
        
        print_R($catMenu);
        
        
        echo $sql = "select * FROM $this->newDb.subcategories ";
        $sth = $this->cmsDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );
        print_R( $results );
        
        
        $x = 1;
        foreach( $results as $subcategory ) {
            if( empty( $catMenu[$subcategory->last_db_id] ) )
                continue;
            
//           print_r( $catMenu[$subcategory->last_db_id]);
            
            $query = 'INSERT INTO '.$this->newDb.'.menus ( order_menu, position, category_id, parent_id, subcategory_id, color )
                    VALUES (
                        '.$this->cmsDb->quote( $x ).',
                        '.$this->cmsDb->quote( 1 ).',                        
                        NULL,
                        '.$this->cmsDb->quote( $catMenu[$subcategory->last_db_id]->id ).',
                        '.$this->cmsDb->quote( $subcategory->id ).',
                        '.$this->cmsDb->quote( "" ).'
                    )
            ';
            echo $query."\n";
            $this->cmsDb->query( $query );
            $x++;
        }
        
    }
    
    
    public function getCategoriesSubcategoriesPost() {
        $sql = "SELECT * FROM $this->oldDb.aqwp_posts
            WHERE aqwp_posts.post_status = 'publish' AND aqwp_posts.post_type = 'post' and id > $this->idMin
         order by id asc LIMIT $this->limit";
        
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );        
        
        foreach( $results as $article ) {
            $relation   = $this->getRelatioshipArticle( $article->ID );
            $userId     = $this->getUserArticle( $article->post_author );
            $this->insertArticle( $relation, $userId, $article );
            
        }
        
        
//        $sql = "select * from aqwp_term_taxonomy join aqwp_terms on aqwp_terms.term_id = aqwp_term_taxonomy.term_id  where term_taxonomy_id = ";
    }
    
    
    private function insertArticle ( $relation, $userId, $article ) {
        $status = $this->getState( $article->post_status );
        
        
        $lastUriWp = date( '/Y/m/d/', strtotime($article->post_date )).$article->post_name;
        
        $query = 'INSERT INTO '.$this->newDb.'.data_articles ( last_db_id, status, category_id, last_modify, create_at, publish_at, top_news, subcategory_one_id, subcategory_two_id, user_create_id, user_publish_id, last_uri_wp )
                    VALUES (
                        '.$this->cmsDb->quote( $article->ID ).',
                        '.$status.',
                        '. $relation['categoryId'] .',
                        '.$this->cmsDb->quote( $article->post_modified ).',
                        '.$this->cmsDb->quote( $article->post_date ).',
                        '.$this->cmsDb->quote( $article->post_date ).',
                        '.$relation['isTopNews'].',
                        '.$relation['subcategoryId'] .',
                        NULL,
                        '.$userId.',
                        '.$userId.',
                        '.$this->cmsDb->quote( $lastUriWp ).'
                    )
            ';
        
        
        
            $res = $this->cmsDb->query( $query );         echo $query . "\n";
            if( empty($res)) {
//                echo $query.'<============ERRORE'."\n";     
                return;
            }
            
            $lastArticleId = $this->cmsDb->lastInsertId();

            $article->post_content = preg_replace('#\s*\[caption[^]]*\].*?\[/caption\]\s*#is', '', $article->post_content);
            $subHeading = $this->utility->tagliaStringa( strip_tags( utf8_decode($article->post_content )), " ", 230);           
            $meta = $this->getMeta( $article, $subHeading );
            
            
            $query = 'INSERT INTO '.$this->newDb.'.content_articles ( 
                    data_article_id, title, sub_heading, body, meta_title, meta_description, video_file, video, signature, source )
                    VALUES (
                        '.$lastArticleId.',
                        '.$this->cmsDb->quote( $article->post_title ).',
                        '.$this->cmsDb->quote( $subHeading ).',
                        '.$this->cmsDb->quote( strip_tags( $article->post_content ) ).',
                        '.$this->cmsDb->quote( $meta['metaTitle'] ).',
                        '.$this->cmsDb->quote( $meta['metaDesc'] ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( "" ).'
                        
                    )
            ';
            
             $res = $this->cmsDb->query( $query );         echo $query . "\n";
            if( empty($res)) {
//                echo $query.'<============ERRORE'."\n";     
                return;
            }
            $this->insertImages( $article->post_name, $lastArticleId, $article->ID );
    }
    
    private function insertImages(  $name, $lastArticleId, $lastWpID ) {
        echo $sql = "select * from $this->oldDb.aqwp_posts where post_parent = $lastWpID and post_type = 'attachment' limit 1 ";
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $res = $sth->fetch( \PDO::FETCH_OBJ );
        if( empty( $res ) ) 
            return false;
        
        $lastImage = $res->guid;
        
        
        $pathSmall = $this->container->getParameter( 'app.folder_img_small_write' );
        $smallWidth = $this->container->getParameter( 'app.img_small_width' );
        $smallHeight = $this->container->getParameter( 'app.img_small_height' );
        
        $pathMedium = $this->container->getParameter( 'app.folder_img_medium_write' );
        $mediumWidth = $this->container->getParameter( 'app.img_medium_width' );
        $mediumHeight = $this->container->getParameter( 'app.img_medium_height' );
        
        $pathBig = $this->container->getParameter( 'app.folder_img_big_write' );
        $bigWidth = $this->container->getParameter( 'app.img_big_width' );
        $bigHeight = $this->container->getParameter( 'app.img_big_height' );
        
        
        $tempDir = '/tmp/';

        //
        $myFile = array();
        $myFile['name'][0]      = $lastImage;
        $myFile['tmp_name'][0]  = $lastImage;        
        $myFile['type'][0]      = $this->utility->myGetTypeImg( $lastImage );
        
        try {
            $foto1 = $this->utility->myUpload($this->cmsDb, $myFile, $pathSmall, $tempDir, $smallWidth, $smallHeight, $this->newDb, 'images', $this->sessioneId);      
            $foto2 = $this->utility->myUpload($this->cmsDb, $myFile, $pathMedium, $tempDir, $mediumWidth, $mediumHeight, $this->newDb, 'images', $this->sessioneId);
            $foto3 = $this->utility->myUpload($this->cmsDb, $myFile, $pathBig, $tempDir, $bigWidth, $bigHeight, $this->newDb, 'images', $this->sessioneId);
        } catch (Exception $e) {
//            php bin/console importDbWordpress 84.33.192.212 migrator y3x9HZdet chedonna_wp 127.0.0.1 root YcPfORBz chedonna 15000 157877 /home/pros/site/cmsadmin  -vvvphp bin/console importDbWordpress 84.33.192.212 migrator y3x9HZdet chedonna_wp 127.0.0.1 root YcPfORBz chedonna 15000 157877 /home/pros/site/cmsadmin  -vvv
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        if( empty( $foto1 ) ||  empty( $foto1['foto'] ) ||  empty( $foto1['foto'][0] ) ) {
            return;
        }
            
        $query = 'INSERT INTO '.$this->newDb.'.images ( 
                src, width_small, height_small, width_medium, height_medium, width_big, height_big, titleImg )
                VALUES (
                    '.$this->cmsDb->quote( $foto1['foto'][0] ).',
                    '.$this->cmsDb->quote( $foto1['dim'][0]['width'] ).',
                    '.$this->cmsDb->quote( $foto1['dim'][0]['height'] ).',
                    '.$this->cmsDb->quote( $foto2['dim'][0]['width'] ).',
                    '.$this->cmsDb->quote( $foto2['dim'][0]['height'] ).',
                    '.$this->cmsDb->quote( $foto3['dim'][0]['width'] ).',
                    '.$this->cmsDb->quote( $foto3['dim'][0]['height'] ).',
                    '.$this->cmsDb->quote( $name ).'

                )
        ';
            
        echo $query."\n";
        $res = $this->cmsDb->query( $query );
        
        if( empty( $res ) ) {
            echo $query.' '.$lastArticleId.'.<============ERRORE'."\n";
        } else {            
            $imageId = $this->cmsDb->lastInsertId();
            
            $query = 'INSERT INTO '.$this->newDb.'.images_data_articles ( 
                    image_id, data_article_id )
                    VALUES (
                        '.$this->cmsDb->lastInsertId().',
                        '.$lastArticleId.'                                              
                    )
            ';

            $res = $this->cmsDb->query( $query );
            if( empty($res)) {
                echo 'nome2 ===>'.$name."\n";
                print_R( $this->cmsDb->errorInfo() );
                echo $query.'<============ERRORE5'."\n";
            }
            
            
            $sql = 'update '.$this->newDb.'.data_articles set priorityImg_id = '.$imageId.' WHERE id = '.$lastArticleId;
            echo $sql."\n";
            $res = $this->cmsDb->query( $sql );
            if( empty($res)) {
                echo 'nome2 ===>'.$name."\n";
                print_R( $this->cmsDb->errorInfo() );
                echo $query.'<============ERRORE5'."\n";
            }
            
        }
    }
    
    private function getState( $status ) {
        switch ( $status ) {
            case 'auto-draft':
            case 'draft':
            case 'future': 
                return 2;
            break;
            case 'publish': 
                return 1;
            break;
            case 'inherit': 
            case 'private': 
                return 0;
            break;
        }
    }
    
    private function getMeta( $article, $subHeading ) {
         $sql = "select * from $this->oldDb.aqwp_postmeta where post_id = $article->ID and meta_key = '_yoast_wpseo_title' ";
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $res = $sth->fetch( \PDO::FETCH_OBJ );
        
        $metaTitle = $article->post_title;
        if( !empty( $res ) )
            $metaTitle = $res->meta_value;
        
        $sql = "select * from $this->oldDb.aqwp_postmeta where post_id = $article->ID and meta_key = '_yoast_wpseo_metadesc' ";
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $res = $sth->fetch( \PDO::FETCH_OBJ );
        
        $metaDesc = $subHeading;
        if( !empty( $res ) )
            $metaDesc = $res->meta_value;
        
        return array( 'metaTitle' => $metaTitle, 'metaDesc' => $metaDesc);
    }    
    
    private function getUserArticle ( $userId ) {
        $sql = "select * FROM $this->newDb.users where last_db_id=$userId";
        $sth = $this->cmsDb->prepare( $sql );
        $sth->execute();
        $user = $sth->fetch( \PDO::FETCH_OBJ );
        $id = false;
        if( !empty( $user ) )
            $id = $user->id;
        
        return $id;
    }
    
    /**
     * Recupera categoria e sottogategoria di un singolo articolo
     * @param type $id
     * @return type
     */
    private function getRelatioshipArticle( $id ) {
        $sql = "select * FROM $this->newDb.categories ";
        $sth = $this->cmsDb->prepare( $sql );
        $sth->execute();
        $categories = $sth->fetchAll( \PDO::FETCH_OBJ );
        $catMenu = array();
        foreach( $categories as $category ) {
            $catMenu[$category->last_db_id] = $category;
        }        
        
        $sql = "select * FROM $this->newDb.subcategories ";
        $sth = $this->cmsDb->prepare( $sql );
        $sth->execute();
        $subcategories = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        
        $subcatMenu = array();
        foreach( $subcategories as $subcategory ) {
            $subcatMenu[$subcategory->last_term_id] = $subcategory;
        }        
        
        $sql = "select * from $this->oldDb.aqwp_term_relationships where object_id = $id";
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );   
        
        $categoryId = 'NULL';
        $subcategoryId = 'NULL';
        $isTopNews = 0;
        
        foreach( $results as $cat ) {              
            
            if( !empty( $catMenu[$cat->term_taxonomy_id] ) ) {
                $categoryId = $catMenu[$cat->term_taxonomy_id]->id; 
                
            } else if( !empty( $subcatMenu[$cat->term_taxonomy_id] ) ) {
                $subcategoryId = $subcatMenu[$cat->term_taxonomy_id]->id; 
            } else if ( $cat->term_taxonomy_id == 87 ) {
                $isTopNews = true;
            }
                
        }
        
        return array( 'categoryId' => $categoryId, 'subcategoryId' => $subcategoryId, 'isTopNews' => $isTopNews );
    }
    
    public function setUsers() {
        $sql = "SELECT * FROM $this->oldDb.aqwp_users";
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );   
        
        foreach( $results AS $result ) {
            $query = 'INSERT INTO '.$this->newDb.'.users ( name, surname, email, username, password, role, canc, close, last_db_id )
                    VALUES (
                        '.$this->cmsDb->quote( $result->display_name ).', 
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( $result->user_email ).',
                        '.$this->cmsDb->quote( $result->user_login ).',
                        '.$this->cmsDb->quote( md5("benvenutoutente") ).',
                        NULL,
                        NULL,
                        NULL,
                        '.$this->cmsDb->quote( $result->ID ).'
                    )
            ';
            echo $query."\n";
            $this->cmsDb->query( $query );
        }
        
        $sql = "SELECT * FROM $this->oldDb.aqwp_users";
        $sth = $this->wpDb->prepare( $sql );
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );   
        
         foreach( $results AS $result ) {
            $query = 'INSERT INTO '.$this->newDb.'.external_users ( name, surname, email, username, password, register_at,ext_user_code )
                    VALUES (
                        '.$this->cmsDb->quote( $result->display_name ).', 
                        '.$this->cmsDb->quote( "" ).',
                        '.$this->cmsDb->quote( $result->user_email ).',
                        '.$this->cmsDb->quote( $result->user_login ).',
                        '.$this->cmsDb->quote( md5("benvenutoutente" ) ).',
                        '.$this->cmsDb->quote(date("Y-m-d H:i:s")).', 
                        '.$this->cmsDb->quote(md5( $result->user_email.date("Y-m-d H:i:s").$result->display_name)).'
                    )
            ';
            echo $query."\n";
            $this->cmsDb->query( $query );
        }
        
    }
        
    private function setPriorityImg() {
        echo 'ENTRO';
        $sth = $this->cmsDb->prepare("select * from '.$this->newDb.'.images_data_articles");
        $sth->execute();
        $results = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        foreach( $results AS $result ) {
            $query = 'UPDATE '.$this->newDb.'.data_articles SET priorityImg_id = '.$result->image_id.
                     ' WHERE '.$result->data_article_id.' = id';
            echo $query."\n";
            $this->cmsDb->query( $query );
        }

    }
    
    
}




























class Utility {

	private $soe;
	private $db;
	private $myDb;
	private $mySql;
	private $sq;
	private $config;

	/**
	 * Metodo costruttore della classe
	 * @param object $siteObjectsElements
	 * @param string $dbName
	 * @param object $mySql
	 * @param object $sq 
	 */
	function __construct($siteObjectsElements, $dbName, $mySql, $sq) {
//		$this->memcache = $siteObjectsElements->memcache;
//		$this->myDb = $siteObjectsElements->myDb;
		$this->memcache = false;
//		$this->myDb = $siteObjectsElements->myDb;
		$this->mySql = $mySql;
		$this->db = $dbName;
		$this->sq = $sq;
//		$this->config = $siteObjectsElements->config;
	}
	
	/**
	 * Fa lo callMapFunction per ogni elemento dell'array
	 * @param type $value
	 * @return type
	 */
	function callMapFunction( $value ) {		 		
		if ( empty( $this->callback ) )
			die( 'Inserire la callback' );
		
		$callback = $this->callback;
		$value = is_array( $value ) ? array_map( array( $this, 'callMapFunction' ), $value ) : $callback( $value );
		return $value;
	}
	
	function checkSession() {
		$sessionID = session_id();
		$sessionStatus = 0;
		$hash = md5("sessioni_" . $sessionID);
		$cache = $this->mySql->getCache($hash);

		$sessionStatus = false;
		if ($cache)
			$sessionStatus = true;
		return $sessionStatus;
	}

	function destroySession() {
		session_start();
		$sessionID = session_id();
		$hash = md5("sessioni_" . $sessionID);
		$this->mySql->deleteCache($hash);
		session_destroy();
		session_unset();
	}

	function sessionCachedAPC($sessionID, $sessionArray = array(), $ttl = 3600) {
		$hash = md5("sessioni_" . $sessionID);
		$cache = $this->mySql->getCache($hash);
		if (!$cache) {
			if ($this->mySql->setCache($hash, serialize($sessionArray), $timeout)) {
				return $sessionArray;
			}
		}
		return unserialize($cache);
	}
	
	/**
	 * Retrieves and returns the IP address of the current user
	 */
	function getClientIP() {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$forwardedip = getenv("HTTP_X_FORWARDED_FOR");
			list($ip, $ip2, $ip3, $ip4) = split(",", $forwardedip);
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} elseif (getenv("REMOTE_ADDR")) {
			$ip = getenv("REMOTE_ADDR");
		}
		$_SESSION["ip"] = $ip;
		return $ip;
	}

	// crypt function
	function easy_crypt($string, $key) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
		$string = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $string, MCRYPT_MODE_CBC, $iv);
		return array(base64_encode($string), base64_encode($iv));
	}

	// decrypt function
	function easy_decrypt($cyph_arr, $key) {
		$out = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, base64_decode($cyph_arr[0]), MCRYPT_MODE_CBC, base64_decode($cyph_arr[1]));
		return trim($out);
	}

	function cripta($stringa, $key) {
		global $default;
		$key = $key;
		if (is_array($stringa)) {
			$str = serialize($stringa);
		} else {
			$str = $stringa;
		}
		$cyph = $this->easy_crypt($str, $key);
		$crypted = urlencode(base64_encode(serialize($cyph)));
		return $crypted;
	}

	function decripta($stringa, $key) {
		global $default;
		$key = $key;
		$crypted = unserialize(base64_decode(urldecode($stringa)));
		$decryted = $this->easy_decrypt($crypted, $key);
		if (@unserialize($decryted) !== false) {
			return unserialize($decryted);
		} else {
			return $decryted;
		}
	}

	function errorLog($stringa) {
		global $default;
		$fileName = $default->tempDir . "/myError.log";
		$fp = @fopen($fileName, "a");
		@fwrite($fp, "$stringa\n");
		@fclose($fp);
	}

	function php_multisort($data, $keys) {
		// List As Columns
		foreach ($data as $key => $row) {
			foreach ($keys as $k) {
				$cols[$k['key']][$key] = $row[$k['key']];
			}
		}
		// List original keys
		$idkeys = array_keys($data);
		// Sort Expression
		$i = 0;
		foreach ($keys as $k) {
			if ($i > 0) {
				$sort.=',';
			}
			$sort.='$cols[' . $k['key'] . ']';
			if ($k['sort']) {
				$sort.=',SORT_' . strtoupper($k['sort']);
			}
			if ($k['type']) {
				$sort.=',SORT_' . strtoupper($k['type']);
			}
			$i++;
		}
		$sort.=',$idkeys';
		// Sort Funct
		$sort = 'array_multisort(' . $sort . ');';
		@eval($sort);
		// Rebuild Full Array
		foreach ($idkeys as $idkey) {
			$result[$idkey] = $data[$idkey];
		}
		return $result;
	}
    
    function array_sort($array, $on, $order=SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
    
    
	function variabileVideo($video) {
		preg_match('@.*v/([a-zA-Z0-9\_\-]*)&.*$@', $video, $matches);
		$idVideo = str_replace(".", "", $matches[1]);
		if (!$idVideo) {
			preg_match('@.*v=([a-zA-Z0-9\_\-]*)\n?.*$@', $video, $matches);
			$idVideo = str_replace(".", "", $matches[1]);
		}
		return $idVideo;
	}

	function resizeImg($maxWidth, $maxHeight, $widthFoto, $heightFoto, $style = 4) {
		// horizontale
		//echo $widthFoto.' '.$heightFoto.'<===<br>';
		if ($widthFoto >= $heightFoto && $widthFoto > $maxWidth) {
			$ratio = $maxWidth / $widthFoto;
			$newWidth = round($widthFoto * $ratio);
			$newHeight = round($heightFoto * $ratio);
			$ratio = 1;
			// dopo resize, altezza + grande del maxHeight
			if ($newHeight > $maxHeight) {
				$ratio = $maxHeight / $newHeight;
			}
			// verticale
		} else if ($heightFoto >= $widthFoto && $heightFoto > $maxHeight) {
			$ratio = $maxHeight / $heightFoto;
			$newWidth = round($widthFoto * $ratio);
			$newHeight = round($heightFoto * $ratio);
			$ratio = 1;
			// dopo resize, larghezza + grande del maxWidth

			if ($newWidth > $maxWidth) {
				$ratio = $maxWidth / $newWidth;
			}
		} else {
			$ratio = 1;
			$newWidth = $widthFoto;
			$newHeight = $heightFoto;
		}

		$newWidth = round($newWidth * $ratio);
		$newHeight = round($newHeight * $ratio);

		$margin = round($maxHeight - $newHeight);
		$margin = round($margin / 2);

		$marginLeft = round($maxWidth - $newWidth);
		$marginLeft = round($marginLeft / 2);

		if ($style == 1) {
			return "width:" . $newWidth . "px; height:" . $newHeight . "px";
		} else if ($style == 2) {
			return "width:" . $newWidth . "px; height:" . $newHeight . "px; margin-top:" . $margin . "px";
		} else if ($style == 3) {
			return "width:" . $newWidth . "px; height:" . $newHeight . "px; margin-left:" . $marginLeft . "px";
		} else if ($style == 4) {
			return "width:" . $newWidth . "px; height:" . $newHeight . "px;margin-top:" . $margin . "px; margin-left:" . $marginLeft . "px";
		} else if ($style == 5) {
            $params = new stdClass();
			$params->width = $newWidth;
			$params->height = $newHeight;
			$params->marginTop = $margin;
			$params->marginLeft = $marginLeft;
			$params->maxWidth = $maxWidth;
			$params->maxHeight = $maxHeight;
			return $params;
		} else {
			return array($newWidth, $newHeight);
		}
	}

	public function tagliaStringa($stringa, $carattere, $max_char) {
		$ptz = 0;
		$car = '';
		if ($carattere == ". ") {
			$ptz = 1;
			$car = ".";
		}
		$strLen = strlen($stringa);
		if ($strLen > $max_char) {
			$stringa_tagliata = substr($stringa, 0, $max_char);
			$last_space = strrpos($stringa_tagliata, $carattere);
			if ($last_space == 0 || $last_space == "") {
				$last_space = strrpos($stringa_tagliata, ".</p>");
			}
			$stringa_ok = substr($stringa_tagliata, 0, $last_space);
			$finalString = substr($stringa, $last_space + $ptz, $strLen);
			$finalStringLen = $strLen - $last_space;
			$testoT = stripslashes($stringa_ok) . $car;
		} else {
			$testoT = stripslashes($stringa);
		}
		return $testoT;
	}

	/**
	 * Metodo che effettua il rederect
	 * @param string $url
	 * @param int $type
	 */
	public function redirectUrl($url, $type) {
		if ($type == '301')
			header("HTTP/1.1 301 Moved Permanently");

		if ($type == '404')
			header("HTTP/1.0 404 Not Found");

		header("Location: " . $url);
		exit;
	}

	/**
	 * Metodo che determina se la visita viene dalla ricerca di google
	 * @return boolean
	 */
	public function isGoogle($referer = false) {
		if (empty($referer))
			return false;

		$HTTP_REFERER = explode("?", $referer);
		$referer = $HTTP_REFERER[0];
		if (preg_match_all("/\bgoogle\b/i", $referer, $matches))
			return true;
		return false;
	}

	function internalReferer($referal) {
		$name = $this->config->nameSite;
		if (empty($referal) || preg_match("#$name#", strtolower($referal)))
			return true;
		return false;
	}

	/**
	 * Metodo che derermina se la visita proviene da uno spider
	 * @param string $agent
	 * @return boolean
	 */
	public function isSpider($agent) {
		if (preg_match("#googlebot#", strtolower($agent)))
			return true;
		if (preg_match("#bingbot#", strtolower($agent)))
			return true;
		if (preg_match("#ahrefsbot#", strtolower($agent)))
			return true;
		if (preg_match("#msnbot#", strtolower($agent)))
			return true;
		if (preg_match("#surveybot#", strtolower($agent)))
			return true;
		if (preg_match("#yandexbot#", strtolower($agent)))
			return true;
		if (preg_match("#facebookexternalhit#", strtolower($agent)))
			return true;
	}

	function toItalianDate($date, $readTime = false) {
		$time = '';
		if ($readTime) {
			$token = explode(' ', $date);
			$date = trim($token[0]);
			$time = ' ' . trim($token[1]);
			unset($token);
		}
		$token = explode('-', $date);
		return $token[2] . '-' . $token[1] . '-' . $token[0] . $time;
	}

	/**
	 * Metodo che ritorna la versione singolare della parola
	 * @param type $name
	 * @return type
	 */
	public function getSingolare($name) {
		$name = strtolower($name);
		$a1 = array(
			'abiti',
		);
		$a2 = array('abito');
		return trim(str_replace($a1, $a2, $name));
	}

	/**
	 * Metodo che formatta la descrizione del dettaglio prodotto
	 * @param type $desc
	 * @return type
	 */
	public function formatDescription($desc) {
		return $desc;
		$init = array(
			'...', '.', '|'
		);
		$final = array(
			'.', '.<br /><br />', '<br />'
		);
		$desc = str_replace($init, $final, $desc);
		return $desc;
	}

	public function replaceToMetaProperty($meta) {
		return str_replace('"', '', $meta);
	}

	/**
	 * Metodo che ricava il dominio di terzo livello
	 * @param type $domain
	 * @return boolean
	 */
	public function getThirdDomain($domain) {
		$data = explode(".", $domain);
		$tot = count($data);
		if ($tot == 3 || $tot == 4) {
			$i = 0;

			if ($data[0] == 'trunk' || $data[0] == 'branch' || $data[0] == 'staging' || $data[0] == 'prod')
				$i = 1;

			if (empty($data[$i]) || $data[$i] == $this->config->baseNameSite || $data[$i] == 'trunk' || $data[$i] == 'branch' || $data[$i] == 'www')
				return false;

			return $data[$i];
		}
		return false;
	}

	/**
	 * Metodo che riceva la copia su cui si sta lavorando [ Dev | Staging | Prod ]
	 */
	public function getEnviroment($domain) {
		$data = explode("-", $domain);
		if ($data[0] == 'trunk' || $data[0] == 'branch')
			return $data[0];
		return false;
	}

	function getTypeImg($type) {
		$typeImg = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP);
		$formato = array(
			IMAGETYPE_GIF => 'image/gif',
			IMAGETYPE_JPEG => 'image/jpeg',
			IMAGETYPE_PNG => 'image/png',
			IMAGETYPE_BMP => 'image/bmp');
		if (in_array($type, $typeImg)) {
			return $formato[$type];
		} else {
			return 'image/jpeg';
		}
	}

    
    //$pdo, $myFile, $pathDirectoryWrite, $tempDir, dbName, $table, $sessioneId, $idFile = -1, $oldVideo = array(), $nameFormat = ''
    function myUploadFiles( $params ) {
        $goUpload = true;		
		$myFiles = null;
        $totFile = 1;	
        $formatsVideo = array( 'video/mp4', 'video/mov', 'video/quicktime', 'video/avi' );
        
        for ( $i = 0; $i < count( $params->files['name'] ); $i++ ) {               
            if ( empty( $params->files["name"][$i] ) || !in_array( $params->files["type"][$i], $formatsVideo ) )
                continue;
            
            $filePathTmp = $params->files['tmp_name'][$i];
			$fileType = $params->files['type'][$i];
			
            if ( empty( $params->oldFiles ) || empty( $params->oldFiles[$i] ) ) {
                if ( empty( $params->fileId ) ) {
                    $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='" . $params->dbName . "' AND TABLE_NAME='" . $params->tableDb . "'";
                    $statement = $params->mySql->prepare( $sql, array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ) );
                    $e = $statement->execute();
                    if ( !$e )
                        return false;
                    $row = $statement->fetch( PDO::FETCH_ASSOC );
                    $fileId = $row["AUTO_INCREMENT"];
                } else {
                    $fileId = $params->fileId;
                }
                
                
                $indexFile = $totFile > 1 ? "_" . $i : '';
                if (!empty( $params->nameFormat ) )
                    $newFilePath = $fileId . $indexFile . $params->nameFormat . ".mp4";
                else
                    $newFilePath = $fileId . $indexFile . ".mp4";

                $hashImg = md5( $params->sessionId . $newFilePath . $i );
                $dir = "";
                
                for ( $o = 0; $o < 3; $o++ ) {
                    $dir .= $hashImg[$o] . "/";
                }
                
                $myPath = $params->pathWrite . $dir . $newFilePath;
                if ( !file_exists( dirname( $myPath ) ) ) {
                    mkdir(dirname($myPath), 0777, 1);
                }
                $myFiles[$i] = $dir . $newFilePath;
                
            } else {
                $fileId = $params->fileId;
                $myPath = $params->pathWrite . $params->oldFiles[$i];

                if ( !file_exists( dirname( $myPath ) ) ) {
                    mkdir( dirname( $myPath ), 0777, 1 );
                }
                $myFiles[$i] = $params->oldFiles[$i];
            }			
            
            if( in_array( $params->files["type"][$i], $formatsVideo ) ) {
                //AAC/H.264
                rename( $filePathTmp, $myPath.'_avconv' );                
                //exec( 'avconv -i '.$myPath.'_avconv'.' -codec copy  "'.$myPath.'"' );
                exec( "avconv -i '{$myPath}_avconv' -vcodec libx264 -preset ultrafast -vprofile baseline -acodec aac -strict experimental -r 24 -b 255k -ar 44100 -ab 59k '{$myPath}'" );
                //exec( 'ffmpeg -i '.$myPath.'_avconv'.' -vcodec libx264 -vprofile high -preset slow -b:v 500k -maxrate 500k -bufsize 1000k -vf scale=-1:480 -threads 0 -acodec libvo_aacenc -b:a 128k -pix_fmt yuv420p "'.$myPath.'"' );
                //avconv -i infile.mp4 -c:a copy -c:v copy outfile.avi
                //avconv -i 3.mp4 -s 100x100 -strict experimental "4.mp4"
            } else {
                rename( $filePathTmp, $myPath );
            }
            return $myFiles;
        }
    }
    
	/*	 * **********************************************************************************************************************************
	 * * FUNZIONE PER L'UPLOAD DELLE IMMAGINI SUL SITO
	 * * PARAMETRI:
	 * *              $myFile(ARRAY) = ARRAY CONTENENTE I FILE DA CARICARE
	 * *              $totFile(INT) = MASSIMO FILE DA CARICARE MASSIMO 5 CONTEMPORANEI
	 * *              $pathDirectoryWrite(STRING) = PATH CARTELLA DI SCRITTURA PER I FILE
	 * *              $tempDir(STRING) =PATH CARTELLA TEMPORANEA DI SCRITTURA PER I FILE
	 * *              $width(INT) = LARGHEZZA MASSIMA CONSENTITA
	 * *              $height(INT) = ALTEZZA MASSIMA CONSENTITA
	 * *              $db(STRING) = DATABASE ATTUALE
	 * *              $table(STRING) = TABELLA DI LAVORO PER RECUPER NEXT ID DA ASSEGNARE ALLA FOTO
	 * *              $sessioneId(STRING) = SESSION ID PER NOME FOTO TEMPORANEA
	 * *              $idTipo(INT) = SE -1 SI TRATTA DI UN NUOVO FILE, SE > -1 SI TRATTA DI UNA SOSTITUZIONE DI FOTO
	 * *********************************************************************************************************************************** */

	function myUpload($pdo, $myFile, $pathDirectoryWrite, $tempDir, $width, $height, $db, $table, $sessioneId, $idTipo = -1, $oldFoto = array(), $nameFormat = '') {		
		$goUpload = true;
		$totFile = 1;
		$arrayFormati = array('image/gif', 'image/png', 'image/jpeg', 'image/jpeg', 'image/jpeg');
		$aDimension = array('small', 'medium', 'large');
		$myFoto = null;
		$dim = null;
		
		for ($x = 0; $x < $totFile; $x++) {
			//if ($myFile["name"][$x] !='' && in_array($myFile["type"][$x],$arrayFormati)) {
			$fileFoto['name'][$x] = $myFile["name"][$x];
			$fileFoto['tmp_name'][$x] = $myFile["tmp_name"][$x];
			$fileFoto['type'][$x] = $myFile["type"][$x];
			//}
		}
        
		for ($i = 0; $i < $totFile; $i++) {
			//foreach ($fileFoto["name"] AS $foto) {
			$imagepath = $fileFoto['tmp_name'][$i];
			$imageType = $fileFoto['type'][$i];
			if ($imagepath) {
				$myTempImgName = $tempDir . $sessioneId . rand() . ".jpg";
				if ( $dim[$i] = $this->resizeConvertImage($imagepath, $imageType, $width, $height, "jpg", $myTempImgName, $pathDirectoryWrite)) {                    
					if( empty( $dim[$i] ) )
						return false;
					
					if (empty($oldFoto) || !$oldFoto[$i]) {
						if ($idTipo == -1) {
							$sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='" . $db . "' AND TABLE_NAME='" . $table . "'";
							$statement = $pdo->prepare($sql, array( \PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
							$e = $statement->execute();
							if (!$e)
								return false;
							$row = $statement->fetch(\PDO::FETCH_ASSOC);
							$immagineId = $row["AUTO_INCREMENT"];
						} else {
							$immagineId = $idTipo;
						}
						$okIdArticolo = true;
						$indice_foto = $totFile > 1 ? "_" . $i : '';
						if (!empty($nameFormat))
							$newImagePath = $immagineId . $indice_foto . $nameFormat . ".jpg";
						else
							$newImagePath = $immagineId . $indice_foto . ".jpg";

						$hashImg = md5($sessioneId . $newImagePath . $i);
						$dir = "";
						for ($o = 0; $o < 4; $o++) {
							$dir .= $hashImg[$o] . "/";
						}
						$myPath = $pathDirectoryWrite . $dir . $newImagePath;
						if (!file_exists(dirname($myPath))) {
							mkdir(dirname($myPath), 0777, 1);
						}
						$myFoto[$i] = $dir . $newImagePath;
					} else {
						$immagineId = $idTipo;
						$myPath = $pathDirectoryWrite . $oldFoto[$i];

						if (!file_exists(dirname($myPath))) {
							mkdir(dirname($myPath), 0777, 1);
						}
						$myFoto[$i] = $oldFoto[$i];
					}                    
					rename($myTempImgName, $myPath);
                    $command1 = 'jpegoptim '.$myPath.' -p -o -m100 --strip-all';
                    try {
                        exec( $command1 );
                    } catch ( Exception $e ) {
                        ;
                    }
				}
			}
		}
		return array("foto" => $myFoto, "dim" => $dim);
	}

	public function setTransparency($new_image, $image_source) {
		$transparencyIndex = @imagecolortransparent($image_source);
		$transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
		if ($transparencyIndex >= 0) {
			$transparencyColor = @imagecolorsforindex($image_source, $transparencyIndex);
		}
		$transparencyIndex = @imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
		@imagefill($new_image, 0, 0, $transparencyIndex);
		@imagecolortransparent($new_image, $transparencyIndex);
	}

	public function resizeConvertImage2($path, $typeIn, $maxWidth, $maxHeight, $typeOut = "gif", $pathToOutput, $percorsoTrim = '', $fileLocale = true) {
        
        $width = 30;
        $height = 48;
        $scale = 1;
        $image = $path;
        
        $size = getimagesize($path);        
        
        $dst_w = $maxWidth; $dst_h = $maxHeight;
        
        $src_image = @imagecreatefrompng($path);
        
        list($imagewidth, $imageheight, $imageType) = getimagesize($path);
        $imageType = image_type_to_mime_type($imageType);
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        
        
        $dst_x=0;
        $dst_y=0;
        if( $size[0]>$maxWidth or $size[1]>$maxHeight )
        {
        $centerX = $size[0]/2;
        $centerY = $size[1]/2;
        if( $size[0] > $size[1] ){
        $src_y = 0;
        $src_x = $centerX-$centerY;
        $src_h = $size[1];
        $src_w = $size[1];
        }
        else{
        $src_x = 0;
        $src_y = $centerY-$centerX;
        $src_w = $size[0];
        $src_h = $size[0];
        }
        }
        
        $dst_image = imagecreatetruecolor($newImageWidth,$newImageHeight);

        imagealphablending($dst_image, false);
        imagesavealpha($dst_image,true);
        $transparent = imagecolorallocatealpha($dst_image, 255, 255, 255, 127);
        imagefilledrectangle($dst_image, 0, 0, $dst_w, $dst_h, $transparent);
        
        imagecopyresampled ( $dst_image , $src_image , $dst_x , $dst_y , $src_x , $src_y , $dst_w , $dst_h , $src_w , $src_h );
     
        echo $path;
        
         @imagepng($dst_image,$pathToOutput);
        
        rename( $pathToOutput,  '/home/ale/site/calciomercato/branches/frontend/web/imagesTeams/prova.png' );
        exit;
        chmod($image, 0777);
        return $image;
        
        exit;
        
    }
    
	public function resizeConvertImage($path, $typeIn, $maxWidth, $maxHeight, $typeOut = "gif", $pathToOutput, $percorsoTrim = '', $fileLocale = true) {
		$arrayFormati = array('gif' => 'image/gif', 'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg');
		$sessionId = substr(session_id(), 1, 10);
		
		$pathToOutput = $pathToOutput == "" ? $default->fileTMP . "/temp.jpg" : $pathToOutput;
		
        
        switch ( $typeIn ) {
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/pjpeg':
				$im = @imagecreatefromjpeg( $path );
				break;
			case 'image/gif':
				$im = @imagecreatefromgif( $path );
				break;
			case 'image/png':
			case 'image/x-png':
				$im = @imagecreatefrompng( $path );
				break;
			default:
				return false;
		}
		
		if( empty( $im ) ) {
			echo "Utility.class.php error cropImage non valid image im for: ".$path;
			return false;
		}
		
		$imgw = imagesx( $im );
		$imgh = imagesy( $im );
		
//		$minW = $imgw;
//		$minH = $imgh;
//		$maxW = $maxH = 0;
//		
//		// Find the size of the borders
//        $top = 0;
//        $bottom = 0;
//        $left = 0;
//        $right = 0;
//        $bgcolor = 0xFFFFFF; // Use this if you only want to crop out white space
////        $bgcolor = imagecolorat( $im, $top, $left ); // This works with any color, including transparent backgrounds
//
//        
//        //top
//        for(; $top < $imgh; ++$top) {
//          for($x = 0; $x < $imgw; ++$x) {
//            if(imagecolorat($im, $x, $top) != $bgcolor) {
//               break 2; //out of the 'top' loop
//            }
//          }
//        }
//        //bottom
//        for(; $bottom < $imgh; ++$bottom) {
//          for($x = 0; $x < $imgw; ++$x) {
//            if(imagecolorat($im, $x, $imgh - $bottom-1) != $bgcolor) {
//               break 2; //out of the 'bottom' loop
//            }
//          }
//        }
//        //left
//        for(; $left < $imgw; ++$left) {
//          for($y = 0; $y < $imgh; ++$y) {
//            if(imagecolorat($im, $left, $y) != $bgcolor) {
//               break 2; //out of the 'left' loop
//            }
//          }
//        }
//        //right
//        for(; $right < $imgw; ++$right) {
//          for($y = 0; $y < $imgh; ++$y) {
//            if(imagecolorat($im, $imgw - $right-1, $y) != $bgcolor) {
//               break 2; //out of the 'right' loop
//            }
//          }
//        }

        
        if( $typeOut == 'png' ) {
            $dst_w = $imgw;
            $dst_h = $imgh;
        } else {
//            $dst_w = $imgw-($left+$right);
//            $dst_h = $imgh-($top+$bottom);
            
            $dst_w = $imgw;
            $dst_h = $imgh;
        }
        
//        
        
        if ($dst_w >= $dst_h && $dst_w > $maxWidth) {
			$ratio = $maxWidth / $dst_w;
			// verticale
		} else if ($dst_h >= $dst_w && $dst_h > $maxHeight) {
			$ratio = $maxHeight / $dst_h;
		} else {
			$ratio = 1;
		}
		$dst_h = $dst_h * $ratio;
		$dst_w = $dst_w * $ratio;
        

        $dst_image = imagecreatetruecolor($dst_w,$dst_h);
        
        if( $typeOut == 'png' ) {
            imagealphablending($dst_image, false);
            imagesavealpha($dst_image,true);
            $transparent = imagecolorallocatealpha($dst_image, 255, 255, 255, 127);
            imagefilledrectangle($dst_image, 0, 0, $dst_w, $dst_h, $transparent);        
            imagecopyresampled ( $dst_image , $im , 0 , 0 , 0, 0, $dst_w , $dst_h , $imgw , $imgh );
        } else {            
//            imagecopy($dst_image, $im, 0, 0, $left, $top, imagesx($dst_image), imagesy($dst_image));
            imagecopyresampled ( $dst_image , $im , 0 , 0 , 0, 0, $dst_w , $dst_h , $imgw , $imgh );
        }
        
        switch($typeOut) {
            case 'jpg':
                    @imagejpeg($dst_image,$pathToOutput);
                    break;
            case 'gif':
                    @imagegif($dst_image,$pathToOutput);
                    break;
            case 'png':
                    @imagepng($dst_image,$pathToOutput);
                    break;
            default:
                    return false;
        }		             
        
        $dimensioni['width'] = $dst_w;
        $dimensioni['height'] = $dst_h;
        return $dimensioni;
    }
    
    function myGetTypeImg($img) {
		$formati = array(
			'gif' => 'image/gif',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'png' => 'image/png',
			'bmp' => 'image/bmp'
		);
		foreach ($formati AS $key => $formato) {
			if (preg_match_all("/\b" . $key . "\b/i", $img, $matches))
				return $formato;
		}
	}
    
    /**
	 * 
	 * @param type $source_file
	 * @return boolean
	 */
	static function cropImage( $source_file, $typeIn, $pathToOutput, $typeOut='jpg' ) {
		//$im = ImageCreateFromJpeg( $source_file );	
		
		switch ( $typeIn ) {
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/pjpeg':
				$im = @imagecreatefromjpeg( $source_file );
				break;
			case 'image/gif':
				$im = @imagecreatefromgif( $source_file );
				break;
			case 'image/png':
			case 'image/x-png':
				$im = @imagecreatefrompng( $source_file );
				break;
			default:
				return false;
		}
		
		if( empty( $im ) ) {
			echo "Utility.class.php error cropImage non valid image im for: ".$source_file;
			return false;
		}
		
		$imgw = imagesx( $im );
		$imgh = imagesy( $im );
		
		$minW = $imgw;
		$minH = $imgh;
		$maxW = $maxH = 0;
		
		for ($i = 0; $i < $imgw; $i++) {
			for ($j = 0; $j < $imgh; $j++) {

				// get the rgb value for current pixel
				$rgb = ImageColorAt( $im, $i, $j );
				// extract each value for r, g, b
				$r = ( $rgb >> 16 ) & 0xFF;
				$g = ( $rgb >> 8 ) & 0xFF;
				$b = $rgb & 0xFF;
				
				if ( ( $r + $g + $b ) < 730 ) {
					$maxW = max( $maxW, $i);
					$maxH = max( $maxH, $j);
					$minW = min( $minW, $i);
					$minH = min( $minH, $j);
					continue;
				}
			}
		}
		
		$destW = $maxW - $minW;
		$destH = $maxH - $minH;
		
		$image_resized = imagecreatetruecolor($destW, $destH);
		imagecopy( $image_resized, $im, 0, 0, $minW, $minH, $destW, $destH );
		
		//imagejpeg( $image_resized, $pathToOutput ); 
		
		
		
		return array( 'width' => $destW, 'height' => $destH, 'image' => $image_resized );
	}
	
	static function RGBHistogram( $source_file ) {
		$im = ImageCreateFromJpeg( $source_file );

		$imgw = imagesx( $im );
		$imgh = imagesy( $im );

		// n = total number or pixels

		$n = $imgw * $imgh;

		$histo = array();

		for ($i = 0; $i < $imgw; $i++) {
			for ($j = 0; $j < $imgh; $j++) {

				// prendo il valore rgb del pixel
				$rgb = ImageColorAt( $im, $i, $j );

				// estraggo i colori di r, g, b
				$r = ( $rgb >> 16 ) & 0xFF;
				$g = ( $rgb >> 8 ) & 0xFF;
				$b = $rgb & 0xFF;
				
				// approssimo il colore.
				$r = round( $r / 10 ) * 10;
				$g = round( $g / 10 ) * 10;
				$b = round( $b / 10 ) * 10;
				
				// get the Value from the RGB value
				$V = round( ( $r + $g + $b ) / 3 );
				
				// tolgo tutti i valori vicini al bianco.
				if ( $V >= 240 )
					continue;
				
				// add the point to the histogram
				$color = "{$r},{$g},{$b}";
				$histo[$color] += $V / $n;
			}
		}
		asort($histo);
		return $histo;
	}
	
	static function drawRGBHistogram( $histo ) {
		// histogram options
		$maxheight = 300;
		$barwidth = 5;
		
		// find the maximum in the histogram in order to display a normated graph
		$max = 0;
		$min = 100000000000;
		foreach( $histo as $value ) {
			$max = max( $max, $value );
			$min = min( $min, $value );
		}
		$mean = ( $max - $min ) / 2;
		$html = "<div style='border: 1px solid'>";
		foreach( $histo as $color => $value ) {
			$h = ( $value / $max ) * $maxheight;
			if ( $h > ( $maxheight * 0.1 ) )
				$html .= "<div style=\"width:{$barwidth}px; height:{$h}px; float: left; background: rgb({$color}); margin-left: 2px; border: 1px solid #000; \">&nbsp;</div>";
		}
		$html .= "<div style='clear:both;'></div>";
		$html .= "</div>";
		
		return $html;
	}
    
    
    
	/**
	 * Metodo che converte le stringhe che hanno charset differente dall'utf8 
	 * @param type $string
	 * @return type
	 */
	public function encodeAllCharsetToUTF8($string) {
		$encode = mb_detect_encoding($string);
		if ($encode != 'UTF-8') {
			try {
				$string = @iconv($encode, 'UTF-8', $string);
//				$string = utf8_encode( $string );
//				$string = iconv('ASCII', 'UTF-8//IGNORE', $string);
//				$string =  mb_convert_encoding( $string, $encode, 'UTF-8'); 
			} catch (Exception $e) {
				$string = utf8_encode($string);
			}
		}
		return $string;
	}

	/**
	 * Determina se una stringa è in utf8
	 * @return type
	 */
	public function isUTF8($string) {
		$encode = mb_detect_encoding($string);
		return ( $encode != 'UTF-8' ) ? false : true;
	}

	
    /**
	 * Metodo che concatena il path per la copia locale
	 * @param type $env
	 * @return type
	 */
	public function concatEnviromentUrl( $base = '' ) {
		$env = !empty( $_SERVER['HTTP_HOST'] ) ? $this->getEnviroment( $_SERVER['HTTP_HOST'] ) : false;
		return $env ? $env.'-' : $base;
	}
    
    public function getNameSmallImage( $img ) {
        return str_replace( array( '_small','_icon','_medium', '.jpg' ), array( '','','', '_small.jpg' ), $img ); 
    }
    
    public function getNameIconImage( $img ) {
        return str_replace( array( '_small','_icon','_medium', '.jpg' ), array( '','','', '_icon.jpg' ), $img ); 
    }
    
    public function getNameMediumImage( $img ) {
        return str_replace( array( '_small','_icon','_medium', '.jpg' ), array( '','','', '_medium.jpg' ), $img ); 
    }
   
    /**
     * Cerca una stringa all'interno di un array
     * @param type $haystack
     * @param type $needles
     * @return type
     */
    function strpos_array( $haystack, $needles ) {
        if ( is_array( $needles ) ) {
            foreach ( $needles as $str ) {
                if ( is_array( $str ) ) {
                    $pos = $this->strpos_array( $haystack, $str );
                } else {
                    $pos = strpos( $haystack, $str );
                }
                if ( $pos !== FALSE ) {
                    return $pos;
                }
            }
        } else {
            return strpos( $haystack, $needles );
        }
    }
    
    /**
     * funzione che traccia i tentativi di haking
     * @param type $stringa
     */
	public function saveToLogControlStringUser($stringa){
        require_once $this->config->pathSiteServer.'/lib/BusinessObjects/User.class.php';
        $user = new User( $this->mySql, $this->config, null, null  );
        $userData = $user->getUserData();
        
		$myIp = $_SERVER["REMOTE_ADDR"];
		$data = date("d-m-Y H:i:s");
		$myHost = $_SERVER["HTTP_HOST"];
		
        $stringa = str_replace( '[init]', '', $stringa);
		$stringa = preg_replace("/\s+/"," ",$stringa);
		$stringa = preg_replace("/\t+/"," ",$stringa);
		$stringa = preg_replace("/\n+/"," ",$stringa);
		$stringa = preg_replace("/\r+/"," ",$stringa);
		$stringa = trim($stringa);
        
        $textMail = "\nInserimento stringa bloccato sito:".$myHost." da parte dell'utente \nusername: ".$userData->username." \nuserId: ".$userData->userId." \ndata: ".$data." \nIP: ".$myIp." \ntesto ".$stringa."\n";
        $textMail .= "############################################################################################################################################"; 
		$h=fopen( $this->config->pathLog.'/controlStringUser'.$this->config->keySite.'.txt',"a");
		fwrite( $h, $textMail );
		fclose( $h );
		
        $textMail = "Inserimento stringa bloccato sito ".$myHost." da parte dell'utente \nusername: ".$userData->username." \nuserId: ".$userData->userId." \ndata: ".$data." \nIP: ".$myIp."  \ntesto: ".$stringa." ";     
        $to = 'aleweb87@gmail.com';
        $full_name = $this->config->nameSite;
        $from_mail = $full_name.'<'.$this->config->emailFrom.'>';
        $subject = 'Inserimento stringa bloccato';
        $message = $textMail;
        $headers = 'From: ' . $from_mail . "\r\n" .
            'Reply-To: noreply@eroticland.it' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail( $to, $subject, $message, $headers );
	}
    
}//End class


    function strpos_array($haystack, $needles) {
        if ( is_array($needles) ) {
            foreach ($needles as $str) {
                if ( is_array($str) ) {
                    $pos = strpos_array($haystack, $str);
                } else {
                    $pos = strpos($haystack, $str);
                }
                if ($pos !== FALSE) {
                    return $pos;
                }
            }
        } else {
            return strpos($haystack, $needles);
        }
    }
    
    function printr( $val ) {
        echo '<pre>';
        print_r( $val );
        echo '</pre>';
    }





