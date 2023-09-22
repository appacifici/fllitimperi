<?php

namespace AppBundle\Service\SpiderService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;

class SpiderPagomeno {
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
    public function run( $dbHost, $dbPort,$dbName, $dbUser, $dbPswd,  $action, $category_id, $getTop ) {
//        echo $dbName = 'acquistigiustitest';
        
        
        $this->action       = $action;
        $this->dbHost       = $dbHost;
        $this->dbName       = $dbName;
        $this->dbUser       = $dbUser;
        $this->dbPswd       = $dbPswd;
        $this->category_id  = $category_id;
        $this->getTop       = $getTop == 1 ? true : false;       
        
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
            if( !empty( $row->name_url_pm ) ) {
                $categoryId     = $row->category_id;
                $subcategoryId  = $row->id;
                $typologyId     = 'NULL';
                echo "\n\n####################################################################################################\n\n";
                echo $row->name."\n\n";
                echo $row->name_url_pm."\n\n";
                $urls = explode( '[#]', $row->name_url_pm );
                foreach( $urls AS $url ) {
                    echo $url."\n";
                    
                    $urlParse = explode('&' ,$url);
                    $urlTopModel = 'category.php?'.str_replace( 'catId', 'k', $urlParse[1] ); 
                    
                    $this->getModelsPagomeno( 'https://pagomeno.it/'.trim($url), $categoryId, $subcategoryId, $typologyId );
                    sleep( $this->sleepElement );
                                        
                    if( !empty( $this->getTop ) ) {
                        echo "RECUPERO PRODOTTI PIU POPOLARI ". $urlTopModel ."\n";exit;
                        $this->getModelsPagomeno( 'https://pagomeno.it/'.trim($urlTopModel), $categoryId, $subcategoryId, $typologyId, false, true );                                                            
                        sleep( $this->sleepElement );
                    }
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
            if( !empty( $row->name_url_pm ) ) {
                $categoryId     = $row->category_id;
                $subcategoryId  = $row->subcategory_id;
                $typologyId     = $row->id;
                $microSectionId = false;
                echo "\n\n####################################################################################################\n\n";
                echo $row->name."\n\n";
                echo $row->name_url_pm."\n\n";
                $urls = explode( '[#]', $row->name_url_pm );
                foreach( $urls AS $url ) {             
                    echo $url."\n";
                    
                    $urlParse = explode('&' ,$url);
                    $urlTopModel = 'category.php?'.str_replace( 'catId', 'k', $urlParse[1] ); 
                    
                    $this->getModelsPagomeno( 'https://pagomeno.it/'.trim($url), $categoryId, $subcategoryId, $typologyId, $microSectionId );                                                            
                    sleep( $this->sleepElement );
                                    
                    if( !empty( $this->getTop ) ) {
                        echo "RECUPERO PRODOTTI PIU POPOLARI ". $urlTopModel ."\n";
                        $this->getModelsPagomeno( 'https://pagomeno.it/'.trim($urlTopModel), $categoryId, $subcategoryId, $typologyId, $microSectionId, true );                                                            
                        sleep( $this->sleepElement );
                    }
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
            if( !empty( $row->name_url_pm ) ) {
                $categoryId     = $row->category_id;
                $subcategoryId  = $row->subcategory_id;
                $typologyId     = $row->typology_id;
                $microSectionId = $row->id;
                echo "\n\n####################################################################################################\n\n";
                echo $row->name."\n\n";
                echo $row->name_url_pm."\n\n";
                $urls = explode( '[#]', $row->name_url_pm );
                foreach( $urls AS $url ) {
                    echo $url."\n";
                    
                    $urlParse = explode('&' ,$url);
                    $urlTopModel = 'category.php?'.str_replace( 'catId', 'k', $urlParse[1] ); 
                    
                    $this->getModelsPagomeno( 'https://pagomeno.it/'.trim($url), $categoryId, $subcategoryId, $typologyId, $microSectionId );
                    sleep( $this->sleepElement );
                                    
                    if( !empty( $this->getTop ) ) {
                        echo "RECUPERO PRODOTTI PIU POPOLARI ". $urlTopModel ."\n";
                        $this->getModelsPagomeno( 'https://pagomeno.it/'.trim($urlTopModel), $categoryId, $subcategoryId, $typologyId, $microSectionId, true );                                                            
                        sleep( $this->sleepElement );
                    }
                }
            }
        }
    }
        
    /**
     * Avvia il recupero della scheda tecnica da pagomeno.it
     * @param type $url
     * @return string
     */
    public function getModelsPagomeno( $url, $categoryId, $subcategoryId, $typologyId, $microSectionId = false, $isTop = false ) {        
        echo "\n\n\n";
        
        ECHO $finalUrl = 'http://tricchetto.homepc.it/wgetInfo/rxndu9034tur0934tun3904tun309tu3490/wgetModelsPm?url='.urlencode($url);                        
        $result = file_get_contents( $finalUrl );
         
        $result = str_replace( '<br>', ',', $result );
        $result = str_replace( '&nbsp;', ' ', $result );
        
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );
        
        $elements = $xpath->query("//div[@class='category-page--products']//a");
        if( $elements->length == 0 ) {
            echo $mex =  "ERRORE LETTURA CATEGORIA: $url - CAT $categoryId - SUBCAT: $subcategoryId - TYPOL: $typologyId\n";
            file_put_contents( '/home/ale/catalogs/spiderPagomeno/errorSpiderPagomeno.txt', date( 'Y-m-d H:i:s' ).' '.$mex, FILE_APPEND );            
            return false;
                    
//            echo $mex =  "AVVIO SECONDA LETTURA\n";
//            $elements = $xpath->query("//div[@class='category-page--products']//a/div/div[1]");
//            if( $elements->length == 0 ) {
//                echo $mex =  "ERRORE SECONDA LETTURA CATEGORIA: $url - CAT $categoryId - SUBCAT: $subcategoryId - TYPOL: $typologyId\n";
//                file_put_contents( '/home/ale/catalogs/spiderPagomeno/errorSpiderPagomeno.txt', date( 'Y-m-d H:i:s' ).' '.$mex, FILE_APPEND );            
//                return false;
//            }            
        }

        $newElements = array();
        $x = 0;
        foreach( $elements AS $element ) {
            if( $x >= $this->totImportModel ) {
                echo 'esco';
                continue;
            }
            
            $child = $xpath->query( "div[2]/div", $element );      
            
            
            
            if( !empty( $child[0] ) && strlen( $child[0]->nodeValue ) > 5  ) {
                $newElements[$x]['nodeValue']   = $child[0]->nodeValue;            
                $newElements[$x]['href']        = $element->getAttribute('href');     
                $x++;
            }
        }
        
        krsort( $newElements );            
        shuffle( $newElements );  
        print_r( $newElements );
        
        foreach( $newElements AS $element ) {
            echo "\n\n####################################################################################################\n\n";
            echo $element['nodeValue']."\n";
            echo $element['href']."\n";
            $this->manageModel( $element['nodeValue'], $element['href'], $categoryId, $subcategoryId, $typologyId, $microSectionId, $isTop );
        }            
    }
    
    /**
     * Metodo che inserisce una nuova marchio
     * @param type $name
     */
    private function manageModel( $name, $nameUrlPm, $categoryId, $subcategoryId, $typologyId, $microSectionId = false, $isTop = false ) {
        $this->model_id = false;
                        
//        $name = 'Honor 10 Lite (6GB RAM) 128GB';
        $name1 = preg_replace("/\([^)]+\)/","",$name );  
        $name1 = trim( preg_replace('!\s+!', ' ', $name1 ) );
        $name2 = trim( str_replace( array( '(',')' ), array('',''), $name ) );          
        $name3 = trim( str_replace( '-', ' ', $name1 ) );          
        $name4 = str_replace( '\'', '', $name1 );      
        $name5 = str_replace( '\'', ' ', $name1 );      
        
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
            if( strpos( strtolower( $name1 ), strtolower( $trademark ), '0' ) !== false ) {
                $this->debug( 'TROVATO MARCHIO '.strtolower( $trademark ) );
                $checked = true;
            }
        }
        
        if( empty( $checked ) ) {
            $table = 'disabled_models';            
        } else {
            $table = 'disabled_models';
        }
        
        $nameUrlPm = trim( $nameUrlPm, '/' );                
        $sql = 'SELECT * FROM '.$this->dbName.'.'.$table.' WHERE name_url_pm = "'.$nameUrlPm.'" OR name = "'.$name1.'" OR name = "'.$name2.'" OR name = "'.$name.'" OR name = "'.$name3.'" OR name = "'.$name4.'" OR name = "'.$name5.'"';                    
        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $row = $sth->fetch( \PDO::FETCH_OBJ );
        
        //Se sta lavorando sui models quindi è un marchio abilitato, e non è presente il modello nella tabella models,
        //prima di inserire il modello verifica se fosse stato disabilitato e quindi presente nella tabella disabled_models
        if( $table == 'models' && empty( $row ) ) {       
            $this->debug( 'MODELLO MARCHIO ABILITATO NON TROVATO CERCO SU DISABILITATI' );
            $sql = 'SELECT * FROM '.$this->dbName.'.disabled_models WHERE name_url_pm = "'.$nameUrlPm.'" OR name = "'.$name1.'" OR name = "'.$name2.'" OR name = "'.$name.'" OR name = "'.$name3.'" OR name = "'.$name4.'" OR name = "'.$name5.'"';
            $this->debug( $sql );
            $sth = $this->mySql->prepare( $sql );
            $sth->execute();
            $row = $sth->fetch( \PDO::FETCH_OBJ );
            if( !empty( $row ) ) {
                $table = 'disabled_models';
            }
        }
        
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
//        
        if( empty( $row ) ) {
            $sqlUp = "INSERT INTO $this->dbName.$table( name, name_url, name_url_pm, category_id, subcategory_id, typology_id, micro_section_id, is_active, date_import $isTopName )
                VALUES(
                ".$this->mySql->quote( $name1 ).",
                ".$this->mySql->quote( $this->globalUtility->rewriteUrl( $name1 ) ).",
                ".$this->mySql->quote( $nameUrlPm ).",
                ".$this->mySql->quote( $insertCategoryId ).",
                ".$this->mySql->quote( $insertSubcategoryId ).",
                ".( !empty( $typologyId ) ? $typologyId : 'NULL' ).",
                ".( !empty( $microSectionId ) ? $microSectionId : 'NULL' ).",
                '0',
                '". $newDate ."'
                $isTopValue
            )";
            $this->debug( $sqlUp );
            $this->mySql->query( $sqlUp );
            $this->model_id = $this->mySql->lastInsertId();
        } else {
            $this->model_id = $row->id;                         
            $sqlUp = "UPDATE $this->dbName.$table SET name_url_pm = '". $nameUrlPm ."', micro_section_id = $microSectionId  where id = $row->id ";                  
            $this->mySql->query( $sqlUp );
            $this->debug( $sqlUp );
        }
        
        $this->debug( 'FK Model: '. $this->model_id );
        $this->itemModel = $this->itemModel+1 ;
        echo "\n\n####################################################################################################\n\n";
        return $this->model_id;        
    }
    
    private function debug( $msg ) {
        echo "\n \n";
        echo $msg;        
    }
    
}
