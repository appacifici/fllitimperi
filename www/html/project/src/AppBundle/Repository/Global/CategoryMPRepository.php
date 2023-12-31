<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryMPRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function setCacheUtility( $secondLevelCacheUtility ) {
        $this->secondLevelCacheUtility = $secondLevelCacheUtility;
    }
    
    /**
     * Crea la query con la cache
     * @param type $toArray
     * @return type
     */
    public function findAllCategoriesMP( $toObject = false ) {
        $sql = 'SELECT c FROM AppBundle:CategoryMP c ORDER BY c.name ASC';        
        $query = $this->getEntityManager()->createQuery( $sql );
        
        $query->setCacheable( true );
        $query->setCacheRegion( 'my_categoryMP_region_query' );
                
        if( !SECOND_LEVEL_CACHE_ENABLED || !$query->isCacheable() ) {
            $query->useQueryCache( true );
            $query->useResultCache(true, CATEGORY_REGION_TTL, 'category_findAllCategoriesMP_CacheORM'.md5( $sql ) );    
        }        
        
        if( empty ( $toObject ) ) {
            $result =  $query->getResult();
        } else {
            $result = $query->getResult( \Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY );
            $result =  json_decode(json_encode($result), FALSE);
        }
        
        if( SECOND_LEVEL_CACHE_ENABLED ||  SECOND_LEVEL_CACHE_SET_EXPIRE_ENABLED  )
            $this->secondLevelCacheUtility->setExpire( 'categoryMP', CATEGORY_REGION_TTL );
        
        return $result;
    }
}
