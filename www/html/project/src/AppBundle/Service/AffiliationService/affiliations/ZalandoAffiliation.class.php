<?php

namespace AppBundle\Service\AffiliationService;

class ZalandoAffiliation extends Affiliations {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Metodo che inizializza l'inserimento dei prodotti
	 * @param array $affiliation
	 * @param stdClass $product
	 */
	public function init( $affiliation, $product ) {		
		$this->product = $product;
		$this->product->fkAffiliation = $affiliation->idAffiliation;
		$this->product->nameAffiliation = $affiliation->name;
		$this->product->fkTrademark = $this->getTrademark( $this->product->manufacturer );

		if ( !$this->getMerchantCategory() )
			return false;

		$this->insertAffilation();
		if ( !empty( $this->product->idProduct ) )
			$this->insertBridgeData();
	}

	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
		$data = explode( '/', $this->product->merchantCategory );

		$this->product->nameSubcategory = trim( $data[2] );
        $ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;

		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];

		if ( !empty( $data[3] ) ) {
			$this->product->nameTypology = $data[3];
			$this->product->fkTypology = $this->getTypology();
		}

		if ( !empty( $data[0] ) ) {
			$this->product->nameGender = $data[0];
			$this->product->gender = $this->getIdGender();
		}
		return true;
	}

	/**
	 * Metodo che inserisce i parametri extra del prodotto
	 */
	private function insertBridgeData() {		
		$this->product->kwds   = !empty( $this->product->extra1 ) ? $this->product->extra1 : null;		
		$this->product->colors = !empty( $this->product->extra2 ) ? $this->product->extra2 : null;
		$this->product->sizes  = !empty( $this->product->terms )  ? $this->product->terms  : null;
		
		if ( $this->getColorBase() )
			$this->insertBridgeColors();
		
		if ( $this->getSizeBase() )
			$this->insertBridgeSizes();

		$this->insertExtraData();
	}	
	
	/**
	 * Metodo che ritorna i dati extra del prodotto
	 */
	public function getExtraDataProduct( $product ) {
		$data = new stdClass();
		$data->colors = !empty( $product->extra2 ) ? $product->extra2 : null;
		$data->sizes  = !empty( $product->terms )  ? $product->terms  : null;
		return $data;
	}
	
}