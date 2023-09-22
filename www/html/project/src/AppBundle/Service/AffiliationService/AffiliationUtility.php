<?php

namespace AppBundle\Service\AffiliationService;

class AffiliationUtility {
	public $debugActive = true;	
    public $fkSubcatAffiliation = null;
	public $product;
    private $sqlInsertProduct = false;
    public $newIdProduct = false;
    public $insertAfter = true;

	public function __construct( $params ) { 
		$this->dbName           = $params->dbName;	
		$this->mySql            = $params->mySql;	
		$this->container        = !empty( $params->container ) ? $params->container : false;	        
		$this->debugActive      = !empty( $params->debugActive ) ? $params->debugActive  : false;	
        $this->affiliationId    = !empty( $params->affiliationId ) ?  $params->affiliationId : false;
        $this->affiliationName  = !empty( $params->affiliationName ) ?  $params->affiliationName : false;        
	}
    
    public function prepareQueryInsertProduct( $sql, $product ) {
        $this->sqlInsertProduct = $sql;
        $this->newProduct     = $product;
    }
    
    public function executeQueryInsertProduct( $productId = false ) {
        if( empty( $this->insertAfter ) ) {
            return $productId;
        }
        echo $this->sqlInsertProduct;
        $stn = $this->mySql->prepare( $this->sqlInsertProduct );
		$resp = $stn->execute();
		if( !$resp ) {
			$this->debug( "query fallita=>". $this->sqlInsertProduct );            
		}
        
        
        $dataImport = date( 'Y-m-d H:i:s' );            
        echo $dataImport . ' ' . $this->mySql->lastInsertId() . ' Prodotto inserito ==>' . $this->newProduct->name."\n";
        
        $this->debug( $this->sqlInsertProduct );
		$this->newIdProduct = $this->mySql->lastInsertId();
        return $this->newIdProduct;
    }
    
    
    
    /**
     * Metodo che inserisce le taglie dei prodotti
     * @param type $product
     * @return boolean
     */
    public function checkColor( $product ) {
        $productName    = $product->name;
        $productId      = $product->idProduct;
        if( empty( $product->colors ) ) {
            return false;            
        }        
        $productColors = explode( '-', $product->colors );
        
        $sql = "select * from ".$this->dbName.".colors where is_active = 1";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $colors = $stn->fetchAll( \PDO::FETCH_OBJ );    
        
        $insertColors = '';                        
        //Cicla tutte le parole di un modello, e se le trova inctementa i match
        foreach ( $colors as $color ) {
            if( strpos( strtolower( $product->colors ), strtolower( $color->name ), '0' ) !== false ) {
                $insertColors .= strtolower( $color->name ).', ';
            }
        }
        
        //Cicla tutte le parole di un modello, e se le trova inctementa i match
        foreach ( $colors as $color ) {            
            $synonyms = explode( ';', $color->synonyms );
            foreach( $synonyms AS $synonym ) {
                if( !empty( $synonym ) ) {
                    if( strpos( strtolower( $product->colors ), strtolower( $synonym ), '0' ) !== false ) {
                        $insertColors .= strtolower( $synonym ).', ';
                    }
                }            
            }
        }
        
        if( empty( trim($insertColors) ) )
            return false;
        
        $sql = "UPDATE " . $this->dbName . ".products SET
            colors = '" . trim($insertColors). "'
        WHERE id = ".$productId;
        
        $stn = $this->mySql->prepare( $sql );
        if ( !$stn->execute() ) {
            $this->debug( 'ERRORE: '.$sql );
            return false;
        }
        $this->debug( $sql );
        return true;             
    }
    
    /**
     * Metodo che inserisce le taglie dei prodotti
     * @param type $product
     * @return boolean
     */
    public function checkSize( $product ) {
        $productName    = $product->name;
        $productId      = $product->idProduct;
        if( empty( $product->size ) || is_object( $product->size ) ) {
            return false;            
        }
        
//        print_r($product);
        $productSizes = explode( ';', $product->size );
        
        $sql = "select * from ".$this->dbName.".sizes where is_active = 1";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $sizes = $stn->fetchAll( \PDO::FETCH_OBJ );    
        
        $insertSizes = '';
        foreach( $sizes AS $size ) {
            if( in_array($size->name, $productSizes ) ) {
                $insertSizes .= '['.$size->name.'] ';
            }
        }
        
        if( empty( trim($insertSizes) ) )
            return false;
        
        $sql = "UPDATE " . $this->dbName . ".products SET
            sizes = '" . trim($insertSizes). "'
        WHERE id = ".$productId;
        
        $stn = $this->mySql->prepare( $sql );
        if ( !$stn->execute() ) {
            $this->debug( 'ERRORE: '.$sql );
            return false;
        }
        $this->debug( $sql );
        return true;             
    }
    
    /**
     * Metodo che ricava il sesso del prodotto
     * @param type $product
     * @return boolean
     */
    public function checkSex( $product, $productId ) {
        $productName    = $product->name;
//        $productId      = $product->idProduct;
        $description    = !empty( $product->sex ) ? $product->sex : $product->description;
        
        $sql = "select * from ".$this->dbName.".sex where is_active = 1";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $aSex = $stn->fetchAll( \PDO::FETCH_OBJ );    
        
        foreach( $aSex AS $sex ) {
            //Sottraggo il nome del marchio se presente
            $sexName = $sex->name;
            $words = explode( ' ', trim( $sexName ) );
            $match = 0;            
            
            //Cicla tutte le parole di un modello, e se le trova inctementa i match
            foreach ( $words as $key => $value ) {
//                echo $value."\n";
                if( empty( $value ) ) {
                    unset($words[$key]);
                    continue;
                }
                if( strpos( strtolower( $productName.' '.$description ), strtolower( $value ), '0' ) !== false ) {
                    $match++;
                }
            }
            
            //Se il numero dei match è uguale al numero di parole del modello è fatta!
            if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {
//                $this->setTrademarkTypologyProduct( $model );                                
                if( $this->setSexProduct( $sex->id, $productId ) )
                    return true;
            }
        }
        
        //Cicla nuovamente le tipologie per cercare nei sinonimi di ogniuna di esse
        foreach( $aSex AS $sex ) {
            //Se riesce ad associare una tipologia con i sinonimi torna true
            if( $this->checkSexSynonyms( $sex, $productName, $productId, $description ) )
                return true;
        }                       
        return false;        
    }
    
     /**
     * Metodo che recupera i sinonimi delle tipologie della sottocategoria e tenta di
     * associarne una al prodotto
     * @param type $subcategoryId
     */
    private function checkSexSynonyms( $sex, $productName, $productId, $description ) {
        $aSynonyms = explode( ';', $sex->synonyms );
        
        if( empty( $aSynonyms ) || empty( $aSynonyms[0] ) ) 
            return false;
        
        foreach( $aSynonyms AS $synonym ) {
            //Sottraggo il nome del marchio se presente
            $sexName = $synonym;
            $words = explode( ' ', trim( $sexName ) );
            $match = 0;            
            
            //Cicla tutte le parole di un modello, e se le trova inctementa i match
            foreach ( $words as $key => $value ) {
                if( empty( $value ) ) {
                    unset($words[$key]);
                    continue;
                }
                if( strpos( strtolower( $productName.' '.$description ), strtolower( $value ), '0' ) !== false ) {
                    $match++;
                }
            }
            
            //Se il numero dei match è uguale al numero di parole del modello è fatta!
            if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {                
                if( $this->setSexProduct( $sex->id, $productId ) )
                    return true;
            }
        }
        return false;
    }
    
    /**
     * Metodo che setta il Trademark, la tipologia, e il modello, arrivato dal match dei modelli
     * @param type $model
     */
	public function setSexProduct( $sex, $productId ) {        
        $sex    = !empty( $sex ) ? $sex : 'NULL';                
        
        
        $sql = "UPDATE " . $this->dbName . ".products SET
            sex_id = " . $sex . "
        WHERE id = ".$productId;
        
        $stn = $this->mySql->prepare( $sql );
        if ( !$stn->execute() ) {
            $this->debug( 'ERRORE: '.$sql );
            return false;
        }
        $this->debug( $sql );
        return true;        
    }
    
    /**
     * Metodo che recupera le tipologie della sottocategoria e tenta di a
     * associarne una al prodotto
     * @param type $subcategoryId
     */
    public function  checkTypology( $subcategoryId, $productName, $productId, $description = false, $typologyId = false, $categoryId = false ) {
//        $sql = "select * from ".$this->dbName.".typologies where subcategory_id  = ".$subcategoryId." AND has_models = 0";
        $sql = "select * from ".$this->dbName.".typologies where is_active = 1 and subcategory_id  = ".$subcategoryId." order by typologies.name desc";
        
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $typologies = $stn->fetchAll( \PDO::FETCH_OBJ );    
        
        foreach( $typologies AS $typology ) {            
            //Sottraggo il nome del marchio se presente
            $typologyName = $typology->name;
            $words = explode( ' ', trim( $typologyName ) );
            $match = 0;            
            
            //Cicla tutte le parole di un modello, e se le trova inctementa i match
            foreach ( $words as $key => $value ) {
                if( empty( $value ) ) {
                    unset($words[$key]);
                    continue;
                }
                
                $initWords = array( '-',' i ',' lo ',' la ',' gli ', ' le ', ' di ', ' a ', ' da ', ' in ', ' con ', ' su ', ' per ', ' tra ', ' fra ' );        
                $endWords  = array( ' ',' ',' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' );        
                $value = str_replace( $initWords, $endWords, ' '.$value );
                $value = trim( $value );
                
                //Trick per metachere solo quelli coerenti al 100%;
                $value = ' '.$value.' ';      
//                $productName = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $productName);
//                $description = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $description);
                
                if( strpos( strtolower( ' '.$productName.' '.$description ), strtolower( $value ), '0' ) !== false ) {
                    $match++;
                }
            }
            
            //Se il numero dei match è uguale al numero di parole del modello è fatta!
            if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {
//                $this->setTrademarkTypologyProduct( $model );                
//                echo 'Associato: ==>'.$typologyName."\n";
                if( $this->setTypologyProductBySubcategory( $typology->id, $productId ) ) {                    
                    return true;
                }
            }
        }
        
        //Cicla nuovamente le tipologie per cercare nei sinonimi di ogniuna di esse
        foreach( $typologies AS $typology ) {
            //Se riesce ad associare una tipologia con i sinonimi torna true            
            if( $this->checkTypologySynonyms( $typology, $productName, $productId, $description ) ) {                
                return true;
            }
        }               
        
        
        
        //Se non è riuscito ad associare a nessuna tipologia
//        if( empty( $typologyId ) || $typologyId == 'NULL' ) {                            
            if( $categoryId == 8 && !empty( $subcategoryId ) && $subcategoryId != 'NULL' ) {
                // Non cancella il prodotto lo tiene per mostrarlo nella lista prodotti della sottocategoria di abbigliamento
            } else {       
                
                  //TODO: DA REIMPLEMENTARE???
                  //Prova cmq a tenere il prodotto per mostrarlo in tutto in "sezione" o tra la ricerca libera
//                if( !$this->checkSubcategorySynonyms( $subcategoryId, $productName, $productId, $description ) ) {    
//                        $this->removeImagesAndProduct( $productId );  
//                } else {
//                    return true;
//                }
            }
//        }
        return false;
    }
    
    /**
     * Prova a vedere se il prodotto può essere associato alla sottocategoria generale per synonimy
     * @param type $subcategoryId
     * @param type $productName
     * @param type $productId
     * @param type $description
     * @return boolean
     */
    private function checkSubcategorySynonyms($subcategoryId, $productName, $productId, $description ) {
        $sql = "select synonyms, singular_name from ".$this->dbName.".subcategories where id = ".$subcategoryId."";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $subcategory = $stn->fetch( \PDO::FETCH_OBJ );                   
        $aSynonyms = explode( ';', $subcategory->synonyms.';'.$subcategory->singular_name );
                
        
        if( empty( $aSynonyms ) || empty( $aSynonyms[0] ) ) 
            return false;
                        
        foreach( $aSynonyms AS $synonym ) {
//                        echo $synonym."<br>";
            //Sottraggo il nome del marchio se presente
            $typologyName = $synonym;
            $words = explode( ' ', trim( $typologyName ) );
            $match = 0;            
            
            //Cicla tutte le parole di un modello, e se le trova inctementa i match
            foreach ( $words as $key => $value ) {
                if( empty( $value ) ) {
                    unset($words[$key]);
                    continue;
                }
                
                $initWords = array( ' i ',' lo ',' la ',' gli ', ' le ', ' di ', ' a ', ' da ', ' in ', ' con ', ' su ', ' per ', ' tra ', ' fra ' );        
                $endWords  = array( ' ',' ',' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' );        
                $value = str_replace( $initWords, $endWords, ' '.$value );
                $value = trim( $value );
                
                $productName = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $productName);
                $description = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $description);
                
                //Trick per metachere solo quelli coerenti al 100%;
                $value = ' '.$value.' ';
                if( strpos( strtolower( ' '.$productName.' '.$description ), strtolower( $value ), '0' ) !== false ) {
                    $match++;
                }
            }
                        
            if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {
                $this->executeQueryInsertProduct( $productId );
                return true;
            }            
        }
        return false;
    }
    
    /**
     * Metodo che recupera i sinonimi delle tipologie della sottocategoria e tenta di
     * associarne una al prodotto
     * @param type $subcategoryId
     */
    private function checkTypologySynonyms( $typology, $productName, $productId, $description ) {
//        echo $typology->synonyms."\n";
        $aSynonyms = explode( ';', $typology->synonyms.';'.$typology->singular_name );
        
        if( empty( $aSynonyms ) || empty( $aSynonyms[0] ) ) 
            return false;
        
        foreach( $aSynonyms AS $synonym ) {
            //Sottraggo il nome del marchio se presente
            $typologyName = $synonym;
            $words = explode( ' ', trim( $typologyName ) );
            $match = 0;            
            
            //Cicla tutte le parole di un modello, e se le trova inctementa i match
            foreach ( $words as $key => $value ) {
                if( empty( $value ) ) {
                    unset($words[$key]);
                    continue;
                }
                
                $initWords = array( ' i ',' lo ',' la ',' gli ', ' le ', ' di ', ' a ', ' da ', ' in ', ' con ', ' su ', ' per ', ' tra ', ' fra ' );        
                $endWords  = array( ' ',' ',' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' );        
                $value = str_replace( $initWords, $endWords, ' '.$value );
                $value = trim( $value );
                
                $productName = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $productName);
                $description = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $description);
                
                //Trick per metachere solo quelli coerenti al 100%;
                $value = ' '.$value.'';
                if( strpos( strtolower( ' '.$productName.' '.$description ), strtolower( $value ), '0' ) !== false ) {
                    $match++;
                }
            }
            //Se il numero dei match è uguale al numero di parole del modello è fatta!
            if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {                                
                if( $this->setTypologyProductBySubcategory( $typology->id, $productId ) ) {
                    return true;
                } 
            }
        }
        return false;
    }
    
    	
    /**
     * Metodo che setta il Trademark, la tipologia, e il modello, arrivato dal match dei modelli
     * @param type $model
     */
	public function setTypologyProductBySubcategory( $typology, $productId ) {     
        $sql = "select count(1) as tot from $this->dbName.products where typology_id = $typology";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $count = $stn->fetch( \PDO::FETCH_OBJ );   
        
//        echo "\n tot => $count->tot\n";
        if( $count->tot >= 1000 ) {
            echo "Tipologia già piena";
            return false;
        }
        
        $productId = $this->executeQueryInsertProduct( $productId );        
        $typology    = !empty( $typology ) ? $typology : 'NULL';                
        
        $sql = "UPDATE " . $this->dbName . ".products SET
            typology_id = " . $typology . "
        WHERE id = ".$productId;
        
        $stn = $this->mySql->prepare( $sql );
        if ( !$stn->execute() ) {
            $this->debug( 'ERRORE: '.$sql );
            return false;
        }
        $this->debug( $sql );
        return true;        
    }    
    
    /**
     * Metodo che prova ad associare un modello se non lo trova prova con i sinonimi senno con 
     * le tipologie se non associa nulla rimuove il prodotto
     * @param type $subcategoryId
     * @param boolean $enabledCheckTypology ( Determina se avviare la ricerca per tipologia se non associa modelli )
     */
    public function checkModel( $subcategoryId, $productName, $productId, $description = false, $typologyId = false, $microSectionId = false, $enabledCheckTypology = true, $checkAllSubcat = false ) {
        $setModelCheck = false;             
        
        if( !empty( $microSectionId ) && $microSectionId != 'NULL' ) {
            //Recupero tutti i modelli di una sottocategoria
            $sql = "SELECT models.*, trademarks.name as trademarkName FROM ".$this->dbName.".models
                    LEFT JOIN ".$this->dbName.".trademarks ON trademarks.id = models.trademark_id
            WHERE micro_section_id = ".$microSectionId." order by models.name desc";
            echo $sql;
        
        } else if( !empty( $typologyId ) && $typologyId != 'NULL' ) {
            //Recupero tutti i modelli di una sottocategoria
            $sql = "SELECT models.*, trademarks.name as trademarkName FROM ".$this->dbName.".models
                    LEFT JOIN ".$this->dbName.".trademarks ON trademarks.id = models.trademark_id
            WHERE typology_id = ".$typologyId." order by models.name desc";
            
        } else {
            //Recupero tutti i modelli di una sottocategoria
            $sql = "SELECT models.*, trademarks.name as trademarkName FROM ".$this->dbName.".models 
                    LEFT JOIN ".$this->dbName.".trademarks ON trademarks.id = models.trademark_id
            WHERE subcategory_id = ".$subcategoryId." order by models.name desc";            
        }  
        
        
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $models = $stn->fetchAll( \PDO::FETCH_OBJ );        
             
        //se non ha trovato modelli per la tipologia
        if( empty( $models ) && !empty( $microSectionId ) && $microSectionId != 'NULL' ) {
           //Recupero tutti i modelli di una sottocategoria
            $sql = "SELECT models.*, trademarks.name as trademarkName FROM ".$this->dbName.".models 
                    LEFT JOIN ".$this->dbName.".trademarks ON trademarks.id = models.trademark_id
            WHERE typology_id = ".$typologyId." order by models.name desc";       
            $stn = $this->mySql->prepare( $sql );
            $stn->execute();
            $models = $stn->fetchAll( \PDO::FETCH_OBJ );                    
        }       
             
        //se non ha trovato modelli per la tipologia
        if( empty( $models ) && !empty( $typologyId ) && $typologyId != 'NULL' ) {
           //Recupero tutti i modelli di una sottocategoria
            $sql = "SELECT models.*, trademarks.name as trademarkName FROM ".$this->dbName.".models 
                    LEFT JOIN ".$this->dbName.".trademarks ON trademarks.id = models.trademark_id
            WHERE subcategory_id = ".$subcategoryId." order by models.name desc";       
            $stn = $this->mySql->prepare( $sql );
            $stn->execute();
            $models = $stn->fetchAll( \PDO::FETCH_OBJ );                    
        }       
                                
        $aModelsAssoc = array();        
        $m = 0;                        
                
//        echo $productName.'<======#';
        //Ciclo i modelli
        foreach( $models AS $model ) {
            
            //Se ha gia associato un modello interrompe il ciclo
            if( $setModelCheck )
                break;
            
            //Sottraggo il nome del marchio se presente
            $modelName = str_replace( array(',',';',':','-','_','+','gb'), array( ' ',' ',' ',' ',' ',' ',' ' ), strtolower( $model->name ) );
//            $productName = str_replace( array(',',';',':',' - ','_','+','gb'), array( ' ',' ',' ',' ',' ',' ',' ' ), strtolower( $productName ) );
            
//            $modelName = str_replace( $model->trademarkName, '', $model->name );
            
            $words = explode( ' ', trim( $modelName ) );
            $match = 0;                                          
            
            //Cicla tutte le parole di un modello, e se le trova inctementa i match
            foreach ( $words as $key => $value ) {
                if( empty( $value ) ) {
                    unset($words[$key]);
                    continue;
                }
                                
                $initWords = array( ' i ',' lo ',' la ',' gli ', ' le ', ' di ', ' a ', ' da ', ' in ', ' con ', ' su ', ' per ', ' tra ', ' fra ' );        
                $endWords  = array( ' ',' ',' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' );        
                $value = str_replace( $initWords, $endWords, ' '.$value );
                $value = trim( $value );
                
                //Per parole di 1/2 lettere antepongo lo spazione davanti la parola;
                if( strlen( $value ) <= 7 )
                    $value = ' '.$value.' ';
                else
                    $value = ' '.$value.' ';
                
//                $productName = preg_replace( "/[^A-Za-z0-9ìèéòàù ]/", ' ', $productName );
//                $productName = preg_replace( "/[^A-Za-z0-9ìèéòàù ]/", ' ', $productName );
                
                if( strpos( strtolower( ' '.$productName.' ' ), strtolower( $value ), '0' ) !== false ) {
                    $match++;
                }
            }
            
            //Se il numero dei match è uguale al numero di parole del modello è fatta!
            if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {                
                $setModelCheck = $this->setTrademarkTypologyModelProduct( $model, $productId );                
                $aModelsAssoc[$m]['name'] = $model->name;
                $aModelsAssoc[$m]['model'] = $model;
                $aModelsAssoc[$m]['trademarkname'] = $model->trademarkName;
                return true;
            } 
        }        
               
        //Cerca di associare per SINONIMI altrimenti per TYPOLOGY
        if( !empty( $models ) && empty( $setModelCheck ) ) {                            
            //Cicla tutti i modelli e cerca nei sinonimi se trova lo aggiunge all'array dei possobili match
            foreach( $models AS $model ) {            
//                $response = $this->checkModelSynonyms( $model, $productName, $productId, '' );
//                if( empty( $response ) ) {
                    $response = $this->checkModelSynonyms( $model, $productName, $productId, $description );
//                }
                
                //mergia gli array dei possibili risultati
                if( !empty( $response ) ) {
                    $aModelsAssoc = array_merge( $aModelsAssoc, $response );
                }                
            }
            
            //Se ci sono possibili march li ordina poi li cicla 
            if( !empty( $aModelsAssoc ) ) {
                
                //Ordina i match per piu parole trovate
                usort( $aModelsAssoc, function($a, $b) { 
                    return ( $this->strWordCount( $a['name'] ) < $this->strWordCount( $b['name'] ) );
                });
                                   
                //Cicla e prova a vedere se nei possibili risultati c'è il nome del marchio in caso associa il primo con marchio
                foreach( $aModelsAssoc AS &$item ) {                    
                    if( empty( $item['trademarkname'] ) || empty( $productName.' '.$description ) )
                        continue;
                    
                    if( strpos( strtolower(' '.$productName.' '.$description.' '), strtolower( $item['trademarkname'] ) ) !== false ) {                            
                        $setModelCheck = $this->setTrademarkTypologyModelProduct( $item['model'], $productId );                                                    
                        if( !empty( $setModelCheck ) )
                            return true;                        
                    } 
                }
                
                //Se sopra non ha trovato il marchio associa il primo match con piu parole trovate
                $setModelCheck = $this->setTrademarkTypologyModelProduct( $aModelsAssoc[0]['model'], $productId );                 
                if( !empty( $setModelCheck ) )
                    return true;                                                
            }            
            
            //Cerca di associare per alpha
            if( !empty( $models ) && empty( $setModelCheck ) ) {                  
                $item = $this->checkAlphaCheckModel( $models, $productName, $productId, $description );   
                if( !empty( $item ) ) {  
                    $setModelCheck = $this->setTrademarkTypologyModelProduct( $item['model'], $productId );                      
                    if( !empty( $setModelCheck ) ) {
                        return true;       
                    }
                }
            }
            
            //Nel caso in cui la ricerca modelli era per microsezione e non ha trovato nulla 
            //provo la ricerca per tutta la typologia
            if( $checkAllSubcat  &&  !empty( $microSectionId ) && $microSectionId != 'NULL' ) {
                echo "\n########## PROVO RECUPERO PER SOTTOCATEGORIA########## \n";
                $setModelCheck = $this->checkModel( $subcategoryId, $productName, $productId, $description, $typologyId, false, false, false );
                if( !empty( $setModelCheck ) )
                    return true;
            }
            
            //Nel caso in cui la ricerca modelli era per tipologia e non ha trovato nulla 
            //provo la ricerca per tutta la sottocategoria
            if( $checkAllSubcat  &&  !empty( $typologyId ) && $typologyId != 'NULL' ) {
                echo "\n########## PROVO RECUPERO PER SOTTOCATEGORIA########## \n";
                $setModelCheck = $this->checkModel( $subcategoryId, $productName, $productId, $description, false, false, false, false );
                if( !empty( $setModelCheck ) )
                    return true;
            }
            
//          //Se abbiamo un tipologia senza modelli, e non è riusciato ad associare quindi un modello cerca la typ.
//            if( $enabledCheckTypology && $this->checkTypology( $subcategoryId, $productName, $productId, $description, $typologyId ) )
//                return true;
            
        }  
//        else if ( empty( $models ) ) {
//            if( $enabledCheckTypology && $this->checkTypology( $subcategoryId, $productName, $productId, $description, $typologyId ) )
//                return true;
//        }  
        return false;
    }
    
    /**
     * Determina se avviare la ricerca per modello su tutta la sottocategoria
     * @param type $subcategoryId
     * @return boolean
     */
    public function checkEnabledForceSubcategory( $subcategoryId ) {
        switch( $subcategoryId ) {
            case 87: //Videogiochi
                return false;
            break;
            default:
                return true;
            break;
        }
        return true;
    }
    
    /**
     * Metodo che cerca di associare un modello per i codici aklpha generati dal sistema
     * @param type $model
     * @param type $productName
     * @param type $productId
     * @param type $description
     * @return boolean
     */
    public function checkAlphaCheckModel( $models, $productName, $productId, $description ) {
        $aModelsAssoc = array();
        $x = 0;
        foreach( $models AS $model  ) {              
            if( !empty( $model->alphaCheckModel ) ) {
//                echo $model->alphaCheckModel."\n";
                $alphas = explode( ';',$model->alphaCheckModel );
                
                foreach( $alphas AS $alpha ) {   
                    if( empty( $alpha ) )
                        continue;
                    
                    //Per parole di 1/2 lettere antepongo lo spazione davanti la parola;
                    if( strlen( $alpha ) <= 5 )
                        $value = ' '.trim($alpha).' ';
                    else
                        $value = ' '.trim($alpha).' ';
                    
//                    echo strtolower( ' '.$productName.' ' ).' <==>'. strtolower( $value )." [#] \n";    
                    
                    //ogni volta che trova un alpha compatibile lo aggiunge in array
                    if( strpos( strtolower( ' '.$productName.' ' ), strtolower( $value ), '0' ) !== false ) {
//                        echo $productName.' == "'.$value.'"';
                        $aModelsAssoc[$x]['name'] = $alpha;
                        $aModelsAssoc[$x]['productName'] = $productName;
                        $aModelsAssoc[$x]['model'] = $model;
                        $aModelsAssoc[$x]['trademarkname'] = $model->trademarkName;
                        $x++;
                    }                    
                }
                
                
                //Prende la prima alpha che deve sempre essere formata da tutte le parole separate da spazio
                //e verifica se tutte le parole sono presenti nel solo titolo in tal caso aggiunge
                $words = explode( ' ', trim( $alphas[0] ) );
                $match = 0;            
                foreach ( $words as $key => $value ) {
                    if( empty( $value ) ) {
                        unset($words[$key]);
                        continue;
                    }
//                    DISATTIVATO PERCHE TOGLIEVA I PUNTI E ALTRI CARATTERI E FACEVA SBALLARE I CONTROLLI
//                    $productName = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $productName);
                    //Cicla tutte le parole di un modello, e se le trova inctementa i match
                    $value = ' '.$value.' ';
                    if( strpos( strtolower( ' '.$productName.' ' ), strtolower( $value ), '0' ) !== false ) {
                        $match++;
                    }
                }
                if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {     
                    $aModelsAssoc[$x]['name'] = $alphas[0];
                    $aModelsAssoc[$x]['productName'] = $productName;
                    $aModelsAssoc[$x]['model'] = $model;
                    $aModelsAssoc[$x]['trademarkname'] = $model->trademarkName;
                    $x++;
                }
                
                //Prende la seconda alpha che deve sempre essere formata da tutte le parole separate da spazio
                //e verifica se tutte le parole sono presenti nel solo titolo in tal caso aggiunge
                if( !empty( $alphas[1]  ) ) {
                    $words = explode( ' ', trim( $alphas[1] ) );
                    $match = 0;            
                    foreach ( $words as $key => $value ) {
                        if( empty( $value ) ) {
                            unset($words[$key]);
                            continue;
                        }
//                        $productName = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $productName);
                        //Cicla tutte le parole di un modello, e se le trova inctementa i match
                        $value = ' '.$value.' ';
                        if( strpos( strtolower( ' '.$productName.' ' ), strtolower( $value ), '0' ) !== false ) {
                            $match++;
                        }
                    }
                    if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {     
                        $aModelsAssoc[$x]['name'] = $alphas[0];
                        $aModelsAssoc[$x]['productName'] = $productName;
                        $aModelsAssoc[$x]['model'] = $model;
                        $aModelsAssoc[$x]['trademarkname'] = $model->trademarkName;
                        $x++;
                    }
                }
                
            }
        }
        
        //Li ordina per numero lunghezza
        if( !empty( $aModelsAssoc ) ) {              
            //Ordina i match per piu parole trovate
            usort( $aModelsAssoc, function($a, $b) { 
                return ( strlen( $a['name'] ) < strlen( $b['name'] ) );
            });
        }
        
        
        return !empty( $aModelsAssoc ) ? $aModelsAssoc[0] : false;
    }
    
    /**
     * 
     * @param type $model
     * @param type $productName
     * @param type $productId
     * @param type $description
     * @return boolean
     */
    public function checkModelSynonyms( $model, $productName, $productId, $description ) {
        $aSynonyms = explode( ';', $model->synonyms );
        
        if( empty( $aSynonyms ) || empty( $aSynonyms[0] ) ) 
            return false;
        
        $aModelsAssoc = array();
        $m = 0;
        foreach( $aSynonyms AS $synonym ) {
            //Sottraggo il nome del marchio se presente
            $modelName = $synonym;
            $words = explode( ' ', trim( $modelName ) );
            $match = 0;            
                                    
            foreach ( $words as $key => $value ) {
                if( empty( $value ) ) {
                    unset($words[$key]);
                    continue;
                }
                $initWords = array( ' i ',' lo ',' la ',' gli ', ' le ', ' di ', ' a ', ' da ', ' in ', ' con ', ' su ', ' per ', ' tra ', ' fra ' );        
                $endWords  = array( ' ',' ',' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' );        
                $value = str_replace( $initWords, $endWords, ' '.$value );
                $value = trim( $value );
                
                $description = substr( $description, 0, 250 );
//                $productName = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $productName);
//                $description = preg_replace("/[^A-Za-z0-9ìèéòàù ]/", ' ', $description);
                
                //Cicla tutte le parole di un modello, e se le trova inctementa i match
                //Trick per metachere solo quelli coerenti al 100%;
                $value = ' '.$value.' ';
                
                
                
                if( strpos( strtolower( ' '.$productName.' '.$description.' ' ), strtolower( $value ), '0' ) !== false ) {
                    $match++;
                }
            }
            
            //Se il numero dei match è uguale al numero di parole del modello è fatta!
            if( !empty( $match ) && intval( $match ) == intval( count( $words ) ) ) {     
//                if( $this->setTrademarkTypologyModelProduct( $model, $productId ) )
//                    return true;
                $aModelsAssoc[$m]['name'] = $synonym;
                $aModelsAssoc[$m]['model'] = $model;
                $aModelsAssoc[$m]['trademarkname'] = $model->trademarkName;                
            }
            $m++;
        }
        return !empty( $aModelsAssoc ) ? $aModelsAssoc :false;
    }
    
    
    /**
     * Metodo che gestisce la cancellazione di un prodotto
     * @param type $productId
     * @return boolean
     */
    public function removeImagesAndProduct( $productId ) {
        
//        $sql = "SELECT * FROM " . $this->dbName . ".product_imageproduct 
//            JOIN ".$this->dbName . ".image_products ON image_products.id = product_imageproduct.imageproduct_id
//        WHERE product_imageproduct.product_id =  $productId";
//        $stn = $this->mySql->prepare( $sql );
//        $stn->execute();
//        $images = $stn->fetchAll( \PDO::FETCH_OBJ );  
//        
//        //CANCELLA LE IMAMGINI DAL SERVER
//        foreach ( $images as $image ) {            
//           @unlink( $this->container->getParameter( 'app.folder_imgProductsSmall_write' ).$image->img );            
//        }
        
        
//        $sql = "select products.id,products.name,products.number,products.deep_link,products.description,products.fk_subcat_affiliation_id, products.subcategory_id, products.typology_id,
//                subcategories.name as subcategoryName, typologies.name as typologyName
//                FROM " . $this->dbName . ".products 
//                LEFT JOIN " . $this->dbName . ".subcategories on subcategories.id = products.typology_id
//                LEFT JOIN " . $this->dbName . ".typologies on typologies.id = products.typology_id
//            WHERE products.id = $productId";
//        $stn = $this->mySql->prepare( $sql );
//        $stn->execute();
//        $product = $stn->fetch( \PDO::FETCH_OBJ );  
        
        if( empty( $this->newProduct->deepLink ) && empty( $this->newProduct->deep_link ) )
            return;
        
        
        $product = array();
        $product['name'] = $this->newProduct->name; 
        $product['number'] = !empty( $this->newProduct->number ) ? $this->newProduct->number : ''; 
        $product['deep_link'] = !empty( $this->newProduct->deepLink ) ? $this->newProduct->deepLink : $this->newProduct->deep_link; 
        $product['description'] = $this->newProduct->description; 
        $product['nameSubcategory'] = !empty( $this->newProduct->nameSubcategory ) ? $this->newProduct->nameSubcategory : $this->newProduct->subcategory_id; 
        $product['category'] = !empty( $this->newProduct->fkCategory ) ? $this->newProduct->fkCategory : $this->newProduct->category_id; 
        $product['subcategory'] = !empty( $this->newProduct->fkSubcategory ) ? $this->newProduct->fkSubcategory : $this->newProduct->subcategory_id; 
        $product['typology'] = !empty( $this->newProduct->fkTypology ) ? $this->newProduct->fkTypology : $this->newProduct->typology_id; 
        $product['imageUrl'] = !empty( $this->newProduct->imageUrl ) ? $this->newProduct->imageUrl : ( !empty( $this->newProduct->largeImage ) ? $this->newProduct->largeImage : '' );
        
        file_put_contents('/home/prod/catalogs/removeProducts/'.$this->affiliationName.'_removeProduc.txt', print_r( $product, true ), FILE_APPEND );
        
//        //CANCELLA IL PRODOTTO DAL DB
//        $sql = "DELETE FROM " . $this->dbName . ".products WHERE id = $productId";
//        $stn = $this->mySql->prepare( $sql );
//        if ( !$stn->execute() ) {
//            $this->debug( 'ERRORE: '.$sql );
//            return false;
//        }
//        echo $sql."\n";
//        exit;
//        
//        //CANCELLA LE IMMAGINI DAL DB
//        foreach ( $images as $image ) {            
//            $sql = "DELETE FROM ".$this->dbName . ".image_products WHERE id = $image->imageproduct_id";
//            $stn = $this->mySql->query( $sql );
//        }   
                        
    }
    
    /**
     * Metodo che setta il Trademark, la tipologia, e il modello, arrivato dal match dei modelli
     * @param type $model
     */
	public function setTrademarkTypologyModelProduct( $model, $productId ) {                    
        $productId      = $this->executeQueryInsertProduct( $productId );        
        
        $modelId        = !empty( $model->id ) ? $model->id : 'NULL';        
        $typology       = !empty( $model->typology_id ) ? $model->typology_id : 'NULL';        
        $microSection   = !empty( $model->micro_section_id ) ? $model->micro_section_id : 'NULL';        
        $trademark      = !empty( $model->trademark_id ) ? $model->trademark_id : 'NULL';
        
        $sql = "UPDATE " . $this->dbName . ".products SET
            trademark_id = " . $trademark . ",
            typology_id = " . $typology . ",
            micro_section_id = " . $microSection . ",
            model_id = " . $modelId . "                
        WHERE id = ".$productId;
        
        $stn = $this->mySql->prepare( $sql );
        if ( !$stn->execute() ) {
            $this->debug( 'ERRORE: '.$sql );
            return false;
        }
        $this->debug( $sql );
        echo $sql."\n";
        
        //Va ad attivare per sicurezza il modello avendo appena associato ad esse in prodotto
        $sql = "UPDATE ".$this->dbName.".models SET is_active = 1, has_products = has_products+1 
        WHERE id = ".$modelId;        
        echo $sql."\n";
        
        $stn = $this->mySql->prepare( $sql );
        if ( !$stn->execute() ) {
            $this->debug( 'ERRORE: '.$sql );
            return false;
        }
        $this->debug( $sql );        
        return true;
    }
    
    
    ###################################################################################################
    ###################################################################################################
    ###################################################################################################
        
    /**
	 * Metodo che counta il numero di annunci attivi e quelli disattivi per un affiliato
	 * @param type $idAffiliation
	 * @return type
	 */
	public function countNumberProductsAffiliation( $idAffiliation ) {
		echo $sql = "SELECT COUNT(*) AS numProduct FROM ".$this->dbName.".products WHERE affiliation_id = {$idAffiliation} and is_active = 1";
		$stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $numActive = $stn->fetch( \PDO::FETCH_OBJ );
        
		$sql = "SELECT COUNT(*) AS numProduct FROM ".$this->dbName.".products WHERE affiliation_id = {$idAffiliation} and is_active = 0";
		$stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $numDisabled = $stn->fetch( \PDO::FETCH_OBJ );
		
		$counts = new \stdClass();
		$counts->productsActive     = $numActive->numProduct;
		$counts->productsDisabled   = $numDisabled->numProduct;
		return $counts;
	}
        
    /**
	 * Metodo che disabilità gli annunci di un affiliatio che non sono più presenti nel feed
	 * @param int $idAffiliation
	 * @return int
	 */
	public function disableProducts( $idAffiliation, $data ) {
		echo $sql = "UPDATE ".$this->dbName.".products SET is_active = 0, data_disabled = '{$data}' WHERE affiliation_id = {$idAffiliation} AND  is_active = 1 AND last_read < '{$data}'";		
		$stn = $this->mySql->prepare( $sql );
		$resp = $stn->execute();
		
		$this->debug( $sql );
		return ( $resp ? $stn->rowCount() : 0 );
	}
	
	
	/**
	 * Metodo che riabilita gli annunci di un affiliatio che non sono stati nuovamente trovati nel feed
	 * @param int $idAffiliation
	 * @return int
	 */
	public function reactivatesProducts( $idAffiliation, $data ) {
		echo $sql = "UPDATE ".$this->dbName.".products SET is_active = 1 WHERE affiliation_id = {$idAffiliation} AND last_read >= '{$data}' and ( manual_off is null or manual_off = 0 )";		
		$stn = $this->mySql->prepare( $sql );
		$resp = $stn->execute();
		
		$this->debug( $sql );
		return ( $resp ? $stn->rowCount() : 0 );
	}
    
    ###################################################################################################
    ###################################################################################################
    ###################################################################################################
    
    
    /**
     * Metodo che setta il numero di articoli inseriti per ogni categoria e sottocategoria e affiliazione
     */
    public function setNumberProducts() {		
        $this->debugActive = true;
        
//        $sql = "SELECT id as idAffiliation FROM ".$this->dbName.".affiliations";
//        $stn = $this->mySql->prepare( $sql );
//        $stn->execute();
//        $rows = $stn->fetchAll( \PDO::FETCH_OBJ );
//		$this->debug( $sql );
//        foreach( $rows AS $row ) {
//            $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".products WHERE is_active = 1 AND to_update = 1 AND affiliation_id = ".$row->idAffiliation;
//            $stn = $this->mySql->prepare( $sql );
//            $stn->execute();
//            $prod = $stn->fetch( \PDO::FETCH_OBJ );
//
//            $sql = "UPDATE ".$this->dbName.".affiliations SET has_products = ".$prod->numProducts." WHERE id = ".$row->idAffiliation;
//            $stn = $this->mySql->prepare( $sql );
//            $stn->execute();
//			$this->debug( $sql );            
//        }                
//        
//        $sql = "SELECT id FROM ".$this->dbName.".categories";
//        $stn = $this->mySql->prepare( $sql );
//        $stn->execute();
//        $rows = $stn->fetchAll( \PDO::FETCH_OBJ );
//		$this->debug( $sql );
//        foreach( $rows AS $row ) {
//            $this->setNumberProductsCategory( $row->id );
//        }
//		
//        $sql = "SELECT id FROM ".$this->dbName.".subcategories";
//        $stn = $this->mySql->prepare( $sql );
//        $stn->execute();
//        $rows = $stn->fetchAll( \PDO::FETCH_OBJ );
//		$this->debug( $sql );
//        foreach( $rows AS $row ) {
//            $this->setNumberProductsSubcategory( $row->id );
//        }
//		
//		$sql = "SELECT id FROM ".$this->dbName.".typologies";
//        $stn = $this->mySql->prepare( $sql );
//        $stn->execute();
//        $rows = $stn->fetchAll( \PDO::FETCH_OBJ );
//		$this->debug( $sql );
//        foreach( $rows AS $row ) {
//            $this->setNumberProductsTypology( $row->id );
//        }	
//        
		$sql = "SELECT id FROM ".$this->dbName.".models";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( \PDO::FETCH_OBJ );
		$this->debug( $sql );
        foreach( $rows AS $row ) {
            $this->setNumberProductsModels( $row->id );
        }	
        
        $sql = "UPDATE ".$this->dbName.".models SET is_active = 1 where has_products > 0";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $this->debug( $sql );
        
        $sql = "UPDATE ".$this->dbName.".models SET is_active = 0 where has_products = 0 and is_completed = 0";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $this->debug( $sql );
        
//        
//        
//		$sql = "SELECT id FROM ".$this->dbName.".trademarks";
//        $stn = $this->mySql->prepare( $sql );
//        $stn->execute();
//        $rows = $stn->fetchAll( \PDO::FETCH_OBJ );
//		$this->debug( $sql );
//        foreach( $rows AS $row ) {
//            $this->setNumberProductsTrademarks( $row->id );
//        }	
        
    }
    
	/**
	 * Metodo che setta il numero di prodotti per marchio
	 */
	public function setNumberProductsTrademarks( $idTrademark ) {
		
        $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".products WHERE is_active = 1 AND to_update = 1 AND trademark_id = ".$idTrademark;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $prod = $stn->fetch( \PDO::FETCH_OBJ );

        $sql = "UPDATE ".$this->dbName.".trademarks SET has_products = ".$prod->numProducts." WHERE id = ".$idTrademark;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $this->debug( $sql );


        ###MODELLI###

        $sql = "SELECT count(*) AS tot FROM  $this->dbName.models WHERE trademark_id = $idTrademark";
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $trademark = $sth->fetch( \PDO::FETCH_OBJ );    

        $sql = "UPDATE $this->dbName.trademarks SET has_models = $trademark->tot WHERE id = $idTrademark";
        $this->mySql->query( $sql );
            
        
		$this->debug( $sql );
	}
	
	/**
	 * Metodo che setta il numero di prodotti per categoria
	 * @param int $idCategory
	 */
    public function setNumberProductsCategory( $idCategory ) {
        $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".products WHERE is_active = 1 AND to_update = 1 AND category_id = ".$idCategory;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $prod = $stn->fetch( \PDO::FETCH_OBJ );
        $this->debug( $sql );

        $sql = "UPDATE ".$this->dbName.".categories SET has_products = ".$prod->numProducts." WHERE id = ".$idCategory;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $this->debug( $sql );
                
    }
    
	/**
	 * Metodo che setta il numero di prodotti per sottocategoria
	 * @param int $idSubcategory
	 */
    public function setNumberProductsSubcategory( $idSubcategory ) {
        $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".products WHERE is_active = 1 AND to_update = 1 AND subcategory_id = ".$idSubcategory;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $prod = $stn->fetch( \PDO::FETCH_OBJ );
        $this->debug( $sql );

        $sql = "UPDATE ".$this->dbName.".subcategories SET has_products = ".$prod->numProducts." WHERE id = ".$idSubcategory;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute(); 
        $this->debug( $sql );
        
        ###MODELLI###
        
        $sql = "SELECT count(*) AS tot FROM  $this->dbName.models WHERE subcategory_id = $idSubcategory";
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $model = $sth->fetch( \PDO::FETCH_OBJ );    
        
        $sql = "UPDATE $this->dbName.subcategories SET has_models = $model->tot WHERE id = $idSubcategory";
        $this->mySql->query( $sql );
    }
	
	/**
	 * Metodo che setta il numero di prodotti per tipologia
	 * @param int $idTypology
	 */
	public function setNumberProductsTypology( $idTypology ) {
        $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".products WHERE is_active = 1 AND to_update = 1 AND typology_id = ".$idTypology;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $prod = $stn->fetch( \PDO::FETCH_OBJ );
        $this->debug( $sql );

        $sql = "UPDATE ".$this->dbName.".typologies SET has_products = ".$prod->numProducts." WHERE id = ".$idTypology;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute(); 
        $this->debug( $sql );
        
        ###MODELLI###
        
        $sql = "SELECT count(*) AS tot FROM  $this->dbName.models WHERE typology_id = $idTypology";
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $model = $sth->fetch( \PDO::FETCH_OBJ );    
        
        $sql = "UPDATE $this->dbName.typologies SET has_models = $model->tot WHERE id = $idTypology";
        $this->mySql->query( $sql );
    }
    
    
	/**
	 * Metodo che setta il numero di prodotti per $idModel
	 * @param int $idModel
	 */
    public function setNumberProductsModels( $idModel ) {
        $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".products WHERE is_active = 1 AND to_update = 1 AND model_id = ".$idModel;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $prod = $stn->fetch( \PDO::FETCH_OBJ );
        $this->debug( $sql );

        $sql = "UPDATE ".$this->dbName.".models SET has_products = ".$prod->numProducts." WHERE id = ".$idModel;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $this->debug( $sql );      
        
        if( empty( $prod->numProducts ) ) {
            $sql = "SELECT date_zero_product FROM ".$this->dbName.".models WHERE id = ".$idModel;
            $stn = $this->mySql->prepare( $sql );
            $stn->execute();
            $model = $stn->fetch( \PDO::FETCH_OBJ );
            $this->debug( $sql );
            
            
            if( empty( $model->date_zero_product ) ) {
                $sql = "UPDATE ".$this->dbName.".models SET date_zero_product = '".date('Y-m-d H:i:s')."' WHERE id = ".$idModel;
                $stn = $this->mySql->prepare( $sql );
                $stn->execute();
                $this->debug( $sql );          
            }            
        } else {
            $sql = "UPDATE ".$this->dbName.".models SET date_zero_product = NULL WHERE id = ".$idModel;
            $stn = $this->mySql->prepare( $sql );
            $stn->execute();
            $this->debug( $sql );  
        }           
    }
    
    
    /**
     * Conta il numero di parole alphanumeriche nella stringa
     * @param type $string
     * @return type
     */
    private function strWordCount( $string ) {
        $words = explode ( ' ', $string );
        return count( $words );
    }        
    
    
	/**
	 * Metodo che stampa u mex di debug
	 */
	public function debug( $msg ) {
		if ( $this->debugActive )
			echo "\n".$this->sep() ."\n" . $msg . "\n".$this->sep() ."\n";
	}

	/**
	 * Metodo che crea la stringa separatrice per il debug in console shell
	 * @return type
	 */
	public function sep() {
		$sep = '#';
		for( $x = 0; $x < 100; $x++ )
			$sep .= '-';
		return $sep.'#';
	}
	
}//End class
