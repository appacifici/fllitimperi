<?php 
namespace AppBundle\Service\SportradarDataService\ArrayElement;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\SportradarDataService\Entity\Layer\EntityLayerException;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;


class ArrayElementHandler
{
    const CUSTOM_EXISTANCE_CHECK_NAME   = 'customExistanceCheck';
    const LAYER_NAMESPACE               = 'AppBundle\\Service\\SportradarDataService\\Entity\\Layer';
    const SABREXML_ATTRIBUTES_KEY       = 'attributes';
    const SABREXML_NAME_KEY             = 'name';
    const SABREXML_VALUE_KEY            = 'value';

	/**
	 * Holds the last inserted key in the parents array
	 * @var string
	 */
	private $_lastParentKey = '';
	
	/**
	 * The Dbal connection
	 * @var Connection
	 */
	protected $dbal;

    /**
     * The injected Doctrine service
     * @var Doctrine
     */
    protected $doctrine;

    /**
     * The injected Monolog service
     * @var Logger
     */
    public $logger;

    /**
     * An array of entities related to the current one
     * @var array
     */
    protected $parents;
    
    public $cacheUtility;

    public function __construct( ObjectManager $doctrine, Connection $dbal, Logger $logger, MemcachedSessionHandler $memcached, Container $container ) {
        $this->dbal      = $dbal;
        $this->doctrine  = $doctrine;
        $this->logger    = $logger;
        
        $this->container        = $container;
        
//        $this->memcached  = new \Memcached( $this->container->getParameter( 'session_memcached_persistent_id' ) );
//        // Add server if no connections listed. 
//        if ( !count($this->memcached->getServerList()) ) {                    
//            $this->memcached->addServer( $this->container->getParameter( 'session_memcached_host' ), $this->container->getParameter( 'session_memcached_port' ) );   
//        }
        
        $this->cacheUtility = $this->container->get('app.cacheUtility');
        $this->cacheUtility->initPhpCache();
        
        $this->cacheUtility->prefix = $this->container->getParameter( 'session_memcached_prefix' );
        $this->parents   = [];        
    }

    /**
     * Does an add/set method exists for the given entity and the given related data?
     * @param Entity $entity    The Entity to test
     * @param string $childName The name of the Relationship to add or set
     * @return string|boolean   The method's name or FALSE if no method has been found
     */
    private function _addOrSetMethodExists($entity, $childName) {
        // If the given Entity is set
        if($entity) {
            //var_dump($childName);
            // Check for the add{entity name} method (1 to n)
            if( method_exists($entity, 'add' . $childName) ) {
                return 'add' . $childName;
            }

            // Check for the set{entity name} method (n to 1 or 1 to 1)
            if( method_exists($entity, 'set' . $childName) ) {
                return 'set' . $childName;
            }
        }

        // Fallback: no method exists
        return FALSE;
    }

	/**
	 * Checks the existance of the given Entity for the existance field(s) set in the Entity
	 * @param $entity The Entity required to perform the existance check
	 * @return BetradarEntity Returns the given entity if it doesn't exists in the Database. Otherwise the Entity that has been found will be returned
	 */
    private function _checkExistance($entity) {
        $repository         = $this->doctrine->getRepository( get_class($entity) );
        $checkConditions    = [];

        if( is_array( $entity->getExistanceField() ) ) {
            foreach( $entity->getExistanceField() as $field ) {
                $fnGet = 'get' . $field;

				if( method_exists($entity, $fnGet) )
                $checkConditions[lcfirst($field)]  = $entity->$fnGet();
            }
            unset($field);
        } else {            
            $fnGet = 'get' . $entity->getExistanceField();
            $checkConditions[lcfirst( $entity->getExistanceField() )] = $entity->$fnGet();
        }
        $exists = $repository->findOneBy($checkConditions);

        return ($exists) ? $exists : $entity;
    }

	/**
     * Clean the namespace and return the class name
     * @param  object $Object   The object you want to retrieve the class name
     * @return string           The class name
     */
    private function _getClassNameFromNamespace($str) {
        return join('', array_slice( explode( '\\', $str ), -1));
    }

    /**
     * Clean the namespace and return the class name
     * @param  object $Object   The object you want to retrieve the class name
     * @return string           The class name
     */
    private function _getClassNameFromObjectNamespace($object) {
        return join('', array_slice( explode( '\\', get_class($object) ), -1));
    }

    /**
     * Remove the unuseful characters from the Entity Name
     * Usually, the Entity name parsed with SabreXml have a "{}" prepended
     * @param  string $entityName The Entity name to clean
     * @return string             The cleaned Entity name
     */
    private function _getCleanEntityName($entityName) {
        return str_replace('{}', '', $entityName);
    }

    /**
     * Returns the Element's name
     * According to the briefing performed on the 27th January 2016, it's the first key of the array
     * @param  array  $element The Element array
     * @return string
     */
    private function _getElementName(array $element) {
        reset($element);

        return key($element);
    }

    /**
     * According to the given name, returns a new $entityName Layer instance
     * @param  string $entityName
     * @return EntityLayer
     */
    private function _getNewEntityLayer($entityName, $data = []) {
        $className = self::LAYER_NAMESPACE . '\\' . $entityName . 'Layer';
        return new $className( $this->logger );
    }

    /**
     * Properly handle the persist or the update of an Entity
     * @param  BetradarEntity $entityLayer The EntityLayer to persist
     * @return EntityLayer
     */
    private function _handlePersistWithDbal($entityLayer, $data) {
		$entityLayer->populateEntity($data);

        if( $entityLayer->hasSkippableExistanceCheck() == FALSE ) {
            // Check if the given entity exists
            if( $entityLayer->hasCustomExistanceCheck() ) {
                $entity = $entityLayer->customExistanceCheck($this->doctrine, $this->parents);
            } else {
                $entity = $this->_checkExistance( $entityLayer->getEntity() );
            }
        } else {
            $entity = $entityLayer->getEntity();
        }
        
        //recupera le info meta dell'entity
        $classMetadata  = $this->doctrine->getClassMetadata( get_class($entity) );

		if( $entity->getId() == NULL) {
			if( $entityLayer->hasCustomPersistMethod() ) {
				try {
					$lastInsertId = $entityLayer->customPersistDbal($this->doctrine, $this->dbal, $this->parents, $data);
				} catch(\Exception $e) {
					$this->logger->error( __CLASS__.' '. __LINE__.
						"Error occured while performing a custom insert on " . $entityLayer->getEntityNameFromNamespace() . ": " . $e->getMessage(), [
							'data' 		=> $data,
							'parents' 	=> $this->parents
						]
					);
                    
				}
			} else {
				try {
					$this->dbal->insert(
						$classMetadata->table['name'],
						$entityLayer->getDbalKeyValue($classMetadata, $this->parents)
					);
					
					$lastInsertId = $this->dbal->lastInsertId();
					
                    //Se ha un metodo specifico per la gestione delle pivot
					if( $entityLayer->hasAfterPersistMethod() ) {                        
						try {
							$entityLayer->afterPersistMethod($this->doctrine, $this->dbal, $this->parents, $data);
                            
						} catch(\Exception $e) {
							$this->logger->error( __CLASS__.' '. __LINE__.
								"Error occured while performing an after persist on " . $entityLayer->getEntityNameFromNamespace() . ": " . $e->getMessage(), [
									'data' => $data,
									'parents' => $this->parents
								]
							);
						}
					}
				} catch(\Exception $e) {      
					$this->logger->error( __CLASS__.' '. __LINE__.
						"Error occured while performing an insert on " . $entityLayer->getEntityNameFromNamespace() . ": " . $e->getMessage(), [
							'data' => $data,
							'parents' => $this->parents
						]
					);
				}
			}
		} else {
			$entityLayer->mergeEntities($entity);
			
			// Perform an update if the entity notify changes with the data
			if( $entityLayer->hasUpdates() ) {
				if( $entityLayer->hasCustomUpdateMethod() ) {
					try {
						$entityLayer->customUpdateDbal($this->doctrine, $this->dbal, $this->parents, $data);
					} catch(\Exception $e) {
						$this->logger->error( __CLASS__.' '. __LINE__.
							"Error occured while performing a custom update on " . $entityLayer->getEntityNameFromNamespace() . ": " . $e->getMessage(), [
								'data' => $data,
								'parents' => $this->parents
							]
						);
					}
				} else {
					try {
						$this->dbal->update(
							$classMetadata->table['name'],
							$entityLayer->getDbalKeyValue($classMetadata, $this->parents),
							['id' => $entity->getId()]
						);
					} catch(\Exception $e) {
						$this->logger->error( __CLASS__.' '. __LINE__.
							"Error occured while performing an update on " . $entityLayer->getEntityNameFromNamespace() . ": " . $e->getMessage(), [
								'data' => $data,
								'parents' => $this->parents
							]
						);
					}
				}
				
			}

			if( $entityLayer->hasAfterUpdateMethod() ) {
				try {
					$entityLayer->afterUpdateMethod($this->doctrine, $this->dbal, $this->parents, $data, $entity->getId());
				} catch(\Exception $e) {
					$this->logger->error( __CLASS__.' '. __LINE__.
						"Error occured while performing an after update on " . $entityLayer->getEntityNameFromNamespace() . ": " . $e->getMessage(), [
							'data' => $data,
							'parents' => $this->parents
						]
					);
				}
			}

			$lastInsertId = $entity->getId();
		}

		try {
			$this->_pushParentForDbal( $this->_getClassNameFromNamespace($classMetadata->name), $lastInsertId );
		} catch(\Exception $e) {
			$this->logger->error( __CLASS__.' '. __LINE__.
				"Error occured while pushing the " . $entityLayer->getEntityNameFromNamespace() . " id into the parents stack: " . $e->getMessage(), [
					'Entity name' 	=> $entityLayer->getEntityNameFromNamespace(),
					'Parents stack' => $this->parents
				]
			);
		}
		
		if( isset($lastInsertId) ) {
			return $lastInsertId;
		}
		
		return FALSE;
    }

	/**
	 * Push the last inserted / updated entity's id in the parents stack
	 * @params $name string The name of the last inserted / updated entity
	 * @params $id integer The id of the last inserted / updated entity
	 */
	private function _pushParentForDbal($name, $id = NULL) {
		if( empty($id) ) {
			return;
		}
		
		if($name === $this->_lastParentKey) {
			if( is_array($this->parents[$name]) && !in_array($id, $this->parents) ) {
				$this->parents[$name][] = $id;
			} else {
				if($this->parents[$name] != $id) {
					$this->parents[$name] = [
						0 => $this->parents[$name],
						1 => $id
					];
				}
			}
		} else {
			$this->parents[$name] = $id;
		}
		
		$this->_lastParentKey = $name;
	}

    private function _setParents($entityLayer) {
        if( count($this->parents) == 0 ) {
            return $entityLayer;
        }

        $associationMappings = $this
            ->doctrine
            ->getClassMetadata( $entityLayer->getEntityName() )
            ->getAssociationMappings();
		
        foreach($associationMappings as $mappedKey => $mappedVal) {
            $keySingular = ucfirst( Inflector::singularize($mappedKey) );

            if( isset($this->parents[$keySingular]) && $mappedVal['isOwningSide']) {
                $entityLayer->populateParent($this->parents[$keySingular], $keySingular);
            }
        }

        return $entityLayer;
    }

    /**
     * Returns the current instance of Doctrine
     * @return Doctrine\Common\Persistence\ObjectManager
     */
    public function getDoctrine() {
        return $this->doctrine;
    }

    /**
     * Persist the given Element as provided by the Parser->toArray() method, handling the specified relationship if
     * specified
     * @param  array    $element        The array provided by the Parser->toArray() method
     * @param  array    $dependencies   The name of the parent relationship
     * @return int      The id of the persisted Entity
     */
    public function persistElement(array &$element) {                      
        $entityName     = $this->_getElementName($element);     
        $this->_freeParents( $entityName );        
        
        $entityLayer    = $this->_getNewEntityLayer($entityName);
        return $this->_handlePersistWithDbal($entityLayer, $element[$entityName]);
	}
    
    /**
     * Metodo che pulisce le relazioni nella variabile parents
     */
    public function _freeParents( $name ) {        
        if( !empty( $this->parents ) ) {
            if( $name == 'Sport' && !empty( $this->parents['Sport']  ) )
                $this->unsetParent( 'Sport' );                
                        
            if( $name == 'Category' && !empty( $this->parents['Category']  ) )
              $this->unsetParent( 'Category' );            
            
            if( $name == 'Tournament' && !empty( $this->parents['Tournament']  ) )
              $this->unsetParent( 'Tournament' );
        }        
    }
    
    public function unsetParent( $name ) {
        $relation = array();
        $relation['Sport']      = array( 'Category', 'Tournament', 'Season' );
        $relation['Category']   = array( 'Tournament', 'Season' );
        $relation['Tournament'] = array( 'Season' );
        
        foreach( $relation[$name] AS $item ) {
//            echo "Cancello: ".$item."\n";            
            unset( $this->parents[$item] );            
        }
    }
    
}
