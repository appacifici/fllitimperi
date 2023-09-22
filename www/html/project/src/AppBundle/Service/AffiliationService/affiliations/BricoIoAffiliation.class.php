<?php

namespace AppBundle\Service\AffiliationService;

class BricoIoAffiliation extends Affiliations {

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
		$this->insertAffilation();
        
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
        
		$this->product->nameSubcategory = trim( $this->product->merchantCategoryName );
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

	