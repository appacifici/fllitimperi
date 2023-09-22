<?php

namespace AppBundle\Service\AffiliationService;

class Affiliations {
	public $debugActive = false;	
    public $fkSubcatAffiliation = null;
	public $product;

	public function __construct( $params ) { 
		$this->dbName            = $params->dbName;	
		$this->mySql             = $params->mySql;	
		$this->container         = $params->container;	        
		$this->globalUtility     = $params->globalUtility;	 
		$this->debugActive       = $params->debugActive;	    
		$this->importOnlySection = $params->importOnlySection;	    
//        echo $params->affiliationId.'<==';
//        exit;
        $this->affiliationUtility = new AffiliationUtility( $params );
	}

	/**
	 * Metodo che ritorna i dati extra del prodotto
	 */
	public function getExtraDataProduct( $product ) {
		return false;
	}
	
	/**
	 * Metodo che recupera l'id del marchio, se non presente del db lo crea run time
	 */
	public function getTrademark( $name ) {
		$initName = $name;
		$name = $this->utility->controlDataInsert( $this->main->specialTrim( strtolower( $name ) ) );
		$stn = $this->mySql->prepare( "SELECT idTrademark FROM ".$this->dbName.".trademark WHERE name = ".$name."" );
		$stn->execute();
        if ( $stn->rowCount() > 0 ) {
            $row = $stn->fetch( PDO::FETCH_ASSOC );
            return $row['idTrademark'];
        }
		$marchi = new Marchi( $this->mySql, $this->config, $this->utility );
		$idTrademark = $marchi->insertMarchio( $initName );
		$img = $marchi->getImage( $initName );
		$marchi->insertLogo( $img, $idTrademark );
		return $idTrademark;
	}

    /**
     * 
     * @param type $name
     * @return boolean
     */
	public function getDbLookupSubcategory( $name ) {
		$name = $this->controlDataInsert( $this->specialTrim( strtolower( $name ) ) );
        
		$sql = "
		SELECT subcategories.id as idSubcategory,subcategories.name AS subcategory, categories.id as idCategory, categories.name as category, 
            subcategorySiteAffiliations.id as idSubcatAffiliation, subcategorySiteAffiliations.is_active, 
            lookup_subcategories.typology_id, lookup_subcategories.micro_section_id
        FROM ".$this->dbName.".subcategorySiteAffiliations
            JOIN ".$this->dbName.".lookup_subcategories ON lookup_subcategories.subcategorySiteAffiliation_id = subcategorySiteAffiliations.id
            JOIN ".$this->dbName.".subcategories ON subcategories.id = lookup_subcategories.subcategory_id
            JOIN ".$this->dbName.".categories ON categories.id = subcategories.category_id
        WHERE subcategorySiteAffiliations.affiliation_id = ".$this->product->fkAffiliation." 
            AND subcategorySiteAffiliations.name = ".$name." 
            AND subcategorySiteAffiliations.is_active = 1;
		";
        
		$stn = $this->mySql->prepare( $sql );
		$stn->execute();
        if ( $stn->rowCount() > 0 ) {
            $row = $stn->fetch(\PDO::FETCH_ASSOC );            
			return $row;
        }
		return false;
	}
    
	/**
	 * Metodo che ritorna la categorie e la settocaregoria
	 * @param type $name
	 * @return boolean
	 */
	public function getCategoryOfSubcategory() {
        $this->fkTypology       = false;
        $this->microSectionId   = false;
        
        $name = $this->specialTrim( strtolower( $this->product->nameSubcategory ) );
        $this->isActivefkSubcatAffiliation = 0;
        
        //Controllo se è stata disabilitata la sottocategoria dell'affiliato
        $sql = "SELECT subcategorySiteAffiliations.is_active 
            FROM ".$this->dbName.".subcategorySiteAffiliations 
        WHERE subcategorySiteAffiliations.affiliation_id = ".$this->product->fkAffiliation." 
        AND subcategorySiteAffiliations.name = '".$name."'";
        
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $itemSubcatAff = $stn->fetch(\PDO::FETCH_OBJ );           
        if( !empty( $itemSubcatAff ) ) {        
            $this->isActivefkSubcatAffiliation = $itemSubcatAff->is_active;   
            //Se lo stato dell'attivazione è 2 significa che è spento e deve saltare la categoria
            if( $this->isActivefkSubcatAffiliation == 2 || $this->isActivefkSubcatAffiliation == 3 || $this->isActivefkSubcatAffiliation == 0 )
                return true;
        }
        		
		$row = $this->getDbLookupSubcategory( $name );                  
        if ( $row ) {
            $this->fkSubcatAffiliation  = $row['idSubcatAffiliation'];                                                         
            $this->fkTypology           = $row['typology_id'];                                
            $this->microSectionId       = $row['micro_section_id'];                                
            return $row;
		} else {
			$this->fkSubcatAffiliation = $this->insertItemSubcategorylookup( $name, $this->product->fkAffiliation, $this->product->nameSubcategory );
            if ( !$this->fkSubcatAffiliation )
                return false;
            
//			$row = $this->getDbLookupSubcategory( $name );
//			if ( $row )
//				return $row;
		}
		return true;
	}
    
    
    /**
     * Metodo che inserisce le subcategorySiteAffiliation e valorizze la tabella di lookup per mapparle
     * @param string $subcat
     * @param int $idAffiliation
     * @param obj $affiliations
     * @return boolean
     */
	public function insertItemSubcategorylookup( $subcat, $idAffiliation, $label ) {		
		$idSubcategory = false;
		$isActive = 0;		
        if ( empty ( $subcat ) ) {
            $this->debug( 'Subacetgory name vuoto' );
            return false;
        }
        
		$subcat = $this->controlDataInsert( $this->specialTrim( strtolower( $subcat ) ) );
		
		//Recupera l'idSubcatAffiliation se non è presente inserisce un nuovo record nella tabella subcategorySiteAffiliation
		$sql = "SELECT id as idSubcatAffiliation FROM ".$this->dbName.".subcategorySiteAffiliations 
			WHERE affiliation_id = $idAffiliation AND name = ".$subcat." "; 
		$stn = $this->mySql->prepare( $sql );
		$stn->execute();
		if ( $stn->rowCount() == 0 ) {
            $sql = 
			"INSERT INTO ".$this->dbName.".subcategorySiteAffiliations ( name, affiliation_id, is_active, label ) 
				VALUES ( ".$subcat.", '".$idAffiliation."', $isActive, ".$this->mySql->quote($label)." )
			";
			//$this->debug( $sql );
			$stn = $this->mySql->prepare( $sql );
			$resp = $stn->execute();
//			
//			$sql = "SELECT id as idSubcatAffiliation FROM ".$this->dbName.".subcategorySiteAffiliations 
//				WHERE name = ".$subcat." AND affiliation_id = $idAffiliation"; 
//			$stn = $this->mySql->prepare( $sql );
//			$stn->execute();
//			$row = $stn->fetch();
			$fkSubcatAffiliation = $this->mySql->lastInsertId();

		} else {
			$row = $stn->fetch();            
			$fkSubcatAffiliation = $row['idSubcatAffiliation'];
//            echo $sql = "UPDATE  ".$this->dbName.".subcategorySiteAffiliations SET label = ".$this->mySql->quote($label)." WHERE id = ".$row['idSubcatAffiliation'];
//            $stn = $this->mySql->prepare( $sql );
//			$resp = $stn->execute();
		}
        return $fkSubcatAffiliation;
	}
		
	/**
	 * Metodo che ricava l'immagine cercandola su google images
	 * @param string $query
	 * @param obj $proxyConnector
	 * @param boolean $newIdentity
	 * @return type
	 */
	public function getImage( $query, $proxyConnector = array(), $newIdentity = false ) {
		$url = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&imgsz=medium&q=".$this->utility->specialReplace( $this->utility->encodeAllCharsetToUTF8( $query ) );
		if ( empty( $proxyConnector ) ) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url );
			curl_setopt($ch, CURLOPT_HEADER, false );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			$json = curl_exec($ch);
		} else {
			if (  $newIdentity )
				$proxyConnector->newIdentity();
			$json = $proxyConnector->getContentPage( $url );
		}

		$jset = json_decode( $json, true );
		//echo "<img src='{$jset["responseData"]["results"][0]["url"]}'><br>";
		return $jset["responseData"]["results"][0]["url"];
	}

	/**
	 * Metodo che inserisce i prodotti nel db
	 */
	public function insertAffilation() {        
        $this->product->idProduct = false;
        $this->affiliationUtility->newIdProduct = false;
        if( empty( $this->isActivefkSubcatAffiliation ) ) {
            echo 'ESCO CATEGORIA SENZA LOOKUP: '.$this->product->name."\n";
            return true;
        }
        if( $this->isActivefkSubcatAffiliation == 2 || $this->isActivefkSubcatAffiliation == 3 || $this->isActivefkSubcatAffiliation == 0 ) {
            switch( $this->isActivefkSubcatAffiliation ) {
                case '0': echo 'ESCO NON ATTIVA: '.$this->product->name."\n";
                    break;
                case '2': echo 'ESCO SPENTA: '.$this->product->name."\n";
                    break;
                case '3': echo 'ESCO IN DUBBIO: '.$this->product->name."\n";
                    break;
            }
            return true;
        }
                    
        
        //Descrizione del prodotto
		$description = '';
		if ( !empty( $this->product->longDescription ) )
			$description = $this->product->longDescription;
		else if ( !empty( $this->product->description ) )
			$description = $this->product->description;
		        
		//Valorizzazioni dati
		$price                           = (string)$this->product->price;
		$this->product->description      = (string)utf8_decode( $description );
		$this->product->fkTrademark      = !empty( $this->product->fkTrademark ) ? $this->product->fkTrademark : 'NULL';
        $this->product->fkCategory       = !empty( $this->product->fkCategory ) ? $this->product->fkCategory : 'NULL';
        $this->product->fkSubcategory    = !empty( $this->product->fkSubcategory ) ? $this->product->fkSubcategory : 'NULL';        		
        $this->product->price            = !empty( $this->product->price ) ? $this->controlDataInsert( (string)$this->product->price ) : 'NULL';        
		$this->fkSubcatAffiliation       = !empty( $this->fkSubcatAffiliation ) ? $this->fkSubcatAffiliation : 'NULL';
        $this->product->fkTypology       = !empty( $this->fkTypology ) ? $this->fkTypology : 'NULL';
        $this->product->microSectionId   = !empty( $this->microSectionId ) ? $this->microSectionId : 'NULL';
        $this->product->nameProduct      = $this->controlDataInsert(  substr( (string)$this->product->name, 0, 250 ) );
		$this->product->orderProduct     = !empty( $this->product->orderProduct ) ? $this->product->orderProduct : 0;
        $this->product->number           = !empty( $this->product->number ) ? "'".(string)$this->product->number."'" : 'NULL';
        $this->product->dataImport       = date('Y-m-d H:i:s');
        $this->product->lastModified     = !empty( $this->product->lastModified ) ? (string)$this->product->lastModified : (string)$this->product->dataImport;
		$this->product->lowestPrices     = 1;
		$this->product->hasOtherProducts = 0;				
        $this->product->shippingHandlingCosts = !empty( $this->product->shippingHandlingCosts ) ? $this->product->shippingHandlingCosts : ( !empty( $this->product->shippingHandlingCosts ) ? $this->product->shippingHandlingCosts : 0 );
		$this->product->deliveryTime     = !empty( $this->product->deliveryTime ) ? $this->product->deliveryTime : null;
		$this->product->stockAmount      = !empty( $this->product->stockAmount ) ? $this->product->stockAmount : 0;
		$this->product->ean              = !empty( $this->product->ean ) && !is_object($this->product->ean)? $this->product->ean : 0;
		$this->product->sizeStockStatus  = !empty( $this->product->sizeStockStatus ) ? $this->product->sizeStockStatus : 'NULL';
		$this->product->lastPrice        = !empty( $this->product->lastPrice ) ? $this->product->lastPrice : 0;
		$this->product->shippingHandlingCosts = $this->product->shippingHandlingCosts != '.00' ? $this->product->shippingHandlingCosts : '0';
        
        
		//Setta json per storico prezzi
		$prices[] = trim( $price );
        $this->product->pricesJson = json_encode( $prices );		
        
        if( is_object( $this->product->shippingHandlingCosts ) ) {
            $this->product->shippingHandlingCosts = 0;
        }
        
		$sql = "
            INSERT INTO ".$this->dbName.".products (
                affiliation_id,
				trademark_id,
				category_id,
				subcategory_id,
                fk_subcat_affiliation_id,
				typology_id,
				micro_section_id,
				name,
				price,
				prices,
                last_price,
				deep_link,
                impression_link,
				number,
				data_import,
				last_read,
                last_modify,				
                is_active,
                handling_cost,
                delivery_time,
                stock_amount,
                ean,
                size_stock_status,
                description
            ) VALUES (
				".$this->product->fkAffiliation.",
				".$this->product->fkTrademark.",
				".$this->product->fkCategory.",
				".$this->product->fkSubcategory.",
                ".$this->fkSubcatAffiliation.",
				".$this->product->fkTypology.",
				".$this->product->microSectionId.",
				".$this->product->nameProduct.",
				".$this->product->price.",
				'".$this->product->pricesJson."',
				'".$this->product->lastPrice."',
				'".$this->product->deepLink."',
                '".md5($this->product->deepLink)."',
				".$this->product->number.",
				'".$this->product->dataImport."',
				'".$this->product->dataImport."',
				'".str_replace( 'T',' ',$this->product->lastModified )."',
                1,
                '".$this->product->shippingHandlingCosts."',
                '".$this->product->deliveryTime."',
                ".$this->product->stockAmount.",
                '".$this->product->ean."',
                '".$this->product->sizeStockStatus."',
                ". $this->mySql->quote(  substr( $this->product->description, 0, 499 ) ) ."
			)
		";
        
//        $this->mySql->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
//		$stn = $this->mySql->prepare( $sql );
//		$resp = $stn->execute();
//		if( !$resp ) {
//			$this->debug( "query fallita=>". $sql );            
//		}
//        
        $this->debug( $sql );
		$this->product->idProduct = false;
		
        //passa la query di inserimento da eseguire all'affiliationUtiliti che solo in caso
        //di match con una tipologia o un modello effettuera l'inserimento del prodotto
        $this->affiliationUtility->prepareQueryInsertProduct( $sql, $this->product );
        
        
        $assoc = false;        
//        //Se la categoria è abbigliamento avvio il check per l'associazione della tipologia, sempre che non siano le sneaker allora entra nei check modelli
//        if( !empty( $this->product->fkCategory ) && $this->product->fkCategory != NULL && $this->product->fkCategory != 'NULL' && $this->product->fkCategory == 8 && 
//                ( empty( $this->product->fkSubcategory ) || $this->product->fkSubcategory!= 205 )
//        ) {            
//            $assoc = $this->affiliationUtility->checkTypology( $this->product->fkSubcategory, $this->product->name, $this->product->idProduct, $this->product->description, $this->fkTypology, $this->product->fkCategory );
////            if( $assoc ) {
//                $this->affiliationUtility->checkSex( $this->product, $this->affiliationUtility->newIdProduct );
//                $this->affiliationUtility->checkSize( $this->product, $this->affiliationUtility->newIdProduct );  
//                $this->affiliationUtility->checkColor( $this->product, $this->affiliationUtility->newIdProduct );
////            }            
//        //Se c'è la sottocategoria, associata grazie alla lookup,
//        //prova a recuperare modello prodotto se possibile
//        } else 
            
        if( !empty( $this->product->fkSubcategory ) && $this->product->fkSubcategory != NULL && $this->product->fkSubcategory != 'NULL'  ) {     
            //TODO inserire il check prima per EAN se poi non trova nulla cerca per model
            $assoc = $this->affiliationUtility->checkModel( $this->product->fkSubcategory, $this->product->name, $this->product->idProduct, $this->product->description, $this->fkTypology, $this->microSectionId );                        
        }              
        
        $this->product->idProduct = $this->affiliationUtility->newIdProduct;
        
        //se è riuscito ad associare typologia o modelli, oppure se non è presente nessuna loockup associa le img
        if( $assoc || ( $this->product->fkCategory == 'NULL' && $this->product->fkSubcategory == 'NULL'  )   ) {
            try {
                echo "\n\n".$this->product->idProduct."\n\n";
                if( !empty( $this->product->idProduct ) ) {
                    echo 'inserisco img';
                    $this->getImageProduct();
                }
            } catch (\Symfony\Component\Debug\Exception\ContextErrorException $e) {

            } catch (\Exception $e) {

            }
        }              
        $this->product->fkSubcategory = !empty( $this->product->fkSubcategory ) ? $this->product->fkSubcategory : null;
		$this->product->fkSubcategory = !empty( $this->product->fkSubcategory ) ? $this->product->fkSubcategory : null;
		$this->product->fkSubcatAffiliation = !empty( $this->fkSubcatAffiliation ) ? $this->fkSubcatAffiliation : null;		        
	}
    
    /**
     * Metodo che inserisce le immagini
     */
    public function getImageProduct() {
        $imagesProduct = !empty( $this->product->mediumImage ) ? $this->product->mediumImage : ( !empty( $this->product->largeImage ) ? $this->product->largeImage : false );
        $imagesProduct = !empty( $imagesProduct ) ? $imagesProduct : ( !empty( $this->product->smallImage ) ? $this->product->smallImage : false );
        
//		if( $this->product->idProduct && !empty( getimagesize( $imagesProduct ) ) ) {			
		if( $this->product->idProduct ) {		
            
			$rewriteName = $this->globalUtility->getNameImageProduct( $this->product->name );
			
			//Se viene modificata questo pezzo di codice modificare alla stesso modo anche il medesimo controllo nella classe DeamonAffiliation.class.php
			$this->product->imgWidth =  null;
			$this->product->imgHeight =  null;
			$this->product->img =  null;
			if ( !empty( $imagesProduct ) && !is_object($imagesProduct) ) {  
                
				$myFile['name'][0] = $imagesProduct;
				$myFile['tmp_name'][0] = $imagesProduct;               
				$myFile['type'][0] = $this->globalUtility->imageUtility->myGetTypeImg( $imagesProduct  );
//                $myFile['type'][0] = 'image/jpeg';
                
                $tmpname = false;
                if( empty( $myFile['type'][0] ) ) {
                    $ext = explode( '.', $imagesProduct );
                    $tmpname = 'tmp_'.date('YmdHis').rand(1,10).'.'.$ext[count($ext) -1];
                    exec( 'cd /tmp && wget '.$imagesProduct.' -O '.$tmpname .'  --no-check-certificate');
                    $myFile['name'][0] = '/tmp/'.$tmpname;
                    $myFile['tmp_name'][0] = '/tmp/'.$tmpname;               
                    $myFile['type'][0] = $this->globalUtility->imageUtility->myGetTypeImg( $imagesProduct  );
                    if( empty( $myFile['type'][0] ) ) {
                        $myFile['type'][0] = 'image/jpeg';
                    }
                }
                
                
                if( !empty( $this->product->fkCategory ) && $this->product->fkCategory != NULL && $this->product->fkCategory != 'NULL' && $this->product->fkCategory == 8 ) {
                    $widthFoto =  $this->container->getParameter('app.imgProductsSmallAbbigliamento_width');
                    $heightFoto =  $this->container->getParameter('app.imgProductsSmallAbbigliamento_height');
                } else {
                    $widthFoto =  $this->container->getParameter('app.imgProductsSmall_width');
                    $heightFoto =  $this->container->getParameter('app.imgProductsSmall_height');
                }
                
				$file = $fileSmall = $this->globalUtility->imageUtility->myUpload( 
                        $myFile, 
                        $this->container->getParameter('app.folder_imgProductsSmall_write'), 
                        $this->container->getParameter('app.folder_tmp'), 
                        $widthFoto, 
                        $heightFoto, 
                        "Product", 
                        session_id(), 
                        $this->product->idProduct, 
                        array(), 
                        false,
                        'jpg',
                        $rewriteName 
                );
                
				if ( !empty( $file['dim'][0]['width'] ) || !empty( $file['dim'][0]['height'] ) || $myFile['type'][0] ) {
					$this->product->img = !empty( $file['foto'][0] ) ? $file['foto'][0] : '';
                    //$fileMedium = $this->utility->myUpload( $this->mySql, $myFile, $this->config->imagesProductsMediumWrite, $this->config->tempDir, 100, 100, $this->dbName, "product", session_id(), $this->product->idProduct, array( $this->product->img ) );
                    //$fileSmall = $this->globalUtility->imageUtility->myUpload( $this->mySql, $myFile, $this->config->imagesProductsWrite, $this->config->tempDir, 245, 272, $this->dbName, "product", session_id(), $this->product->idProduct, array( $this->product->img ) );
				}
			}
     
			$widthSmall = $heightSmall = $widthMedium = $heightMedium = $widthLarge = $heightLarge = 0;
			if( !empty( $this->product->img ) ) {
                
				$widthSmall =  !empty( $fileSmall['dim'][0]['width'] ) ? $fileSmall['dim'][0]['width'] : 0;
				$heightSmall = !empty( $fileSmall['dim'][0]['height'] ) ? $fileSmall['dim'][0]['height'] : 0;
//				$widthMedium =  !empty( $fileMedium['dim'][0]['width'] ) ? $fileMedium['dim'][0]['width'] : 0;
//				$heightMedium = !empty( $fileMedium['dim'][0]['height'] ) ? $fileMedium['dim'][0]['height'] : 0;
//				$widthLarge =  !empty( $file['dim'][0]['width'] ) ? $file['dim'][0]['width'] : 0;
//				$heightLarge = !empty( $file['dim'][0]['height'] ) ? $file['dim'][0]['height'] : 0;
//			

                if( file_exists( $this->container->getParameter('app.folder_imgProductsSmall_write') . $this->product->img ) ) {
                    $sql = "
                        INSERT INTO ".$this->dbName.".image_products
                            ( img,width_small,height_small,width_medium,height_medium,width_large,height_large )
                        VALUE(                        
                            '".$this->product->img."',
                            '$widthSmall',
                            '$heightSmall',
                            '$widthMedium',
                            '$heightMedium',
                            '$widthLarge',
                            '$heightLarge'
                        )
                    ";
                    $stn = $this->mySql->prepare( $sql );
                    $resp = $stn->execute();
                    $this->debug( $sql );

                    if( !empty( $resp ) ) {
                        $imageProductId = $this->mySql->lastInsertId();
                        $sql = "INSERT INTO ".$this->dbName.".product_imageproduct ( product_id, image_product_id )
                        VALUE (
                            ".$this->product->idProduct.",
                            ".$imageProductId."
                        )";       
                        $stn = $this->mySql->prepare( $sql );
                        $resp = $stn->execute();
                        $this->debug( $sql );


                        $sql = "UPDATE ".$this->dbName.".products SET priority_img_id = $imageProductId
                            WHERE id =  ".$this->product->idProduct.";
                        ";
                        $stn = $this->mySql->prepare( $sql );
                        $resp = $stn->execute();
                        $this->debug( $sql );
                    }

                }                
            }
            if( !empty( $tmpname ) )
                unlink( '/tmp/'.$tmpname );
                  
		}
        
   }
    
    
    /**
     * MEtodo che adatta le stringhe di testo
     * @param type $string
     * @param type $permissionChar
     * @return type
     */
    public function specialTrim( $string, $permissionChar = '' ) {
        //echo $string."\n";
        $string = str_replace(
			array( '/', 'car-navigation', 'tomtom-outlet-store', 'accessories', 'special-offers' ),
			array( ' ', 'navigazione auto', 'tomtom outlet', 'accessori', 'offerte speciali' ),
			$string
		);
        $string = preg_replace( "/\s+/", " ", $string );
		$string = preg_replace( "/\n ?+/", " ", $string );
		$string = preg_replace( "/\n+/", " ", $string );
		$string = preg_replace( "/\r ?+/", " ", $string );
		$string = preg_replace( "/\t+/", " ", $string );
		$string = preg_replace( "/ +/", " ", $string );
		$string = trim( $string );
        $string = str_replace( array('à','á','é','è','í','ì','ó','ò','ú','ù'),array('a','a','e','e','i','i','o','o','u','u'), $string );
        $string = str_replace( array('À','Á','É','È','Í','Ì','Ó','Ò','Ú','Ù'),array('A','A','E','E','I','I','O','O','U','U'), $string );
        $string = preg_replace( "#[^A-Za-z0-9\-àáéèíìóòúù$permissionChar/]#", " ", $string );
        $string = preg_replace( "/\s+/", " ", $string );
        
        
		return strtolower( trim( $string ) );
	}
    
    /**
	 * Metodo che controlla e sistema i dati perche siano buoni per essere inertiti in query sql
	 * @param type $data
	 */
	public function controlDataInsert($data, $stripTags = true) {
		if ($stripTags)
			$data = strip_tags($data);
		return trim($this->mySql->quote($data));
	}
    
	/**
	 * Metodo che stampa u mex di debug
	 */
	public function debug( $msg ) {
		if ( $this->debugActive ) {
			echo "\n".$this->sep() ."\n" . $msg . "\n".$this->sep() ."\n";
        }
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



