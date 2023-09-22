<?php

namespace AppBundle\Service\AffiliationService;

class DouglasAffiliation extends Affiliations {
	
	public function __construct( $params ) {        
		parent::__construct( $params );
	}
	
	/**
	 * Metodo che inizializza l'inserimento dei prodotti
	 * @param array $affiliation
	 * @param stdClass $product 
	 */
	public function init( $affiliation, $product ) {
		$this->product = $product;
		$this->product->fkAffiliation = $affiliation->id;
		$this->product->nameAffiliation = $affiliation->name;
//        if( !empty( $this->product->manufacturer ) ) 
//            $this->product->fkTrademark = $this->getTrademark( $this->product->manufacturer );
        
		if ( !$this->getMerchantCategory() )
			return false;
		        
        
        if( $this->importOnlySection == 'false' ){
            $this->insertAffilation();
        }
        
	}
	
	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
//		$data = explode( '/', $this->product->merchantCategoryPath );		
//		if ( empty( $data[0] ) )
//			return false;
		
		$nameSubcategory = $this->product->merchantCategoryPath;
		$this->product->nameSubcategory = trim( $nameSubcategory );
		$ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
        
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];
 
	
        return true;
	}
    
}

//INSERT INTO category (name,keyUrlCategory,inMenu,isActive,inVetrina,numProducts) value ( 'bellezza', 'bellezza', 1, 1,1,10);
//INSERT INTO affiliation ( fkCategory,name,url,linkLastUpdate) value(16,'Douglas IT', 'http://productdata.zanox.com/exportservice/v1/rest/24415228C91911925.xml?ticket=BD2DCF2A4937817E1EB413B3E726490F&productIndustryId=1&gZipCompress=yes','http://productdata.zanox.com/exportservice/v1/rest/24415228C91911925.xml?ticket=BD2DCF2A4937817E1EB413B3E726490F&productIndustryId=1&GetUpdateDate=yes' );

/**
 * Creare nuova categoria nel db e mettergli i prodotti dentro
 * importare prodotti 
 * sudo php /home/prod/site/miglioreprezzo.com/script/trunk/maintenance.php --a scriptProd --u prod --f setNumberProducts
 * sudo indexer --rotate miglioreprezzo
 * cancellare file cache
 * creare directory dentro public/vetrina con il nome della categoria appena creata
 * crea nuove sottocategorie da associalre alla nuova categoria
 * lookup sottocategorie da admin
 * 
 */