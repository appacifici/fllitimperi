<?php

namespace AppBundle\Service\AffiliationService;

class AutopartiAffiliation extends Affiliations {
	
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
        
        $this->mapFields();
		if ( !$this->getMerchantCategory() )
			return false;
		        
        
        if( $this->importOnlySection == 'false' ){
            $this->insertAffilation();
        }
        
	}
	
    
	public function mapFields() {
        
		$this->product->deepLink = isset( $this->product->deepLink ) ? $this->product->deepLink : $this->product->productUrl;
		$this->product->largeImage = isset( $this->product->largeImage ) ? $this->product->largeImage : (!empty( $this->product->imageUrl ) ? $this->product->imageUrl : false );
		$this->product->currencyCode = isset( $this->product->currencyCode ) ? $this->product->currencyCode : $this->product->currency;
		$this->product->number = isset( $this->product->number ) ? $this->product->number : $this->product->TDProductId;
		$this->product->shippingHandlingCost = isset( $this->product->shippingHandlingCosts ) ? $this->product->shippingHandlingCosts : (!empty( $this->product->shippingCost ) ? $this->product->shippingCost : false );
		$this->product->program = isset( $this->product->program ) ? $this->product->program : $this->product->programId;
		$this->product->ean = !empty( $this->product->ean )  ? $this->product->ean : '';
		$this->product->stockAmount = !empty( $this->product->stockAmount )  ? $this->product->stockAmount : $this->product->inStock ;
        $this->product->deliveryTime     = !empty( $this->product->deliveryTime ) ? $this->product->deliveryTime : null;        
        
        if( is_object( $this->product->deliveryTime ) && empty( $this->product->deliveryTime->{0})) {
            $this->product->deliveryTime = null;
        }
        
        if( is_object( $this->product->stockAmount ) && empty( $this->product->stockAmount->{0})) {
            $this->product->stockAmount = null;
        } 
        
        if( !empty( $this->product->stockAmount ) && $this->product->stockAmount > 0 ) {
            $this->product->sizeStockStatus = 'in stock';
        } else {
            $this->product->sizeStockStatus = 'out of stock';
        }
        
        if( is_object( $this->product->ean ) )
            $this->product->ean = '';
        
        
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