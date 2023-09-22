<?php

namespace AppBundle\Service\AffiliationService;

class ZooplusAffiliation extends Affiliations {

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
	 * Metodo che ritorna le categorie
	 * @params string $data ( stringa contenente la categoria e la subcategoria )
	 */
	public function getMerchantCategory() {
		$data = explode( '/', $this->product->merchantCategoryName );

		$this->product->nameSubcategory = $this->product->merchantCategoryName;
        $ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;

		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];

		return true;
	}

	/**
	 * Metodo che inserisce i parametri extra del prodotto
	 */
	private function insertBridgeData() {
		$this->product->dataText = $this->product->extra1.'< br/>< br/>'.$this->product->extra2;
		$this->insertExtraData();
	}
}