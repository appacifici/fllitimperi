<?php

namespace AppBundle\Service\AffiliationService;

class EurofficeAffiliation extends Affiliations {
	
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
        
		if ( !$this->getMerchantCategory() )
			return false;
		
		$this->insertAffilation();
	}
	
	/**
	 * Metodo che setta le proprieta categoria suttocategoria e typologia sesso del prodotto
	 */
	public function getMerchantCategory() {
		$data = explode( '/', $this->product->merchantCategoryPath );		
		if ( empty( $data[2] ) )
			return false;
		
		$nameSubcategory = !empty( $data[2] ) ? $data[2] : $data[1];
		$this->product->nameSubcategory = trim( $nameSubcategory );
		$ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
        
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];
 
		$nameTypology = !empty( $data[3] ) ? $data[3] : $data[2];
		if ( !empty( $nameTypology ) ) {
			$this->product->nameTypology = $nameTypology;
			$this->product->fkTypology = $this->getTypology();
		}
		return true;
	}	
}

//INSERT INTO category (name,keyUrlCategory,isActive,inVetrina) value ( 'ufficio', 'ufficio', 1, 1);
//INSERT INTO affiliation (fkCategory, name,url,linkLastUpdate) value(15, 'Euroffice IT', 'http://productdata.zanox.com/exportservice/v1/rest/30094361C456610717.xml?ticket=BD2DCF2A4937817E1EB413B3E726490F&productIndustryId=1&gZipCompress=yes','http://productdata.zanox.com/exportservice/v1/rest/30094361C456610717.xml?ticket=BD2DCF2A4937817E1EB413B3E726490F&productIndustryId=1&GetUpdateDate=yes');