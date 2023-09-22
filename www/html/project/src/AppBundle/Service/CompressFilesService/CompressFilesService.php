<?php 

namespace AppBundle\Service\CompressFilesService;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Monolog\Logger;
use AppBundle\Service\UtilityService\GlobalUtility;
use AppBundle\Service\DependencyService\DependencyManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Controller\CompressController;

class CompressFilesService {
    protected $dependencyManager;
    protected $globalUtility;
    private $container;
    
    public function __construct( Container $container, DependencyManager $dependencyManager, GlobalUtility $globalUtility) {
        $this->dependencyManager = $dependencyManager;
        $this->globalUtility     = $globalUtility;
        $this->container = $container;
        
    }

    public function compress( $folder = 'template' ) {
        
        if( $folder == 'admin')            
            $this->dependencyManager = $this->container->get('app.dependencyManagerAdmin' );       
        else
            $this->dependencyManager = $this->container->get('app.dependencyManagerTemplate' );       
        
        $this->debug( '####################################### COMPRESSIONE CSS #######################################' );
        
        $this->folder       = $folder;
        
        $this->basePath     = $this->container->getParameter( 'kernel.root_dir' ).'/../web';        
        $this->minFolder    = $this->container->getParameter( 'app.compactVersion' );
        $this->minFolder    =  '/min';
        
        $this->folderTwig   = $this->container->getParameter( 'app.folder_templates_xml' ).$this->folder;
        
        //Gestiona path compressione jss
        $this->cssFolder    = $this->container->getParameter( 'app.folder_css' );
        
        $this->cssPath      = $this->basePath.$this->cssFolder.$this->folder;
        $this->cssPathMin   = $this->basePath.$this->cssFolder.$this->folder.$this->minFolder;
        $this->debug( $this->cssPath );
        $this->debug( $this->cssPathMin );
        
        //Gestiona path compressione js
        $this->jsFolder     = $this->container->getParameter( 'app.folder_js' );        
        $this->folder_js_minified     = $this->container->getParameter( 'app.folder_js_minified' );        
        
        $this->folder       = $folder;
//        $this->jsPath       = $this->basePath.$this->jsFolder.$this->folder;
//        $this->jsPathMin    = $this->basePath.$this->jsFolder.$this->folder.$this->minFolder;
        $this->jsPath       = $this->basePath.$this->jsFolder.$this->folder;
        $this->jsPathMin    = $this->basePath.$this->folder_js_minified.$this->folder.$this->minFolder;
        $this->debug( $this->jsPath );
        $this->debug( $this->jsPathMin );
        
//        $cssString = $this->compressSkin( $folder );
        
//        $this->compactCss( $this->cssPath.'/main.'.str_replace( array( 'm_', 'app_', 'amp_' ), '', $folder ).'.css', $this->cssPathMin.'/main.'.str_replace( array( 'm_', 'app_' ), '', $folder ).'.css' );
        
//        $cssMain = file_get_contents( $this->cssPathMin.'/main.'.str_replace( array( 'm_', 'app_', 'amp_' ), '', $folder ).'.css' );
//        file_put_contents( $this->cssPathMin.'/main.'.str_replace( array( 'm_', 'app_', 'amp_' ), '', $folder ).'.css', $cssMain );        
        
        $this->debug(  '####################################### COMPRESSIONE JAVASCRIPT #######################################' );
        $this->compressDependency();        
    }
    
    /**
     * Metodo che comprime i css dello skin della versione spicifica di un sito
     * @param string $folder
     * @return string 
     */
    private function compressSkin( $folder ) {
        $folder = str_replace( array( 'm_', 'app_' ), '', $folder );
        $this->compactCss( 
            $this->basePath."/assets/css/skins/module.admin.stylesheet-complete.skin.{$folder}.min.css", 
            $this->basePath."/assets/css/skins/module.admin.stylesheet-complete.skin.{$folder}.compress.css"
        );
            
        $this->compactCss( 
            $this->basePath."/assets/library/icons/pictoicons/css/picto.css", 
            $this->basePath."/assets/library/icons/pictoicons/css/picto.compress.css"
        );
        
        $aFiles = array(
            '/assets/library/icons/fontawesome/assets/css/font-awesome.min.css'
            ,'/assets/library/icons/glyphicons/assets/css/glyphicons_filetypes.css'
            ,'/assets/library/icons/glyphicons/assets/css/glyphicons_regular.css'
            ,'/assets/library/icons/glyphicons/assets/css/glyphicons_social.css'
            ,'/assets/library/icons/pictoicons/css/picto.compress.css'
            ,"/assets/css/skins/module.admin.stylesheet-complete.skin.{$folder}.compress.css"
        );
        
            
        $newFile = '';
        foreach( $aFiles AS $file ) {
            $newFile .= file_get_contents( $this->basePath.$file );
        }
        return $newFile;               
    }
    
    /**
     * Crea i css compressi e li sposta nella cartella di appartenenza
     * @param type $fileIn
     * @param type $fileOut
     */
    private function compactCss( $fileIn, $fileOut ) {
//        $command = "curl -X POST -s --data-urlencode 'input@{$fileIn}' http://cssminifier.com/raw > {$fileOut}";
//        exec( $command );
//        $this->debug( $command );        
        
        echo $command = "java -jar yuicompressor-2.4.8.jar --type css ".$fileIn." -o ".$fileOut;
        exec( $command );
        $this->debug( $command );
        
    }
    
    
    /**
     * Crea i js compressi e li sposta nella cartella di appartenenza
     */
    public function compressDependency() {
        $fileStructure = $this->includeFolder( $this->folderTwig );    
                
        $this->dependencyManager->setForceVersion( $this->folder );            
        
        $compressController = new CompressController( $this->container, $this->dependencyManager );
        
        
        foreach( $fileStructure AS $file ) {         
            if( $file == 'empty' )
                continue;
            
            
            $this->dependencyManager->restoreDependency();
            
            $this->debug( '####################################### '.strtoupper( $file ).' #######################################' );
            $compressController->init( $file, $this->folder );
            
            $cssArray = array();
            $cssArray['allCategories.xml']              = 'allcategoriesproduct';
            $cssArray['catSubcatTypologyProduct.xml']   = 'catsubcattypologyproduct';
            $cssArray['homepage.xml']                   = 'homepage';
            $cssArray['detailProduct.xml']              = 'detailmodel';
            $cssArray['detailNews.xml']                 = 'detailnews';
            $cssArray['dinamycPage.xml']                 = 'dinamycpage';
//            $cssArray['listModelsTrademark.xml']        = 'listmodelstrademark';
            $cssArray['listProduct.xml']                = 'listproduct';
            $cssArray['listArticles.xml']               = 'listarticles';
            $cssArray['modelComparison.xml']            = 'modelcomparison';
            $cssArray['listModelsComparison.xml']       = 'listmodelscomparison';
            $cssArray['notFound.xml']                   = 'notfound';
            
            if( !empty( $cssArray[$file] ) ) {
                switch( $this->folder ) {
                    case 'template':
                        $cssF = 'Desk.BODY.'.$cssArray[$file].'.css';
                    break;
                }
                
                
                $this->compactCss( $this->cssPath.'/'.$cssF, $this->cssPathMin.'/main.'.str_replace( '.xml','', $file).'.css' );
            }
            
//            $cssHead = $this->dependencyManager->getCSSHead(); 
//            $this->createMinCss($cssHead,$file, 'head');
            
//            $cssBody = $this->dependencyManager->getCSSBody(); 
//            $this->createMinCss($cssBody,$file, 'body');
            
//            print_r($cssHead);
//            print_r($cssBody);
            
            $jsHead = $this->dependencyManager->getJSHead(); 
            $this->createMinJs( $jsHead, $file, 'head' );
            
            $jsBody = $this->dependencyManager->getJSBody();                    
            $this->createMinJs( $jsBody, $file, 'body' );
            
        }
    }
    
    
    /**
     * Crea il file unico js
     * @param type $jsBody
     * @param type $file
     * @param type $type
     */
    private function createMinCss( $css, $file, $type ) {
        $compressassets = '';
        $compresscss = '';
        $x = 0;
        
        foreach( $css AS $f => $value ) {
            echo $this->basePath.$f ."\n";
            if( file_exists( $this->basePath.$f  ) ) {                
                $newFile = file_get_contents( $this->basePath.$f );
                $newFile = trim( $newFile, ';' )."\n";
                $compresscss .= $newFile.$this->getSpace();
            } else {
                
                $newFile = file_get_contents( $f );
                $newFile = trim( $newFile, ';' )."\n";
                $compresscss .= $newFile.$this->getSpace();
                
                $this->debug( 'FILE NON TROVATO: ' .$this->basePath.$f. 'prova a cercarlo in:'.$f );
            }
        }
        
        $file = str_replace( '.xml', '_'.$type.'.css',$file );
        if( file_exists( $this->cssPathMin.'/css_'.$file ) )
            @unlink( $this->cssPathMin.'/css_'.$file );

        
        $compresscss = empty( $compresscss ) ? '.ciao {};' : $compresscss;
        file_put_contents( $this->cssPathMin.'/css_'.$file , $compresscss );
        $this->debug( $this->cssPathMin.'/css_'.$file );

        
//        if( strpos( ' '.$file, '-min' ) === FALSE && strpos( ' '.$file, '.min' ) ) {        
            $command = "java -jar yuicompressor-2.4.8.jar --type css ".$this->cssPathMin.'/css_'.$file." -o ".$this->cssPathMin.'/css_'.$file;
            exec( $command );
            $this->debug( $command );
//        }
        
        unset( $compresscss ); 
        unset( $compressassets ); 
    }
    
    /**
     * Crea il file unico js
     * @param type $jsBody
     * @param type $file
     * @param type $type
     */
    private function createMinJs( $jsBody, $file, $type ) {
        $compressassets = '';
        $compressjs = '';
        $x = 0;
        
        foreach( $jsBody AS $js => $value ) {
            if( file_exists( $this->basePath.$js  ) ) {
                echo $this->basePath.$js."\n";
                $newFile = file_get_contents( $this->basePath.$js );
                $newFile = trim( $newFile, ';' )."\n;";
                $compressjs .= $newFile.$this->getSpace();
            } else {
                $newFile = file_get_contents( $js );
                $newFile = trim( $newFile, ';' )."\n;";
                $compressjs .= $newFile.$this->getSpace();
                
                $this->debug( 'FILE NON TROVATO: ' .$this->basePath.$js. 'prova a cercarlo in:'.$js );
                
            } 
        }

        $file = str_replace( '.xml', '_'.$type.'.js',$file );
        if( file_exists( $this->jsPathMin.'/js_notcompiled'.$file ) ) {
            @unlink( $this->jsPathMin.'/js_notcompiled'.$file );
            @unlink( $this->jsPathMin.'/js_'.$file );
        }

        
        file_put_contents( $this->jsPathMin.'/js_notcompiled'.$file , $compressjs );
        $this->debug( $this->jsPathMin.'/js_notcompiled'.$file );
        
        $command = "java -jar compiler.jar -W QUIET --js ".$this->jsPathMin.'/js_notcompiled'.$file."  --js_output_file ".$this->jsPathMin.'/js_'.$file;
        exec( $command );
        $this->debug( $command );
        
        unset( $compressjs ); 
        unset( $compressassets ); 
    }
    
    /**
     * Analizza tutti i file di una cartella
     * @param type $folder
     * @param type $directory
     * @return type
     */
    private function includeFolder( $folder, $directory = false ) {
		$dir = scandir($folder);
		$x = 0;
		foreach( $dir as $f ) {
			if( $f == "." || $f == "..") {
				continue;
			}
			if ( is_dir( $folder."/".$f ) && $directory == true ) {
				$arrayfile[] = $f;
			} else if ( !is_dir( $folder."/".$f ) && $directory == false ){
				$arrayfile[] = $f;
			}
			
			$x++;
		}
		sort( $arrayfile );
		return $arrayfile;
	}
    
    private function getSpace() {
        $s = '';
        for( $x=0; $x < 1; $x++ ) {
            $s .= "\n";
        }
        return $s;
    }
    
    private function debug( $msg ) {
        echo "\n";
        echo $msg."\n";
    }   
    
    public function compressHtml($html) {
		$html = preg_replace("/\n ?+/", " ", $html);
		$html = preg_replace("/\n+/", " ", $html);
		$html = preg_replace("/\r ?+/", " ", $html);
		$html = preg_replace("/\r+/", " ", $html);
		$html = preg_replace("/\t ?+/", " ", $html);
		$html = preg_replace("/\t+/", " ", $html);
		$html = preg_replace("/ +/", " ", $html);
		$html = trim($html);
		return $html;
	}
    
}