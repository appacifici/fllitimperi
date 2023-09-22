<?php

namespace AppBundle\Service\UtilityService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\ORM\EntityManager;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class DictionaryUtility {
    
    protected $container;
    
    public function __construct(  Container $container, EntityManager $entityManager, CacheUtility $cacheUtility )  {               
        $this->container        = $container;
        $this->em    = $entityManager;
        $this->cacheUtility     = $cacheUtility;
                
    }
    
    /**
     * metodo che effettua il replace di unt ermine per l'apertura del popup
     * @param type $technicalSpecifications
     * @param type $subcategoryId
     * @param type $typologyId
     * @return type
     */
    public function replaceText( $text, $subcategoryId, $typologyId ) {
        if( !empty( $typologyId ) )
            $dictionaries = $this->em->getRepository('AppBundle:Dictionary')->findByTypology( $typologyId );
        else
            $dictionaries = $this->em->getRepository('AppBundle:Dictionary')->findBySubcategory( $subcategoryId );
        
        foreach( $dictionaries AS $dictionary ) {
            $valueNew = $dictionary->getName();
//            echo $valueNew."\n";
//                
            if(  strpos( ' '.$text.' ', ''.$valueNew.'', 0 ) !== false ) { 
//                echo $valueNew.'<==';
                $text = ucfirst( trim( str_replace( $valueNew , "<span data-dictionary='".$dictionary->getId()."'>".$dictionary->getName()."</span>", $text." " ) ) );                
                
            }
            
            
        }   

        return $text;
//        exit;
    }
    /**
     * metodo che effettua il replace di unt ermine per l'apertura del popup
     * @param type $technicalSpecifications
     * @param type $subcategoryId
     * @param type $typologyId
     * @return type
     */
    public function replaceTechnicalSpecifications( $technicalSpecifications, $subcategoryId, $typologyId ) {
        if( !empty( $typologyId ) )
            $dictionaries = $this->em->getRepository('AppBundle:Dictionary')->findByTypology( $typologyId );
        else
            $dictionaries = $this->em->getRepository('AppBundle:Dictionary')->findBySubcategory( $subcategoryId );
        
        foreach( $dictionaries AS $dictionary ) {
            foreach( $technicalSpecifications  AS $key => &$technicalSpecification ) {                
                $originalValue = trim( $technicalSpecification['value'] );
                
                $valueOld = strtolower( str_replace( ' ', '', $technicalSpecification['value'] ) );
                $valueNew = strtolower( str_replace( ' ', '', $dictionary->getName() ) );
                
                if(  strpos( ' '.$valueOld, $valueNew, 1 ) !== false ) {
                    $terms = explode( ' - ', $technicalSpecification['value'] );
//                    echo $valueNew."<br>";
                    
                    $newTerm = '';
                    $newterms = array();
                    foreach( $terms AS $term ) {
                        $originalterm = $term;
                        $term = strtolower( str_replace( ' ', '', $term ) );
                        
                        $newTerm = $originalterm;
                        
                        if(  strpos( ' '.$term.' ', ' '.$valueNew.' ', 0 ) !== false ) { 
                            $newTerm = ucfirst( trim( str_replace( strtolower( $valueNew )." ", "<span data-dictionary='".$dictionary->getId()."'>".$dictionary->getName()."</span>", strtolower( $term )." " ) ) );
                        }
                        $newterms[] = str_replace( '<spandata-dictionary', '<span data-dictionary', $newTerm );
                    }
                    
                    $newTerm = implode( ' - ', $newterms );
                    $technicalSpecifications[$key]['value'] = trim( $newTerm);
//                    print_r( $dictionary->getName() );
//                    print_r( $technicalSpecifications );
                }
            }        
//            echo "\n\n";
        }        
        return $technicalSpecifications;
    }
    
    /**
     * metodo che effettua il replace di unt ermine per l'apertura del popup
     * @param type $technicalSpecifications
     * @param type $subcategoryId
     * @param type $typologyId
     * @return type
     */
    public function replaceTechnicalSpecificationsComparison( $technicalSpecifications, $subcategoryId, $typologyId ) {
        if( !empty( $typologyId ) )
            $dictionaries = $this->em->getRepository('AppBundle:Dictionary')->findByTypology( $typologyId );
        else
            $dictionaries = $this->em->getRepository('AppBundle:Dictionary')->findBySubcategory( $subcategoryId );
        
//        print_R($technicalSpecifications);
        
        foreach( $dictionaries AS $dictionary ) {
            foreach( $technicalSpecifications  AS $key => &$technicalSpecification ) {                
                foreach( $technicalSpecification  AS $key2 => &$items) {                
                    foreach( $items  AS $key2 => &$itemValue) {                
                        
                        $originalValue = trim( $itemValue );

                        $valueOld = strtolower( str_replace( ' ', '', $itemValue ) );
                        $valueNew = strtolower( str_replace( ' ', '', $dictionary->getName() ) );

                        if(  strpos( ' '.$valueOld, $valueNew, 1 ) !== false ) {
                            $terms = explode( ' - ', $itemValue );
        //                    echo $valueNew."<br>";

                            $newTerm = '';
                            $newterms = array();
                            foreach( $terms AS $term ) {
                                $originalterm = $term;
                                $term = strtolower( str_replace( ' ', '', $term ) );

                                $newTerm = $originalterm;
                                if(  strpos( ' '.$term.' ', ' '.$valueNew.' ', 0 ) !== false ) { 
                                    $newTerm = ucfirst( trim( str_replace( strtolower( $valueNew )." ", "<span data-dictionary='".$dictionary->getId()."'>".$dictionary->getName()."</span>", strtolower( $term )." " ) ) );
                                }
                                $newterms[] = str_replace( '<spandata-dictionary', '<span data-dictionary', $newTerm );
                            }

                            $newTerm = implode( ' - ', $newterms );
                            $itemValue = trim( $newTerm) ;
        //                    print_r( $newterms );
//                            print_r( $technicalsSpecification );
                        }
                    }        
                }        
            }        
//            echo "\n\n";
        }
        return $technicalSpecifications;
    }
    
    
}//End Class

