<?php

namespace AppBundle\Repository;
use AppBundle\Repository\Web365ManagerRepository;
/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DinamycPageRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function setCacheUtility( $secondLevelCacheUtility ) {
        $this->secondLevelCacheUtility = $secondLevelCacheUtility;
    }
   
    
}
