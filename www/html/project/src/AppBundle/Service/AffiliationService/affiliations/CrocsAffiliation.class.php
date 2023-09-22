<?php

namespace AppBundle\Service\AffiliationService;

class CrocsAffiliation extends Affiliations {
	public $dbName;

	public function __construct() {
		parent::__construct();
		$this->dbName = $this->config->dbSite;
	}

	/**
	 * Metodo che inizializza l'inserimento dei prodotti
	 * @param array $affiliation
	 * @param stdClass $product d
	 */
	public function init( $affiliation, $product  ) {
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
	 * Metodo che ritorna le categorie
	 * @params string $data ( stringa contenente la categoria e la subcategoria )
	 */
	public function getMerchantCategory() {
		$typeElement = explode( '/', $this->product->merchantCategory );
		$stringGender = $typeElement[0];

        if ( !empty( $typeElement[1]) )
            $stringGender .= ' '.$typeElement[1];

        if ( !empty( $typeElement[2]) )
            $stringGender .= ' '.$typeElement[2];
        $stringGender .= ' '.$this->product->description;

		$gender = $this->getTypeGender( $this->product->extra3 );
		if ( $gender == 'undefined' )
			$gender = $this->getTypeGender( $stringGender );
		
		$nameSubcategory = !( empty( $typeElement[1] ) ) ? $typeElement[1] : $typeElement[0];
		$this->product->nameSubcategory = str_replace( array( 'Girls', '-', 'Women', '- Crocs@' ), '', $nameSubcategory );
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


	/**
	 * Metodo che inserisce i parametri extra dell'affiliato
	 * @param int $idProduct
	 * @param stdClass $product
	 * @return int
	 */
	private function insertBridgeData() {
		$this->product->colors = $this->product->extra1;
		$this->product->sizes  = trim( str_replace( 'Sizes:', '', $this->product->extra2 ) );
		
		if ( $this->getColorBase() )
			$this->insertBridgeColors();
		
		if ( $this->getSizeBase() )
			$this->insertBridgeSizes();
		
		$this->insertExtraData();
	}
		
	/**
	 * Metodo che ritorna i dati extra del prodotto
	 */
	public function getExtraDataProduct( $product ) {
		$data = new stdClass();
		$data->colors = !empty( $product->extra1 ) ? $product->extra1 : null;
		$data->sizes  = !empty( $product->extra2 )  ? trim( str_replace( 'Sizes:', '', $product->extra2 ) )  : null;
		return $data;
	}
}