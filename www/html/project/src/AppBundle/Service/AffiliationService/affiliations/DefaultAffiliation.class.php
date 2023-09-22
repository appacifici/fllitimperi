<?php

namespace AppBundle\Service\AffiliationService;

class DefaultAffiliation extends Affiliations {
	public $dbName;
	
    public function __construct( $params ) {
		parent::__construct( $params );
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
		
        if ( $this->getMerchantCategory() )
            return false;
				
		$this->insertAffilation();		
	}
    
    /**
	 * Metodo che ritorna le categorie
	 * @params string $data ( stringa contenente la categoria e la subcategoria )
	 */
	public function getMerchantCategory() {
        $merchantCategory = !empty( $this->product->merchantCategory ) ? $this->product->merchantCategory : $this->product->merchantCategoryPath;
        $data = explode( '/', $merchantCategory );		
		if ( empty( $data[0] ) )
			return false;
        
		$this->product->nameSubcategory = trim( $data[0] );
        $ids = $this->getCategoryOfSubcategory();
		if ( !$ids )
			return false;
        
		$this->product->fkCategory	= $ids['idCategory'];
		$this->product->fkSubcategory = $ids['idSubcategory'];
	}
}