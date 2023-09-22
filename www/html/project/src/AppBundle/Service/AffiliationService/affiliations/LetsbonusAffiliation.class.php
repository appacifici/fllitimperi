<?php

namespace AppBundle\Service\AffiliationService;

class LetsbonusAffiliation extends Affiliations {

	public function __construct() {
		parent::__construct();
	}

	public function init( $affiliation, $product ) {
		$this->product = $product;
		$this->product->fkAffiliation = $affiliation->idAffiliation;
		$this->product->nameAffiliation = $affiliation->name;

		$this->product->fkTrademark = 0;
		$this->product->fkCategory = $affiliation['fkCategory'];
		$this->product->fkSubcategory = 0;

		$this->insertAffilation();
	}
}