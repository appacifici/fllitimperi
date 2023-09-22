<?php

namespace AppBundle\Service\AffiliationService;

class PrezzoFeliceAffiliation extends Affiliations {
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Metodo che inizializza l'inserimento dei prodotti
	 * @param array $affiliation
	 * @param stdClass $product 
	 */
	public function init( $affiliation, $product  ) {
		$this->product = $product;
		$this->product->fkAffiliation = $affiliation->idAffiliation;
		$this->product->nameAffiliation = $affiliation->name;
		
		$this->affiliationFkCategory = $affiliation['fkCategory'];
		if ( !is_numeric( trim( $this->product->manufacturer ) ) )
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
		if ( !empty( $this->product->merchantCategory ) ) {
			$this->product->nameSubcategory = trim( $this->product->merchantCategory );
			$ids = $this->getCategoryOfSubcategory();
			if ( !$ids )
				return false;
		}		
		$this->product->fkCategory	= $this->affiliationFkCategory;
		$this->product->fkSubcategory = !empty( $ids['idSubcategory'] ) ? $ids['idSubcategory'] : 0;
		return true;
	}
		
	/**
	 * Metodo che inserisce i parametri extra del prodotto
	 */
	private function insertBridgeData() {
		$this->product->dataText = $this->product->extra1.'<br /><br />'.$this->product->terms;
		$this->insertExtraData();
	}
	
}