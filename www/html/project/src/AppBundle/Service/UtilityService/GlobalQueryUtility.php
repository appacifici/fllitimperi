<?php

namespace AppBundle\Service\UtilityService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;
use AppBundle\Service\UtilityService\CacheUtility;

/**
 * Description of GlobalQueryUtility
 * @author alessandro
 */
class GlobalQueryUtility {
    
    public $browserUtility;
    public $category = false; 
    public $subcategory = false; 
    public $typology = false;
    public $microSection = false;
    public $model = false;
    public $modelsComparison = false;
    
    public function __construct(  Container $container, EntityManager $entityManager, CacheUtility $cacheUtility )  {               
        $this->container        = $container;
        $this->em    = $entityManager;
        $this->cacheUtility     = $cacheUtility;
                
    }
    
    //Metodo che centralizza la query di recupero della $catSubcatTypology per non doverla effettuare in piu punti 
    //se già è stata eseguita da quale core nel processo di creazione, prova prima con gli array redis se va male via db
    public function getRedisOrDBCatSubcatTypology( $catSubcatTypology ) {
        $categoryByName     = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesByName' );        
        $subcategoryByName  = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesByName' );
        $typologyByName     = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesByName' );

        $categoryId       = array_key_exists($catSubcatTypology, (array)$categoryByName) ? $categoryByName->{$catSubcatTypology}->id : false;
        $subcategoryId    = array_key_exists($catSubcatTypology, (array)$subcategoryByName) ? $subcategoryByName->{$catSubcatTypology}->id : false;
        $typologyId       = array_key_exists($catSubcatTypology, (array)$typologyByName) ? $typologyByName->{$catSubcatTypology}->id : false;                                  
        
        if( !empty( $categoryId ) || !empty( $subcategoryId ) || !empty( $typologyId ) ) {
            $response = new \stdClass;
            $response->category     = $categoryId;
            $response->subcategory  = $subcategoryId;
            $response->typology     = $typologyId;
//            return $response;
        }
        
        $response = $this->getCatSubcatTypology( $catSubcatTypology, 'getId' );
        return $response;
    }
    
    public function getRedisOrDbTrademarksById() {
        return $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'trademarksById' );
    }
   
    //Metodo che centralizza la query di recupero della $catSubcatTypology per non doverla effettuare in piu punti 
    //se già è stata eseguita da quale core nel processo di creazione
    public function getCatSubcatTypology( $catSubcatTypology, $returnField = false, $type = false ) {              
        if( !empty( $this->category ) || !empty( $this->subcategory ) || !empty( $this->typology ) || !empty( $this->microSection ) ) {
            $response = new \stdClass;
            if( empty( $returnField ) ) {            
                $response->category         = $this->category;
                $response->subcategory      = $this->subcategory;
                $response->typology         = $this->typology;
                $response->microSection     = $this->microSection;
            } else {
                $response->category         = !empty( $this->category ) ? $this->category->{$returnField}() : false;
                $response->subcategory      = !empty( $this->subcategory ) ? $this->subcategory->{$returnField}() : false;
                $response->typology         = !empty( $this->typology ) ? $this->typology->{$returnField}() : false;
                $response->microSection     = !empty( $this->microSection ) ? $this->microSection->{$returnField}() : false;
            }
            return $response;
        }
        
        
        
        //Se è vuoto il tipo di sezione da cui deriva la url la recupera a step senno usa quella impostata
        if( empty( $type ) ) {                
            $this->category = $this->em->getRepository('AppBundle:Category')->findByNameUrl($catSubcatTypology);
            if( empty( $this->category ) ) {
                $this->subcategory = $this->em->getRepository('AppBundle:Subcategory')->findByNameUrl($catSubcatTypology);
            }

            if( empty( $this->category ) && empty( $this->subcategory ) )
                $this->typology = $this->em->getRepository('AppBundle:Typology')->findByNameUrl($catSubcatTypology);

            if( empty( $this->category ) && empty( $this->subcategory ) && empty( $this->typology ) )
                $this->microSection = $this->em->getRepository('AppBundle:MicroSection')->findByNameUrl($catSubcatTypology);
        } else {
            $var = lcfirst( $type );
            $this->{$var} = $this->em->getRepository('AppBundle:'.$type)->findByNameUrl($catSubcatTypology);
        }
        
        
        
        $response = new \stdClass;
        if( empty( $returnField ) ) {            
            $response->category         = $this->category;
            $response->subcategory      = $this->subcategory;
            $response->typology         = $this->typology;
            $response->microSection     = $this->microSection;
        } else {
            $response->category         = !empty( $this->category ) ? $this->category->{$returnField}() : false;
            $response->subcategory      = !empty( $this->subcategory ) ? $this->subcategory->{$returnField}() : false;
            $response->typology         = !empty( $this->typology ) ? $this->typology->{$returnField}() : false;
            $response->microSection     = !empty( $this->microSection ) ? $this->microSection->{$returnField}() : false;
        }
        
        return $response;
    }
        
    //Metodo che centralizza la query di recupero per modello per non doverla effettuare in piu punti 
    //se già è stata eseguita da quale core nel processo di creazione
    public function getModelByNameUrl( $modelName ) {
        if( !empty( $this->model ) ) 
            return $this->model;
        
        $this->model = $this->em->getRepository('AppBundle:Model')->findOneByNameUrl( $modelName );
        return $this->model;
    }
        
    //Metodo che centralizza la query di recupero per modello per non doverla effettuare in piu punti 
    //se già è stata eseguita da quale core nel processo di creazione
    public function getModelsComparison( $idModels, $checkExist = true ) {
        if( !empty( $checkExist ) && !empty( $this->modelsComparison ) )
            return $this->modelsComparison;
        
        $idModels = str_replace( ',','[#]' ,$idModels );        
        $aIds = explode( '[#]' ,$idModels );        
        
        if( strpos( ' '.$idModels, '[#]' ) !== FALSE ) {            
            $this->modelsComparison = $this->em->getRepository('AppBundle:Model')->findModelByIds( $aIds );
            
        } else {
//            $urls = explode( '-vs-' ,$idModels );        
            $this->modelsComparison = $this->em->getRepository('AppBundle:Comparison')->findOneByNameUrl( $idModels );
        }
        
        
        return $this->modelsComparison;
    }
    
    
}//End Class