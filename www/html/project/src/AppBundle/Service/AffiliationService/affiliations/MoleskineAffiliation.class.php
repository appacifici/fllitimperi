<?php

namespace AppBundle\Service\AffiliationService;

class MoleskineAffiliation extends Affiliations {
	
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
        if( !empty( $this->product->manufacturer ) ) 
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
		$data = explode( '/', $this->product->merchantCategoryPath );		
		if ( empty( $data[0] ) )
			return false;
		
		$nameSubcategory = $data[0];
		$this->product->nameSubcategory = trim( $nameSubcategory );
		$ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
        
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];
 
		if ( !empty( $data[1] ) ) {
			$this->product->nameTypology = $data[1];
			$this->product->fkTypology = $this->getTypology();
		}
        
        if ( !empty( $this->product->gender ) ) {
			$this->product->nameGender = $this->product->gender;
			$this->product->gender = $this->getIdGender();
		}
        
        return true;
	}
	
	/**
	 * Metodo che inserisce i parametri extra del prodotto
	 */
	private function insertBridgeData() {
		$this->product->colors = !empty( $this->product->color ) ? $this->product->color : null;
		$this->product->sizes  = !empty( $this->product->size )  ? $this->product->size  : null;
		
		if ( $this->getColorBase() )
			$this->insertBridgeColors();
		
		if ( $this->getSizeBase() )
			$this->insertBridgeSizes();

		$this->insertExtraData();
	}	
}
//INSERT INTO affiliation ( name,url,linkLastUpdate) value('Moleskine IT', 'http://productdata.zanox.com/exportservice/v1/rest/30094938C855040192.xml?ticket=BD2DCF2A4937817E1EB413B3E726490F&productIndustryId=1&gZipCompress=yes','http://productdata.zanox.com/exportservice/v1/rest/30094938C855040192.xml?ticket=BD2DCF2A4937817E1EB413B3E726490F&productIndustryId=1&GetUpdateDate=yes' );