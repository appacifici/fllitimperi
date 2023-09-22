<?php

namespace AppBundle\Service\AffiliationService;

class SpartooAffiliation extends Affiliations {
	
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
		if ( empty( $data[2] ) )
			return false;
		
		$nameSubcategory = !empty( $data[2] ) ? $data[2] : $data[1];
		$this->product->nameSubcategory = trim( $nameSubcategory );
		$ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
        
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];
 
		$nameTypology = !empty( $data[2] ) ? $data[2] : $data[1];
		if ( !empty( $nameTypology ) ) {
			$this->product->nameTypology = $nameTypology;
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
		$this->product->dataText = $this->product->extra1.'< br/>'.$this->product->extra2.'< br/>'.$this->product->extra3;
		$this->insertExtraData();
	}
	
}