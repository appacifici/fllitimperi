<?php

namespace AppBundle\Service\AffiliationService;

class SolarisSportAffiliation extends Affiliations {
	
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
	}
	
	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
		$data = explode( '/', $this->product->merchantCategory );
		
		$stringGender = $data[0].' '.$data[1].' '.$data[2].' '.$this->product->name;
		$gender = $this->getTypeGender( $this->product->extra1 );
		if ( $gender == 'undefined' )
			$gender = $this->getTypeGender( strtolower( $stringGender ) );
				
        $this->product->nameSubcategory = strtolower( str_replace( ',', ' ', $data[1] ) );
        $ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
		
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];

		if ( !empty( $this->product->nameSubcategory ) ) {
			$this->product->nameTypology = $this->product->nameSubcategory;
			$this->product->fkTypology = $this->getTypology();
		}

		if ( !empty( $gender ) ) {
			$this->product->nameGender = $gender;
			$this->product->gender = $this->getIdGender();
		}
		return true;
	}
}