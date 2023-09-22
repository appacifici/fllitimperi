<?php 
namespace AppBundle\Service\SportradarDataService;

use AppBundle\Service\SportradarDataService\ArrayElement\ArrayElementHandler;
use AppBundle\Service\SportradarDataService\Entity\Layer\SportradarDataLayer;
use Sabre\Xml\Service as SabreXml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

global $count;

class Parser {


    const CREATE_ENTITY                     = 1;
    const CREATE_JSON_DATA_LIVE             = 2;
    const CREATE_JSON_FROM_CLIENT_SOCKET    = 3;

    /**
     * The data fetched by the Parser
     * @var SimpleXMLObject
     */
    private   $debugActive = false;
    protected $data;
    protected $typeFeed;
    protected $idResponse;
    protected $actionPostParse = self::CREATE_ENTITY;
	protected $typeFolderFeed;
    protected $typeFolderDefaultFeed = 'Soccer';
    protected $dataToSocketClient = array();
    protected $aFeed = array(
        'tournament_Soccer',
        'leaguetable_Soccer',
        'squad_Soccer',
        'playerstatistics_Soccer',
//        'matchdetails_Soccer', //postmatch
        'livescore_Livescore',
        'schedulesandresult_Soccer',
//		'assists_Soccer'
		'bwin_BwinLive',
		'bwin_Bwin',
    );
	
	/**
	 * The base path to the NodeFeed classes w/o the trailing slash
	 * @var string
	 */
	private $_basePath;
	
    /**
     * A flag that, if enabled, tells the Parser to skip the nested data
     * @var bool
     */
    private $_exceptionThrown = FALSE;
	
	/**
	 * The root node in the XML feed
	 * @var string
	 */
	private $_rootNode;

    /**
     * The ArrayElementHandler
     * @var ArrayElementHandler
     */
    protected $arrayElementHandler;
    
    //Servizio classi utilità
    protected $globalUtility;

    /**
     * The SabreXML Parser
     * @var Reader
     */
    protected $sabreXml;

    public function __construct(
            ArrayElementHandler $arrayElementHandler,  
            \AppBundle\Service\UtilityService\GlobalUtility $globalUtility,
            \AppBundle\Service\UtilityService\GlobalQueryUtility $globalQueryUtility ) {
        
        $this->_basePath                        = __NAMESPACE__ . "\Feed";
        $this->arrayElementHandler  = $arrayElementHandler;
        $this->globalUtility        = $globalUtility;
        $this->globalQueryUtility   = $globalQueryUtility;
        
        $this->sabreXml             = new SabreXml();
        $this->sabreXml->elementMap = ['{http://xmlexport.scoreradar.com/V1/}SportradarData' => 'Sabre\Xml\Element\KeyValue'];
    }

    /**
     * Parse the given feed
     * @param string $feed The path of the feed to parse
     */
    public function parse($feed, $folder, $feedType) {
        $fs = new FileSystem();
		
        if( !$fs->exists( $feed ) ) {
            throw new \InvalidArgumentException( 'File not found', 404 );
        }
        $originalNamefeed = $feed;       
        $baseName =  explode( '/', $originalNamefeed ) ;
        
        $fileLog = str_replace( '.xml', '.log', end( $baseName ) );
        $fileLog =  str_replace( end( $baseName ), $fileLog, $feed );        
//        $this->arrayElementHandler->logger->pushHandler(new StreamHandler( $fileLog, Logger::DEBUG)); // <<< uses a stream

        // add records to the log
//        $this->arrayElementHandler->logger->info( 'Init Import' );        

        $this->data = file_get_contents($feed);        
        
        if( trim( $folder, '/' ) == 'bwinLive' ) {
            $switchStr = false;
            $this->_rootNode = false;
            $this->typeFeed = 'BwinOddsLive';
            $this->typeFolderFeed = 'BwinLive';
                    
        } else if( trim( $folder, '/' ) == 'bwin' ) {
            $switchStr = false;
            $this->_rootNode = false;
            $this->typeFeed = 'BwinOdds';
            $this->typeFolderFeed = 'Bwin';
                    
        } else {
        
            $attributes = $this->getXmlAttributes('array');
            $switchStr 	= '';
            $this->_rootNode = $attributes['rootNode'];

            if( !empty($attributes['serviceName']) ) {
                $switchStr = ( isset($attributes['serviceName']) ) ? $attributes['serviceName'] . '_' . $feedType : $attributes['rootNode'];

                if( !empty($attributes['fileName']) ) {
                    $feed = $attributes['serviceName'] . '_' . $attributes['fileName'];
                }
            } else {
                $feed = '';
            }


            foreach( $this->aFeed AS $name ) {
                if( strpos( $feed, $name ) !== false ) {

                    $name = explode( '_', $name );

                    // Determina di quale sport è il feed
                    // i.e. squad_Soccer.ASROMA.2702_1453906224591.xml
                    // $name[0] = 'squad'
                    // $name[1] = 'Soccer'
                    $this->typeFeed  		= $name[0];
                    $this->typeFolderFeed 	= $name[1];

                    //return $name;
                }
            }                    
        }

        switch( $switchStr ) {            
            case 'matchdetails_from_socket_to_entity_json':
            case 'livescore_from_socket_to_entity_json':
//                $this->arrayElementHandler->logger->info( 'Type Import' .$switchStr );
                $resp = $this->parseFromSocketToEntityJson();
                break;
            case 'matchdetails_from_socket_to_client':
            case 'livescore_from_socket_to_client':
//                $this->arrayElementHandler->logger->info( 'Type Import' .$switchStr );
                echo $this->parseFromSocketToClient();
                exit;
            break;
            default:                
//                $this->arrayElementHandler->logger->info( 'Type Import: Default'  );
                $resp = $this->parseSpecificFeed( $this->_rootNode );                
            break;       
        }        
                
        
        if( $resp == FALSE ) {
//            $this->arrayElementHandler->logger->info( 'unlink '.$originalNamefeed );
            echo 'unlink '.$originalNamefeed."\n";
//            unlink ( $originalNamefeed );            
            $baseName =  explode( '/', $originalNamefeed ) ;
//            unlink ( str_replace( '.xml', '.log', $originalNamefeed ) );
            return false;
        } else {
//            $this->arrayElementHandler->logger->info( 'mv '.$originalNamefeed );            
            $baseName =  explode( '/', $originalNamefeed ) ;
            $this->mvFile( $originalNamefeed, end( $baseName), strtolower( $folder ) );
//            $this->mvFile( $fileLog, str_replace( '.xml', '.log', end( $baseName ) ), strtolower( $folder ) );
            return false;
        }        
        return $this;
    }
    
     /**
     * Fa il move del file per i backupdaemon
     * @param type $oldFile
     * @param type $newFile
     */
    public function mvFile( $oldFile, $newFile, $folder ) {
        return;
        $base = '/home/prod/site/livescoreServices/var/backupSportradar';
        if( !file_exists( $base ) )
            $base = '/home/ale/backupSportradar';
        
        $year  = date( 'Y' );
        $month = date( 'm' );
        $day   = date( 'd' );        
        $path = "{$base}/{$year}/{$month}/{$day}/{$folder}";
        
        $old = umask(0);
        if( !file_exists( "{$base}/{$year}" ) )
            mkdir( "{$base}/{$year}", 0777 );
        
        if( !file_exists( "{$base}/{$year}/{$month}" ) )
            mkdir( "{$base}/{$year}/{$month}", 0777 );
        
        if( !file_exists( "{$base}/{$year}/{$month}/{$day}" ) )
            mkdir( "{$base}/{$year}/{$month}/{$day}", 0777 );
            
        if( !file_exists( "{$base}/{$year}/{$month}/{$day}/{$folder}" ) )
            mkdir( "{$base}/{$year}/{$month}/{$day}/{$folder}", 0777 );
            
        umask($old);
        exec( 'mv '.$oldFile.' '.$path.'/'.$newFile );
//        $this->arrayElementHandler->logger->info( 'mv '.$oldFile.' '.$path.'/'.$newFile );    
        echo 'mv '.$oldFile.' '.$path.'/'.$newFile."\n";
    }

    /**
     * Metodo che avvia il parser del feed che viene ricevuto da uno stream socket
     * per essere inviato al socket client degli utenti
     */
    public function parseFromSocketToClient() {
        //Sovrascrive il tipo di azione post parse
        $this->actionPostParse = self::CREATE_JSON_FROM_CLIENT_SOCKET;
        return $this->parseSpecificFeed();
    }

    /**
     * Metodo che avvia il parser del feed che viene ricevuto da uno stream socket e
     */
    public function parseFromSocketToEntityJson() {
//        echo 'sii';
        //Sovrascrive il tipo di azione post parse
        $this->actionPostParse = self::CREATE_JSON_DATA_LIVE;
        return $this->parseSpecificFeed();
    }

     /**
     * Metodo che avvia il parser del feed
     * @param type $xml
     */
	public function parseSpecificFeed($rootNode = '') {
        $classPath =  $this->_basePath . "\\" . $this->typeFolderFeed . "\Feed" . ucfirst($this->typeFeed);
		
        if( !class_exists($classPath) ) {
			if( empty($this->typeFeed) && !empty($rootNode) ) {
				// Fallback for detecting the feed type checking the root node
				// i.e. the OddsFeed doesn't have any attributes but the root element (<OddsFeed>) is quite eloquent, isn't it?
				$classPath = $this->_basePath . "\\" . $this->typeFolderDefaultFeed . "\Feed" . ucfirst($rootNode);
			} else {
				$classPath = $this->_basePath . "\\" . $this->typeFolderDefaultFeed . "\Feed" . ucfirst($this->typeFeed);
			}
        }        
        
		$classFeed = new $classPath();

        //recupera la lista dei nodi da leggere
        $nodeList = $classFeed->getListNodes( $this->actionPostParse );

        $this->xml = new \DOMDocument();
        $this->xml->loadXML( $this->data, LIBXML_PARSEHUGE );

        //Avvia la lettura del  file
        return $this->readNodesFeed( $nodeList['root'] );
	}

    /**
     * Cicla l'array dei nodi da leggere ed effettua la lettura del nodo xml
     * @param array $nodes [ Array contenente il metodo di lettura dei vari nodi del feed ]
     * @param type $xml
     */
    public function readNodesFeed($nodeList) {
		if( empty($nodeList) ) return;
		
        foreach( $nodeList AS $item ) {
            //Recupera il nodo a partire dal path definito
            $node = $this->getPathNode( $item['pathNode'] );            
            //Se ci sono più nodi dell'elemento li cicla tutti
            if( $node->length > 1 ) {
                foreach ( $node as $nodeItem ) {
                    //Recupera l'array con i valori da inserire nel db dell'elemento
                    $this->getDataNode( $item, $nodeItem );                                        
                }
            } else if( $node->length == 1 ) {

                //Recupera l'array con i valori da inserire nel db dell'elemento
                $this->getDataNode( $item, $node->item(0) );
            } else {
                return false;
            }
            
             switch( $this->actionPostParse ) {
                case self::CREATE_JSON_FROM_CLIENT_SOCKET:
                    return json_encode ( $this->dataToSocketClient );                    
                break;
                default: return true;
            }
            
            $this->debug( $this->sep() );
        }
    }

    /**
     *
     * @param type $item
     * @param type $node
     */
    public function getDataNode( $item, $node ) {        
        //Istanzia la classe del nodo per ricavare i dati finali
        $classPath = __NAMESPACE__."\Feed\Node\\".$this->typeFolderFeed.'\\'.ucfirst( $item['name'] )."";
        if( !class_exists( $classPath ) ) {
            $classPath = __NAMESPACE__."\Feed\Node\\".$this->typeFolderDefaultFeed.'\\'.ucfirst( $item['name'] )."";
        }        
        
        //Se è specificata l'entita in cui salvare il dato usa quella altrimenti la ricava dal nome
        $entity = !empty( $item['entity'] ) ? $item['entity'] : $item['name'];

        if( !empty( $node ) ) {
            $params->actionPostParse        = $params = new \stdClass;
            $params->actionPostParse        = $this->actionPostParse;            
            $params->globalUtility          = $this->globalUtility;
            $params->globalQueryUtility     = $this->globalQueryUtility;
            $params->arrayElementHandler    = $this->arrayElementHandler;
            $params->cacheUtility           = $this->arrayElementHandler->cacheUtility;
            $params->lastIdResponse         = $this->idResponse;
            $params->entityName             = $entity;            
            
            $classFeed = new $classPath( $node, $params );
			
            //Recupera i dati
            $dataNode = $classFeed->getDataNode($this->_rootNode);

//                                print_r($dataNode);
            switch( $this->actionPostParse ) {
                case self::CREATE_ENTITY:
                case self::CREATE_JSON_DATA_LIVE:                

//                    print_r($this->idRespo$datanse);
                    try {
                        if( !empty($dataNode) ) {
                            $this->idResponse = $this->arrayElementHandler->persistElement($dataNode);
                        }
                    } catch(\Exception $e) {
                        $this->_exceptionThrown = TRUE;
                        // Log here any catched exception
                    }
                break;
                case self::CREATE_JSON_FROM_CLIENT_SOCKET:
//                    print_R($dataNode);
                    $this->dataToSocketClient[] = $dataNode;
                break;
            }
        }

        if( !empty( $item['child'] ) ) {
            foreach( $item['child'] AS $child ) {
                $this->debug( $child['pathNode'] );
                $child['pathNode'] = $this->getPathNodeToParent( $child['pathNode'], $node );
                $this->readNodesFeed( array( $child ) );
            }
        }
        $this->_exceptionThrown = FALSE;
    }

     /**
     * Metodo che torna il nodo di un path specifico a partire dal nodo padre
     * @param string $pathNode [ Contiene il path del nodo da recuperare ]
     * obj
     */
    private function getPathNodeToParent( $pathNode, $initNode ) {
        $xpath = new \DomXPath($this->xml);
        $this->debug( $initNode->getNodePath().$pathNode );
        $node = $xpath->query( $initNode->getNodePath().$pathNode );
		
        return $node;
    }

     /**
     * Metodo che torna il nodo di un path specifico
     * @param string $pathNode [ Contiene il path del nodo da recuperare ]
     * obj
     */
    private function getPathNode( $pathNode ) {
        if( is_object( $pathNode ) )
            return $pathNode;

        $xpath = new \DomXPath( $this->xml );
        $node = $xpath->query( $pathNode );
        return $node;
    }


    /**
     * Metodo che torna il nodo di un path specifico
     * @param string $pathNode [ Contiene il path del nodo da recuperare ]
     * obj
     */
    private function getPathNode2( $pathNode ) {
        if( is_object( $pathNode ) )
            return $pathNode;

        $node = $this->xml;
        $path = explode( '->', $pathNode );
        foreach( $path AS $item ) {
            $node = $node->{$item};
        }
        return $node;
    }


    private function insertData() {
        return date("Y-m-d H:i:s").rand(1,100);
    }

    /**
     * Returns the XML header attributes
     * @param string $format The format to use for the response (xml, array)
	 * @param SimpleXML $simpleXML If a SimpleXML Object is provided, the string conversion will be skipped
     * @return mixed A value returned in the specified format (xml, array)
     */
    public function getXmlAttributes($format = 'xml', $simpleXml = NULL) {
        try {            
            if( $simpleXml == NULL ) {
                $simpleXml = simplexml_load_string($this->data);
            }

            switch( strtolower($format) ) {
                case 'xml':
                    $data = $simpleXml->attributes();                
                    break;
                case 'array':
                    $ret 	= (array)$simpleXml->attributes();
                    
                    $data 	= ( isset($ret['@attributes']) ) ? $ret['@attributes'] : [];
                    break;
                default:
                    $data = $simpleXml->attributes();
            }

            $data['rootNode'] = $simpleXml->getName();		
            if( $data['rootNode'] == 'BetradarLivescoreData') {
                $data['serviceName'] = 'livescore';
                $data['fileName']    = 'Livescore.liveScore';
            }
            
            return $data;
        }  catch ( Exception $e) {
            return false;
        }
		        
    }

    /**
     * Returns an array according to the parsed data
     * @return array
     */
    public function toArray() {
        return $this->sabreXml->parse($this->data);
    }

    public function toXml() {
        return simplexml_load_string($this->data);
    }

     /**
     * Funziona di stampa debug
     * @param type $msg
     */
    public function debug( $msg ) {
        if( !$this->debugActive )
            return false;

        if( is_array( $msg ) ) {
            print_r( $msg );
        } else if( is_object( $msg ) ) {
            print_r( $msg );
        } else {
            echo "\n".$this->sep() ."\n\n" . $msg . "\n";
        }
    }

    /**
     * Costruisce una stringa di separazione per il debug
     * @return type
     */
    public function sep( $limit = 147 ) {
        $sep = '#';
        for( $x = 0; $x < $limit; $x++ )
            $sep .= '-';
        return $sep.'#';
    }

}
