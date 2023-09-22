<?php

namespace AppBundle\Service\GlobalConfigService;
use Twig_Environment as Environment;
use Twig_SimpleFunction;
use Twig_SimpleFilter;
use AppBundle\Service\GlobalConfigService\RouterManager;

class GlobalTwigExtension extends \Twig_Extension {   
   
    public function __construct( Environment $twig, RouterManager $routerManager ) {
        $this->twig             = $twig;        
        $this->routerManager    = $routerManager;        
        $this->setRouterManager();
        
//        $this->setExtPrintFirstNews();
        $this->hideUrlForGoogle();
        $this->salePercentage();
        $this->jsonDecode();
        $this->utf8Encode();
        $this->utf8Decode();
        $this->convertPtoBR();
        $this->encodeUrlDeepLink();
        $this->adaptFromMeta();
        $this->hyphenizeString();
        $this->getUpDownArrowPrices();
    }
    
    function jsonDecode() {
        $generate = new Twig_SimpleFunction('jsonDecode', function ( $string ) {   
            return json_decode( $string );
        });
        $this->twig->addFunction( $generate );
    }
    
    /**
     * Metodo che crea l'iconda dell'andamento rpezzo
     */
    function getUpDownArrowPrices() {
        $generate = new Twig_SimpleFunction('getUpDownArrowPrices', function ( $model, $anchor = false ) {   
            $html = '';
            
            if( empty( $model['lastPrice'] ) ||  (int)$model['price'] == (int)$model['lastPrice']  )
                return '<span class="arrowEmpty"></span>';
            
            $dataTrend = empty( $anchor ) ? 'data-PriceTrend=\''.$model['price'].'\'' : '';
            $dataTrend = '';
            
            if ( (int)$model['price'] > (int)$model['lastPrice'] )
                $html .= '<span title="Andamento Prezzo Crescente" class="arrowUp" '.$dataTrend.'></span>';
            else if(  (int)$model['price'] < (int)$model['lastPrice'] )
                $html .= '<span title="Andamento Prezzo Descrescente" class="arrowDown" '.$dataTrend.'></span>';
            
            
            
            if( !empty( $anchor ) )
                return '<a href="#chartDetailModel">'.$html.'</a>';
            else
                return $html;
        });
        $this->twig->addFunction( $generate );
    }
    
    /**
     * Rende la stringa compatibile per i meta tag html
     */
    function adaptFromMeta() {
        $generate = new Twig_SimpleFunction('adaptFromMeta', function ( $string ) {   
            return str_replace( array('"', '&'), array(' ', '','',''), $string );
        });
        $this->twig->addFunction( $generate );
    }
    
    /**
     * Rimuove caratteri strani nelle stringhe
     */
    function hyphenizeString() {
        $generate = new Twig_SimpleFunction('hyphenize', function ( $string ) {   
            return hyphenize( $string ) ;
        });
        $this->twig->addFunction( $generate );
    }
    
    /**
     * Fake url encode per sistemare i caratteri strani nei deepLink dei prodotti
     */
    function encodeUrlDeepLink() {
        $generate = new Twig_SimpleFunction('encodeDeepLink', function ( $string ) {   
            return str_replace( array( '[', ']' ), array( '%5B', '%5D'), $string );
        });
        $this->twig->addFunction( $generate );
    }
    
    /**
     * Modifica gli p ion br
     */
    function convertPtoBR() {
        $generate = new Twig_SimpleFunction('convertPtoBR', function ( $string ) {   
            return str_replace( array( '<p>', '</p>'), array( '', '<br>'), strip_tags( $string,  '<em><strong><p><br><br/><a><img><amp-img>' ) );
        });
        $this->twig->addFunction( $generate );
    }    
    
    function utf8Decode() {
        $generate = new Twig_SimpleFunction('utf8Decode', function ( $string ) {   
            return utf8_decode( $string );
        });
        $this->twig->addFunction( $generate );
    }
    
    function utf8Encode() {
        $generate = new Twig_SimpleFunction('utf8Encode', function ( $string ) {   
            return iconv(mb_detect_encoding($string, mb_detect_order(), true), "UTF-8//IGNORE", $string);
//            return utf8_encode( $string);
        });
        $this->twig->addFunction( $generate );
    }
    
    /**
     * Usa il router manager per creare la rotta
     */
    function setRouterManager() {
        $generate = new Twig_SimpleFunction('generate', function ( $routeName, $params = array(), $absolute = true ) {   
            return $this->routerManager->generate( $routeName, $params, $absolute );
        });
        $this->twig->addFunction( $generate );
    }
    
    /**
     * Calcola la percentuale di sconto
     */
    public function salePercentage() {
        $salePercentage = new Twig_SimpleFunction('salePercentage', function ( $price, $lastPrice ) {   
            return ceil( $price /  ( $lastPrice / 100 ) ) ;
        });
        $this->twig->addFunction( $salePercentage );
    }
    
    /**
     * Aggiunge un trink zozzo zozzo per determinare se nei blocchi delle news e stato gia utilizzato e stampata la prima news
     * nel block 1, in tal caso nel block due fa saltare la prima enws
     */
    public function setExtPrintFirstNews() {
        $setPrintFirstNews = new Twig_SimpleFunction('setPrintFirstNews', function ( $val ) {     
            global $typeNews;
            $typeNews = $val;
        });
        $this->twig->addFunction( $setPrintFirstNews );
        
        $getPrintFirstNews = new Twig_SimpleFunction( 'getPrintFirstNews', function () {    
            global $typeNews;
            return $typeNews;
        });
        $this->twig->addFunction( $getPrintFirstNews );
    }
    
    /**
     * Aggiunge un trink zozzo zozzo per determinare se nei blocchi delle news e stato gia utilizzato e stampata la prima news
     * nel block 1, in tal caso nel block due fa saltare la prima enws
     */
    public function hideUrlForGoogle() {
        $setPrintFirstNews = new Twig_SimpleFunction('hideUrlForGoogle', function ( $val ) {   
            $prf1 = $this->generateRandomString( 4 );
            $prf2 =  $this->generateRandomString( 5 );
            return '#'.$prf1.base64_encode( $val ).$prf2;
        });
        $this->twig->addFunction( $setPrintFirstNews );        
    }

    /**
     * Genera una stringa random
     * @param type $length
     * @return string
     */
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
   
}


function hyphenize($string) {
    $dict = array(
        "I'm"      => "I am",
        "thier"    => "their",
        // Add your own replacements here
    );
    
//    $string = iconv(mb_detect_encoding($string, mb_detect_order(), true), "UTF-8//IGNORE", $string);
    
//    $string = utf8_decode( $string );
    
    return 
        // the full cleanString() can be downloaded from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
        cleanString(
            str_replace( // preg_replace can be used to support more complicated replacements
                array_keys($dict),
                array_values($dict),
                urldecode($string)
            )
        )       
    ;
}

function cleanString($text) {          
    $utf8 = array(
        'â','€ ','€','.','?','â','ã','ª','ä','Â','Ã','Ä','Î','Ï','î','ï','ê', 'ë','Ê','Ë','ô','õ','º','ö','Ô','Õ','Ö','û','ü','Û','Ü','�'
    );
    return preg_replace("/[^A-Za-z0-9ìèéòàù\[\]\#\-\.\,\'\" ]/", '',str_replace($utf8, ' ', $text));   
}