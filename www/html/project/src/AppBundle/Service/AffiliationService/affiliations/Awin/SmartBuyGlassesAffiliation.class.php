<?php

namespace AppBundle\Service\AffiliationService;

class SmartBuyGlassesAffiliation extends Affiliations {
	
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
        $this->mapFields();
        
		if ( !$this->getMerchantCategory() )
			return false;
		        
        
        if( $this->importOnlySection == 'false' ){
            $this->insertAffilation();
        }        
	}
    
    public function mapFields() {
        $this->product->name   = $this->product->product_name;
		$this->product->deepLink = isset( $this->product->aw_deep_link ) ? $this->product->aw_deep_link : $this->product->deepLink;        
		$this->product->largeImage = isset( $this->product->merchant_image_url ) ? $this->product->merchant_image_url : false;        
		$this->product->currencyCode = isset( $this->product->currency ) ? $this->product->currency : $this->product->currencyCode;        
		$this->product->number = isset( $this->product->aw_product_id ) ? $this->product->aw_product_id : $this->product->number;
        
        $this->product->price = $this->product->search_price;
		$this->product->shippingHandlingCosts = !empty( $this->product->delivery_cost ) ? $this->product->delivery_cost  : 0;
		$this->product->ean = !empty( $this->product->ean )  ? $this->product->ean : '';
		$this->product->stockAmount = !empty( $this->product->size_stock_amount )  ? $this->product->size_stock_amount : ( !empty( $this->product->in_stock ) ? $this->product->in_stock : null );
        $this->product->deliveryTime     = !empty( $this->product->delivery_time ) ? $this->product->delivery_time : null;        
        
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
        
        $this->product->sizeStockStatus = $this->product->in_stock == 1 ? 'in stock' : 'out of stock';
        
        if( is_object( $this->product->ean ) )
            $this->product->ean = '';
        
        $this->product->name = str_replace( "''''", '', $this->product->name );
	}
	
	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
        if(is_object( $this->product->description )) {
            $this->product->description = !empty( $this->product->description->{0} ) ? str_replace( "''''", '', $this->product->description->{0} ) : '';
            
        } else {
            $this->product->description = str_replace( "''''", '', $this->product->description );            
        }
		$data = explode( '-', $this->product->name );
        
		$this->product->nameSubcategory = trim(  str_replace( ">", '-', $this->product->merchant_category ) );
        $ids = $this->getCategoryOfSubcategory();
        
		if ( !$ids )
			return false;

		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];
        
//		if ( !empty( $data[2] ) ) {
//			$this->product->nameTypology = $data[2];
//			$this->product->fkTypology = $this->getTypology();
//		}

        
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