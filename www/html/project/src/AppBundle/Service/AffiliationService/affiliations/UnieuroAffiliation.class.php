<?php

namespace AppBundle\Service\AffiliationService;

class UnieuroAffiliation extends Affiliations {

	public function __construct( $params ) {
		parent::__construct( $params );
	}

	/**
	 * Metodo che inizializza l'inserimento dei prodotti
	 * @param array $affiliation
	 * @param stdClass $product
	 */
	public function init( $affiliation, $product ) {
		$this->product = $product;
		$this->product->fkAffiliation = $affiliation->id;
		$this->product->nameAffiliation = $affiliation->name;
        $manufacturer = explode( ' ', $this->product->name );
//		$this->product->fkTrademark = $this->getTrademark( $manufacturer[0] );

        if ( !$this->getMerchantCategory() )
			return false;

		$this->insertAffilation();
        
//		if ( !empty( $this->product->idProduct ) )
//			$this->insertBridgeData();
	}

	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
        $data = explode( '/', $this->product->merchantCategoryPath );
		$this->product->nameSubcategory = $this->product->merchantCategoryPath;
        $ids = $this->getCategoryOfSubcategory();
        
		if ( !$ids )
			return false;

		$this->product->fkCategory      = $ids['idCategory'];
		$this->product->fkSubcategory   = $ids['idSubcategory'];
		$this->product->fkTypology      = $ids['typology_id'];

//		if ( !empty( $data[2] ) ) {
//			$this->product->nameTypology = $data[2];
//			$this->product->fkTypology = $this->getTypology();
//		}
		return true; 
	}

	/**
	 * Metodo che inserisce i parametri extra del prodotto
	 */
	private function insertBridgeData() {
		if ( !empty( $this->product->terms) ) {
			$this->product->dataText = $this->product->terms;			
		}
        $this->insertExtraData();
	}

}