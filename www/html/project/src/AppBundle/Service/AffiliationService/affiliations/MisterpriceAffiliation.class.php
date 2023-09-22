<?php

namespace AppBundle\Service\AffiliationService;

class MisterpriceAffiliation extends Affiliations {
	
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
		$this->product->fkTrademark = $this->getTrademark( $this->product->manufacturer );	
        
		if ( !$this->getMerchantCategory() )
			return false;		
		$this->insertAffilation();
		$this->insertExtraData();
	}
	
	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
		$data = explode( '/', $this->product->merchantCategory );
		
		$this->product->nameSubcategory = trim( $data[0] );
		$ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
		
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];
		
		if ( !empty( $data[1] ) ) {
			$this->product->nameTypology = $data[1];
			$this->product->fkTypology = $this->getTypology();
		}
		return true;
	}	
}