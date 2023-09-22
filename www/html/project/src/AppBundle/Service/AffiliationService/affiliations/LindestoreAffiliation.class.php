<?php

namespace AppBundle\Service\AffiliationService;

class LindestoreAffiliation extends Affiliations {
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
		$arraySearchSubcategory = array_merge(
			$this->typeSubategoryBorse,
			$this->typeScarpe,
			$this->typeSubategoryAccessori,
			$this->typeSubategoryAbbigliamento
		);
        
		$category = 'misto';
		if ( strtolower( $this->product->merchantCategory ) == 'scarpe' || $this->isCategoryScarpe( $this->product->merchantCategory.' '.$this->product->name ) )
			$category = 'scarpe';
			
		else if ( $this->isCategoryAccessori( $this->product->merchantCategory.' '.$this->product->name ) )
			$category = 'accessori';
			
		else if ( $this->isCategoryBorse( $this->product->merchantCategory.' '.$this->product->name ) )
			$category = 'borse';
		
		else if ( $this->isCategoryAbbigliamento( $this->product->merchantCategory.' '.$this->product->name ) )
			$category = 'abbigliamento';
		
		
		$gender = $this->getTypeGender( $this->product->merchantCategory );
		if ( $gender == 'undefined' )
			$gender = $this->getTypeGender( $this->product->name );
		
		$this->product->nameSubcategory = trim( $this->product->merchantCategory );
        $ids = $this->getCategoryOfSubcategory();
        
        if ( !$ids ) {
            $subcategory = $this->getSubcategoryInString( $this->product->merchantCategory.' '.$this->product->name, $arraySearchSubcategory );
			if ( !empty ( $subcategory ) ) {
				$this->product->nameSubcategory = trim( $subcategory );
				$ids = $this->getCategoryOfSubcategory();
			}
		}
		
		if ( !$ids )
			return false;
		
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];		
		
		if ( !empty( $gender ) ) {
			$this->product->nameGender = $gender;
			$this->product->gender = $this->getIdGender();
		}
		return true;
	}	
}