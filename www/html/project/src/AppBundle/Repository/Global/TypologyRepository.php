<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypologyRepository extends \Doctrine\ORM\EntityRepository
{
    
     public function setCacheUtility( $secondLevelCacheUtility ) {
        $this->secondLevelCacheUtility = $secondLevelCacheUtility;
    }
    
     //metodo che recupera tutti i modelli attivi completati o che hanno prodotti per elastica
    public function getAllTypologiesFosElastica() {
       $repository = $this->getEntityManager()->getRepository('AppBundle:Typology');
       $qb = $repository->createQueryBuilder('t');
       $qb->select('t');       
       $qb->where('t.isActive = 1');            
       return $qb;         
    }
    
    
    
    /**
     * Crea la query con la cache che recupera i team per la registrazione Utente
     * @param type $toArray
     * @return type
     */
    public function findTypologiesBySubcategory( $subcategoryId ) {
        $sql = 'SELECT t FROM AppBundle:Typology t WHERE t.subcategory = '.$subcategoryId.' ORDER BY t.name ASC';
        $query = $this->getEntityManager()->createQuery( $sql );
        
        try {
            
//            $query->setCacheable( SECOND_LEVEL_CACHE_ENABLED );
//            $query->setCacheRegion( 'my_subcategory_region_query' );
//
//            if( !SECOND_LEVEL_CACHE_ENABLED || !$query->isCacheable() ) {
//                $query->useQueryCache( true );
//                $query->useResultCache(true, TEAM_REGION_TTL, 'subcategory_findSubcategoriesIsTeam_CacheORM'.md5( $sql ) );    
//            }      
       
            $result = $query->getResult();     
//            if( SECOND_LEVEL_CACHE_ENABLED ||  SECOND_LEVEL_CACHE_SET_EXPIRE_ENABLED  )
//                $this->secondLevelCacheUtility->setExpire( 'subcategory', TEAM_REGION_TTL );
            
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
        return $result;
    }
    
    /**
     * Crea la query con la cache
     * @param type $toArray
     * @return type
     */
    public function findByNameUrl( $name ) {        
        $sql = "SELECT t,c,s FROM AppBundle:Typology t   
                JOIN t.category c   
                JOIN t.subcategory s   
                WHERE t.nameUrl = '".$name."'"; 
        $query = $this->getEntityManager()->createQuery( $sql )->setMaxResults(1);
        $query->setCacheable( true );
        $query->setCacheRegion( 'my_typology_region_query' );
                
        if( !SECOND_LEVEL_CACHE_ENABLED || !$query->isCacheable() ) {
            $query->useQueryCache( true );
            $query->useResultCache(true, CATEGORY_REGION_TTL, 'typology_findByNameUrl_CacheORM'.md5( $sql ) );    
        }        
        $result = $query->getOneOrNullResult();
        if( SECOND_LEVEL_CACHE_ENABLED ||  SECOND_LEVEL_CACHE_SET_EXPIRE_ENABLED  )
            $this->secondLevelCacheUtility->setExpire( 'typology', CATEGORY_REGION_TTL );
        
        return $result;
    }
    
    /**
     * Crea la query con la cache
     * @param type $toArray
     * @return type
     */
    public function findAllTypologies( $toObject = false ) {
        $sql = 'SELECT t, s, c FROM AppBundle:Typology t join t.subcategory s join t.category c WHERE t.isActive = 1 ORDER BY t.name ASC';        
        $query = $this->getEntityManager()->createQuery( $sql );
        
        $query->setCacheable( true );
        $query->setCacheRegion( 'my_typology_region_query' );
                
        if( !SECOND_LEVEL_CACHE_ENABLED || !$query->isCacheable() ) {
            $query->useQueryCache( true );
            $query->useResultCache(true, CATEGORY_REGION_TTL, 'typology_findAllTypologies_CacheORM'.md5( $sql ) );    
        }        
        
        if( empty ( $toObject ) ) {
            $result =  $query->getResult();
        } else {
            $result = $query->getResult( \Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY );
            $result =  json_decode(json_encode($result), FALSE);
        }
        
        if( SECOND_LEVEL_CACHE_ENABLED ||  SECOND_LEVEL_CACHE_SET_EXPIRE_ENABLED  )
            $this->secondLevelCacheUtility->setExpire( 'typology', CATEGORY_REGION_TTL );
        
        return $result;
    }
    
     /*
     * Query che ritorna i prodotti paginati 
     */
    public function findTypologiesWithLimit( $limit, $catId = false, $subcatId = false, $hasModels = false ) { 
        $where = '1=1';
        
        if( !empty( $subcatId ) )
            $where .= ' AND t.subcategory = '.$subcatId;
        
        if( !empty( $catId ) )
            $where .= ' AND t.category = '.$catId;
                
        if( !empty( $hasModels ) )
            $where .= $hasModels == 0 ? ' AND t.hasModels = '.$hasModels : ' AND t.hasModels > '.$hasModels;
        
        
        $sql = 'SELECT t FROM AppBundle:Typology t WHERE '. $where .' ORDER BY t.name ASC';
        
        $query = $this->getEntityManager()
                ->createQuery( $sql );
        
        if( !empty( $limit ) ) {
            $limit = explode(',', $limit);
            $firstResult = count($limit) == 1 ? 0 : $limit[0];
            $lastResult = count($limit) == 1 ? $limit[0] : $limit[1];
            $query->setFirstResult($firstResult)
            ->setMaxResults($lastResult);         
        }
        
        try {            
            return $query->getResult();            
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
     /*
     * Query che fa la count dei prodotti 
     */
    public function countTypologies( $subcatId = false, $catId = false, $hasModels = false ) {
        $where = '1=1';
        
        if( !empty( $subcatId ) )
            $where .= ' AND t.subcategory = '.$subcatId;
        
        if( !empty( $catId ) )
            $where .= ' AND t.category = '.$catId;
        
        if( !empty( $hasModels ) )
            $where .= $hasModels == 0 ? ' AND t.hasModels = '.$hasModels : ' AND t.hasModels > '.$hasModels;
        
        $sql = 'SELECT COUNT(t) as tot FROM AppBundle:Typology t WHERE '. $where;        
        $query = $this->getEntityManager()->createQuery( $sql );        
        try {
            $result = $query->getSingleResult();                 
            
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        return $result;
    }
    
    
}
