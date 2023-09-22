<?php

namespace AppBundle\Service\AffiliationService;

class GuessAffiliation extends Affiliations {
	public $dbName;
	
	public function __construct() {
		parent::__construct();
		$this->dbName = $this->config->dbSite;
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
		$this->product->fkTrademark = $this->getTrademark( 'Guess' );
		
        if ( !$this->getMerchantCategory() )
			return false;
				
		$this->insertAffilation();		
		if ( !empty( $this->product->idProduct ) )
			$this->insertBridgeData();
	}
	
	/**
	 * Metodo che ritorna le categorie
	 * @params string $data ( stringa contenente la categoria e la subcategoria )
	 */
	public function getMerchantCategory() {
		$data = strtolower( $this->product->merchantCategory );
		
		$this->product->nameSubcategory = trim( $this->product->merchantCategory );
        $ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
        
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];		
		
		if ( !empty( $this->product->merchantCategory ) ) {
			$this->product->nameTypology = trim( $this->product->merchantCategory );
			$this->product->fkTypology = $this->getTypology();
		}
		
		if ( !empty( $this->product->extra2 ) ) {
			$this->product->nameGender = $this->product->extra2;
			$this->product->gender = $this->getIdGender();
		}
		return true;
	}
	
	/**
	 * Metodo che inserisce i parametri extra dell'affiliato
	 */
	private function insertBridgeData() {
		$this->product->colors = $this->product->extra1;
		if ( $this->getColorBase() )
			$this->insertBridgeColors();
		
		$this->insertExtraData();
	}
	
	/**
	 * Metodo che ritorna i dati extra del prodotto
	 */
	public function getExtraDataProduct( $product ) {
		$data = new stdClass();
		$data->colors = !empty( $product->extra1 ) ? $product->extra1 : '';
		$data->sizes  = '';
		return $data;
	}
	
}