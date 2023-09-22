<?php

namespace AppBundle\Service\AffiliationService;

class SarenzaAffiliation extends Affiliations {

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
 	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
		$stringSearch =  $this->product->name.' '.$this->product->longDescription;

		$gender = $this->getTypeGender( $this->product->merchantCategory );
		if ( $gender == 'undefined' )
			$gender = $this->getTypeGender( $stringSearch );

		$arraySearchSubcategory = array_merge(
			$this->typeScarpe,
			$this->typeSubategoryAccessori,
			$this->typeSubategoryBorse,
			$this->typeSubategoryAbbigliamento
		);

		if ( $this->isCategoryAccessori( $stringSearch ) ) {
			$category = 'accessori';

		} else if ( $this->isCategoryBorse( $stringSearch ) ) {
			$category = 'borse';

		} else if ( $this->isCategoryScarpe( $stringSearch ) ) {
			$category = 'scarpe';

		} else if ( $this->isCategoryAbbigliamento( $stringSearch ) ) {
			$category = 'abbigliamento';
		}
        $subcategory = $this->getSubcategoryInString( $stringSearch, $arraySearchSubcategory );

		$this->product->nameSubcategory = trim( $subcategory );
        $ids = $this->getCategoryOfSubcategory();
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