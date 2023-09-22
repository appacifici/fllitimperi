<?php

namespace AppBundle\Service\AffiliationService;

class SwarovskiAffiliation extends Affiliations {

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
//		$this->product->fkTrademark = $this->getTrademark( $this->product->manufacturer );

		if ( !$this->getMerchantCategory() )
			return false;

		$this->insertAffilation();
//		if ( !empty( $this->product->idProduct ) )
//			$this->insertBridgeData();
	}

	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
		if( empty( $this->product->merchantCategoryPath ) )
			return false;
		
//		$data = explode( '/', $this->product->merchantCategoryPath );
		$this->product->nameSubcategory = $this->product->merchantCategoryPath;
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
		$this->product->sizes  = !empty( $this->product->extra2 ) ? $this->product->extra2 : false;		
		$this->product->dataText  = !empty( $this->product->extra1 ) ? $this->product->extra1 : false;		
		
		if ( !empty( $this->product->sizes ) ) {
			$this->product->aSizes = array( $this->product->sizes );
			$this->insertBridgeSizes();
		}
		$this->insertExtraData();
	}
	
	/**
	 * Metodo che ritorna i dati extra del prodotto
	 */
	public function getExtraDataProduct( $product ) {
		$data = new stdClass();
		$data->colors = '';
		$data->sizes  = !empty( $product->extra2 )  ? $product->extra2  : null;
		return $data;
	}
}