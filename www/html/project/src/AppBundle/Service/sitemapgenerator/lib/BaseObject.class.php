<?php

/**
 * Classe base che verra estesa da tutte le classi BusinessOjbect e TemplatesObject
 * per mappare tutti gli oggetti della classe Main dopo che sarà lanciata una sua
 * instanza nella seguente classe
 */
class BaseObject {
	public $main;
	
	public function __construct() {
		$this->main = Main::getInstance();	
		//Mappa tutti gli oggetti della classe main sulla classe che estende questa
		$this->main->mapParams( $this );
	}
}