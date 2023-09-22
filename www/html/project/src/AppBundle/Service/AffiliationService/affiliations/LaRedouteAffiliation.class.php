<?php

namespace AppBundle\Service\AffiliationService;

class LaRedouteAffiliation extends Affiliations {
	
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
	}
	
	/**
	 * Metodo che determina la categoria la sottocategoria la tipologia e il sesso del prodotto
	 */
	public function getMerchantCategory() {
		$data = explode( '/', $this->product->merchantCategory );
		$stringGender = $data[2].' '.$data[3].' '.$data[4].' '.$this->product->name;
		
		$this->product->nameSubcategory = trim( str_replace( ',', '',$data[3] ) );
        $ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
               
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];		
		
		$typologyName = !empty( $data[4] ) ? $data[4] : $data[3];
		if ( !empty( $typologyName ) ) {
			$this->product->nameTypology = $typologyName;
			$this->product->fkTypology = $this->getTypology();
		}
		
		if ( !empty( $stringGender ) ) {
			$this->product->nameGender = $this->getTypeGender( $stringGender );
			$this->product->gender = $this->getIdGender();
		}
		return true;
	}
}