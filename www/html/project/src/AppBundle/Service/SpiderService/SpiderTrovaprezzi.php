<?php

namespace AppBundle\Service\SpiderService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;

class SpiderTrovaprezzi {
    private $container;
    private $doctrine;
    private $prxC;
    private $typeCurl = '';
    private $category_id;
    private $subcategory_id;
    private $typology_id;
    private $trademark_id;
    private $modelId;
    private $itemModel = 0;
        
    public function __construct( ObjectManager $doctrine, Container $container, GlobalUtility $globalUtility ) {
        $this->doctrine = $doctrine;
        $this->container = $container; 
        $this->globalUtility = $globalUtility; 
    }

    /**
     * Metodo che elimina le immagini top News quando gli articoli sono stati pubblicati da più di un mese
     */
    public function run( $dbHost, $dbPort,$dbName, $dbUser, $dbPswd,  $action, $category_id ) {
        $this->action       = $action;
        $this->dbHost       = $dbHost;
        $this->dbName       = $dbName;
        $this->dbUser       = $dbUser;
        $this->dbPswd       = $dbPswd;
        $this->category_id  = $category_id;
        
        echo 'mysql:host='.$dbHost.';port='.$dbPort.';';
        
        try {
            $this->mySql        = new \PDO('mysql:host='.$dbHost.';port='.$dbPort.';', $dbUser, $dbPswd);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
        
//        include( "ProxyConnector/proxyConnector.class.php" );        
//        $this->prxC = proxyConnector::getIstance();
//        $this->prxC->newIdentity();
                
        switch( $action ) {
            case 'globalSpider':
            case 'listModelsTrademark':
            case 'otherTrademarks':
                $this->globalSpider();
            break;            
        }
    }
    
    /**
    * Funzione che per il recupero del contenuto di una pagina remota in due modalit� differenti
    * @params strinf $proxy ( se proxy chiama il metodo della classe proxyConnector altrimenti il metodo nativo php file_get_contents )
    * @return string
    */
   public function fileGetContent( $file, $type = 'proxy' ) {
       try {
           echo "############################## $file #############################";
           
            $type = '';
            if ( $type == 'proxy' ) {                      
                echo 'etrno2';
                $string = $this->prxC->getContentPage( $file );
            } else {                
               $string = file_get_contents( $file );
            }
        } catch (Symfony\Component\Debug\Exception\ContextErrorException $e) {          
            return false;
        } catch (\Exception $e) {
            return false;
        }
        return  $string ;
    }
    
    
    /**
     * Avvia lo spider totale per trovaprezzi a partire da una categoria
     */
    private function globalSpider() {
//        79.56.208.37
        
        $this->aSubcategoriesTP = array();
        $this->aSubcategoriesTP[1]  = 'https://www.trovaprezzi.it/prezzi_elettrodomestici.aspx';
        $this->aSubcategoriesTP[2]  = 'https://www.trovaprezzi.it/prezzi_informatica.aspx';
        $this->aSubcategoriesTP[3]  = 'https://www.trovaprezzi.it/prezzi_casa-giardino.aspx';
        $this->aSubcategoriesTP[4]  = 'https://www.trovaprezzi.it/prezzi_telefonia.aspx';
        $this->aSubcategoriesTP[5]  = 'https://www.trovaprezzi.it/prezzi_sport.aspx';
        $this->aSubcategoriesTP[6]  = 'https://www.trovaprezzi.it/prezzi_audio-video.aspx';
        $this->aSubcategoriesTP[7]  = 'https://www.trovaprezzi.it/prezzi_salute-bellezza.aspx';
//        $this->aSubcategoriesTP[8]  = 'https://www.trovaprezzi.it/prezzi_moda.aspx';
        $this->aSubcategoriesTP[9]  = 'https://www.trovaprezzi.it/prezzi_auto-moto.aspx';
        $this->aSubcategoriesTP[10] = 'https://www.trovaprezzi.it/prezzi_infanzia.aspx';
        $this->aSubcategoriesTP[11] = 'https://www.trovaprezzi.it/prezzi_giochi-hobby.aspx';
        $this->aSubcategoriesTP[12] = 'https://www.trovaprezzi.it/prezzi_fotografia.aspx';
        $this->aSubcategoriesTP[13] = 'https://www.trovaprezzi.it/prezzi_prodotti-animali.aspx';
        $this->aSubcategoriesTP[14] = 'https://www.trovaprezzi.it/prezzi_orologi-gps-strumentazione.aspx';
        $this->aSubcategoriesTP[15] = 'https://www.trovaprezzi.it/prezzi_vini-alimentari.aspx';
        $this->aSubcategoriesTP[16] = 'https://www.trovaprezzi.it/prezzi_prodotti-ufficio.aspx';
        $this->aSubcategoriesTP[17] = 'https://www.trovaprezzi.it/prezzi_ottica.aspx';
        $this->aSubcategoriesTP[18] = 'https://www.trovaprezzi.it/prezzi_gioielli.aspx';
        $this->aSubcategoriesTP[19] = 'https://www.trovaprezzi.it/prezzi_libri.aspx';
        $this->aSubcategoriesTP[20] = 'https://www.trovaprezzi.it/prezzi_musica.aspx';
        $this->aSubcategoriesTP[21] = 'https://www.trovaprezzi.it/prezzi_idee-regalo-gadgets.aspx';
        $this->aSubcategoriesTP[22] = 'https://www.trovaprezzi.it/prezzi_viaggi-voli-hotel.aspx';
        $this->aSubcategoriesTP[23] = 'https://www.trovaprezzi.it/prezzi_servizi.aspx';        
        $this->getSubcategory( $this->aSubcategoriesTP[$this->category_id] );
    }
    
    /**
     * Recupera tutte le sottocategorie, e le sue tipologie
     * @param type $url
     * @return boolean
     */
    private function getSubcategory( $url ) {
        echo 'entrooo';
        $result = $this->fileGetContent( $url, $this->typeCurl );
        if( empty( $result ) ) {
            echo 'escooo';
            return false;
        }
        
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );

        $elements = $xpath->query("//div[@id='fullpage_container']/ul/li[@class='list_item mother_item']");
//        Se non trova elementi
        if ( $elements->length == 0 ) {
            return;
        }
        
        foreach( $elements AS $element ) {
            $this->typology_id      = false;
            $this->trademark_id     = false;
            $this->subcategory_id   = false;
            
            $title = $xpath->query( "div/a", $element );
            if( $title->length == 0 )
                continue;
            
            //lancio inserimento o update subcategory
            if( !$this->manageSubcategory( $title[0]->nodeValue, $title[0]->getAttribute('href') ) ) {
                $this->subcategory_id = false;
                return false;
            }
                        
//            sleep( 5 );
//            $this->prxC->newIdentity();  
            
            $child = $xpath->query( "ul[@class='child_list'][1]/li/a", $element );        
            if( $child->length == 0 ) {
                //resetti modelli per subcat_id
                $child = $xpath->query( "div/a", $element );                                    
                $this->getTypologyModel( $child[0]->getAttribute('href') );
                continue;
            }
            
            foreach( $child as $link ) {                
                if( !$this->manageTypology( $link->nodeValue, $link->getAttribute('href') ) )
                    continue;
                
                //resetti modelli per typo_id
                $this->getTypologyModel( $link->getAttribute('href') );
            }                            
            echo "\n\n";            
        }                         
    }
    
    /**
     * Recupera tutti i modelli di una tipologia template principale
     */
    private function getTypologyModel( $path ) {                
        $result = $this->fileGetContent( "https://www.trovaprezzi.it$path", $this->typeCurl );
        if( empty( $result ) )
            return false;
        
        $doc = new \DOMDocument();        
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();
        
        $xpath = new \DOMXpath( $doc );
        
        if( $this->action == 'otherTrademarks') {
            $childs = $xpath->query("//li[@class='list_item mother_item other_brands']//h3/a");
            if( $childs->length == 0 )
                return false;

            foreach( $childs AS $child ) {
                if( !$this->manageTrademark( $child->nodeValue, $child->nodeValue, $child->getAttribute('href'), 0 ) ) {
                    continue;
                }
                $this->getModelPagination( $child->getAttribute('href') );
//                sleep( 5 );
//                $this->prxC->newIdentity();

            }
            echo 'otherTrademarks';
            return true;
        }
        
        // div[@class='brand_variations_list']/h2/strong
//        $elements = $xpath->query("//li[@class='list_item mother_item']");
        $elements = $xpath->query("//div[@class='brand_variations_list']");
        if( $elements->length == 0 ) {
            $this->getTypologyModelCategory( $xpath, $path );
            return false;
        }
        
        foreach( $elements AS $element ) {
            $label = $xpath->query( "h2/strong", $element );
            if( $label->length == 0 ) {
                $listElement = $xpath->query( "div/a", $element );
                
                if( !$this->manageTypology( $listElement[0]->nodeValue, $listElement[0]->getAttribute('href') ) )
                    continue;
                
                
                echo "\n\n=====>#".$listElement[0]->getAttribute('href');
                //se è la grafica tipo: https://www.trovaprezzi.it/prezzi_videogiochi-console.aspx
                //avvio il recupero ricorsivo speciale
                $this->getTypologyModel( $listElement[0]->getAttribute('href') );
                continue;       
            }                        
            
            $title = $xpath->query( "a[@class='goto_brand_page']", $element );
            if( $title->length == 0 )
                return false;
            
           
            if( !$this->manageTrademark( $label[0]->nodeValue, $title[0]->nodeValue , $title[0]->getAttribute('href') ) ) {
                continue;
            }
            
            //Parte per il recupero di tutti i modelli paginati di un  marchio scommentare e commettare il blocco sotto per attivarlo
            if( $this->action == 'listModelsTrademark') {                
                $this->getModelPagination( $title[0]->getAttribute('href') );
//                sleep( 5 );
//                $this->prxC->newIdentity();
                
            //Recupera tutti i modelli della pagina principale di una sottocategoria o tipologia
            } else if( $this->action == 'globalSpider') {            
                $this->itemModel = 0;
//                $child = $xpath->query( "ul[@class='child_list'][1]/li/a", $element );
                $child = $xpath->query( "ul/li[@class='variation']/a", $element );
                foreach( $child as $link ) {
                    
                    $nameModel = $xpath->query( "div[@class='text']/text()", $link );
                    
//                    echo $nameModel[0]->nodeValue.' '. $link->getAttribute('href')."\n";
                    
                    if( $child->length == 0 )
                        continue;

                    if( !$this->manageModel( trim( $nameModel[0]->nodeValue ), $link->getAttribute('href') ) ) {
                        continue;
                    }                                        
                }                                    
            
            //Recupera tutti i modelli delle altre marche in fondo della pagina principale di una sottocategoria o tipologia
            } 
            
        }    
        
        if( $this->action == 'globalSpider') {
            $child = $xpath->query( "//div[contains(@class, 'showcase_carousel')]//div[@class='carousel_item']/a" );
            foreach( $child AS $nameModelTop ) {
                $this->setTopModel( $nameModelTop->getAttribute('href') );
            }
        }
        
    }
       
    /**
     * Recupra i modelli dalla seconda grafica di trovaprezzi esempio:
     * https://www.trovaprezzi.it/prezzi_cartucce-stampanti.aspx
     */
    private function getTypologyModelCategory( $xpath, $path ) {
        echo '=====>'.$path;
        
        $elements = $xpath->query("//div[@class='category']");
        if( !empty( $elements ) && $elements->length == 0 ) {
            echo "non c'è";
            return false;
        }
        
        foreach( $elements AS $element ) {
            $title = $xpath->query( "h2", $element );
            if( $title->length == 0 )
                return false;
            
            $aTademarks = explode( ' ', $title[0]->nodeValue );            
            $nameTrademark =  $aTademarks[count( $aTademarks )-1];
            
            if( !$this->manageTrademark( $nameTrademark, $nameTrademark, $nameTrademark ) ) {
                continue;
            }
             
            $child = $xpath->query( "span/a", $element );
            foreach( $child as $link ) {
                if( $child->length == 0 )
                    continue;
                
                echo $link->nodeValue."\n";
                if( !$this->manageModel( $link->nodeValue, $link->getAttribute('href') ) ) {
                    continue;
                }
            }                            
            echo "\n\n";
        }        
        echo "c'è";
    }
    
    /**
     * Recupera il prezzo consigliato del modello
     * @param type $path
     * @return boolean
     */
    public function getAdvisedPriceModel( $path, $modelId, $newIdenity = false ) {        
        $path = trim( $path, '/' );
        
        if( !empty( $newIdenity ) ) {
//            echo '=================cambiooooo=================';
//            sleep( 10 );
//            $this->prxC->newIdentity();  
        }
        echo 'https://www.trovaprezzi.it/'.$path."\n";
        
        $result = $this->fileGetContent( "https://www.trovaprezzi.it/$path", '' );
        $doc = new \DOMDocument();
        if( empty( $result ) )
            return false;
        
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();
        
        $xpath = new \DOMXpath( $doc );
                
        $element = $xpath->query("//table[@class='price_table']//td[@class='market_price']");
        if( $element->length == 0 ) {
            return false;
        }

        $aAdvisedPrice = explode( ',', trim( $element[0]->nodeValue, ' €' ) );
        $aAdvisedPrice = explode( '.', $aAdvisedPrice[0] );
              
        
        if( count( $aAdvisedPrice ) == 1 ) {
            $advisedPrice = $aAdvisedPrice[0].','.rand( 1,9 ).rand( 1,9 );
        } else {
            $newPrice = (int)$aAdvisedPrice[1] + rand( 1,9 );
            if( strlen($newPrice) == 1 ) {
                $newPrice = '00'.$newPrice;
            }else if( strlen($newPrice) == 2 ) {
                $newPrice = '0'.$newPrice;
            }
            $advisedPrice = $aAdvisedPrice[0].'.'.$newPrice.','.rand( 1,9 ).rand( 1,9 );
        }        
        
        $sql = "UPDATE $this->dbName.models SET advised_price = '".$advisedPrice."' where id = $modelId ";        
        $this->mySql->query( $sql );
        $this->debug( $sql );
        return true;
    }
    
    
     /**
     * Metodo che recupera tutti i modelli di un marchio per una tpologia
     * es: https://www.trovaprezzi.it/prezzi/cellulari_samsung
     * @param type $path
     * @return boolean
     */
    private function getModelPagination( $path ) {
        $path = trim( $path, '/' );
        echo "https://www.trovaprezzi.it/$path";
        $result = $this->fileGetContent( "https://www.trovaprezzi.it/$path", $this->typeCurl );
        if( empty( $result ) )
            return false;
        
        $doc = new \DOMDocument();        
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();        
        $xpath = new \DOMXpath( $doc );
      
        //PARTE CHE CICLAVA TUTTE LE PAGINE DEL MARCHIO DALLA PIU VECCHIA ALLA PRIMA UTILE ALL'INIZIO PER IMPORTARE TUTTO
//        $paginations = $xpath->query("//div[@class='listing_pagination desktop']//div[@class='pagination'][1]/a");
//        if( $paginations->length > 0  ) {
//            for( $x = $paginations->length +1 ; $x > 1; $x-- ) {
//                $baseUrl = explode( '~', $paginations[0]->getAttribute('href') );
//                $urlRequest = $baseUrl[0]."~pg-".$x;            
//                $this->getModelPaginationItemModel( $urlRequest);      
//                sleep( 3 );
//            }            
//        }                                
//        sleep( 3 );
        
        //PARTE CHE LEGGE SOLO LA PRIMA PAGINA
        $elements = $xpath->query("//div[@id='fullpage_container']//h2/a");
        foreach( $elements As $element ) {
            echo $element->nodeValue." ".$element->getAttribute('href')."\n";
            if( !$this->manageModel( $element->nodeValue, $element->getAttribute('href') ) ) {
                continue;
            }            
        }        
    }
    
     /**
     * Metodo che recupera tutti i modelli di un marchio per una tpologia
     * es: https://www.trovaprezzi.it/prezzi/cellulari_samsung
     * @param type $path
     * @return boolean
     */
    private function getModelPaginationItemModel( $path ) {
        $path = trim( $path, '/' );
        echo "https://www.trovaprezzi.it/$path";
        $result = $this->fileGetContent( "https://www.trovaprezzi.it/$path", $this->typeCurl );
        if( empty( $result ) )
            return false;
        
        $doc = new \DOMDocument();        
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();        
        $xpath = new \DOMXpath( $doc );
        
        $elements = $xpath->query("//div[@id='fullpage_container']//h2/a");
        foreach( $elements As $element ) {
            echo $element->nodeValue." ".$element->getAttribute('href')."\n";
            if( !$this->manageModel( $element->nodeValue, $element->getAttribute('href') ) ) {
                continue;
            }  
        }              
    }
    
    /**
     * Metodo che inserisce una nuova sottocategoria
     * @param type $name
     */
    private function manageSubcategory( $name, $nameUrlTP ) {
        $this->subcategory_id = false;
        
        $nameUrl = explode( '_', $nameUrlTP );
        $nameUrl = str_replace( '.aspx', '', $nameUrl[1]  );        
        
        $sql = "SELECT * FROM $this->dbName.subcategories WHERE name_url_tp = '$nameUrlTP'";
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $row = $sth->fetch( \PDO::FETCH_OBJ );
        
        if( empty( $row ) ) {
            $sqlUp = "INSERT INTO $this->dbName.subcategories( name, name_url, name_url_tp, category_id, is_active )
                VALUES(
                ".$this->mySql->quote( $name ).",
                ".$this->mySql->quote( $nameUrl ).",
                ".$this->mySql->quote( $nameUrlTP ).",
                ".$this->mySql->quote( $this->category_id ).",
                '0'                    
            )";
            $this->debug( $sqlUp );
            $this->mySql->query( $sqlUp );
            $this->subcategory_id = $this->mySql->lastInsertId();
        } else {
            $this->subcategory_id = $row->id;   
//            $sql = "UPDATE $this->dbName.subcategories SET name_url_tp = '".$nameUrlTP ."' where id = $row->id";  
//            $this->mySql->query( $sql );
//            $this->debug( $sql );
        }
        $this->debug( 'FK SUbcategory: '. $this->subcategory_id );
        return $this->subcategory_id;
    }
    
    /**
     * Metodo che inserisce una nuova typologia
     * @param type $name
     */
    private function manageTypology( $name, $nameUrlTP ) {
        $this->typology_id = false;
        
        $nameUrl = explode( '_', $nameUrlTP );
        $nameUrl = str_replace( '.aspx', '', $nameUrl[1]  );    
        
        $sql = "SELECT * FROM $this->dbName.typologies WHERE name_url_tp = '$nameUrlTP'";
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $row = $sth->fetch( \PDO::FETCH_OBJ );
        
        if( empty( $row ) ) {
            $sqlUp = "INSERT INTO $this->dbName.typologies( name, name_url, name_url_tp, subcategory_id, is_active )
                VALUES(
                ".$this->mySql->quote( $name ).",
                ".$this->mySql->quote( $nameUrl ).",
                ".$this->mySql->quote( $nameUrlTP ).",
                ".$this->mySql->quote( $this->subcategory_id ).",
                '1'                    
            )";
            $this->debug( $sqlUp );
            $this->mySql->query( $sqlUp );
            $this->typology_id = $this->mySql->lastInsertId();
        } else {
            $this->typology_id = $row->id;            
//            $sql = "UPDATE $this->dbName.typologies SET name_url_tp = '".$nameUrlTP ."' where id = $row->id";  
//            $this->mySql->query( $sql );
//            $this->debug( $sql );
        }
        $this->debug( 'FK Typology: '. $this->typology_id );
        return $this->typology_id;
    }
    
    /**
     * Metodo che inserisce una nuova marchio
     * @param type $name
     */
    private function manageTrademark( $label, $name, $nameUrl, $top = 1 ) {
        echo '==>'.$nameUrl.'<=====';
        
        $this->trademark_id = false;
                
        $nameUrl = explode( '_', $nameUrl );
        unset($nameUrl[0]); 
        
        $nameUrl = str_replace( '.aspx', '', implode("_", $nameUrl) );         
        $initLetter = substr( $nameUrl, 0, 1 );
        
        $sql = "SELECT * FROM $this->dbName.trademarks WHERE name_url = '$nameUrl'";
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $row = $sth->fetch( \PDO::FETCH_OBJ );
        
        if( empty( $row ) ) {
            $sqlUp = "INSERT INTO $this->dbName.trademarks( name, name_url, init_letter, is_active, top )
                VALUES(
                ".$this->mySql->quote( $label ).",
                ".$this->mySql->quote( $nameUrl ).",
                ".$this->mySql->quote( $initLetter ).",
                '1',
                ".$this->mySql->quote( $top )."
            )";
            $this->debug( $sqlUp );
            $this->mySql->query( $sqlUp );
            $this->trademark_id = $this->mySql->lastInsertId();
        } else {
            $this->trademark_id = $row->id;            
        }
        $this->debug( 'FK Trademark: '. $this->trademark_id );
        
        $insertSubcategoryId = $this->subcategory_id;        
        if( $this->category_id == 5 && $this->subcategory_id == 232 ) {
            $insertSubcategoryId = 205;
        }
        
        //se si tratta di un marchio presente tra i top di trovaprezzi lo inserisce nella tabella
        if( $top == 1 ) {            
            
            //VERIFICA SE GIA INSERITO NELLA YTABELLA DEI TOP MARCHI PER SEZIUONE
            $subcategory = !empty( $insertSubcategoryId ) ? " subcategory_id = $insertSubcategoryId " : ' subcategory_id IS NULL';
            $typology = !empty( $this->typology_id ) ?  " typology_id = $this->typology_id " : ' typology_id IS NULL';                
            $sql = "SELECT count(*) as tot FROM $this->dbName.topTrademarksSection WHERE
                    $subcategory AND $typology AND trademark_id = $this->trademark_id";
            $this->debug( $sql );
            $sth = $this->mySql->prepare( $sql );
            $sth->execute();
            $row = $sth->fetch( \PDO::FETCH_OBJ );

            if( $row->tot == 0 ) {                    
                $subcategory = !empty( $insertSubcategoryId ) ? $insertSubcategoryId : 'NULL';
                $typology = !empty( $this->typology_id ) ? $this->typology_id : 'NULL';
                $sql = "INSERT INTO $this->dbName.topTrademarksSection (subcategory_id,typology_id,trademark_id,position,limit_models) 
                    VALUE ( ".$subcategory.", ".$typology.", ".$this->trademark_id.", 50, '2' )
                ";
                $this->debug( $sql );
                $sth = $this->mySql->prepare( $sql );
//                $sth->execute(); //TODO: DA RIATTIVARE QUANDO SISTEMATO
            }
            
            
            
        } else {
            //VERIFICA SE GIA INSERITO NELLA YTABELLA DEI TOP MARCHI PER SEZIUONE
            $subcategory = !empty( $insertSubcategoryId ) ? " subcategory_id = $insertSubcategoryId " : ' subcategory_id IS NULL';
            $typology = !empty( $this->typology_id ) ?  " typology_id = $this->typology_id " : ' typology_id IS NULL';                
            $sql = "DELETE FROM $this->dbName.topTrademarksSection WHERE
            $subcategory AND $typology AND trademark_id = $this->trademark_id";
            $this->mySql->query( $sql );
            $this->debug( $sql );
        }
        
        return $this->trademark_id;        
    }
    
    /**
     * Metodo che inserisce una nuova marchio
     * @param type $name
     */
    private function manageModel( $name, $nameUrlTP ) {
        $this->model_id = false;
        $nameUrlTP = trim( $nameUrlTP, '/' );
                
        $nameUrl = $this->globalUtility->rewriteUrl( $name );
        $sql = "SELECT * FROM $this->dbName.models WHERE name_url_tp = '$nameUrlTP'";
//        $sql = "SELECT * FROM $this->dbName.models WHERE name = '$name' AND trademark_id = $this->trademark_id";
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $row = $sth->fetch( \PDO::FETCH_OBJ );
        
        $insertCategoryId    = $this->category_id ;
        $insertSubcategoryId = $this->subcategory_id;        
        
        if( $this->category_id == 5 && $this->subcategory_id == 232 ) {
            $insertCategoryId    = 8;
            $insertSubcategoryId = 205;
        }
        
        $newDate =  date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - '.$this->itemModel.' seconds'));
        
        if( empty( $row ) ) {
            $sqlUp = "INSERT INTO $this->dbName.models( name, name_url, name_url_tp, category_id, subcategory_id, typology_id, trademark_id, is_active, date_import )
                VALUES(
                ".$this->mySql->quote( $name ).",
                ".$this->mySql->quote( $this->globalUtility->rewriteUrl( $name ) ).",
                ".$this->mySql->quote( $nameUrlTP ).",
                ".$this->mySql->quote( $insertCategoryId ).",
                ".$this->mySql->quote( $insertSubcategoryId ).",
                ".( !empty( $this->typology_id ) ? $this->typology_id : 'NULL' ).",
                ".$this->mySql->quote( $this->trademark_id ).",
                '1',
                '". $newDate ."'
            )";
            $this->debug( $sqlUp );
            $this->mySql->query( $sqlUp );
            $this->model_id = $this->mySql->lastInsertId();
        } else {
            $this->model_id = $row->id;             
            
//            $newDate =  date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - '.$this->itemModel.' seconds'));
//            $sql = "UPDATE $this->dbName.models SET date_import = '". $newDate ."' where id = $row->id ";                  
//            $this->mySql->query( $sql );
//            $this->debug( $sql );
        }
        $this->debug( 'FK Model: '. $this->model_id );
        $this->itemModel = $this->itemModel+1 ;
        return $this->model_id;        
    }
    
    private function setTopModel( $name) {
        $name = trim( $name, '/' );
        echo $name;
        
        $insertSubcategoryId = $this->subcategory_id;        
        if( $this->category_id == 5 && $this->subcategory_id == 232 ) {
            $insertSubcategoryId = 205;
        }
        
        if( !empty( $this->subcategory_id ) )
            $where = ' AND models.subcategory_id = '.$insertSubcategoryId;
        
        if( !empty( $this->typology_id ) )
            $where = ' AND models.typology_id = '.$this->typology_id;
        
        echo $sql = "UPDATE $this->dbName.models 
                SET is_top = 1
            WHERE name_url_tp = '$name' $where";
        $this->debug( $sql );
        $sth = $this->mySql->query( $sql );
        
        echo $sql = "UPDATE $this->dbName.models 
                SET in_showcase = 1
            WHERE name_url_tp = '$name' $where AND ( models.has_products > 0 or models.is_completed = 1 )";
        $this->debug( $sql );
        $sth = $this->mySql->query( $sql );
    }
    
    private function debug( $msg ) {
        echo "\n####################\n";
        echo $msg;        
    }
    
}