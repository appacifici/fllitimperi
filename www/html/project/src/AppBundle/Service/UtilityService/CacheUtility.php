<?php

namespace AppBundle\Service\UtilityService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class CacheUtility {
    
    protected $container;
    public    $phpCache;
    protected $typeLibrary = 'memcached';
    protected $phpCacheIsConnect = false;
    
    public function __construct( Container $container )  {                
        $this->container        = $container;
        $this->typeLibrary      = $this->container->getParameter( 'handler_cache' );
    }
    
    /**
     * Metodo che ritorna la connessione a memcached o a memcache in base al tipo di libreria
     * @return type
     */
    public function initPhpCache( $channel = 'sncredis' ) {        
//        if( empty( $this->phpCacheIsConnect ) ) {
            switch( $this->typeLibrary ) {
                case 'redis':
                    $this->startRedis( $channel );
                break;
                case 'memcached':
                    $this->startMemcached();
                break;
                case 'memcache':
                    $this->startMemcache();
                break;
            }
//        }
        return $this->phpCache;
    }
    
    /**
     * Metodo che chiude la connessione a memcached o a memcache  in base al tipo di libreria
     */
    public function closePhpCache() {
        switch( $this->typeLibrary ) {
            case 'memcached':
                $this->phpCache->quit();
            break;
            case 'memcache':
                $this->phpCache->close();
            break;
        }        
    }
    
    public function phpCacheGet( $key, $convert = true, $toArray = false ) {
        switch( $this->typeLibrary ) {
            case 'redis':                             
                $value = $this->phpCache->get( $key );
                if( $convert && $this->isJson( $value ) )
                    $value = json_decode ( $value, $toArray );     
                               
                    return $value;
                break;
            default:
                return $this->phpCache->get( $key );
            break;
        }
    }
    
    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    public function phpCacheSet( $key, $value, $ttl = 3600 ) {        
        switch( $this->typeLibrary ) {
            case 'redis':
                if( is_object($value) || is_array( $value ))
                    $value = json_encode ( $value );                
                
                return $this->phpCache->setEx( $key, $ttl, $value);
            break;
            case 'memcached':
                return $this->phpCache->set( $key, $value, $ttl );
            break;
            case 'memcache':
                return $this->phpCache->set( $key, $value, MEMCACHE_COMPRESSED, $ttl );
            break;
        } 
    }
    
    /**
     * Metodo che cancella la cache
     * @param type $key
     * @return type
     */
    public function phpCacheRemove( $key ) {
        switch( $this->typeLibrary ) {
            case 'memcached':
                return $this->phpCache->delete( $key );
            break;
            case 'memcache':
                return $this->phpCache->delete( $key );
            break;
        } 
    }
    
    /**
     * Metodo che forza il TTl dei dati delle query 
     * @param type $region
     * @param type $ttl
     */
    public function setExpire( $region, $ttl ) {             
        foreach ( $this->phpCache->keys('*') AS $key ) {            
            if( strpos( $key, 'my_'.$region.'_region', '0' ) !== false ) {
                $realTTL =  $this->phpCache->ttl( $key );
                
                if( !empty( $realTTL ) && $realTTL > $ttl )
                    $this->phpCache->expire( $key, $ttl );
            }
        }
    }
    
    //"my_images_data_article_region_result[my_images_data_article_region_result_appbundle.entity.dataarticle_244__images][1]"
    public function removeKey( $region, $idKey = false  ) {
        foreach ( $this->phpCache->keys('*') AS $key ) {      
            
            if( !empty( $idKey ) && strpos( $key, $idKey, '0' ) !== false && strpos( $key, $region, '0' ) !== false ) {
//                echo 'cancello1';
                $this->phpCache->del( $key );
            } else if( empty( $idKey ) && strpos( $key, $region, '0' ) !== false ) {
                echo 'cancello2';
                $this->phpCache->del( $key );
            }
        }
    }

    
    public function getKey( $key = '*') {        
        return $this->phpCache->keys( $key );
    }


    //http://www.thegeekstuff.com/2014/02/phpredis
    private function startRedis( $channel ) {
//        if( empty( $this->phpCacheIsConnect ) ) {
            $this->phpCache = $this->container->get('snc_redis.'.$channel );
            $this->phpCacheIsConnect = true;             
//        }
    }


    /**
     * Metodo che  avvia la connesione con Memcache
     * @param string $host
     * @param string $port 
     */
    public function startMemcached($host = "localhost", $port = "11211", $isActiveMemcache = true) {                
//        if ( !class_exists( 'Memcached' ) )
//            $this->config->isActiveMemcache = false;

        $this->phpCache  = new \Memcached( );
        $this->phpCache->setOption(\Memcached::OPT_COMPRESSION, true);        
        $this->phpCache->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 2000);
        
        // Add server if no connections listed.         
        if ( !count( $this->phpCache->getServerList() ) ) {
            $this->phpCache->addServer( $this->container->getParameter( 'session_memcached_host' ), $this->container->getParameter( 'session_memcached_port' ) );        
        }
        $this->phpCacheIsConnect = true;
        
    }

    /**
     * Metodo che  avvia la connesione con Memcache
     * @param string $host
     * @param string $port 
     */
    public function startMemcache($host = "localhost", $port = "11211", $isActiveMemcache = true) {
//        if (!class_exists('Memcache'))
//            exit;
//            $this->config->isActiveMemcache = false;

        $this->phpCache = new \Memcache();
        $this->phpCache->addServer( $this->container->getParameter( 'session_memcached_host' ), $this->container->getParameter( 'session_memcached_port' ), true );   
        $stats = @$this->phpCache->getExtendedStats();
//        $available = (bool) $stats["$host:$port"];
        
        $this->phpCacheIsConnect = true;
    }
    
}//End Class