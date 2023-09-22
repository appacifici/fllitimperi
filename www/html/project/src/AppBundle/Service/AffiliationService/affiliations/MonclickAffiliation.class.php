<?php

namespace AppBundle\Service\AffiliationService;

class MonclickAffiliation
extends Affiliations {
	
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
		
		
		$this->product->orderProduct = 1;                
        if ( !$this->getMerchantCategory() )
			return false;

		if( $this->importOnlySection == 'false' ){
            $this->insertAffilation();
        }
        
	}
	
	public function mapFields() {
        
		$this->product->deepLink = isset( $this->product->deepLink ) ? $this->product->deepLink : $this->product->productUrl;
		$this->product->largeImage = isset( $this->product->largeImage ) ? $this->product->largeImage : $this->product->imageUrl;
		$this->product->currencyCode = isset( $this->product->currencyCode ) ? $this->product->currencyCode : $this->product->currency;
		$this->product->number = isset( $this->product->number ) ? $this->product->number : $this->product->TDProductId;
		$this->product->shippingHandlingCosts = isset( $this->product->shippingHandlingCost ) ? $this->product->shippingHandlingCost : $this->product->shippingCost;
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
        
        $this->product->name = str_replace( "''''", '', $this->product->name );
	}
	
	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
        $this->product->description = str_replace( "''''", '', $this->product->description );
		$data = explode( '-', $this->product->name );
        
        if(is_object( $this->product->merchantCategoryName ) || empty( $this->product->merchantCategoryName ) )
            return true;
        
		$this->product->nameSubcategory = trim( $this->product->TDCategoryName.' - '.$this->product->merchantCategoryName );        
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

//2018-05-29 11:57:23 182 Prodotto inserito ==>TV LED Smart KDL-32WD753 Full HD
//2018-05-29 11:57:23 183 Prodotto inserito ==>TV LED Smart 55PUS6262/12 Ultra HD 4K
//2018-05-29 11:57:23 184 Prodotto inserito ==>TV LED Smart 49UJ701V Ultra HD 4K
//2018-05-29 11:57:24 185 Prodotto inserito ==>TV LED 24PFS5303/12 Full HD
//2018-05-29 11:57:24 186 Prodotto inserito ==>TV LED PALCO28 LED08 HD Ready
//2018-05-29 11:57:24 187 Prodotto inserito ==>TV LED Smart UE65NU7170 Ultra HD 4K
//2018-05-29 11:57:25 188 Prodotto inserito ==>TV LED Smart H55N5305 Ultra HD 4K