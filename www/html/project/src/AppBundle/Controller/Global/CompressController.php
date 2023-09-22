<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompressController {    
	private $onCallPhp = false;
	private $versionSite;
	private $folderTemplate;
    private $callJsLoadPage = array();
	
    public function __construct( $container, $dependencyManager ) {
        $this->container = $container;
        $this->dependencyManager = $dependencyManager;
    }
    
     /**
	 * Metodo che setta i parametri necessari all'utilizzo della classe
	 */
	private function setPatameters() {	
        //Recupera i parametri dalle configurazioni parameters di ambiente        
        $this->folderTemplate       = $this->container->getParameter( 'app.folder_templates_xml' );
        $this->folderJs             = $this->container->getParameter( 'app.folder_js' );
        $this->folderJsMin          = $this->container->getParameter( 'app.folder_js_minified' );
        $this->compactSite          = $this->container->getParameter( 'app.compactSite' );
        $this->extension            = $this->container->getParameter( 'app.extensionTpl' );                   
	}
    
    /**
     * Inizializza tutto il motore
     * @param type $fileStructure
     */
    public function init( $fileStructure, $folder ) {
        $this->setPatameters();                
        
      
        //determina quale versione del sito caricare 
        $fileStructure = $folder.'/'.$fileStructure;
        
        $this->setXml( $this->folderTemplate, $fileStructure );	
        
        $this->arrayFetch = array();
        $this->initTemplate();        

        $this->addDependencies( $fileStructure );        
        
        $configDependencyManager = $this->container->getParameter( 'app.dependencyManager' );
        
    }
    
    /**
     * Metodo che avvia il caricamento delle dipendenze javascript della sezione head e body
     */
    public function addDependencies( $fileStructure ) {        
//        $this->get( 'twig' )->addGlobal( 'dependenciesCSSHead', $this->dependencyManager->getCSSHead() );        
//        $this->get( 'twig' )->addGlobal( 'dependenciesJSHead', $this->dependencyManager->getJSHead() );        
//        
//        if( !$this->compactSite || ( !empty( $this->isIeVersion ) && $this->isIeVersion < 10 ) ) {
//            $this->get( 'twig' )->addGlobal( 'dependenciesCSSBody', $this->dependencyManager->getCSSBody() );
//            $this->get( 'twig' )->addGlobal( 'dependenciesJSBody', $this->dependencyManager->getJSBody() );
//            return;
//        }        
//        $fileMinifiedJs  = 'js_'.str_replace( '.xml', '.js', trim( $fileStructure, '/' ) );
//        $fileMinifiedCss = 'css_'.str_replace( '.xml', '.css', trim( $fileStructure, '/' ) );
//        
//        if( file_exists( $this->folderJsMin.ltrim( $fileMinifiedJs  )  ) && file_exists( $this->folderJsMin.ltrim( $fileMinifiedCss  )  )  ) {
//            $filesJS = array( $this->folderJsMin.ltrim( $fileMinifiedJs ) => 1 );
//            $filesCSS = array( $this->folderJsMin.ltrim( $fileMinifiedCss ) => 1 );
//            
//            $this->get( 'twig' )->addGlobal( 'dependenciesCSSBody', $filesCSS  );
//            $this->get( 'twig' )->addGlobal( 'dependenciesJSBody', $filesJS  );
//            return;
//        }                    
//        $this->get( 'twig' )->addGlobal( 'dependenciesCSSBody', $this->dependencyManager->getCSSBody() );        
//        $this->get( 'twig' )->addGlobal( 'dependenciesJSBody', $this->dependencyManager->getJSBody() );        
    }
	
    
	/**
	 * Metodo che setta il nome del xml da leggere
	 * @param string $xml 
	 */
	public function setXml( $config, $xml ) {  
		$this->xml = simplexml_load_file( $config.$xml );
	}
	
	
	/**
	 * Metodo che setta le varibili di controllo se l'utente è loggato ono
	 * @param boolean $controlSession ( Determina se devono essere controlste le sessioni dell'utente o no )
	 * @param boolean $sessionActive  ( Determina se l'utente è loggato oppure no )
	 */
	public function setSessionActive( $controlSession, $sessionActive ) {
		$this->controlSession = $controlSession;
		$this->sessionActive = $sessionActive;
	}
   	
	
	/**
	 * Metodo che legge l'xml e fa il fetch e l'assign di tutti i tpl
	 */
	public function initTemplate() {
		$this->createTemplate( $this->xml );        
		if ( !empty( $this->arrayFetch ) ) {
			$this->arrayFetch = array_reverse( $this->arrayFetch );
			foreach( $this->arrayFetch as $key => $myfetch ) {
				$this->concatenate( $this->arrayFetch, $key );
			}
		}
	}
	
	/**
	 * Metodo che cicla l'xml e fa il fetch dei figli unici e gli altri li mette in un array
	 * @param obj $xml 
	 */
	function createTemplate( $xml ) {        
        $x=0;
		foreach ( $xml->tpl as $node ){       
			$name = explode( "|",$node['name'] );
			$root = explode( "|",$node['padre'] );
			$cores = explode( " ",$node['cores'] );
			$ajaxCore = $node['ajax'];
            $ajaxCore = $ajaxCore == 'null' ? 0 : $ajaxCore;
            			
            
//			//Se il tpl da caricare necessita che l'utente sia loggato blocca l'inclusione, e se è settato un tpl di copertura lo carica
//			if ( $this->controlSession ) {              
//				if( !$this->sessionActive && key_exists( $name[0], $this->tplToSessionActive ) ) {                    
//					$newLoadTpl = $this->tplToSessionActive[$name[0]]; 
//                    $name[0] = $newLoadTpl;
//                    if( empty( $name[0] ) )
//                        continue;
//				}
//			}
//            
//            //Se il tpl da caricare necessita che l'utente sia loggato blocca l'inclusione, e se è settato un tpl di copertura lo carica
//			if ( $this->controlUserIsActive ) { 
//                if( !$this->userIsActive && key_exists($name[0], $this->tplToUserIsActive) ) {       
//					$newLoadTpl = $this->tplToUserIsActive[$name[0]];
//                    $name[0] = $newLoadTpl;
//                    if( empty( $name[0] ) )
//                        continue;
//				}
//            }
//			
            //Se è definita una variabile specifica sulla quale assegnare il fetch la setta nella specifica in caso contrario a quella del padre
            $varFetch = !empty( $node['assign'] ) ? $node['assign'] : $root[0];
            
			if ( $this->controls( $xml, $node['name'], $root[0] ) && count( $node ) == 0 ) {
                $value = $this->getFunctionForThisTpl( $name[0], $cores );                
//                $this->get('twig')->addGlobal( "fetch_".$varFetch, $value );
				//$this->arrayBox["fetch_".$varFetch] = $value;
                
			} else {
                if( !empty(  $name[0] ) ) {
                    $this->arrayFetch["fetch_".$varFetch][$x]['value'] = $name[0];
                    $this->arrayFetch["fetch_".$varFetch][$x]['cores'] = $cores;
                    $this->arrayFetch["fetch_".$varFetch][$x]['ajax'] = $ajaxCore;
                }
			}
            $x++;
			$this->createTemplate( $node );
		}
	}

	/**
	 * Metodo che verifica se il padre del box seguente avra altri figli, se si torna False e la funzione
	 * chiamante non farà il fetch ma metterà il nome del tpl in un array
	 * @param object $xml
	 * @param string $tpl
	 * @param string $fetchVar
	 * @return boolean 
	 */
	function controls( $xml, $tpl, $fetchVar ) {
		$count = 0;
		foreach ( $xml->tpl as $node ) {
			$nome  = explode( "|", $node['name'] );
			$root  = explode( "|", $node['padre'] );
			if ( $node['name'] != $tpl ) {
				if ( $root[0] == $fetchVar ) {
					 $count++;
				}
			}
			$this->controls( $node, $tpl, $fetchVar );
		}
		return ( $count == 0 ? true : false );
	}


	/**
	 * Metodo che concatenate i fetch dei box figli che andranno inclusi nel box padre
	 * @param array $arr
	 * @param string $fetchVar 
	 */
	function concatenate( $arr, $fetchVar ) {
		$value = '';	
		foreach( $arr[$fetchVar] as $myBox ) {
            $value .= $this->getFunctionForThisTpl( $myBox['value'],$myBox['cores'],$myBox['ajax'] );
		}
//        $this->get('twig')->addGlobal( $fetchVar, $value );
	}   
    
    /**
	 * Metodo che lancia le funzioni necessarie per la costruzione del tpl
	 * @param string $myTpl 
	 */
	public function getFunctionForThisTpl( $template, $cores = null, $ajaxCore = 0 ) {        
        $this->dependencyManager->addTplDependencies( $template );

//        //Se il tpl inizia con le seguenti stringe non instanzia la classe
//        if ( strpos( strtolower( $template ), "tructure_" ) || strpos( strtolower( $template ), "idget_" ) ) {           
//            $data = array();
//            if( ( empty( $ajaxCore ) || $ajaxCore == 0 ) && !empty( $cores ) ) {
//                foreach( $cores AS $core ) {
//                    if(  !empty( $core ) && $core != null && $core!= 'null' ){
////                        $widget = $this->get( 'app.'.$core );     
////                        $data_new = $widget->processData();
////                        $data = array_merge( $data, $data_new );
//                    }
//                }
//            } else {
//                $this->callJsLoadPage[] = 'modules.add( "'.$template.'","'.str_replace( array( 'Ajax_', '_TO' ),'', implode(' ', $cores ) ).'", '.$ajaxCore.' )';
//            }
////            return $this->get('twig')->render( $this->versionSite."/{$template}".$this->extension, $data ); 
//        }		
        return '';        
	}
        
}//End class
