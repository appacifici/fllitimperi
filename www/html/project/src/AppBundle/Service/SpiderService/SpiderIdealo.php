<?php

namespace AppBundle\Service\SpiderService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;

class SpiderIdealo {
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
    private $sleep = 5;
    private $sleepElement = 5;
    private $totImportModel = 60;
        
    public function __construct( ObjectManager $doctrine, Container $container, GlobalUtility $globalUtility ) {
        $this->doctrine = $doctrine;
        $this->container = $container; 
        $this->globalUtility = $globalUtility; 
    }

    /**
     * Metodo che elimina le immagini top News quando gli articoli sono stati pubblicati da più di un mese
     */
    public function run( $dbHost, $dbPort,$dbName, $dbUser, $dbPswd,  $action, $category_id = false, $fkSubcatgory= false, $fkTypology = false, $url = false ) {
        $dbName = 'acquistigiusti';        
        
        $this->action       = $action;
        $this->dbHost       = $dbHost;
        $this->dbName       = $dbName;
        $this->dbUser       = $dbUser;
        $this->dbPswd       = $dbPswd;
        $this->category_id  = $category_id;
        $this->fkSubcatgory  = $fkSubcatgory;
        $this->fkTypology  = $fkTypology;
        $this->url          = $url;
        
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
                $this->globalSpider();
            break;            
            case 'getModelByUrl':            
                $this->getModelByUrl();
            break;            
            case 'getModelProducts':            
                $this->getModelProducts();
            break;            
            case 'getModelProductsIdeUpdate':            
                $this->getModelProductsIdeUpdate();
            break;            
        }
    }
    
    private function getModelByUrl(  ) {
        $this->elementByUrl = 2;
        
         if( !empty( $this->fkTypology )  ) {
            $sql = "SELECT * FROM $this->dbName.typologies WHERE id = ".$this->fkTypology;
        } else if( !empty( $this->fkSubcatgory ) ) {
            $sql = "SELECT * FROM $this->dbName.subcategories WHERE id = ".$this->fkSubcatgory;
        }
        echo $sql;
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $row = $sth->fetch( \PDO::FETCH_OBJ );
        
        $this->category_id = $row->category_id;
        $this->fkSubcatgory = !empty( $row->subcategory_id ) ? $row->subcategory_id : $this->fkSubcatgory ;
        
        $this->getModelsIdealo( $this->url, $this->category_id, $this->fkSubcatgory, $this->fkTypology );
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
        echo 'eccomi';
        $this->getSubcategories( $this->category_id );
        sleep( $this->sleep );
        $this->getTypologies( $this->category_id );
        sleep( $this->sleep );
        $this->getMicroSections( $this->category_id );
    }
    
    /**
     * Recupera i modelli per sottocategorie
     * @param type $id
     */
    private function getSubcategories( $id ) {
        $sql = "SELECT * FROM $this->dbName.subcategories WHERE category_id = $id";
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $rows = $sth->fetchAll( \PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {
            if( !empty( $row->name_url_ide ) ) {
                $categoryId     = $row->category_id;
                $subcategoryId  = $row->id;
                $typologyId     = 'NULL';
                echo "\n\n####################################################################################################\n\n";
                echo $row->name."\n\n";
                echo $row->name_url_ide."\n\n";
                $urls = explode( '[#]', $row->name_url_ide );
                foreach( $urls AS $url ) {
                    echo $url."\n";
                    $this->getModelsIdealo( 'https://www.idealo.it/'.$url, $categoryId, $subcategoryId, $typologyId, false, true );
                    sleep( $this->sleepElement );
                }
            }
        }
    }    
    
    /**
     * Recupera i modelli per tipologia
     * @param type $id
     */
    private function getTypologies( $id ) {
        $sql = "SELECT * FROM $this->dbName.typologies WHERE category_id = $id";
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $rows = $sth->fetchAll( \PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {
            if( !empty( $row->name_url_ide ) ) {
                $categoryId     = $row->category_id;
                $subcategoryId  = $row->subcategory_id;
                $typologyId     = $row->id;
                $microSectionId = false;
                echo "\n\n####################################################################################################\n\n";
                echo $row->name."\n\n";
                echo $row->name_url_ide."\n\n";
                $urls = explode( '[#]', $row->name_url_ide );
                foreach( $urls AS $url ) {                    
                    $this->getModelsIdealo( 'https://www.idealo.it/'.trim($url), $categoryId, $subcategoryId, $typologyId, $microSectionId, true );                                                            
                    sleep( $this->sleepElement );
                }
            }
        }
    }
    
    /**
     * Recupera i modelii per una micro sezione
     * @param type $id
     */
    private function getMicroSections( $id ) {
        $sql = "SELECT * FROM $this->dbName.micro_sections WHERE category_id = $id";
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $rows = $sth->fetchAll( \PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {
            if( !empty( $row->name_url_ide ) ) {
                $categoryId     = $row->category_id;
                $subcategoryId  = $row->subcategory_id;
                $typologyId     = $row->typology_id;
                $microSectionId = $row->id;
                echo "\n\n####################################################################################################\n\n";
                echo $row->name."\n\n";
                echo $row->name_url_ide."\n\n";
                $urls = explode( '[#]', $row->name_url_ide );
                foreach( $urls AS $url ) {
                    echo $url."\n";
                    $this->getModelsIdealo( 'https://www.idealo.it/'.trim($url), $categoryId, $subcategoryId, $typologyId, $microSectionId, true );
                    sleep( $this->sleepElement );
                }
            }
        }
    }
        
    /**
     * Avvia il recupero della scheda tecnica da pagomeno.it
     * @param type $url
     * @return string
     */
    public function getModelProductsIdeUpdate() {        
        $sql = "SELECT count(*) as tot FROM $this->dbName.models WHERE has_products_ide = 1 AND is_active=1 ";
        echo "\n".$sql."\n";
        
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $count = $sth->fetch( \PDO::FETCH_OBJ );
        
        $day = 1;
        $sleep = 5;
        if( $count->tot <= 100 ) {
            $day = 1;
            $limit = 100;
            $sleep = 60;
        } else if( $count->tot <= 200 ) {
            $day = 2;
            $limit = 100;
            $sleep = 60;
        } else if( $count->tot <= 300 ) {
            $day = 3;
            $limit = 100;
            $sleep = 60;
        } else if( $count->tot <= 400 ) { 
            $day = 4;
            $limit = 100;
            $sleep = 60;
        } else if( $count->tot <= 500 ) { 
            $day = 5;
            $limit = 100;
            $sleep = 60;        
        } else if( $count->tot <= 600 ) { 
            $day = 6;
            $limit = 100;
            $sleep = 60;       
        } else if( $count->tot <= 700 ) { 
            $day = 7;
            $limit = 100;
            $sleep = 60;
        } else if( $count->tot <= 800 ) { 
            $day = 4;
            $limit = 200;
            $sleep = 60;
        } else if( $count->tot <= 900 ) { 
            $day = 5;
            $limit = 200;
            $sleep = 60;
        } else if( $count->tot <= 1000 ) { 
            $day = 6;
            $limit = 200;
            $sleep = 60;
        }           
        
        echo "\n\n###############################################################################################################################################\n";
        echo "RUN: Totale Modelli: $count->tot Giorni: -$day Limite: $limit Ritardo: $sleep\n";
        echo "###############################################################################################################################################\n";
        
        $sql = "SELECT * FROM $this->dbName.models WHERE has_products_ide = 1 AND is_active=1 AND last_read_ide  <=  (DATE(NOW()) - INTERVAL $day DAY) ORDER BY id DESC LIMIT $limit";
        echo "\n".$sql."\n";        
//        exit;
//        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $models = $sth->fetchAll( \PDO::FETCH_OBJ );
        foreach( $models AS $model ) {
            
            //Recupero tutti i prodotti di un modello 
            $sql = "SELECT * FROM $this->dbName.products WHERE model_id = ".$model->id.' AND fake_product = 1 AND is_active = 1 ORDER BY id ASC'
                    . '';
            echo "\n".$sql."\n";
//            $this->debug( $sql );
            $sth = $this->mySql->prepare( $sql );
            $sth->execute();
            $products = $sth->fetchAll( \PDO::FETCH_OBJ );
            if( empty( $products ) ) {
                continue;
            }
                        
            echo "\n\n\n\n\n\n\n\n\n###############################################################################################################################################\n";
            echo "###############################################################################################################################################\n";
            echo "###############################################################################################################################################\n";
            echo "MODELLO: $model->id - $model->name \n";
            echo "#################################################################################################################################################\n";
            echo "#################################################################################################################################################\n";
            echo "#################################################################################################################################################\n";
            
            echo $finalUrl =  'https://www.idealo.it/'. $model->name_url_product_ide;    
            
//            $finalUrl = '/home/ale/bosch-smv68mx03e.html';            
//            $result = file_get_contents( $finalUrl );            
            
            $finalUrl = 'http://tricchetto.homepc.it/wgetInfo/rxndu9034tur0934tun3904tun309tu3490?url='.$finalUrl;                
            $result = file_get_contents( $finalUrl );
            
            $result = str_replace( '<br>', ',', $result );
            $result = str_replace( '&nbsp;', ' ', $result );

            //Recupero la pagina di idealo
            $doc = new \DOMDocument();
            libxml_use_internal_errors( true );
            $doc->loadHTML( $result );
            libxml_clear_errors();       
            $xpath = new \DOMXpath( $doc );
            
            //recupero tutte le offerte
            $elements = $xpath->query("//li[contains( @class, 'productOffers-listItem ')]");
            if( $elements->length == 0 ) {
                echo $mex =  "ERRORE LETTURA:$finalUrl \n";
                file_put_contents( '/home/ale/catalogs/spiderPagomeno/errorSpiderIdealo.txt', date( 'Y-m-d H:i:s' ).' '.$mex, FILE_APPEND );            
                return false;            
            }
            
            //Ciclo i prodotti del modello e per ogniuno di esso ciclo tutti gli elementi di idealo per trovare quello uguale tramide SID di idealo
            foreach( $products AS $product ) {        
                
                echo "\n\n\n#################################################################################################################################################\n";
                echo "PRODOTTO: $product->id - $product->name \n";
                echo "#################################################################################################################################################\n";
                
                $newElements = array();
                $checkProduct = false;
                $x = 0;
                
                //Ciclo elementi Idealo
                foreach( $elements AS $element ) {                                            
                    $shop      = $element->getAttribute('data-shop');
                    $title      = $xpath->query( "div[@data-offerlist-column='title']/a/span", $element );        
        //            $price      = $xpath->query( "div[@data-offerlist-column='price']/div/a", $element ); senza spese di spedizione
                    $price      = $xpath->query( "div[@data-offerlist-column='price']/div/a", $element );    
                    $imageShop  = $xpath->query( "div[@data-offerlist-column='shop']/div/a/img[contains( @class, 'productOffers-listItemOfferLogoShop')]", $element );        
                    
                    //Recupero dati prodotto
//                    if( $this->isJSON( trim( $shop ) ) ) {
//                        $shop = json_decode( $shop );
//                        $newElements['shop']  = $shop->type;

                        $newElements['title'] = strpos( trim( $title[0]->nodeValue ), 'getElementById', 0  ) == false ? str_replace( '&#173;', '', trim( $title[0]->nodeValue ) ) : '';

                        preg_match('![0-9\,\.]+!', trim( $price[0]->nodeValue ), $matches);                                
                        $newElements['price'] = $matches[0];
                        $newElements['href'] = trim( $price[0]->getAttribute('href') );
                        $datagtmpayload = trim( $price[0]->getAttribute('data-gtm-payload') );
                        $datagtmpayload = json_decode( $datagtmpayload );

                        $newElements['shopName'] = $datagtmpayload->shop_name;
                        $newElements['productId'] = $datagtmpayload->product_id;
        //                $newElements[$x]['price'] = trim( $datagtmpayload->product_price );

                        $url = 'https://www.idealo.it/'.$newElements['href'];
                        $redirectedUrl = '';

                        $newElements['redirectedUrl'] = trim( $redirectedUrl );
                        $newElements['imageShop'] = 'http://'.trim( $imageShop[0]->getAttribute('data-shop-logo'), '//');                                                
//                    }
                    
                    //Avvio confroto prodotti per trovare quello corrente
                    $oldUrl = trim( html_entity_decode( $product->original_link ) );
                    $newUrl = trim( $newElements['href'] );                    
                    
                    //parso le due url vecchie e nuova per ricavare i dati dei prodotti da confrontare
                    parse_str( $oldUrl, $parse1 );
                    parse_str( $newUrl, $parse2 );
                                        
                    //controllo il codice identificativo del prodotto se manca salto giro
                    if( empty( $parse1['sid'] ) || empty( $parse2['sid']) ) {
                        continue;
                    }
                    
                    //Recupero codice identificativo del prodotto
                    $sid1 = trim( $parse1['sid'] );
                    $sid2 = trim( $parse2['sid'] );
                    
                    echo "\n".( !empty( $newElements['title'] ) ? $newElements['title'] : 'NESSUN NOME') ."\n";
                                        
                    $newPrice = str_replace( array( '.',',' ), array( '' ,'.'), $newElements['price'] );                     
                    $oldPrice = $product->price;
                    echo $oldPrice .'!='. $newPrice." && $sid1 == $sid2 \n";
                    
                    //Incaso il prezzo sia cambiato e il codice del prodotto è lo stesso aggiorno il prodotto
                    if(  $oldPrice != $newPrice && $sid1 == $sid2 ) {
                        echo "\n========== TROVATA URL UGUALE AGGIORNO PREZZO ==============================";
                        echo "\n$product->name \n$oldPrice .'!='. $newPrice && $sid1 == $sid2\n";
                        
                        $sql = "UPDATE $this->dbName.products SET price = '$newPrice', last_price = '$oldPrice', last_read = '".date('Y-m-d H:i:s')."', last_modify = '".date('Y-m-d H:i:s')."'" 
                                . " WHERE id = ".$product->id;
//                        $sth = $this->mySql->prepare( $sql );
//                        $sth->execute();
                        echo $sql."\n";
                        echo "=============================================================================\n";                        
//                        $checkProduct = true;
                        break;           
                        
                    }
                    
                    if( $sid1 == $sid2 ) {
                        $checkProduct = true;
                    } 
                    
                    echo "\n";                    
                }
                
                //Se non è stato trovato alcun prodotto con quello del db aggiorna solo la data di lettura 
                if( !empty( $checkProduct ) ) { 
                    echo "\n======================= AGGIORNO DATA LETTURA PRODOTTO ==============================\n";
                    $sql = "UPDATE $this->dbName.products SET last_read = '".date('Y-m-d H:i:s')."'
                            WHERE id = ".$product->id;
//                            $sth = $this->mySql->prepare( $sql );
//                            $sth->execute();
                    echo $sql."\n";
                    echo "=======================================================================================\n";
                }                
            }    
            
            //Aggiorna la data di lettura del modello per idealo
            echo "\n======================= AGGIORNO DATA LETTURA MODELLO ==============================\n";
            $sql = "UPDATE $this->dbName.models SET last_read_ide = '".date('Y-m-d H:i:s')."'
                    WHERE id = ".$model->id;
//                        $sth = $this->mySql->prepare( $sql );
//                        $sth->execute();
            echo $sql."\n";
            echo "=======================================================================================\n";            
        }                            
        
        echo "\n\n=======================================================================================\n";            
        echo "===================================  MODELLI ELABORATI ================================\n";
        echo "=======================================================================================\n";            
        foreach( $models AS $model ) {            
            echo "$model->id - $model->name\n";
            echo "=======================================================================================\n";            
        }
    }
    
    
    /**
     * Avvia il recupero della scheda tecnica da pagomeno.it
     * @param type $url
     * @return string
     */
    public function getModelProducts( $finalUrl = 'https://www.idealo.it/confronta-prezzi/6067571/dyson-cyclone-v10-motorhead.html' ) {                
        $finalUrl =  'https://www.idealo.it/'. $_GET['urlIde'] ;        
        $finalUrl = 'http://tricchetto.homepc.it/wgetInfo/rxndu9034tur0934tun3904tun309tu3490?url='.$finalUrl;                
        $result = file_get_contents( $finalUrl );
                
        $result = str_replace( '<br>', ',', $result );
        $result = str_replace( '&nbsp;', ' ', $result );

        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );

        $elements = $xpath->query("//li[contains( @class, 'productOffers-listItem ')]");
        if( $elements->length == 0 ) {
            echo $mex =  "ERRORE LETTURA:$finalUrl \n";
            file_put_contents( '/home/ale/catalogs/spiderPagomeno/errorSpiderIdealo.txt', date( 'Y-m-d H:i:s' ).' '.$mex, FILE_APPEND );            
            return false;            
        }        
        
        $newElements = array();
        $x = 0;
        foreach( $elements AS $element ) {                                           
            $shop      = $element->getAttribute('data-shop');
            $title      = $xpath->query( "div[@data-offerlist-column='title']/a/span", $element );        
//            $price      = $xpath->query( "div[@data-offerlist-column='price']/div/a", $element ); senza spese di spedizione
            $price      = $xpath->query( "div[@data-offerlist-column='price']/div/a", $element );    
            
            $imageShop  = $xpath->query( "div[@data-offerlist-column='shop']/div/a/img[contains( @class, 'productOffers-listItemOfferLogoShop')]", $element );        
            $newElements[$x]['title'] = strpos( trim( $title[0]->nodeValue ), 'getElementById', 0  ) == false ? str_replace( '&#173;', '', trim( $title[0]->nodeValue ) ) : '';


            preg_match('![0-9\,\.]+!', trim( $price[0]->nodeValue ), $matches);                                
            $newElements[$x]['price'] = $matches[0];
            $newElements[$x]['href'] = trim( $price[0]->getAttribute('href') );
            $datagtmpayload = trim( $price[0]->getAttribute('data-gtm-payload') );
            $datagtmpayload = json_decode( $datagtmpayload );

            $newElements[$x]['shopName'] = $datagtmpayload->shop_name;
            $newElements[$x]['productId'] = $datagtmpayload->product_id;
//                $newElements[$x]['price'] = trim( $datagtmpayload->product_price );

            $url = 'https://www.idealo.it/'.$newElements[$x]['href'];
            $redirectedUrl = '';                
            $newElements[$x]['redirectedUrl'] = trim( $redirectedUrl );
            $newElements[$x]['imageShop'] = 'http://'.trim( $imageShop[0]->getAttribute('data-shop-logo'), '//');
                                
            $x++; 
        }            
      
//        print_r($newElements);
        return $newElements;
                 
    }
    
    public function isJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }
    
    
    /**
     * Avvia il recupero della scheda tecnica da pagomeno.it
     * @param type $url
     * @return string
     */
    public function getModelsIdealo( $url, $categoryId, $subcategoryId, $typologyId, $microSectionId = false, $isTop = false ) {        
        echo "\n\n\n";
        sleep( 3 );
        //div[contains( @class, 'offerList ')]//div[@class='offerList-item-detailsWrapper']//div[@class='offerList-item-description-title']
        ECHO $finalUrl = 'http://tricchetto.homepc.it/wgetInfo/rxndu9034tur0934tun3904tun309tu3490/wgetModelsPm?url='.urlencode($url);
        
        $result = file_get_contents( $finalUrl );
         
        $result = str_replace( '<br>', ',', $result );
        $result = str_replace( '&nbsp;', ' ', $result );
        
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );
        
        $elements = $xpath->query("//div[contains( @class, 'offerList ')]//a[@class='offerList-itemWrapper']");
        if( $elements->length == 0 ) {
            echo $mex =  "ERRORE LETTURA CATEGORIA: $url - CAT $categoryId - SUBCAT: $subcategoryId - TYPOL: $typologyId\n";
            file_put_contents( '/home/ale/catalogs/spiderPagomeno/errorSpiderIdealo.txt', date( 'Y-m-d H:i:s' ).' '.$mex, FILE_APPEND );            
            return false;            
        }

        $newElements = array();
        $x = 0;
        foreach( $elements AS $element ) {                                           
            $child = $xpath->query( "div/div/div/div[contains( @class, 'offerList-item-description-title')]", $element );        
            
            if( $child->length != 0 ) {
                if( $x > $this->totImportModel )
                    continue;
                $newElements[$x]['href']        = trim( trim( $element->getAttribute('href') ), '/' );   
                $newElements[$x]['nodeValue']   = trim( $child[0]->nodeValue );      
                $x++;         
            }                        
        }
        
        krsort( $newElements );                
        shuffle( $newElements );
        
        foreach( $newElements AS $element ) {
            if( $this->action == 'getModelByUrl' && $this->elementByUrl == 0 ) {
                echo "\nINSERITO PRODOTTI PER URL SPECIFICA FINE\n";
                exit;
            }
            
            echo "\n\n####################################################################################################\n\n";
            echo $element['nodeValue']."\n";
            echo $element['href']."\n";
            $resp = $this->manageModel( $element['nodeValue'], $element['href'], $categoryId, $subcategoryId, $typologyId, $microSectionId, $isTop );
            
            if( $this->action == 'getModelByUrl' && !empty( $resp ) ) {
                $this->elementByUrl--;
            }            
            
        }            
    }
    
    /**
     * Metodo che inserisce una nuova marchio
     * @param type $name
     */
    private function manageModel( $name, $nameUrlId, $categoryId, $subcategoryId, $typologyId, $microSectionId = false, $isTop = false ) {
        $this->model_id = false;
        
//        $name = "Karcher FC 5 1.055-400.0";
        $name1 = preg_replace("/\([^)]+\)/","",$name);  
        $name1 = preg_replace('!\s+!', ' ', $name1);
        $name2 = str_replace( array( '(',')' ), array('',''), $name );          
        $name3 = str_replace( '-', ' ', $name1 );      
        $name4 = str_replace( '\'', '', $name1 );      
        $name5 = str_replace( '\'', ' ', $name1 );      
//        echo $name1;
//        exit;
        
        if( !empty( $typologyId ) && $typologyId != 'NULL' ) {
            $sql = "SELECT * FROM $this->dbName.typologies WHERE id = ".$typologyId;
        } else if( !empty( $subcategoryId ) ) {
            $sql = "SELECT * FROM $this->dbName.subcategories WHERE id = ".$subcategoryId;
        }
        echo $sql;
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $row = $sth->fetch( \PDO::FETCH_OBJ );
        $trademarksAccepted = explode( '[#]',$row->filter_trademarks_section );
        $checked = false;
        foreach( $trademarksAccepted AS $trademark ) {
            $trademark = trim( $trademark ).' ';  
            echo '==>'.
                    strtolower( $name1 ).' '. strtolower( $trademark );
            if( strpos( strtolower( $name1 ), strtolower( $trademark ), '0' ) !== false ) {
                $this->debug( 'TROVATO MARCHIO '.strtolower( $trademark ) );
                $checked = true;
            } 
        }
        
        if( empty( $checked ) ) {
//            return false;
            $table = 'disabled_models';            
        } else {
            $table = 'disabled_models';
        }
        
        $table = 'disabled_models';
        $nameUrlId = trim( $nameUrlId, '/' );                
        $sql = 'SELECT * FROM '.$this->dbName.'.'.$table.' WHERE name_url_ide = "'.$nameUrlId.'" OR name = "'.$name1.'" OR name = "'.$name2.'" OR name = "'.$name.'" OR name = "'.$name3.'" OR name = "'.$name4.'" OR name = "'.$name5.'"';                    
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $row = $sth->fetch( \PDO::FETCH_OBJ );
        
        //Se sta lavorando sui models quindi è un marchio abilitato, e non è presente il modello nella tabella models,
        //prima di inserire il modello verifica se fosse stato disabilitato e quindi presente nella tabella disabled_models
        if( $table == 'disabled_models' && empty( $row ) ) {       
            $this->debug( 'MODELLO MARCHIO ABILITATO NON TROVATO CERCO SU ABILITATI' );
            $sql = 'SELECT * FROM '.$this->dbName.'.models WHERE name_url_ide = "'.$nameUrlId.'" OR name = "'.$name1.'" OR name = "'.$name2.'" OR name = "'.$name.'" OR name = "'.$name3.'" OR name = "'.$name4.'" OR name = "'.$name5.'"';
            $this->debug( $sql );
            $sth = $this->mySql->prepare( $sql );
            $sth->execute();
            $row = $sth->fetch( \PDO::FETCH_OBJ );
            if( !empty( $row ) ) {
                $table = 'models';
            }
        }
        
//        $table = 'disabled_models';
        
        
        $insertCategoryId    = $categoryId ;
        $insertSubcategoryId = $subcategoryId;        
        $trademarkId = 'NULL';
        
        $microSectionId = !empty( $microSectionId ) ? $microSectionId : 'NULL';        
        
        $newDate =  date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - '.$this->itemModel.' seconds'));        
        $value = preg_replace("/\([^)]+\)/","",$name);  
        
        $isTopName  = !empty( $isTop ) ? ',is_top' : '';
        $isTopValue = !empty( $isTop ) ? ',1' : '';
        
//        if( !empty( $typologyId ) && $typologyId != 'NULL' ) {
//            echo $sql = "SELECT count(*) as tot FROM $this->dbName.models WHERE typology_id = ".$typologyId;
//            $sth = $this->mySql->prepare( $sql );
//            $sth->execute();
//            $count = $sth->fetch( \PDO::FETCH_OBJ );
//        } else if( !empty( $subcategoryId ) ) {
//            echo $sql = "SELECT count(*) as tot FROM $this->dbName.models WHERE subcategory_id = ".$subcategoryId;
//            $sth = $this->mySql->prepare( $sql );
//            $sth->execute();
//            $count = $sth->fetch( \PDO::FETCH_OBJ );
//            
//        }        
//        
//        if( $count->tot >= 15  ) {
//            $table = 'disabled_models';
//        }  
        
        if( empty( $row ) ) {
            $sqlUp = "INSERT INTO $this->dbName.$table( name, name_url, name_url_ide, category_id, subcategory_id, typology_id, micro_section_id, is_active, date_import $isTopName )
                VALUES(
                ".$this->mySql->quote( $name1 ).",
                ".$this->mySql->quote( $this->globalUtility->rewriteUrl( $name1 ) ).",
                ".$this->mySql->quote( $nameUrlId ).",
                ".$this->mySql->quote( $insertCategoryId ).",
                ".$this->mySql->quote( $insertSubcategoryId ).",
                ".( !empty( $typologyId ) ? $typologyId : 'NULL' ).",
                ".( !empty( $microSectionId ) ? $microSectionId : 'NULL' ).",
                '1',
                '". $newDate ."'
                $isTopValue
            )";
            $this->debug( $sqlUp );
            $this->mySql->query( $sqlUp );
            $this->model_id = $this->mySql->lastInsertId();
        } else {
//            $this->model_id = $row->id;                         
            $sqlUp = "UPDATE $this->dbName.$table SET name_url_ide = '". $nameUrlId ."', micro_section_id = $microSectionId  where id = $row->id ";                  
            $this->mySql->query( $sqlUp );
            $this->debug( $sqlUp );
        }
        
        $this->debug( 'FK Model: '. $this->model_id );
        $this->itemModel = $this->itemModel+1 ;
        echo "\n\n####################################################################################################\n\n";
        return $this->model_id;        
    }
    
    private function debug( $msg ) {
        echo "\n####################\n";
        echo $msg;        
    }
    
    function entities_to_unicode($str) {
        $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        $str = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $str);
        return $str;
    }

    
}