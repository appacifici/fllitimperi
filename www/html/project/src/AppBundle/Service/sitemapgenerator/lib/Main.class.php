<?php

class Main {
	public $obj;
	public $mySql;
	public $qs;
	public $utility;
	public $server;
	public $var;
	public $rewrite;
	private static $instance = null;
	
	/**
	 * Funzione costruttore del sito
	 */
	function __construct() {
		$this->obj			 = new ObjectsSite();
		$this->config 		 = $this->obj->config;
		$this->server 		 = $this->obj->server;
		$this->var 			 = $this->obj->var;
		$this->mySql 		 = $this->obj->mySql;
		$this->qs 			 = $this->obj->qs;
		$this->utility 		 = $this->obj->utility;
		$this->dbName 		 = $this->config->dbSite;				
		require_once $this->config->pathScriptBusiness.'/lib/BusinessObjects/Rewrite.class.php';
	}
	
	public function initGlobalClasses() {
		$this->rewrite = new Rewrite();
	}
	
	/**
	 * Metodo che crea un instanza della classe se già non esistente e la ritorna al metodo chiamante
	 * @return type
	 */
	public static function getInstance() {
		if ( self::$instance == null )
			self::$instance = new Main();
		return self::$instance;
	}
	
	/**
	 * Metodo che mappa gli oggetti della classe main nella classe passata come argomento alla funzione
	 * @param object $class [ Riferimento alla classe chiamante ]
	 */
	public function mapParams( $class ) {
		$a = get_object_vars( $this );
		foreach( $a as $field => $value )
			$class->{$field} = !empty( $value ) ? $value : null;	
	}
	
	/**
	 * Metodo che gestisce lo script da eseguire
	 * @param type $script
	 */
	public function launchScript( $script, $options ) {
		switch ( $script ) {
			case 'DeamonAffiliation': $this->lauchDeamonAffiliation( $options );
				break;
		}
	}
	
	public function lauchDeamonAffiliation( $options ) {
		if( empty( $options['i'] ) )
			die("\nInserisci l'id dell'affilliato da inserire\n");

		if( empty( $options['a'] ) )
			die("\nInserisci il nome dell'ambiente\n");

		$limit = 500;
		if( !empty( $options['l'] ) )
			$limit = $options['l'] != 'null' ? $options['l'] : false;

		new DeamonAffiliation( 'xml', $options['i'], $limit );
	}
	
	public function specialTrim( $string, $permissionChar = '' ) {
        //echo $string."\n";
        $string = str_replace(
			array( '/', 'car-navigation', 'tomtom-outlet-store', 'accessories', 'special-offers' ),
			array( ' ', 'navigazione auto', 'tomtom outlet', 'accessori', 'offerte speciali' ),
			$string
		);
        $string = preg_replace( "/\s+/", " ", $string );
		$string = preg_replace( "/\n ?+/", " ", $string );
		$string = preg_replace( "/\n+/", " ", $string );
		$string = preg_replace( "/\r ?+/", " ", $string );
		$string = preg_replace( "/\t+/", " ", $string );
		$string = preg_replace( "/ +/", " ", $string );
		$string = trim( $string );
        //$string = str_replace( array('à','á','é','è','í','ì','ó','ò','ú','ù'),array('a','a','e','e','i','i','o','o','u','u'), $string );
        //$string = str_replace( array('À','Á','É','È','Í','Ì','Ó','Ò','Ú','Ù'),array('A','A','E','E','I','I','O','O','U','U'), $string );
        $string = preg_replace( "#[^A-Za-z0-9àáéèíìóòúù$permissionChar/]#", " ", $string );
        $string = preg_replace( "/\s+/", " ", $string );
		return strtolower( trim( $string ) );
	}
	
}//End class