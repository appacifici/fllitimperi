<?php

namespace AppBundle\Service\AffiliationService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;

session_start();
$sessioneId = session_id();

class DeamonAffiliation {

    public $pdo;
    public $typeImport;
    public $affiliations = null;
    public $limitProduct;
    public $config;
    public $main;
    public $statsAffiliation = null;
    private $debugActive = false;
    
    public function __construct( ObjectManager $doctrine, Container $container, GlobalUtility $globalUtility ) {
        $this->doctrine = $doctrine;
        $this->container = $container; 
        $this->globalUtility = $globalUtility; 
    }
    
    /**
     * Metodo costruttore della classe
     * @params obj $this->mySql ( Oggetto pdo per la connesione al db )
     * @params string $idAffiliations ( elenco delle affiliazioni da importare ES: 23,24,67,87,96 )
     * @params string $typeImport ( tipo di importazione da eseguire consentite [xml|cvs] )
     */
    public function run(
            $container,
            $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $limitProduct = false,
            $typeImport = 'xml', $idAffiliation = null, $pathFile = false, $importOnlySection = false, $debugActive = false            
        ) {
        
        $this->container        = $container;
        $this->dbHost           = $dbHost;
        $this->dbPort           = $dbPort;
        $this->dbName           = $dbName;
        $this->dbUser           = $dbUser;
        $this->dbPswd           = $dbPswd;
        $this->limitProduct     = $limitProduct;
        $this->typeImport       = $typeImport;
        $this->pathFile         = $pathFile;
        $this->importOnlySection= $importOnlySection;
        $this->idAffiliation    = $idAffiliation;
        $this->mySql = new \PDO('mysql:host='.$dbHost.';port='.$dbPort.';', $dbUser, $dbPswd);
        
        $params = new \stdClass();
        $params->mySql              = $this->mySql;
        $params->dbName             = $this->dbName;
        $params->container          = $this->container;
        $params->globalUtility      = $this->globalUtility;
        $params->debugActive        = false;       
        $params->importOnlySection  = $importOnlySection;       
        $this->affiliationUtility   = new AffiliationUtility( $params );
        
        require_once 'Affiliations.php';
//        require_once 'affiliations/MaintenanceAffiliation.class.php';
        require_once 'affiliations/DefaultAffiliation.class.php';        
        require_once 'affiliations/UnieuroAffiliation.class.php';        
        require_once 'affiliations/YooxPrivateNetworkAffiliation.class.php';        
        require_once 'affiliations/BricoIoAffiliation.class.php';
        require_once 'affiliations/EpriceAffiliation.class.php';
        require_once 'affiliations/MonclickAffiliation.class.php';
        require_once 'affiliations/BonPrixAffiliation.class.php';
        require_once 'affiliations/SwarovskiAffiliation.class.php';
        require_once 'affiliations/DouglasAffiliation.class.php';
        require_once 'affiliations/ZooplusAffiliation.class.php';
        require_once 'affiliations/WineowineAffiliation.class.php';
        require_once 'affiliations/AutopartiAffiliation.class.php';        
        require_once 'affiliations/MadeInDesignAffiliation.class.php';        
        require_once 'affiliations/EGlobalcentralAffiliation.class.php';
        require_once 'affiliations/MaintstoreAffiliation.class.php';
        require_once 'affiliations/Awin/SmartBuyGlassesAffiliation.class.php';
        require_once 'affiliations/Awin/AlternateAffiliation.class.php';
        require_once 'affiliations/Awin/OnedirectAffiliation.class.php';
        require_once 'affiliations/Awin/IdealoAffiliation.class.php';
        require_once 'affiliations/Awin/EuronicsAffiliation.class.php';
        require_once 'affiliations/Awin/WireshopAffiliation.class.php';
        require_once 'affiliations/Awin/GearbestAffiliation.class.php';
        require_once 'affiliations/Awin/DecathlonAffiliation.class.php';
        require_once 'affiliations/Zanox/FreeshopAffiliation.class.php';
        require_once 'affiliations/Tradedoubler/SpartooAffiliation.class.php';
        require_once 'affiliations/Tradedoubler/EscarpeAffiliation.class.php';
        require_once 'affiliations/Tradedoubler/BowdooAffiliation.class.php';
        
        $this->debugActive = $debugActive;
        $this->statsAffiliation = new \stdClass();

        //Seleziona le affiliazioni da importare
        $this->affiliations = $this->selectListAffiliations( $idAffiliation );        
        foreach ( $this->affiliations as $affiliation ) {
            $lastReadAffiliation = '';
            
            //Recupera l'ultima data di aggiornamento del feed
            if ( !empty( $affiliation->link_last_update ) )
                $lastReadAffiliation = $this->lastModifyAffiliation( $affiliation->link_last_update );                        
            $lastReadAffiliation = '';

            
            if ( empty( $lastReadAffiliation ) || $affiliation->last_read < $lastReadAffiliation ) {
//                Scarica il feed nel server
                $pathFeed = $this->downloadFeed( $affiliation->url, $affiliation->name );
//                $pathFeed = '/home/ale/catalogs/Freeshop.xml';

                if ( $this->typeImport == 'xml' )
                    $this->importFeedXml( $pathFeed, $affiliation );

                else if ( $this->typeImport == 'csv' )
                    $this->importFeedCsv( $pathFeed, $affiliation );

                $this->setLastReadFeed( $affiliation->id );
            } else {
                $this->debug( 'Feed già importato' );
            }
        }
    }

    /**
     * Metodo che recupera la lista degli affiliati da importare
     * @params int $idAffiliations ( lista id affiliazioni da importare )
     */
    private function selectListAffiliations( $id = null) {
        $inId = '';
        if ( $id != null )
            $inId = ' WHERE id IN ( ' . $id . ' )';
        
        $sql = "SELECT * FROM " . $this->dbName.'' . ".affiliations" . $inId;        
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        return $stn->fetchAll( \PDO::FETCH_OBJ );
    }

    /**
     * Metodo che ritorna la data dell'ultimo aggiornamento del feed
     * @params string $linkLastUpdate ( link per il recupero della data dell'ultimo aggiornamento del feed )
     */
    private function lastModifyAffiliation( $linkLastUpdate ) {
        $date = file_get_contents( $linkLastUpdate );
        return trim( $date, 'Z' );
    }

    /**
     * Metodo che scarica il file del feed nel sul server
     * @params string $url ( path del feed da scaricare sul server )
     */
    private function downloadFeed( $url, $name ) {
        $this->statsAffiliation->dataStart = date( 'Y-m-d H:i:s' );
        $start = microtime( true );

        $path = $this->pathFile . '/' . str_replace( ' ', '_', $name );
        $command = 'wget --content-disposition --no-cache -k "' . $url . '&rand=' . rand(1, 5000) . '" --output-document=' . $path . '.gz ';
        system( $command, $output );
        $this->debug( $command );

        //Set parametri statistiche import
        $this->statsAffiliation->kbFeed = $this->globalUtility->bytesToSize( filesize( $path . '.gz' ) );

        $command = 'rm ' . $path . '.xml';
        system( $command );
        $this->debug( $command );

        $command = 'gunzip ' . $path . '.gz && mv ' . $path . ' ' . $path . '.xml';
        system($command);
        $this->debug($command);

        //Set parametri statistiche import
        $this->statsAffiliation->durationDownloadFeed = microtime(true) - $start;
        return $path . '.xml';
    }

    /**
     * Metodo che cicla i risultati del feed
     * @params string $linkFeed ( path interno al server per la lettura del feed scaricato in xml )
     */
    private function importFeedXml($linkFeed, $affiliation) {
        $start = microtime(true);
        //Set parametri statistiche import
        $this->statsAffiliation->message = 'NULL';
        $this->statsAffiliation->fkAffiliation = $affiliation->id;
        $this->statsAffiliation->numImport = 0;
        $this->statsAffiliation->numUpdate = 0;
        
        $document = simplexml_load_file($linkFeed, 'SimpleXMLElement', LIBXML_NOCDATA);
        echo "INIZIO IMPORT\n";
        $x = $i = 0;
        $maxP = count($document->product) - 1;

        //Set parametri statistiche import
        $this->statsAffiliation->status = $maxP > 0 ? 1 : 0;
        $this->statsAffiliation->numElement = $maxP + 1;
        
        $this->classAffiliation = $this->createClassAffiliation( $affiliation );

        //echo "{$this->limitProduct} && {$x} == {$this->limitProduct} || {$x} == {$maxP}";		
        foreach ( $document->product as $product ) {
//            if( $product->TDProductId != '2667912065' ) {                
//                continue;
//            } else {
//                echo '########=>>>>>ECCOLOOOOOO'.$product->aw_product_id."\n";
//                echo $product->name;
//            }
  
            $product = $xml = json_decode( json_encode( (array) $product), FALSE );
            $dataImport = date( 'Y-m-d H:i:s' );
            $i++;
            if ( $x >= 0 ) {
                if ( !$this->isNewProduct( $product, $affiliation ) ) {
                    $this->statsAffiliation->numUpdate++;
                    $this->debug( $dataImport . ' Prodotto gia inserito ==>' . $product->name, false );
                    continue;
                } else {
                    $this->statsAffiliation->numImport++;
                    $this->debug( $dataImport . ' ' . $x . ' Prodotto DA INSERIRE ==>' . $product->name, false );
                    $x++;
                }
                $this->runAffiliation( $affiliation, $product );
            }
            if ( ( $this->limitProduct && ( $x == $this->limitProduct ) ) || $x == $maxP )
                break;
        }
        
//        $this->setNumProducts();
        //$this->clearBusinessCacheFiles();
        $this->debug( 'Totale prodotti feed ' . $maxP );

        //Set parametri statistiche import
        $this->statsAffiliation->dataEnd = date( 'Y-m-d H:i:s' );
        $this->statsAffiliation->durationImport = microtime( true ) - $start;
        $this->statsAffiliation->durationGlobal = $this->statsAffiliation->durationDownloadFeed + $this->statsAffiliation->durationImport;

        $this->disableProducts($affiliation->id, $this->statsAffiliation->dataStart);
        $this->reactivatesProducts($affiliation->id, $this->statsAffiliation->dataStart);
        $this->setStatsAffiliation();
        echo "FINE IMPORT\n";
    }

    /**
     * Metodo che effeffua la disabilitazione dei prodotti non più presenti nel feed dell'affiliato
     * @param int $idAffiliation
     * @param datatime $dataStart
     */
    private function disableProducts($idAffiliation, $dataStart) {
        $this->statsAffiliation->numDisabled = $this->affiliationUtility->disableProducts($idAffiliation, $dataStart);
    }

    /**
     * Metodo che riattiva i prodotti che erano stati disattivati che sono stati nuovamente trovati nel feed
     * @param int $idAffiliation
     * @param datatime $dataStart
     */
    private function reactivatesProducts($idAffiliation, $dataStart) {
        $this->statsAffiliation->numDisabled = $this->affiliationUtility->reactivatesProducts($idAffiliation, $dataStart);
    }
    
    /**
     * Metodo che setta il numero di prodotti per categoria sottocategoria affiliati e marchi
     * @param int $idAffiliation
     * @param int $count
     */
    private function setNumProducts() {
        $this->affiliationUtility->setNumberProducts();
    }

    /**
     * Metodo che verifica se il prodotto da inserire sia nuovo o già esistente
     * @param array $product
     * @param int $idAffiliation
     * @return boolean
     */
    private function isNewProduct( $product, $affiliation ) {
        $idAffiliation = $affiliation->id;
        switch ( $idAffiliation ) {
            case 2:            
            default:  
                $product->number = !empty($product->number) ? $product->number : $product->TDProductId;
            break;
            //TRADEDUBLER
            case 5: 
            case 6: 
            case 8: 
            case 9: 
            case 10: 
            case 11: 
            case 12: 
            case 13:                         
            case 24: 
            case 25: 
            case 26: 
                $product->number = !empty($product->number) ? $product->number : $product->TDProductId;
            break;
            //AWIN
            case 14: 
            case 15: 
            case 17: 
            case 18: 
            case 19: 
            case 20:             
            case 27:             
            case 28:             
            case 29:            
            case 21:
                $product->number = $product->aw_product_id;
                $product->name   = $product->product_name;
                $product->price =  $product->search_price;
            break;
        }
        
        echo $sql = "SELECT id,price,prices,last_modify FROM " . $this->dbName . ".products WHERE affiliation_id = '" . $idAffiliation . "' AND number = '" . $product->number . "'";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        
        if ( $stn->rowCount() == 0 ) {
            return true;
        } else {
            $row = $stn->fetch( \PDO::FETCH_OBJ );
            $priceDb = $row->price;
            $pricesJson = $row->prices;
            if ( !empty( $product->lastModified ) ) {
                $lastModify = str_replace( 'T', ' ', $product->lastModified );
                if ( trim( $lastModify ) > trim( $row->last_modify ) ) {
                    $prices = $row->prices;
                    if ( !empty( $row->prices ) ) {
                        $prices = json_decode( $row->prices );
                        $index = count( $prices ) - 1;
                        if ( trim( $prices[$index] ) != trim( $product->price ) )
                            $prices[] = (string) $product->price;
                    } else {
                        $prices = json_decode( $row->prices );
                        $prices[] = trim( (string) $product->price );
                    }
                    $pricesJson = json_encode( $prices );
                }
            }

            $updateHandlingCost = '';
            $handlingCost = $this->getHandlingCost( $product );
            if( !empty( $handlingCost ) ) {
                if(!is_object( $handlingCost ) )                    
                    $updateHandlingCost = ",handling_cost = '" . $handlingCost. "'";
            }
            

            $setLastPrice = $priceDb != $product->price ? 'last_price = price,' : '';

            $date = date('Y-m-d H:i:s');
            $product->last_modified = !empty( $product->last_modified ) ? (string) $product->last_modified : (string) $date;
            if( !empty( $product->price ) && $product->price > '0.99' ) {
                echo $sql = "
                    UPDATE " . $this->dbName . ".products SET
                        last_read = '" . $date . "',
                        last_modify = '" . str_replace('T', ' ', $product->last_modified) . "',
                        $setLastPrice
                        price = '" . $product->price . "',
                        prices = '" . addslashes($pricesJson) . "'
                        $updateHandlingCost
                    WHERE id = $row->id
                ";
                //is_active = 1 RIMOSSO DALLA QUERY PERCHE RIATTIVAVA I PRODOTTI SPENTI A MANO, DA FIXARE SENNO NON RI RIATTIVANO I PRODOTTI SPENTI DAGLI SCRIPT DI IMPORTAZIONE

                $stn = $this->mySql->prepare( $sql );
                if ( !$stn->execute() )
                $this->debug( $sql );
            }

//            $classAffiliation = $this->createClassAffiliation( $affiliation );            
            
//            $dataProductExtra = $classAffiliation->getExtraDataProduct($product);
//            if (!empty($dataProductExtra) && (!empty($dataProductExtra->colors) || !empty($dataProductExtra->sizes) )) {
//                $sql = "
//					UPDATE " . $this->dbName . ".productExtra 
//						SET color = '{$dataProductExtra->colors}', size = '{$dataProductExtra->sizes}'
//					WHERE fkProduct = $row->idProduct";
//                $stn = $this->mySql->prepare($sql);
//                $this->debug($sql);
//                if (!$stn->execute())
//                    $this->debug($sql);
//            }
        }
        return false;
    }
    
    /**
     * Ricava le spese di spedizione per 
     * @param type $product
     * @return type
     */
    private function getHandlingCost( $product ) {
        if( !empty( $product->shippingHandlingCosts ) )
            return $product->shippingHandlingCosts; 
        
        if( !empty( $product->shippingHandlingCost ) )
            return $product->shippingHandlingCost; 
        
        if( !empty( $product->shippingCost ) )
            return $product->shippingCost;
        
        return false;
    }
    
    /**
     * Metodo che instanzia la classe per l'affiliazione richiesta
     * @param object $affiliation
     * @return \DefaultAffiliation
     */
    private function createClassAffiliation( $affiliation ) {
        $params = new \stdClass();
        $params->mySql              = $this->mySql;
        $params->dbName             = $this->dbName;
        $params->container          = $this->container;
        $params->globalUtility      = $this->globalUtility;
        $params->debugActive        = $this->debugActive;       
        $params->affiliationId      = $affiliation->id;       
        $params->affiliationName    = $affiliation->name;       
        $params->importOnlySection  = $this->importOnlySection;       
//        $this->affiliationUtility   = new AffiliationUtility( $params );
        
        switch( strtolower( $affiliation->id ) ) {
            case 1:
                $classAffiliation = new UnieuroAffiliation( $params );
            break;           
            case 2:
                $classAffiliation = new YooxPrivateNetworkAffiliation( $params );
            break;
            case 5:
                $classAffiliation = new EpriceAffiliation( $params );
            break;
            case 6:
                $classAffiliation = new BricoIoAffiliation( $params );
            break;
            case 7:
                $classAffiliation = new SwarovskiAffiliation( $params );
            break;
            case 8:
                $classAffiliation = new MonclickAffiliation( $params );
            break;
            case 9:
                $classAffiliation = new BonPrixAffiliation( $params );
            break;
            case 10:
                $classAffiliation = new DouglasAffiliation( $params );
            break;
            case 11:
                $classAffiliation = new ZooplusAffiliation( $params );
            break;
            case 11:
                $classAffiliation = new ZooplusAffiliation( $params );
            break;
            case 12:
                $classAffiliation = new WineowineAffiliation( $params );
            break;
            case 13:
                $classAffiliation = new AutopartiAffiliation( $params );
            break;
            case 14:
                $classAffiliation = new SmartBuyGlassesAffiliation( $params );
            break;
            case 15:
                $classAffiliation = new EuronicsAffiliation( $params );
            break;
            case 17:
                $classAffiliation = new EGlobalcentralAffiliation( $params );
            break;
            case 18:
                $classAffiliation = new MaintstoreAffiliation( $params );
            break;
            case 19:
                $classAffiliation = new AlternateAffiliation( $params );
            break;
            case 20:
                $classAffiliation = new OnedirectAffiliation( $params );
            break;
            case 21:
                $classAffiliation = new FreeshopAffiliation( $params );
            break;
            case 24:
                $classAffiliation = new SpartooAffiliation( $params );
            break;
            case 25:
                $classAffiliation = new EscarpeAffiliation( $params );
            break;
            case 26:
                $classAffiliation = new BowdooAffiliation( $params );
            break;
            case 27:
                $classAffiliation = new WireshopAffiliation( $params );
            break;
            case 28:
                $classAffiliation = new GearbestAffiliation( $params );
            break;
            case 29:
                $classAffiliation = new DecathlonAffiliation( $params );
            break;
            case 111115:
                $classAffiliation = new MadeInDesignAffiliation( $params );
            break;
            default:
                $classAffiliation = new DefaultAffiliation( $params );
            break;
        }
        return $classAffiliation;
    }

    /**
     * Metodo che chiama la classe che gestisce l'inserimento di uno specifico affiliato
     */
    private function runAffiliation( $affiliation, $product ) {
//        $classAffiliation = $this->createClassAffiliation( $affiliation );
        $this->classAffiliation->init( $affiliation, $product );
//        unset( $classAffiliation );
    }

    /**
     * Metodo per il recupero dell'ultima importazione di un feed
     * @params int $idAffiliation ( id dell'affiliazione per cui recuperare la data di ultima importazione )
     */
    private function setLastReadFeed( $idAffiliation ) {
        $data = date( "Y-m-d H:i:s" );
        $sql = "UPDATE " . $this->dbName . ".affiliations SET last_read = '" . $data . "' WHERE id = " . $idAffiliation;
        $this->mySql->query( $sql );
    }

    /**
     * Metodo che inserire il resposto delle statitiche di import del feed
     */
    private function setStatsAffiliation() {
        $counts = $this->affiliationUtility->countNumberProductsAffiliation( $this->statsAffiliation->fkAffiliation );

        $this->statsAffiliation->productsActive         = $counts->productsActive;
        $this->statsAffiliation->productsDisabled       = $counts->productsDisabled;
        $this->statsAffiliation->durationDownloadFeed   = substr($this->statsAffiliation->durationDownloadFeed, 0, 7);
        $this->statsAffiliation->durationImport         = substr($this->statsAffiliation->durationImport, 0, 7);
        $this->statsAffiliation->durationGlobal         = substr($this->statsAffiliation->durationGlobal, 0, 7);

        $sql = "INSERT INTO " . $this->dbName . ".statsFeedAffiliations ( 
				affiliation, 
				data_start, 
				data_end, 
				kb_feed,
				duration_download_feed,
				duration_import, 				 
				duration_global, 
				is_active, 
				num_element, 
				num_import, 
				num_update,
				num_disabled,
				products_active,
				products_disabled,
				message 
		) VALUES ( 
            '{$this->statsAffiliation->fkAffiliation}',
            '{$this->statsAffiliation->dataStart}',
            '{$this->statsAffiliation->dataEnd}',
            '{$this->statsAffiliation->kbFeed}',					
            '{$this->statsAffiliation->durationDownloadFeed}',
            '{$this->statsAffiliation->durationImport}',			
            '{$this->statsAffiliation->durationGlobal}',
            '{$this->statsAffiliation->status}',				
            '{$this->statsAffiliation->numElement}',					
            '{$this->statsAffiliation->numImport}',
            '{$this->statsAffiliation->numUpdate}',
            '{$this->statsAffiliation->numDisabled}',
            '{$this->statsAffiliation->productsActive}',
            '{$this->statsAffiliation->productsDisabled}',
            '{$this->statsAffiliation->message}'					
		)";
        //$this->debug( $sql );
        $stn = $this->mySql->prepare( $sql );
        if ( !$stn->execute() ) {
            $this->debug( 'ERRORE: '.$sql );
        }
    }

    public function debug($msg, $sep = true) {
//        if (!$this->debugActive)
//            return false;

        if ($sep)
            echo "\n" . $this->sep() . "\n";

        echo $msg;
        if (!$sep)
            echo "\n";

        if ($sep)
            echo "\n" . $this->sep() . "\n";
    } 

    public function sep() {
        $sep = '#';
        for ($x = 0; $x < 100; $x++)
            $sep .= '-';
        return $sep . '#';
    }
}
