<?php

namespace AppBundle\Service\AffiliationService;

class MaintenanceAffiliation {
	public $dbName;
	public $affiliations = null;
    public $filtersArray;
	private $debugActive = true;
    
    /**
	 * Metodo costruttore della classe
	 * @params obj $this->mySql ( Oggetto pdo per la connesione al db )
	 * @params string $idAffiliations ( elenco delle affiliazioni da importare ES: 23,24,67,87,96 )
	 * @params string $typeImport ( tipo di importazione da eseguire consentite [xml|cvs] )
	 */
	public function __construct( $debugActive = false ) {
		parent::__construct();
		$this->dbName = $this->config->dbSite;    
		$this->debugActive = $debugActive;
        $this->filtersArray = new FiltersArray();
		$this->rewrite = new Rewrite();
    }
    
    
    /**
	 * Metodo che recupera la lista degli affiliati da importare
	 * @params int $idAffiliations ( lista id affiliazioni da importare )
	 */
	private function selectListAffiliations( $idAffiliations = null ) {
		$inId = '';
		if ( $idAffiliations != null )
			$inId = ' WHERE idAffiliation IN ( '.$idAffiliations.' )';
		$sql = "SELECT * ".$this->dbName.".FROM affiliation".$inId;
		$this->debug( $sql );
		$stn = $this->mySql->prepare( $sql );
		$stn->execute();
		return $stn->fetchAll(  PDO::FETCH_ASSOC );
	}
	
	/**
	 * Metodo che scarica il file del feed nel sul server
	 * @params string $url ( path del feed da scaricare sul server )
	 */
	private function downloadFeed( $url, $name ) {
		$path = FILE_AFFILIATIONS.'/'.str_replace(' ','_',$name);
		
		$command = 'wget --content-disposition -k "'.$url.'" --output-document='.$path.'.gz ';
		system( $command, $output );
		$this->debug( $command );
		
		$command = 'gunzip '.$path.'.gz && mv  '.$path.' '.$path.'.xml';
		system( $command ); 
		$this->debug( $command );
		
		return $path.'.xml';
	}
    
    /**
     * Metodo che scarica il feed xml cicla
     * @param type $idAffiliations
     */
    public function insertSubcategorySiteAffiliations( $idAffiliations ) {
        //Seleziona le affiliazioni da importare
		$this->affiliations = $this->selectListAffiliations( $idAffiliations );
		foreach ( $this->affiliations as $affiliation ) {
            $pathFeed = $this->downloadFeed( $affiliation['url'], $affiliation['name'] );
            //$pathFeed = '/home/ale/site/soshopping.it/tools/affiliations/catalogs/Zalando_IT.xml';
            $this->checkSubcategorysFeed( $pathFeed, $affiliation['idAffiliation'] );
		}
    }
    	
	/**
	 * Metodo che cicla le sottocategorie presenti nel feed e le inserire nella tabella subcategorySiteAffiliation
	 * e se trova corrispondenze nella tabella subcategori le mappa nella lookup senno le inserisce spente dovranno 
	 * essere poi mappate a mano
	 * @param type $linkFeed
	 * @param type $idAffiliation
	 * 
	 */
	private function checkSubcategorysFeed( $linkFeed, $idAffiliation ) {        
        $document = simplexml_load_file( $linkFeed, 'SimpleXMLElement', LIBXML_NOCDATA );
		foreach ( $document->product as $product ) {
			 $products[] = $product ;
		}
		$products = array_reverse( $products );
        
		$affiliations = new Affiliations( $this->main );
		
		$subcategorysAffiliation = array();
		foreach ( $products as $product ) {
			$typeElement = explode( '/', $product->merchantCategory );
			$subcategory = $this->main->specialTrim( $typeElement[0] );
			
			if ( !empty( $subcategory ) &&  !in_array( $subcategory, $subcategorysAffiliation ) )
                $subcategorysAffiliation[] = $subcategory;
		}
        
        foreach( $subcategorysAffiliation AS $subcat ) {
			$this->insertItemSubcategorylookup( $subcat, $idAffiliation, $affiliations );
        }
		exit;
	}
   
    /**
     * Metodo che inserisce le subcategorySiteAffiliation e valorizze la tabella di lookup per mapparle
     * @param string $subcat
     * @param int $idAffiliation
     * @param obj $affiliations
     * @return boolean
     */
	public function insertItemSubcategorylookup( $subcat, $idAffiliation ) {
		//COMMENTATO BLOCCO LOOCKUP AUTOMATICO SOTTOCATEGORIE DA ARRAY MANUALE
//		if ( !empty( $this->filtersArray->typeCategoryOfSubcategory[$subcat] ) )
//			$subcategorySite = $this->filtersArray->typeCategoryOfSubcategory[$subcat]['subcategory'];
		
		//Recupera l'id della sottocategoria
		$subcategorySearch = !empty( $subcategorySite ) ? $subcategorySite : $subcat;		
		$idSubcategory = false;
		$isActive = 0;
		
		//COMMENTO RECUPERO SUBCATEGORY PER NOME GIA ESISTENTE PER EVITARE LOOCKUP AUTOMATICA
//		$stn = $this->mySql->prepare( "SELECT idSubcategory FROM ".$this->dbName.".subcategory WHERE name = '".$subcategorySearch."'" );
//		$stn->execute();
//		if ( $stn->rowCount() > 0 ) {
//			$isActive = 1;
//			$row = $stn->fetch();
//			$idSubcategory = $row['idSubcategory'];
//		}

        if ( empty ( $subcat ) ) {
            $this->debug( 'Subacetgory name vuoto' );
            return false;
        }
        
		$subcat = $this->utility->controlDataInsert( $this->main->specialTrim( strtolower( $subcat ) ) );
		
		//Recupera l'idSubcatAffiliation se non è presente inserisce un nuovo record nella tabella subcategorySiteAffiliation
		$sql = "SELECT idSubcatAffiliation FROM ".$this->dbName.".subcategorySiteAffiliation 
			WHERE name = ".$subcat." AND fkAffiliation = $idAffiliation"; 
		$stn = $this->mySql->prepare( $sql );
		$stn->execute();
		if ( $stn->rowCount() == 0 ) {
			$sql = 
			"INSERT INTO ".$this->dbName.".subcategorySiteAffiliation ( name, fkAffiliation, isActive ) 
				VALUES ( ".$subcat.", '".$idAffiliation."', $isActive )
			";
			//$this->debug( $sql );
			$stn = $this->mySql->prepare( $sql );
			$resp = $stn->execute();
			
			$sql = "SELECT idSubcatAffiliation FROM ".$this->dbName.".subcategorySiteAffiliation 
				WHERE name = ".$subcat." AND fkAffiliation = $idAffiliation"; 
			$stn = $this->mySql->prepare( $sql );
			$stn->execute();
			$row = $stn->fetch();
			$fkSubcatAffiliation = $row['idSubcatAffiliation'];

		} else {
			$row = $stn->fetch();
			$fkSubcatAffiliation = $row['idSubcatAffiliation'];
		}

		//Se è presente una sottocategoria già attiva ne fa il loockup automatico
		if ( $idSubcategory ) {
			$sql = "
			SELECT idLookup FROM ".$this->dbName.".lookupSubcategory
				WHERE fkSubcategory = '".$idSubcategory."' AND fkSubcatAffiliation = '".$fkSubcatAffiliation."'
			";
			$stn = $this->mySql->prepare( $sql );
			$stn->execute();
			if ( $stn->rowCount() == 0 ) {
				$sql = 
				"INSERT INTO ".$this->dbName.".lookupSubcategory ( fkSubcatAffiliation, fkSubcategory ) 
					VALUES ( '".$fkSubcatAffiliation."', $idSubcategory )
				";
				//$this->debug( $sql );
				$stn = $this->mySql->prepare( $sql );
				$resp = $stn->execute();
			}
		}
        return $fkSubcatAffiliation;
	}
	
	/**
	 * Metodo che visualizza l'array delle categorie
	 */
    public function getCategoryArray() {
        $categorys = array();
        foreach ( $this->filtersArray->typeCategoryOfSubcategory AS $key => $item ) {
            $category = $item['category'];
            if ( !empty( $category ) &&  !in_array( $category, $categorys ) )
                $categorys[] = $category;
        }
        sort( $categorys );
    }
    
	/**
	 * Metodo che inserisce le subcategory presente nel file filtersArray nel db
	 */
    public function insertSoshoppingCategorySubcategory() {
        foreach ( $this->filtersArray->typeCategoryOfSubcategory AS $key => $item ) {
            $this->insertSubcategory( $item );
        }
    }
    
    /**
     * Metodo che inserisce le sottocategorie nel db
     * @param type $item
     * @return type
     */
	public function insertSubcategory( $item ) {
		$affiliations = new Affiliations( $this->main );
		$category = $this->main->specialTrim( strtolower( $item['category'] ) );
		$stn = $this->mySql->prepare( "SELECT idCategory FROM ".$this->dbName.".category WHERE name = '".$category."'" );
		$stn->execute();
		if ( $stn->rowCount() == 0 ) {
			die( 'categoria non trovata => '.$item['category'] );
		}
		$row = $stn->fetch();
		$subcategory = $this->main->specialTrim( strtolower( $item['subcategory'] ) );

		$stn = $this->mySql->prepare( "SELECT idSubcategory FROM ".$this->dbName.".subcategory WHERE name = '".$subcategory."' AND fkCategory = '".$row['idCategory']."' " );
		$stn->execute();
		if ( $stn->rowCount() == 0 ) {
			$sql = 
			"INSERT INTO ".$this->dbName.".subcategory ( name, fkCategory, isActive ) 
				VALUES ( '".$subcategory."', '".$row['idCategory']."', 1 )
			";
			$this->debug( $sql );
			$stn = $this->mySql->prepare( $sql );
			$resp = $stn->execute();
			return $this->mySql->lastInsertId();
		} else{
			$row = $stn->fetch();
			return $row['idSubcategory'];
		}
	}
    
    /**
     * Metodo che inserisce le rewrite name nei prodotti già inseriti
     */
	public function insertRewriteName() {
		$sql = "SELECT * FROM ".$this->dbName.".product";
		$stn = $this->mySql->prepare( $sql );
		$stn->execute();
		$rows = $stn->fetchAll(  PDO::FETCH_OBJ );
		foreach( $rows AS $row ) {
			$rewriteName = '/'.rewriteUrl( $row->name );
			$sql = "UPDATE ".$this->dbName.".product SET rewriteName = '$rewriteName' WHERE idProduct = $row->idProduct";
			$stn = $this->mySql->prepare( $sql );
			$stn->execute();
			$this->debug( $sql );
		}
	}
	
	/**
	 * 
	 * @param type $params
	 */
	public function setManualLookupSubcategoryItem( $params ) {
		$sql = "SELECT $params->fieldIdName AS idField FROM ".$this->dbName.".$params->table 
			WHERE fkSubcatAffiliation = $params->fkSubcatAffiliation";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        $this->debug( $sql );
        foreach( $rows AS $row ) {      
            $sql = "UPDATE ".$this->dbName.".$params->table SET $params->valueField = $params->valueSet 
				WHERE $params->fieldIdName = $row->idField
            ";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
            if ( !$resp ) {
                $sql = "DELETE FROM ".$this->dbName.".$params->table WHERE $params->fieldIdName = $row->idField";
                $stn = $this->mySql->prepare( $sql );
                $resp = $stn->execute();
                $this->debug( $sql );
            }
        }
	}
	
    /**
     * Metodo per settare le mappature delle sottocategorie dei feed con quelle del sito
     * @param type $fkCategory
     * @param type $fkSubcategory
     * @param type $fkSubcatAffiliation
     */
    public function setManualLookupSubcategory( $fkCategory, $fkSubcategory, $fkSubcatAffiliation ) {
        $sql = 
        "INSERT INTO ".$this->dbName.".lookupSubcategory ( fkSubcatAffiliation, fkSubcategory ) 
            VALUES ( '".$fkSubcatAffiliation."', $fkSubcategory )
        ";
        $this->debug( $sql );
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        
//		/**********************************************************************/
//		
//		$params = new stdClass();
//		$params->fieldIdName = 'idBridgeAC';
//		$params->table = 'bridgeAffiliationCategory';
//		$params->valueField = 'fkCategory';
//		$params->valueSet = $fkCategory;
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$this->setManualLookupSubcategoryItem( $params );
//		
//		/**********************************************************************/
//		
//		$params = new stdClass();
//		$params->fieldIdName = 'idBridgeAS';
//		$params->table = 'bridgeAffiliationSubcategory';
//		$params->valueField = 'fkSubcategory';
//		$params->valueSet = $fkSubcategory;
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$this->setManualLookupSubcategoryItem( $params );
//		
//		/***********************************************************************/
//				
//		$params = new stdClass();
//		$params->table = 'bridgeColorCategory';
//		$params->fieldIdName = 'idBridgeCC';		
//		$params->valueField = 'fkCategory';
//		$params->valueSet = $fkCategory;
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$this->setManualLookupSubcategoryItem( $params );
//		
//		/***********************************************************************/
//		 
//		$params = new stdClass();
//		$params->table = 'bridgeColorSubcategory';
//		$params->fieldIdName = 'idBridgeCS';		
//		$params->valueField = 'fkSubcategory';
//		$params->valueSet = $fkSubcategory;
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$this->setManualLookupSubcategoryItem( $params );
//		
//		/***********************************************************************/
//		
//		$params = new stdClass();
//		$params->table = 'bridgeSizeCategory';
//		$params->fieldIdName = 'idBridgeSizeC';		
//		$params->valueField = 'fkCategory';
//		$params->valueSet = $fkCategory;
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$this->setManualLookupSubcategoryItem( $params );
//		
//		/***********************************************************************/
//		
//		$params = new stdClass();
//		$params->table = 'bridgeSizeSubcategory';
//		$params->fieldIdName = 'idBridgeSizeS';		
//		$params->valueField = 'fkSubcategory';
//		$params->valueSet = $fkSubcategory;
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$this->setManualLookupSubcategoryItem( $params );
//		
//		/***********************************************************************/
//       		
//		$params = new stdClass();
//		$params->table = 'bridgeTrademarkCategory';
//		$params->fieldIdName = 'idBridgeTC';		
//		$params->valueField = 'fkCategory';
//		$params->valueSet = $fkCategory;
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$this->setManualLookupSubcategoryItem( $params );
//		
//		/***********************************************************************/
//        
//		$params = new stdClass();
//		$params->table = 'bridgeTrademarkSubcategory';
//		$params->fieldIdName = 'idBridgeTS';		
//		$params->valueField = 'fkSubcategory';
//		$params->valueSet = $fkSubcategory;
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$this->setManualLookupSubcategoryItem( $params );
//		
//		/***********************************************************************/
		
        /* SETTA I CAMPI DI PRODUCT_TYPE*/
        $sql = 
        "UPDATE ".$this->dbName.".typology SET
            fkSubcategory = $fkSubcategory
        WHERE fkSubcatAffiliation = $fkSubcatAffiliation        
        ";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $this->debug( $sql );
                
        /* SETTA I CAMPI DEL PRODOTTO */
        $sql = 
        "UPDATE ".$this->dbName.".product  
            SET fkCategory = $fkCategory, fkSubcategory = $fkSubcategory
        WHERE fkSubcatAffiliation = $fkSubcatAffiliation
        ";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $this->debug( $sql );
        
        /* SETTA I CAMPI DEL PRODOTTO */
        $sql = 
        "UPDATE ".$this->dbName.".subcategorySiteAffiliation  
            SET isActive = 1
        WHERE idSubcatAffiliation = $fkSubcatAffiliation
        ";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $this->debug( $sql );
        
        $this->setNumberProductsCategory( $fkCategory );
        $this->setNumberProductsSubcategory( $fkSubcategory );
		exit(1);
    }
	
	/**
	 * Metodo che elimina i record dalle tabelle di bridge per la categoria e la sottocategoria dei colori
	 * e delle taglie qualora non siano più necessari perchè non ci sono più
	 * prodotti associati in caso siano stati spostati di categoria o siano stati eliminati
	 * @param type $params
	 */
	public function setChangeBridgeCategorySubcategoryElementProducts( $params ) {
		$sql = "SELECT DISTINCT $params->fieldName AS fieldName FROM ".$this->dbName.".$params->tableSelect WHERE fkProduct IN ( $params->ids )";
		$stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
		$this->debug( $sql );
		foreach( $rows AS $row ) {
			//Recuperare il numero di prodotti che hanno quel filtro tra quelli selezionati
			$sql = "SELECT count(*) AS tot FROM ".$this->dbName.".$params->tableSelect JOIN ".$this->dbName.".product ON product.idProduct = $params->tableSelect.fkProduct 
				WHERE $params->fieldName = " .$row->fieldName." AND fkProduct IN ( $params->ids )  AND $params->fieldNameWhere = $params->fieldValueWhere";
			$stn = $this->mySql->prepare( $sql );
            $stn->execute();
			$this->debug( $sql );
            $prodElementes = $stn->fetch( PDO::FETCH_OBJ );
			if ( empty( $prodElementes->tot ) )
				$prodElementes = new stdClass();			
			$prodElementes->tot = !empty( $prodElementes->tot ) ? $prodElementes->tot : 0;
			
			//Recupera il numero di prodotti che hanno quel filtro
			$sql = "SELECT count(*) AS tot FROM ".$this->dbName.".$params->tableSelect JOIN ".$this->dbName.".product ON product.idProduct = $params->tableSelect.fkProduct 
				WHERE $params->fieldName = " .$row->fieldName." AND $params->fieldNameWhere = $params->fieldValueWhere";
			$stn = $this->mySql->prepare( $sql );
            $stn->execute();
            $count = $stn->fetch( PDO::FETCH_OBJ );
			if ( empty( $count->tot ) )
				$count = new stdClass();			
			$count->tot = !empty( $count->tot ) ? $count->tot : 0;
			
			$this->debug( $sql );
			$this->debug( $prodElementes->tot .' >= '. $count->tot );
						
			$params->fieldNameWhere = str_replace( 'product.', '', $params->fieldNameWhere );
			//Cancella il record dalla tabella di bridge
			if( $prodElementes->tot >= $count->tot ) {
				$sql = "DELETE FROM ".$this->dbName.".$params->tableDelete WHERE $params->fieldName = " .$row->fieldName." AND $params->fieldNameWhere = $params->fieldValueWhere";
				$stn = $this->mySql->prepare( $sql );
				$resp = $stn->execute();
				$this->debug( $sql );
			}
			
			if ( !empty( $params->newValueSection ) ) {
				$sql = "INSERT INTO ".$this->dbName.".$params->tableDelete ( $params->fieldName, ".$params->fieldNameWhere.", fkSubcatAffiliation )  VALUE ( $row->fieldName, $params->newValueSection, 9 )";
				$stn = $this->mySql->prepare( $sql );
				$resp = $stn->execute();
				$this->debug( $sql );
			}
		}
	}
	
	/**
	 * Metodo che elimina i record dalle tabelle di bridge generiche qualora non siano più necessari perchè non ci sono più
	 * prodotti associati in caso siano stati spostati di categoria o siano stati eliminati
	 * @param type $params
	 */
	public function setChangeBridgeGenericElementProducts( $params ) {
		$sql = "SELECT DISTINCT $params->fieldName AS fieldName FROM ".$this->dbName.".$params->tableSelect WHERE idProduct IN ( $params->ids )";
		$stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
		$this->debug( $sql );
		foreach( $rows AS $row ) {
			//Recuperare il numero di prodotti che hanno quel filtro tra quelli selezionati
			$sql = "SELECT count(*) AS tot FROM $params->tableSelect WHERE $params->fieldName = " .$row->fieldName." AND idProduct IN ( $params->ids )  AND $params->fieldNameWhere = $params->fieldValueWhere";
			$stn = $this->mySql->prepare( $sql );
            $stn->execute();
			$this->debug( $sql );
			
            $prodElementes = $stn->fetch( PDO::FETCH_OBJ );			
			if ( empty( $prodElementes->tot ) )
				$prodElementes = new stdClass();			
			$prodElementes->tot = !empty( $prodElementes->tot ) ? $prodElementes->tot : 0;

			//Recupera il numero di prodotti che hanno quel filtro
			$sql = "SELECT count(*) AS tot FROM $params->tableSelect WHERE $params->fieldName = " .$row->fieldName." AND $params->fieldNameWhere = $params->fieldValueWhere";
			$stn = $this->mySql->prepare( $sql );
            $stn->execute();
            $count = $stn->fetch( PDO::FETCH_OBJ );

			if ( empty( $count->tot ) )
				$count = new stdClass();			
			$count->tot = !empty( $count->tot ) ? $count->tot : 0;
			
			$this->debug( $sql );
			$this->debug( $prodElementes->tot .' >= '. $count->tot );

			//Cancella il record dalla tabella di bridge
			if( $count->tot > 0 && $prodElementes->tot >= $count->tot ) {
				$sql = "DELETE FROM ".$this->dbName.".$params->tableDelete 
					WHERE $params->fieldName = " .$row->fieldName." AND $params->fieldNameWhere = $params->fieldValueWhere";
				$stn = $this->mySql->prepare( $sql );
				$resp = $stn->execute();
				$this->debug( $sql );
			}
			
			if ( !empty( $params->newValueSection ) ) {
				$sql = "INSERT INTO ".$this->dbName.".$params->tableDelete ( $params->fieldName, ".str_replace( 'product.', '', $params->fieldNameWhere ).", fkSubcatAffiliation )  VALUE ( $row->fieldName, $params->newValueSection, 9 )";
				$stn = $this->mySql->prepare( $sql );
				$resp = $stn->execute();
				$this->debug( $sql );
			}
		}
	}
	
	/**
	 * Metodo che elimina i record dalle tabelle di bridge per typoligy dei colori
	 * e delle taglie qualora non siano più necessari perchè non ci sono più
	 * prodotti associati in caso siano stati spostati di categoria o siano stati eliminati
	 * @param type $params
	 */
	public function setChangeBridgeTypologyElementProducts( $params ) {
		$sql = "SELECT DISTINCT fkTypology FROM ".$this->dbName.".product WHERE idProduct IN ( $params->ids )";
		$stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
		$this->debug( $sql );
		foreach( $rows AS $row ) {
			$params->fieldValueWhere = $row->fkTypology;
			switch( $params->callFunction ) {
				case 'setChangeBridgeGenericElementProducts';
					$this->setChangeBridgeGenericElementProducts( $params );
				break;
				case 'setChangeBridgeCategorySubcategoryElementProducts';
					$this->setChangeBridgeCategorySubcategoryElementProducts( $params );
				break;				
			}
		}
	}
	
	/**
	 * Metodo che sposta i prodotti in altre sezioni
	 * @param type $idCategory
	 * @param type $idSubcategory
	 * @param type $ids
	 */
	public function  setChangeSectionProducts( $search ) {		
		if ( empty( $search->fkCategory ) ||
			 empty( $search->fkSubcategory ) ||
			 empty( $search->ids ) ||
			 empty( $search->categoryLast ) ||
			 empty( $search->subcategoryLast ) ) {			
			die( 'Mancano i parametri per chiamare questa funzione: setChangeSectionProducts');
		}
		$aIds = explode( ',', $search->ids );
		$numProducts = count( $aIds );		
		
//		/********************** bridgeColorCategory ****************************/
//		
//		$params = new stdClass();
//		$params->tableSelect = 'bridgeProductColor';
//		$params->fieldName = 'fkColor';
//		$params->tableDelete = 'bridgeColorCategory';
//		$params->fieldNameWhere = 'product.fkCategory';		
//		$params->fieldValueWhere = $search->categoryLast;		
//		$params->newValueSection = $search->fkCategory;				
//		$params->ids = $search->ids;
//		$this->setChangeBridgeCategorySubcategoryElementProducts( $params );		
//		
//		/********************** bridgeColorSubcategory *************************/
//		
//		unset( $params ); 
//		$params = new stdClass();
//		$params->tableSelect = 'bridgeProductColor';
//		$params->fieldName = 'fkColor';
//		$params->tableDelete = 'bridgeColorSubcategory';
//		$params->fieldNameWhere = 'product.fkSubcategory';
//		$params->fieldValueWhere = $search->subcategoryLast;
//		$params->newValueSection = $search->fkSubcategory;
//		$params->ids = $search->ids;
//		$this->setChangeBridgeCategorySubcategoryElementProducts( $params );
//		
//		/*********************** bridgeSizeCategory ***************************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->tableSelect = 'bridgeProductSize';
//		$params->fieldName = 'fkSize';
//		$params->tableDelete = 'bridgeSizeCategory';
//		$params->fieldNameWhere = 'product.fkCategory';
//		$params->fieldValueWhere = $search->categoryLast;
//		$params->newValueSection = $search->fkCategory;
//		$params->ids = $search->ids;
//		$this->setChangeBridgeCategorySubcategoryElementProducts( $params );		
//		
//		/*********************** bridgeSizeSubcategory ************************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->tableSelect = 'bridgeProductSize';
//		$params->fieldName = 'fkSize';
//		$params->tableDelete = 'bridgeSizeSubcategory';
//		$params->fieldNameWhere = 'product.fkSubcategory';
//		$params->fieldValueWhere = $search->subcategoryLast;
//		$params->newValueSection = $search->fkSubcategory;
//		$params->ids = $search->ids;
//		$this->setChangeBridgeCategorySubcategoryElementProducts( $params );		
//		
//		/********************** bridgeTrademarkCategory ***********************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->tableSelect = 'product';
//		$params->fieldName = 'fkTrademark';
//		$params->tableDelete = 'bridgeTrademarkCategory';
//		$params->fieldNameWhere = 'product.fkCategory';
//		$params->fieldValueWhere = $search->categoryLast;
//		$params->newValueSection = $search->fkCategory;
//		$params->ids = $search->ids;
//		$this->setChangeBridgeGenericElementProducts( $params );
//		
//		/******************** bridgeTrademarkSubcategory **********************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->tableSelect = 'product';
//		$params->fieldName = 'fkTrademark';
//		$params->tableDelete = 'bridgeTrademarkSubcategory';
//		$params->fieldNameWhere = 'product.fkSubcategory';
//		$params->fieldValueWhere = $search->subcategoryLast;
//		$params->newValueSection = $search->fkSubcategory;
//		$params->ids = $search->ids;
//		$this->setChangeBridgeGenericElementProducts( $params );
//		
//		/********************  bridgeAffiliationTypology **********************/
//		
//		$params = new stdClass();
//		$params->tableSelect = 'product';
//		$params->fieldName = 'fkTrademark';
//		$params->tableDelete = 'bridgeTrademarkTypology';
//		$params->fieldNameWhere = 'product.fkTypology';
//		$params->ids = $search->ids;
//		$params->callFunction = 'setChangeBridgeGenericElementProducts';
//		$this->setChangeBridgeTypologyElementProducts( $params );
//		
//		/**********************  bridgeColorTypology ****************************/
//		
//		$params = new stdClass();
//		$params->tableSelect = 'bridgeProductColor';
//		$params->fieldName = 'fkColor';
//		$params->tableDelete = 'bridgeColorTypology';
//		$params->fieldNameWhere = 'product.fkTypology';
//		$params->ids = $search->ids;
//		$params->callFunction = 'setChangeBridgeCategorySubcategoryElementProducts';
//		$this->setChangeBridgeTypologyElementProducts( $params );
//		
//		/**********************  bridgeSizeTypology ****************************/
//		
//		$params = new stdClass();
//		$params->tableSelect = 'bridgeProductSize';
//		$params->fieldName = 'fkSize';
//		$params->tableDelete = 'bridgeSizeTypology';
//		$params->fieldNameWhere = 'product.fkTypology';
//		$params->ids = $search->ids;
//		$params->callFunction = 'setChangeBridgeCategorySubcategoryElementProducts';
//		$this->setChangeBridgeTypologyElementProducts( $params );
//		
//		/********************** bridgeTrademarkCategory ***********************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->tableSelect = 'product';
//		$params->fieldName = 'fkAffiliation';
//		$params->tableDelete = 'bridgeAffiliationCategory';
//		$params->fieldNameWhere = 'product.fkCategory';
//		$params->fieldValueWhere = $search->categoryLast;
//		$params->ids = $search->ids;
//		$this->setChangeBridgeGenericElementProducts( $params );
//		
//		
//		/******************** bridgeTrademarkSubcategory **********************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->tableSelect = 'product';
//		$params->fieldName = 'fkAffiliation';
//		$params->tableDelete = 'bridgeAffiliationSubcategory';
//		$params->fieldNameWhere = 'product.fkSubcategory';
//		$params->fieldValueWhere = $search->subcategoryLast;
//		$params->ids = $search->ids;
//		$this->setChangeBridgeGenericElementProducts( $params );
//		
//		/********************  bridgeAffiliationTypology **********************/
//		
//		$params = new stdClass();
//		$params->tableSelect = 'product';
//		$params->fieldName = 'fkAffiliation';
//		$params->tableDelete = 'bridgeAffiliationTypology';
//		$params->fieldNameWhere = 'product.fkTypology';
//		$params->ids = $search->ids;
//		$params->callFunction = 'setChangeBridgeGenericElementProducts';
//		$this->setChangeBridgeTypologyElementProducts( $params );
//		
//		/********************  bridgeAffiliationTypology **********************/
		
		$addWhere = '';
		if( !empty( $search->fkTypology ) )
			$addWhere = ", fkTypology = $search->fkTypology";
		
		/* SETTA I CAMPI DEL PRODOTTO */
        $sql = 
        "UPDATE ".$this->dbName.".product  
            SET fkCategory = $search->fkCategory, fkSubcategory = $search->fkSubcategory $addWhere
        WHERE idProduct IN ( $search->ids );
        ";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $this->debug( $sql );	
		
		$this->setNumberProductsCategory( $search->fkCategory );
        $this->setNumberProductsSubcategory( $search->fkSubcategory );
		exit(1);
	}
	
    /**
     * Metodo che setta il numero di articoli inseriti per ogni categoria e sottocategoria e affiliazione
     */
    public function setNumberProducts() {
		@unlink( $this->config->cacheAffiliationsFilename );
		@unlink( $this->config->cacheCategoriesFilename );
		@unlink( $this->config->cacheSubcategoriesFilename );
		@unlink( $this->config->cacheTypologiesFilename );		
		
        $sql = "SELECT idAffiliation FROM ".$this->dbName.".affiliation";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
		$this->debug( $sql );
        foreach( $rows AS $row ) {
            $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".product WHERE fkAffiliation = ".$row->idAffiliation;
            $stn = $this->mySql->prepare( $sql );
            $stn->execute();
            $prod = $stn->fetch( PDO::FETCH_OBJ );

            $sql = "UPDATE ".$this->dbName.".affiliation SET numProducts = ".$prod->numProducts." WHERE idAffiliation = ".$row->idAffiliation;
            $stn = $this->mySql->prepare( $sql );
            $stn->execute();
			$this->debug( $sql );
        }                
        $sql = "SELECT idCategory FROM ".$this->dbName.".category";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
		$this->debug( $sql );
        foreach( $rows AS $row ) {
            $this->setNumberProductsCategory( $row->idCategory );
        }
		
        $sql = "SELECT idSubcategory FROM ".$this->dbName.".subcategory";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
		$this->debug( $sql );
        foreach( $rows AS $row ) {
            $this->setNumberProductsSubcategory( $row->idSubcategory );
        }
		
		$sql = "SELECT idTypology FROM ".$this->dbName.".typology";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
		$this->debug( $sql );
        foreach( $rows AS $row ) {
            $this->setNumberProductsTypology( $row->idTypology );
        }		
    }
    
	/**
	 * Metodo che setta il numero di prodotti per marchio
	 */
	public function setNumberProductsTrademarks() {
		$sql = "SELECT idTrademark FROM ".$this->dbName.".trademark";
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {
            $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".product WHERE fkTrademark = ".$row->idTrademark;
            $stn = $this->mySql->prepare( $sql );
            $stn->execute();
            $prod = $stn->fetch( PDO::FETCH_OBJ );

            $sql = "UPDATE ".$this->dbName.".trademark SET numProducts = ".$prod->numProducts." WHERE idTrademark = ".$row->idTrademark;
            $stn = $this->mySql->prepare( $sql );
            $stn->execute();
			$this->debug( $sql );
        }
		$this->debug( $sql );
	}
	
	/**
	 * Metodo che setta il numero di prodotti per categoria
	 * @param int $idCategory
	 */
    public function setNumberProductsCategory( $idCategory ) {
        $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".product WHERE fkCategory = ".$idCategory;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $prod = $stn->fetch( PDO::FETCH_OBJ );
        $this->debug( $sql );

        $sql = "UPDATE ".$this->dbName.".category SET numProducts = ".$prod->numProducts." WHERE idCategory = ".$idCategory;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $this->debug( $sql );
    }
    
	/**
	 * Metodo che setta il numero di prodotti per sottocategoria
	 * @param int $idSubcategory
	 */
    public function setNumberProductsSubcategory( $idSubcategory ) {
        $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".product WHERE fkSubcategory = ".$idSubcategory;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $prod = $stn->fetch( PDO::FETCH_OBJ );
        $this->debug( $sql );

        $sql = "UPDATE ".$this->dbName.".subcategory SET numProducts = ".$prod->numProducts." WHERE idSubcategory = ".$idSubcategory;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute(); 
        $this->debug( $sql );
    }
	
	/**
	 * Metodo che setta il numero di prodotti per tipologia
	 * @param int $idTypology
	 */
	public function setNumberProductsTypology( $idTypology ) {
        $sql = "SELECT count(*) AS numProducts FROM ".$this->dbName.".product WHERE fkTypology = ".$idTypology;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute();
        $prod = $stn->fetch( PDO::FETCH_OBJ );
        $this->debug( $sql );

        $sql = "UPDATE ".$this->dbName.".typology SET numProducts = ".$prod->numProducts." WHERE idTypology = ".$idTypology;
        $stn = $this->mySql->prepare( $sql );
        $stn->execute(); 
        $this->debug( $sql );
    }
    
    /**
     * Metodo che elimina i valori duplicati
     */
    public function restoreTableOfUniqueKey() {
		$sql = "UPDATE ".$this->dbName.".lookupSubcategory SET deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $sql = "SELECT DISTINCT fkSubcatAffiliation,fkSubcategory FROM ".$this->dbName.".lookupSubcategory order by idLookup asc";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute(); 
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {           
            $sql = "UPDATE ".$this->dbName.".lookupSubcategory SET deleteRow = 0
            WHERE fkSubcatAffiliation = ".$row->fkSubcatAffiliation." AND fkSubcategory = ".$row->fkSubcategory."
                ORDER BY idLookup ASC LIMIT 1";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
        $sql = "DELETE FROM ".$this->dbName.".lookupSubcategory WHERE deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $this->debug( $sql );
        $resp = $stn->execute();
		exit;
		
        $sql = "UPDATE ".$this->dbName.".bridgeProductSize SET deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $sql = "SELECT DISTINCT fkProduct,fkSize FROM ".$this->dbName.".bridgeProductSize order by fkProduct asc";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute(); 
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {           
            $sql = "UPDATE ".$this->dbName.".bridgeProductSize SET deleteRow = 0
            WHERE fkProduct = $row->fkProduct AND fkSize = $row->fkSize 
                ORDER BY idBridgePS ASC LIMIT 1";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
        $sql = "DELETE FROM ".$this->dbName.".bridgeProductSize WHERE deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $this->debug( $sql );
        $resp = $stn->execute();
        
        $sql = "UPDATE ".$this->dbName.".bridgeProductColor SET deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $sql = "SELECT DISTINCT fkProduct,fkColor FROM ".$this->dbName.".bridgeProductColor order by fkProduct asc";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute(); 
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {           
            $sql = "UPDATE ".$this->dbName.".bridgeProductColor SET deleteRow = 0
            WHERE fkProduct = $row->fkProduct AND fkColor = $row->fkColor 
                ORDER BY idBridgePC ASC LIMIT 1";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
        $sql = "DELETE FROM ".$this->dbName.".bridgeProductColor WHERE deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $this->debug( $sql );
        $resp = $stn->execute();
        exit;

        //alter table bridgeTrademarkSize add `deleteRow` int(10) DEFAULT NULL; 
        //alter table bridgeTrademarkSize add key fkBridgeTrademarkColorDeleteRow (deleteRow);
        $sql = "UPDATE ".$this->dbName.".bridgeTrademarkSize SET deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $sql = "SELECT DISTINCT fkTrademark,fkSize FROM ".$this->dbName.".bridgeTrademarkSize order by fkTrademark asc";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute(); 
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {           
            $sql = "UPDATE ".$this->dbName.".bridgeTrademarkSize SET deleteRow = 0
            WHERE fkTrademark = $row->fkTrademark AND fkSize = $row->fkSize 
                ORDER BY idBridgeTS ASC LIMIT 1";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
        $sql = "DELETE FROM ".$this->dbName.".bridgeTrademarkSize WHERE deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $this->debug( $sql );
        $resp = $stn->execute();
        
        //alter table bridgeTrademarkColor add `deleteRow` int(10) DEFAULT NULL; 
        //alter table bridgeTrademarkColor add key fkBridgeTrademarkColorDeleteRow (deleteRow);
        $sql = "UPDATE ".$this->dbName.".bridgeTrademarkColor SET deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $sql = "SELECT DISTINCT fkTrademark,fkColor FROM ".$this->dbName.".bridgeTrademarkColor order by fkTrademark asc";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {           
            $sql = "UPDATE ".$this->dbName.".bridgeTrademarkColor SET deleteRow = 0
            WHERE fkTrademark = $row->fkTrademark AND fkColor = $row->fkColor 
                ORDER BY idBridgeTC ASC LIMIT 1";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
        $sql = "DELETE FROM ".$this->dbName.".bridgeTrademarkColor WHERE deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $this->debug( $sql );
        $resp = $stn->execute();       
        
        //alter table bridgeColorCategorySubcategory add `deleteRow` int(10) DEFAULT NULL; 
        //alter table bridgeColorCategorySubcategory add key fkBridgeColorCategorySubcategoryDeleteRow (deleteRow);
        $sql = "UPDATE ".$this->dbName.".bridgeColorCategorySubcategory SET deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $sql = "SELECT DISTINCT fkSubcatAffiliation, fkColor FROM ".$this->dbName.".bridgeColorCategorySubcategory order by fkSubcatAffiliation asc";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {           
            $sql = "UPDATE ".$this->dbName.".bridgeColorCategorySubcategory SET deleteRow = 0
            WHERE fkSubcatAffiliation = $row->fkSubcatAffiliation AND fkColor = $row->fkColor 
                ORDER BY idBridgeCS ASC LIMIT 1";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
        $sql = "DELETE FROM ".$this->dbName.".bridgeColorCategorySubcategory WHERE deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $this->debug( $sql );
        $resp = $stn->execute();
        
        //alter table bridgeSizeCategorySubcategory add `deleteRow` int(10) DEFAULT NULL; 
        //alter table bridgeSizeCategorySubcategory add key bridgeSizeCategorySubcategoryDeleteRow (deleteRow);
        $sql = "UPDATE ".$this->dbName.".bridgeSizeCategorySubcategory SET deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $sql = "SELECT DISTINCT fkSubcatAffiliation, fkSize FROM ".$this->dbName.".bridgeSizeCategorySubcategory ORDER BY fkSubcatAffiliation ASC";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {           
            $sql = "UPDATE ".$this->dbName.".bridgeSizeCategorySubcategory SET deleteRow = 0
            WHERE fkSubcatAffiliation = $row->fkSubcatAffiliation AND fkSize = $row->fkSize 
                ORDER BY idBridgeSizeCS ASC LIMIT 1";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
        $sql = "DELETE FROM ".$this->dbName.".bridgeSizeCategorySubcategory WHERE deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $this->debug( $sql );
        $resp = $stn->execute();
        
        
        //alter table bridgeTrademarkCategorySubcategory add `deleteRow` int(10) DEFAULT NULL; 
        //alter table bridgeTrademarkCategorySubcategory add key bridgeTrademarkCategorySubcategoryDeleteRow (deleteRow);
        $sql = "UPDATE ".$this->dbName.".bridgeTrademarkCategorySubcategory SET deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $sql = "SELECT DISTINCT fkSubcatAffiliation, fkTrademark FROM ".$this->dbName.".bridgeTrademarkCategorySubcategory order by fkSubcatAffiliation asc";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {           
            $sql = "UPDATE ".$this->dbName.".bridgeTrademarkCategorySubcategory SET deleteRow = 0
            WHERE fkSubcatAffiliation = $row->fkSubcatAffiliation AND fkTrademark = $row->fkTrademark 
                ORDER BY idBridgeTS ASC LIMIT 1";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
        $sql = "DELETE FROM ".$this->dbName.".bridgeTrademarkCategorySubcategory WHERE deleteRow = 1";
        $stn = $this->mySql->prepare( $sql );
        $this->debug( $sql );
        $resp = $stn->execute();        
    }
    
	
    /**
     * Metodo che crea i nuovi formati per le immagini mancanti
     * @param type $limit
     */
    public function createNewFormatImg( $limit = false ) {
        $limit = $limit ? 'limit '.$limit : '';
        $sql = "SELECT idProduct,img FROM ".$this->dbName.".product where imgFormat = 0 AND img != '' order by idProduct desc $limit";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $product ) {
            $myFile['name'][0] = $this->config->urlSite.'/'.$this->config->imagesProducts.$product->img;
            $myFile['tmp_name'][0] = $this->config->urlSite.'/'.$this->config->imagesProducts.$product->img;
            $myFile['type'][0] = $this->utility->getTypeImg( exif_imagetype( $this->config->urlSite.'/'.$this->config->imagesProducts.$product->img ) );
            $file = myUpload( $this->mySql, $myFile, $this->config->imagesProductsMediumWrite, $this->config->tempDir, 220, 250, $this->dbName, "product", session_id(), $product->idProduct, array( $product->img ) );
            $file = myUpload( $this->mySql, $myFile, $this->config->imagesProductsSmallWrite, $this->config->tempDir, 165, 165, $this->dbName, "product", session_id(), $product->idProduct, array( $product->img ) );
            echo $this->config->imagesProducts.$product->img."\n";
            $sql = "UPDATE  ".$this->dbName.".product SET imgFormat = 1 WHERE idProduct = ".$product->idProduct;
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
    }
    
    /**
     * Metodo che setta le keywords per le News
     */
    public function setKeywordNews() {
        $sql = "SELECT idReview,link From ".$this->dbName.".review WHERE tags = '' OR tags = 'Array'";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {
           $metaTags = get_meta_tags( $row->link );
           if ( !empty( $metaTags['keywords'] ) ) {
               $sql = "UPDATE review SET tags = ".$this->mySql->quote( trim( utf8_decode( ucwords( $metaTags['keywords'] ) ) ), PDO::PARAM_STR )." WHERE idReview = $row->idReview";
               $stn = $this->mySql->prepare( $sql );
               $resp = $stn->execute();
               $this->debug( $sql );
           }
        }
    }
    
	/**
	 * Metodo che cambia la sottocategoria o la categoria alle tabelle di bridge
	 * @param type $params
	 */	
	public function changeSubcategoryProductItem( $params ) {
		if ( empty( $params ) )
			die( 'changeSubcategoryProductItem: PARAMETRI MANCANTI' );
		
		$set = "";
		$where = "";
		if ( !empty( $params->fkCategoryNew ) ) {
			$set .= " fkCategory = $params->fkCategoryNew, ";
			$where .= "fkCategory = $params->fkCategoryError AND ";
		}
		
		if ( !empty( $params->fkSubcategoryNew ) ) {
			$set .= " fkSubcategory= $params->fkSubcategoryNew, ";
			$where .= "fkSubcategory= $params->fkSubcategoryError AND ";
		}
		
		$sql = "
		UPDATE ".$this->dbName.".$params->table 
			SET $set fkSubcatAffiliation= $params->newFkSubcatAffiliation
		WHERE $where fkSubcatAffiliation= $params->fkSubcatAffiliation 
        ";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $this->debug( $sql );
        if ( !$resp ) {
            $sql = "DELETE FROM ".$this->dbName.".$params->table 
                WHERE $where AND fkSubcatAffiliation= $params->fkSubcatAffiliation
            ";
            $stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
            $this->debug( $sql );
        }
	}
	
    /**
     * Metodo che sposta tutta una sottocategoria i suoi prodotti e le sue relative tabelle di bridge nella nuova sottocategoria
     * @param int $fkCategoryNew
     * @param int $fkSubcategoryNew
     * @param int $fkCategoryError
     * @param int $fkSubcategoryError
     * @param int $fkSubcatAffiliation
     */
    public function changeSubcategoryProduct( $fkCategoryNew, $fkSubcategoryNew, $fkCategoryError, $fkSubcategoryError, $fkSubcatAffiliation  ) {
        $sql = "SELECT fkSubcatAffiliation FROM ".$this->dbName.".lookupSubcategory WHERE fkSubcategory = ".$fkSubcategoryNew;
		$stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
		$row = $stn->fetch( PDO::FETCH_OBJ );
		$newFkSubcatAffiliation = $row->fkSubcatAffiliation;

		$sql = "UPDATE ".$this->dbName.".product 
			SET fkCategory = $fkCategoryNew, 
				fkSubcategory= $fkSubcategoryNew,
				fkSubcatAffiliation= $newFkSubcatAffiliation
            WHERE fkCategory = $fkCategoryError AND fkSubcategory= $fkSubcategoryError
        ";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $this->debug( $sql );
        
        $sql = "UPDATE ".$this->dbName.".productType SET 
				fkSubcategory = $fkSubcategoryNew,
				fkSubcatAffiliation = $newFkSubcatAffiliation
            WHERE fkSubcategory = $fkSubcategoryError AND fkSubcatAffiliation= $fkSubcatAffiliation
        ";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $this->debug( $sql );
        
        $sql = "UPDATE ".$this->dbName.".lookupSubcategory 
				SET fkSubcategory = $fkSubcategoryNew,
					fkSubcatAffiliation= $newFkSubcatAffiliation
            WHERE fkSubcategory = $fkSubcategoryError AND fkSubcatAffiliation= $fkSubcatAffiliation
        ";
        $stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $this->debug( $sql );
        
//		
//        /**********************************************************************/
//		
//		$params = new stdClass();
//		$params->fkCategoryNew = $fkCategoryNew;
//		$params->fkCategoryError = $fkCategoryError;
//		$params->newFkSubcatAffiliation = $newFkSubcatAffiliation;		
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$params->table = 'bridgeColorCategory';
//		$this->changeSubcategoryProductItem( $params );        
//		
//		/**********************************************************************/
//		
//		unset( $params );
//        $params = new stdClass();
//		$params->fkSubcategoryNew = $fkSubcategoryNew;
//		$params->fkSubcategoryError = $fkSubcategoryError;
//		$params->newFkSubcatAffiliation = $newFkSubcatAffiliation;		
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$params->table = 'bridgeColorSubcategory';
//		$this->changeSubcategoryProductItem( $params );
//        
//		/**********************************************************************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->fkCategoryNew = $fkCategoryNew;
//		$params->fkCategoryError = $fkCategoryError;
//		$params->newFkSubcatAffiliation = $newFkSubcatAffiliation;		
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$params->table = 'bridgeSizeCategory';
//		$this->changeSubcategoryProductItem( $params );
//		
//		/**********************************************************************/
//        
//		unset( $params );
//		$params = new stdClass();
//		$params->fkSubcategoryNew = $fkSubcategoryNew;
//		$params->fkSubcategoryError = $fkSubcategoryError;
//		$params->newFkSubcatAffiliation = $newFkSubcatAffiliation;		
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$params->table = 'bridgeSizeSubcategory';
//		$this->changeSubcategoryProductItem( $params );
//        
//		/**********************************************************************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->fkCategoryNew = $fkCategoryNew;
//		$params->fkCategoryError = $fkCategoryError;
//		$params->newFkSubcatAffiliation = $newFkSubcatAffiliation;		
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$params->table = 'bridgeTrademarkCategory';
//		$this->changeSubcategoryProductItem( $params );
//		
//		/**********************************************************************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->fkSubcategoryNew = $fkSubcategoryNew;
//		$params->fkSubcategoryError = $fkSubcategoryError;
//		$params->newFkSubcatAffiliation = $newFkSubcatAffiliation;		
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$params->table = 'bridgeTrademarkSubcategory';
//		$this->changeSubcategoryProductItem( $params );
//        
//		/**********************************************************************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->fkCategoryNew = $fkCategoryNew;
//		$params->fkCategoryError = $fkCategoryError;
//		$params->newFkSubcatAffiliation = $newFkSubcatAffiliation;		
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$params->table = 'bridgeAffiliationCategory';
//		$this->changeSubcategoryProductItem( $params );
//		
//		/**********************************************************************/
//		
//		unset( $params );
//		$params = new stdClass();
//		$params->fkSubcategoryNew = $fkSubcategoryNew;
//		$params->fkSubcategoryError = $fkSubcategoryError;
//		$params->newFkSubcatAffiliation = $newFkSubcatAffiliation;		
//		$params->fkSubcatAffiliation = $fkSubcatAffiliation;
//		$params->table = 'bridgeAffiliationSubcategory';
//		$this->changeSubcategoryProductItem( $params );
//        
//		/**********************************************************************/
        
        $this->setNumberProductsCategory( $fkCategoryNew );
        $this->setNumberProductsCategory( $fkCategoryError );
        $this->setNumberProductsSubcategory( $fkSubcategoryNew );
        $this->setNumberProductsSubcategory( $fkSubcategoryError );
    }
	
	/**
	 * Metodo che inserisce le dimensioni delle immagini dei prodotti nella tabella imagesProducts
	 */
	public function insertDimensionImagesProducts() {
		$sql = "
		SELECT idProduct,img,imgWidth,imgHeight FROM  ".$this->dbName.".product
			WHERE idProduct >= 0 order by idProduct ASC;
		";
		$stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {
			list( $widthSmall, $heightSmall, $typeSmall, $attrSmall ) = getimagesize( $this->config->urlSite.'/'.$this->config->imagesProductsSmall.$row->img );
			list( $widthMedium, $heightMedium, $typeMedium, $attrMedium ) = getimagesize( $this->config->urlSite.'/'.$this->config->imagesProductsMedium.$row->img );
			$sql = "
				INSERT INTO ".$this->dbName.".imageProduct 
					( fkProduct,img,widthSmall,heightSmall,widthMedium,heightMedium,widthLarge,heightLarge )
				VALUE(
					'$row->idProduct',
					'$row->img',
					'$widthSmall',
					'$heightSmall',
					'$widthMedium',
					'$heightMedium',
					'$row->imgWidth',
					'$row->imgHeight'
				)	
			";
			$stn = $this->mySql->prepare( $sql );
            $resp = $stn->execute();
			$this->debug( $this->mySql->specialTrimQuery( $sql ) );
		}
	}
	
	/**
	 * Metodo che ottimizza le immagini
	 * @param type $data
	 */
	public function omptimizedImageProducts( $data ) {
		$sql = "
		SELECT img from ".$this->dbName.".product  
			JOIN ".$this->dbName.".imageProduct ON imageProduct.fkProduct =  product.idProduct
		WHERE dataImport >= '".$data."'";
		$this->debug( $sql );
		$stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
        foreach( $rows AS $row ) {
        	if ( !empty( $row->img ) ) {
				$command1 = 'jpegoptim '.$this->config->imagesProductsSmallWrite.$row->img.' -p -o -m100 --strip-all';
				$command2 = 'jpegoptim '.$this->config->imagesProductsMediumWrite.$row->img.' -p -o -m100 --strip-all';
				$command3 = 'jpegoptim '.$this->config->imagesProductsWrite.$row->img.' -p -o -m100 --strip-all';
				try {
					system( $command1 );
					system( $command2 );
					system( $command3 );
				} catch ( Exception $e ) {
					echo 'ATTENZIONE: Ottimizzazione Immagine Fallita!!! '.$e;
				}
			}
        }
	}
	
	/**
	 * Metodo che setta le key url delle categorie sottocategorie e tipologie
	 */
	public function setKeyUrlSections() {
//		$sql = "SELECT idCategory,name FROM ".$this->dbName.".category";
//		$this->debug( $sql );
//		$stn = $this->mySql->prepare( $sql );
//        $resp = $stn->execute();
//        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
//		foreach( $rows AS $row ) {
//			$sql = "UPDATE ".$this->dbName.".category SET keyUrlCategory = '".$this->rewrite->rewriteUrl( $row->name )."' WHERE idCategory = $row->idCategory";
//			$stn = $this->mySql->prepare( $sql );
//			$resp = $stn->execute();
//			$this->debug( $sql );
//		}
//		
//		$sql = "SELECT idSubcategory,name FROM ".$this->dbName.".subcategory";
//		$this->debug( $sql );
//		$stn = $this->mySql->prepare( $sql );
//        $resp = $stn->execute();
//        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
//		foreach( $rows AS $row ) {
//			$sql = "UPDATE ".$this->dbName.".subcategory SET keyUrlSubcategory = '".$this->rewrite->rewriteUrl( $row->name )."' WHERE idSubcategory = $row->idSubcategory";
//			$stn = $this->mySql->prepare( $sql );
//			$resp = $stn->execute();
//			$this->debug( $sql );
//		}
		
		$sql = "SELECT idTypology,name FROM ".$this->dbName.".typology";
		$this->debug( $sql ); 
		$stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $rows = $stn->fetchAll( PDO::FETCH_OBJ );
		foreach( $rows AS $row ) {
			$row = $this->utility->setValidKeyUrl( $row, array( 'name' ) );
			$sql = "UPDATE ".$this->dbName.".typology SET keyUrlTypology = '".$this->rewrite->rewriteUrl( $row->name )."' WHERE idTypology = $row->idTypology";
			$stn = $this->mySql->prepare( $sql );
			$resp = $stn->execute();
			$this->debug( $sql );
		}
	}
	
	/**
	 * Metodo che disabilità gli annunci di un affiliatio che non sono più presenti nel feed
	 * @param int $idAffiliation
	 * @return int
	 */
	public function disableProducts( $idAffiliation, $data ) {
		$sql = "UPDATE ".$this->dbName.".product SET isActive = 0, dataDisabled = '{$data}' WHERE isActive = 1 AND fkAffiliation = {$idAffiliation} AND lastRead < '{$data}'";		
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
		$sql = "UPDATE ".$this->dbName.".product SET isActive = 1 WHERE fkAffiliation = {$idAffiliation} AND lastRead >= '{$data}'";		
		$stn = $this->mySql->prepare( $sql );
		$resp = $stn->execute();
		
		$this->debug( $sql );
		return ( $resp ? $stn->rowCount() : 0 );
	}
	
	
	/**
	 * Metodo che counta il numero di annunci attivi e quelli disattivi per un affiliato
	 * @param type $idAffiliation
	 * @return type
	 */
	public function countNumberProductsAffiliation( $idAffiliation ) {
		$sql = "SELECT COUNT(*) AS numProduct FROM ".$this->dbName.".product WHERE fkAffiliation = {$idAffiliation} and isActive = 1";
		$stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $numActive = $stn->fetch( PDO::FETCH_OBJ );
		
		$sql = "SELECT COUNT(*) AS numProduct FROM ".$this->dbName.".product WHERE fkAffiliation = {$idAffiliation} and isActive = 0";
		$stn = $this->mySql->prepare( $sql );
        $resp = $stn->execute();
        $numDisabled = $stn->fetch( PDO::FETCH_OBJ );
		
		$counts = new stdClass();
		$counts->productsActive = $numActive->numProduct;
		$counts->productsDisabled = $numDisabled->numProduct;
		return $counts;
	}
	
	/**
	 * Metodo che cancella i file di cache dei BusinessObject
	 */
	public function clearBusinessCacheFiles( $type = 'all' ) {
		if ( $type == 'trademarks' )
			@unlink( $this->config->cacheTrademarksFilename );
		if ( $type == 'all' || $type == 'affiliations' )
			@unlink( $this->config->cacheAffiliationsFilename );
		
		if ( $type == 'all' || $type == 'categories' )
			@unlink( $this->config->cacheCategoriesFilename );
		
		if ( $type == 'all' || $type == 'subcategories' )
			@unlink( $this->config->cacheSubcategoriesFilename );
		
		if ( $type == 'all' || $type == 'typologies' )
			@unlink( $this->config->cacheTypologiesFilename );		
		
		if ( $type == 'all' || $type == 'colors' )
			@unlink( $this->config->cacheColorsFilename );		
		
		if ( $type == 'all' || $type == 'sizes' )
			@unlink( $this->config->cacheSizesFilename );	
		
		if ( $type == 'all' || $type == 'genders' )
			@unlink( $this->config->cacheGendersFilename );
		return true;
	}
		
    public function debug( $msg ) {
		if( $this->debugActive )
			echo "\n".$this->sep() ."\n\n" . $msg . "\n";
	}
	
	public function sep() {
		$sep = '#';
		for( $x = 0; $x < 147; $x++ )
			$sep .= '-';
		return $sep.'#';
	}   
}