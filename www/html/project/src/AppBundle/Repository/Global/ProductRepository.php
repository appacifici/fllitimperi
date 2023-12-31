<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function setCacheUtility( $secondLevelCacheUtility ) {
        $this->secondLevelCacheUtility = $secondLevelCacheUtility;
    }
    
       
      // metodo che recupera tutti gli articoli per l'admin
    
    public function getAllProductsFosElastica() {
       $repository = $this->getEntityManager()->getRepository('AppBundle:Product');

       $qb = $repository->createQueryBuilder('p');
       $qb->select('p');       
//       $qb->join('p.trademark', 'tm');
//       $qb->join('p.typology', 't');
       $qb->where('p.isActive = 1'); 
           
       return $qb;         
    }
    
    public function findElementById( $id ) {
        $sql = "SELECT p FROM AppBundle:Product p WHERE p.id = '".$id."'"; 
        
        $query = $this->getEntityManager()->createQuery( $sql )->setMaxResults(1);          
        
        $query->setCacheable( true );
        $query->setCacheRegion( 'my_product_region_query' );
                
        if( !SECOND_LEVEL_CACHE_ENABLED || !$query->isCacheable() ) {
            $query->useQueryCache( true );
            $query->useResultCache(true, CATEGORY_REGION_TTL, 'product_findElementById_CacheORM'.md5( $sql ) );    
        } 
        
        $result = $query->getOneOrNullResult();
        if( SECOND_LEVEL_CACHE_ENABLED ||  SECOND_LEVEL_CACHE_SET_EXPIRE_ENABLED  )
            $this->secondLevelCacheUtility->setExpire( 'product', CATEGORY_REGION_TTL );
        
        return $result;
    }
    
    
    public function findProductsByIds( $idsFiltered, $limit = false ) {
//        return $this->findArticleByCategoryAndTeam(false, false, $limit, false, false, false, $idsFilteredArticles);
        
        $where = '1=1';
        if (!empty($idsFiltered)) {
            $ids = join(",",$idsFiltered);   
            $where .= ' AND p.id IN ('.$ids.')';            
        }
        
        $sql = 'SELECT p, t FROM AppBundle:Product p
            JOIN p.trademark t WHERE '. $where .'  ORDER BY p.id DESC'
        ;
        
        $query = $this->getEntityManager()
                ->createQuery( $sql );
        
        if( !empty( $limit ) ) {
            $limit = explode(',', $limit);
            $firstResult = count($limit) == 1 ? 0 : $limit[0];
            $lastResult = count($limit) == 1 ? $limit[0] : $limit[1];
            $query->setFirstResult($firstResult)
            ->setMaxResults($lastResult);         
        }
        
        $result = $query->getResult();   
        
        return $result;
        
    }
    
     /*
     * Query che ritorna tutti i prodotti più venduti
     */
    public function getCountProductList( $typology, $subcategory, $trademark, $affiliate, $sex = false, $aPrice = false ) {
        $where = 'p.isActive = 1';
        
        if( !empty( $typology ) )
            $where .= ' AND p.typology = '.$typology;  
        
        if( !empty( $subcategory ) )
            $where .= ' AND p.subcategory = '.$subcategory;  
        
        if( !empty( $trademark ) )
            $where .= ' AND p.trademark = '.$trademark;
//        
        if( !empty( $affiliate ) )
            $where .= ' AND p.affiliation = '.$affiliate;
                
        if( !empty( $sex ) )
            $where .= ' AND p.sex = '.$sex;
                 
        if( !empty( $aPrice['gte'] ) )
            $where .= ' AND p.price >= '.$aPrice['gte'];
        
        if( !empty( $aPrice['lte'] ) )
            $where .= ' AND p.price <= '.$aPrice['lte'];
        
        $query = $this->getEntityManager()
                ->createQuery(
                'SELECT COUNT(p) as tot FROM AppBundle:Product p
                    LEFT JOIN p.trademark t 
                WHERE '. $where );

       try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    
     /*
     * Query che ritorna tutti i prodotti più venduti
     */
    public function getProductList( $limit, $typology, $subcategory, $trademark, $affiliate, $subcatAff = false, $toArray = false, $sex = 1, $aPrice = array() ) {
        $where = 'p.isActive = 1';
        
        if( !empty( $typology ) )
            $where .= ' AND p.typology = '.$typology;  
        
        if( !empty( $subcategory ) )
            $where .= ' AND p.subcategory = '.$subcategory;  
        
        if( !empty( $trademark ) )
            $where .= ' AND p.trademark = '.$trademark;
        
        if( !empty( $affiliate ) )
            $where .= ' AND p.affiliation = '.$affiliate;
        
        if( !empty( $sex ) )
            $where .= ' AND p.sex = '.$sex;
        
        if( !empty( $aPrice['gte'] ) )
            $where .= ' AND p.price >= '.$aPrice['gte'];
        
        if( !empty( $aPrice['lte'] ) )
            $where .= ' AND p.price <= '.$aPrice['lte'];
        
        
        $limit = explode(',', $limit);
        $firstResult = count($limit) == 1 ? 0 : $limit[0];
        $lastResult = count($limit) == 1 ? $limit[0] : $limit[1];
        
        $query = $this->getEntityManager()
                ->createQuery(
                        'SELECT p,i,t FROM AppBundle:Product p
                        JOIN p.priorityImg i  LEFT JOIN p.trademark t WHERE '. $where .'  ORDER BY p.id DESC')
                ->setFirstResult($firstResult)
                ->setMaxResults($lastResult);
        
        try {   
            if (empty($toArray))
                return $query->getResult();
            else
                $response = $query->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
                return json_decode(json_encode( $response ), FALSE);

        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
     /*
     * Query che ritorna tutti i prodotti più venduti
     */
    public function getBestsellerProducts( $limit, $category = false, $subcategory = false, $typology = false, $trademark = false, $affiliate , $toArray = false) {
        $where = 'p.isActive = 1';
        
        if( !empty( $category ) )
            $where .= ' AND p.category = '.$category;  
        
        if( !empty( $subcategory ) )
            $where .= ' AND p.subcategory = '.$subcategory;          
        
        if( !empty( $typology ) )
            $where .= ' AND p.typology = '.$typology;          
        
        if( !empty( $category ) )
            $where .= ' AND p.category = '.$category;          
        
        if( !empty( $trademark ) )
            $where .= ' AND p.trademark = '.$trademark;
//        
        if( !empty( $affiliate ) )
            $where .= ' AND p.affiliation = '.$affiliate;
        
        
        $query = $this->getEntityManager()
                ->createQuery(
                        'SELECT p, t FROM AppBundle:Product p                            
                        left JOIN p.trademark t WHERE '. $where .' '
                        . 'AND p.priorityImg is not null ORDER BY p.id DESC')
                
                ->setMaxResults($limit);
        
        try {   
            if (empty($toArray))
                return $query->getResult();
            else
                $response = $query->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
                return json_decode(json_encode( $response ), FALSE);

        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
     /*
     * Query che ritorna tutti i prodotti più venduti
     */
    public function getProductsSale( $limit, $category, $trademark, $affiliate , $toArray = false) {
        $where = ' AND p.isActive = 1';
        
        if( !empty( $category ) )
            $where .= ' AND p.category = '.$category;  
        
        if( !empty( $trademark ) )
            $where .= ' AND p.trademark = '.$trademark;
//        
        if( !empty( $affiliate ) )
            $where .= ' AND p.affiliation = '.$affiliate;
        
        $query = $this->getEntityManager()
                ->createQuery(
                        'SELECT p, t FROM AppBundle:Product p
                        JOIN p.trademark t WHERE p.price < p.lastprice '. $where .' ORDER BY p.id DESC')
                ->setMaxResults($limit);
        
        try {   
            if (empty($toArray))
                return $query->getResult();
            else
                $response = $query->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
                return json_decode(json_encode( $response ), FALSE);

        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    
    
    /*
     * Query che ritorna i prodotti paginati 
     */
    public function findProductsWithLimit( $limit, $name = false, $isCompleted = false, $category = false, $subcategory = false, $typology = false, $date = false, $number = false ) { 
        $limit = explode(',', $limit);
        $firstResult = count($limit) == 1 ? 0 : $limit[0];
        $lastResult = count($limit) == 1 ? $limit[0] : $limit[1];

        $where = 'where 1=1';
        if( !empty( $name ) ) {
            $where .= " and p.name like '%$name%'";
        }
        if( $isCompleted !== false ) {
            $where .= " and p.isCompleted = '$isCompleted' ";
        }
        
        if( !empty( $number ) )
            $where .= " and p.number = '$number' ";
        
        if( !empty( $category ) )
            $where .= " and p.category = $category ";
        
        if( !empty( $subcategory ) )
            $where .= " and p.subcategory = $subcategory ";
        
        if( !empty( $typology ) )
            $where .= " and p.typology = $typology ";
        
        if( $date !== false ) {
            $dateInit = date( 'Y-m-d ', strtotime( str_replace( ' ', '-', $date ) ) ). '00:00:00';
            $where .= " and p.dateImport > '$dateInit' ";
        }

        $query = $this->getEntityManager()
                ->createQuery(
                'SELECT p,i FROM AppBundle:Product p LEFT JOIN p.priorityImg i '.$where.'
                          
                ORDER BY p.name ASC')
                ->setFirstResult($firstResult)
                ->setMaxResults($lastResult);
        try {            
            return $query->getResult();            
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
     /*
     * Query che fa la count dei prodotti 
     */
    public function countProducts( $name = false, $isCompleted = false, $category = false, $subcategory = false, $typology = false, $date = false, $number = false ) {
        $where = 'where 1=1';
        if( !empty( $name ) ) {
            $where .= " and p.name like '%$name%'";
        }
        if( $isCompleted !== false ) {
            $where .= " and p.isCompleted = '$isCompleted' ";
        }
        
        if( !empty( $number ) )
            $where .= " and p.number = '$number' ";
        
        
        if( !empty( $category ) )
            $where .= " and p.category = $category ";
        
        if( !empty( $subcategory ) )
            $where .= " and p.subcategory = $subcategory ";
        
        if( !empty( $typology ) )
            $where .= " and p.typology = $typology ";
        
        if( $date !== false ) {
            $dateInit = date( 'Y-m-d ', strtotime( str_replace( ' ', '-', $date ) ) ). '00:00:00';
            $where .= " and p.dateImport > '$dateInit' ";
        }

        
        
        $sql = 'SELECT COUNT(p) as tot FROM AppBundle:Product p '.$where;        
        $query = $this->getEntityManager()->createQuery( $sql );        
        try {
            $result = $query->getSingleResult();                 
            
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        return $result;
    }
    
     /*
     * Query che ritorna tutti i prodotti più venduti
     */
    public function findProductsByModel( $model, $limit, $toUpdate = false, $toArray = false) {
        $where = '1=1';
        
        $limit = explode(',', $limit);
        $firstResult = count($limit) == 1 ? 0 : $limit[0];
        $lastResult = count($limit) == 1 ? $limit[0] : $limit[1];
        
        if( $toUpdate !== false )
            $where .= ' AND p.toUpdate = 1';  
        
        if( !empty( $model ) )
            $where .= ' AND p.model = '.$model;  
        
        $query = $this->getEntityManager()
                ->createQuery(
                        'SELECT p,t,a FROM AppBundle:Product p      
                            JOIN p.affiliation a
                        left JOIN p.trademark t 
                        WHERE '. $where .' ORDER BY p.price ASC')
                ->setFirstResult($firstResult)
                ->setMaxResults($lastResult);
//        echo $query->getSQL().'<br>';
        try {   
            if (empty($toArray))
                return $query->getResult();
            else
                $response = $query->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
                return json_decode(json_encode( $response ), FALSE);

        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
     /*
     * Query che ritorna tutti i prodotti più venduti
     */
    public function countProductsByModel( $model ) {
        $where = 'p.isActive = 1';
        
        if( !empty( $model ) )
            $where .= ' AND p.model = '.$model;  
        
        $query = $this->getEntityManager()
                ->createQuery(
                        'SELECT COUNT(p) as tot FROM AppBundle:Product p      
                            JOIN p.affiliation a
                        WHERE '. $where );
        try {   
                return $query->getSingleResult();

        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    
    public function findProductsByReleatedCodeAmazon( $codes ) {        
        $sql = 'SELECT p FROM AppBundle:Product p WHERE p.number IN (:codes)';                
        $query = $this->getEntityManager()->createQuery( $sql );    
        $query->setParameters([
            'codes' => $codes,
        ]);
        $result = $query->getResult();   
        
        return $result;
        
    }
    
    
}