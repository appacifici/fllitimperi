<?php

namespace AppBundle\Service\AffiliationService;

class DecathlonAffiliation extends Affiliations {
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
	public function init( $affiliation, $product  ) {
		$this->product = $product;
		$this->product->fkAffiliation = $affiliation->idAffiliation;
		$this->product->nameAffiliation = $affiliation->name;
		$this->product->fkTrademark = $this->getTrademark( $this->product->manufacturer );
		
		if ( !$this->getMerchantCategory() )
            return false;
		$this->insertAffilation();		
	}
	
	/**
	 * Metodo che ritorna le categorie
	 * @params string $data ( stringa contenente la categoria e la subcategoria )
	 */
	public function getMerchantCategory() {
		$data = explode( '/', $this->product->merchantCategory );
		$stringGender = $data[0].' '.( isset( $data[1] ) ? $data[1] : '' ).' '.( isset( $data[2] ) ? $data[2] : '' ) .' '.$this->product->name;
		
        $ids = $this->getCategoryOfSubcategory( trim( $data[0] ), $this->product->fkAffiliation );
		if ( !$ids )
			return false;
        		
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];
		
		if ( !empty( $data[2] ) ) {
			$this->product->nameTypology = $data[2];
			$this->product->fkTypology = $this->getTypology();
		}
		if ( !empty( $stringGender ) ) {
			$this->product->nameGender = $this->getTypeGender( $stringGender );
			$this->product->gender = $this->getIdGender();
		}
		return true;
	}
}