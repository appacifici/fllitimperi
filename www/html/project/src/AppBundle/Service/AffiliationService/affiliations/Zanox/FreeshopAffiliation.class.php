<?php

namespace AppBundle\Service\AffiliationService;

class FreeshopAffiliation extends Affiliations {

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
//		$this->product->fkTrademark = $this->getTrademark( $this->product->brand );
		$this->mapFields();
		
		if ( !$this->getMerchantCategory() )
			return false;
        
		$this->product->orderProduct = 1;                
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
		$this->product->stockAmount = !empty( $this->product->size_stock_amount )  ? $this->product->size_stock_amount : null;
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
        
		$this->product->nameSubcategory = trim(  str_replace( array(">","-"), array( '',' ' ), $this->product->merchant_category ) );
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
