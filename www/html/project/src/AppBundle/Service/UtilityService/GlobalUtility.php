<?php

namespace AppBundle\Service\UtilityService;
use AppBundle\Service\SpiderService\proxyConnector;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class GlobalUtility {
    
    public $browserUtility;
    public $cacheUtility;
    
    public function __construct( BrowserUtility $browserUtility, CacheUtility $cacheUtility, ImageUtility $imageUtility, FileUtility $fileUtility )  {                
        $this->browserUtility = $browserUtility;        
        $this->cacheUtility   = $cacheUtility;        
        $this->imageUtility   = $imageUtility;        
        $this->fileUtility    = $fileUtility;        
    }
    
    
    public function getBulletPoints( $getTecnicalTemplateId, $technicalSpecifications ) {
        
        $aVocabularyKey = array();
        $aVocabularyValue = array();
        $initVocabulary = explode( ';', $getTecnicalTemplateId->vocabulary );
        foreach( $initVocabulary  AS $vocabulary ) {
            $aItem = explode( '[#]', $vocabulary );
            if( !empty( $aItem[1] ) ) {               
                $aVocabularyKey[]   = trim($aItem[0]);
                $aVocabularyValue[] = ' '.trim($aItem[1]);
            }
        }      
        
        $strBullets = '';
        $aBullet = explode( ';', $getTecnicalTemplateId->bulletPoints );        

        
        foreach( $aBullet  AS $itemBullet ) {
            $aItem = explode( '[#]', $itemBullet );
            foreach( $technicalSpecifications AS $tecnical ) {
                
                if( trim( $tecnical['name'] ) ==  trim( $aItem[0] ) ) {                    
                    $tecnical['value'] = str_replace( $aVocabularyValue, $aVocabularyKey, strtolower( $tecnical['value'] ) );
                    
                    $tecnical['value'] =   str_replace( 
                            array('kWh', 'millioni', ' h ', ' mp ', '1 litri'), 
                            array('kW/h','milioni', ' ore', ' mpx ', '1 litro'), 
                            $tecnical['value'].' ' 
                    ) ;
                    
//                    $tecnical['value'] = trim( preg_replace("/[^A-Za-z0-9àòùèì ]/", '', $tecnical['value'] ) );
                    if( trim( $tecnical['value'] ) == 'si' ) {
                        $strBullets .= trim(  ucfirst(  $aItem[0]  ) ).';';
                    } else {
                        $strBullets .= trim(  ucfirst(  $aItem[1]  ) ).' '.trim( $tecnical['value'] ) .';';
                    }
                }
            }            
        }   
        
        return $strBullets;
    }
    
    public function getTecnicalTemplates( $getTecnicalTemplateId, $getTechnicalSpecifications ) {
        $response = array();
        $response['tecnical'] = false;
        $response['bullets'] = false;
        
        if( !empty( $getTecnicalTemplateId->template ) ) {
            $text = '';
            
            
            $initTmplate =  explode( ';',$getTecnicalTemplateId->template );
            
            $aVocabularyKey = array();
            $aVocabularyValue = array();
            $initVocabulary = explode( ';', $getTecnicalTemplateId->vocabulary );             
            foreach( $initVocabulary  AS $vocabulary ) {
                $aItem = explode( '[#]', $vocabulary );        
//                print_r($aItem);
                if( !empty( $aItem[1] ) ) {            
//                    echo count($aItem);
                    $number =  rand(1,count($aItem)-1);
                    
                    $aVocabularyKey[]   = trim($aItem[0]);
                    $aVocabularyValue[] = ' '.trim($aItem[$number]);
                }
            }    
            
            
            $finalTecnical = array();
            $tecnical = explode( ';', $getTechnicalSpecifications );
            $i = 0;
            $pagomenoValue = array();
            foreach( $tecnical AS $itemTecnical ) {                                
                $item = explode( ':', $itemTecnical );                           
                if( empty(  $item[0] ) )
                    continue;
                if( empty(  $item[1] ) )
                    continue;                
                
                $val2 = !empty( $item[2] ) ? ':'.$item[2] : '';                
                $pagomenoValue[strtolower(trim($item[0]))] = trim($item[1].$val2);
            }       
            
            
            $final = array();
            $brefing = array();                              
            $accept = array();                                          
            $keyB = false;
            
            foreach( $initTmplate AS $item ) {
                if( strpos( ' '.$item, '[LABEL]' ) !== FALSE ) {
                    $aItem = explode( '[LABEL]', $item );
//                    print_r($aItem);
                    
            
//                    $keyA = trim( str_replace( '[LABEL]', '', $aItem[0] ) );
                    $keyB = trim( str_replace( '[LABEL]', '', $item ) );
//                    $accept[$keyA] = $keyB; 
                    continue;
                }
                $aItem = explode( '[#]', $item );    
                
                $arrayRand =  array();
                for( $x = 1; $x < count($aItem); $x++ ) {
                    if( !empty( $aItem[$x] ) )
                        $arrayRand[$x] = $x;
                }
                
                
                if( !empty( $aItem[1] ) ) {
//                    echo 'cccomi';
                    $numberRand = $this->getRandValue(  $arrayRand, $aItem, $pagomenoValue );                    
                    
//                    if( $numberRand !== false ) {
//                        echo '====>'.$numberRand.'<====';
//                        print_r( $aItem );
                        $aItem[1] = strtolower( $aItem[1] );
                        $brefing[$keyB][trim($aItem[0])] = false;                
                        $accept[trim($aItem[0])] = trim( $aItem[$numberRand] ); 
//                    }
                }  
            }             
//
//            print_r($brefing);
//            print_r($accept);
//            print_r($pagomenoValue);

//                $tdValue = trim( str_replace( array( 'Suggerisci una modifica', '&nbsp;' ), array('',' ') , $item[1] ) )  ;
////                $tdValue = preg_replace("/[^A-Za-z0-9àòùèì]/", '', $tdValue);
//                $thValue = trim( preg_replace("/[^A-Za-z0-9àòùèì\.\,\/\(\) ]/", '', $item[0]) );
////                $thValue = trim( preg_replace("/[^A-Za-z0-9àòùèì ]/", '', $item[0]) );

            
                    foreach ( $brefing AS &$itemBriefing ) {                        
                        foreach ( $itemBriefing AS $key => $value) {                                    
                            if(  !empty( trim( $accept[$key] ) ) && ! empty( $pagomenoValue[strtolower( $accept[$key] )] ) ) {                                                    
//                                echo "\necco la chiave". $key." ==> ".$acceptValue = strtolower( $accept[$key] )."\n";
//                                print_r($pagomenoValue);                            
                                $itemBriefing[$key] = trim( str_replace( $aVocabularyKey, $aVocabularyValue, strtolower( $pagomenoValue[strtolower( $accept[$key] )] ) ),' -' );
                            } else if(  !empty( trim( $accept[$key] )  ) ) {
                                $itemBriefing[$key] = '';
                            }
                        }                   
                    }
                
//            }
//            print_r($itemBriefing);
            
            foreach ( $brefing AS $key2 => &$item ) {
                $text .= $key2.';';
                foreach ( $item AS $key => &$value) {    
                    if( !empty( $value ) ) {
//                        continue;
//                    $text .= $key.':'.preg_replace("/[^A-Za-z0-9\-\,\" ]/", '', trim( $value,'-')).';';         
//                    
//                    $value = '1 Litro';                   
                    $value =  $this->convertDataTecnical( trim( $value ).' ' );
                    $text .= $key.':'.trim( $value,'-').';';   
//                    echo $text .= $key.':'.trim( $value,'-').';';   
//                    exit;
                    } else {
                        $text .= $key.':NA;';   
                    }
                    
                }                   
            }
            $getTechnicalSpecifications = $text;
            
            $finalTecnical = array();
            $tecnical = explode( ';', $getTechnicalSpecifications );
            $i = 0;
            foreach( $tecnical AS $itemTecnical ) {
                $item = explode( ':', $itemTecnical );           
                if( empty(  $item[0] ) )
                    continue;

                
                $finalTecnical[$i]['name'] = $item[0]; 
                $finalTecnical[$i]['value'] = !empty( $item[1] ) ?  $this->convertDataTecnical( trim( $item[1].' ' ) ) : ''; 
                $finalTecnical[$i]['isLabel'] = !empty( $item[1] ) ?  false : true; 
                $i++;
            }
            
            $bullets = $this->getBulletPoints($getTecnicalTemplateId, $finalTecnical );
            
            $response['tecnical'] = $getTechnicalSpecifications;
            $response['bullets'] = str_replace( 'Â', '', $bullets );
            $response['bullets'] = trim( str_replace( $aVocabularyKey, $aVocabularyValue, strtolower( $response['bullets'] ) ) );
            echo json_encode( $response, JSON_UNESCAPED_UNICODE );
        }
    }
    
    /**
     * Metodo che converte i valori degli altri siti
     * @param type $value
     */
    private function convertDataTecnical( $value ) {
        $value = strtolower( $value );          
        $value =   str_replace( 
                array('kwh', ' wh', ' kw', 'millioni', ' h ', ' mp ', '1 litri'), 
                array("kW\h", " kW\h", " kW\h", 'milioni', ' ore', ' mpx ', '1 litro'), 
                $value.' ' 
        ) ;        
        
        //rimuove i valori tra parentesi comprese le stesse parentesi
        $value = preg_replace("/\([^)]+\)/","",$value);  
        
        //Se si tratta di un valore ES: 16 777 216 colori
        $value2 = trim( preg_replace("/\s+/", '', $value ) );             
        
        if (preg_match("/([0-9\ ]+)colori/i", $value2, $matches) || preg_match("/([0-9 ]+) colori/i", trim( $value2 ), $matches) ) {            
            if( !empty( $matches[1] ) ) {           
                $matches[1] = str_replace( '.', '', $matches[1] );        
                if( trim( $matches[1] ) > 999999 ) {                                   
                    $newValue =  !empty( $matches[1] ) ? round( ( $matches[1] / 1000000 ), 1 ) ." milioni di colori" : $value;                                        
                    return str_replace( $matches[0], $newValue.' ', $value2 );
                }                
            }
        }           
        
        //se si tratta di un valore ES: [5,8 pollici / 14,73 cm] 
        if( strpos( $value, '/') > 3 ) {
            return trim( substr($value, 0, strpos( $value, '/' ) ) );
        }
        
//        
        $value2 = preg_replace("/[^A-Za-z0-9\-\,\"]/", '', $value );        
        //Se si tratta di un valore in mhz ES: 1449 mhz o 1.550 mhz
        if (preg_match("/([0-9]+) min /i", $value.' ', $matches)  ) {               
            if( !empty( $matches[1] ) ) {           
                if( trim( $matches[1] ) > 59 ) {                             
                    $newValue =  !empty( $matches[1] ) ? $this->convertToHoursMins( $matches[1] ) : $value;                                        
                    return str_replace( $matches[0], $newValue.' ', $value );
                }                
            }
        }
                
//        $value2 = preg_replace("/[^A-Za-z0-9\-\,\" ]/", '', $value );        
        //Se si tratta di un valore in mhz ES: 1449 mhz o 1.550 mhz
        if (preg_match("/([0-9\,\.]+) litr/i", $value, $matches) || preg_match("/([0-9\.\,]+)litr/i", trim( $value ), $matches) ) {                  
            if( !empty( $matches[1] ) ) {                           
                $matches[1] = str_replace( '.', '', $matches[1] );        
                if( trim( $matches[1] ) > 1 ) {                                   
                    return $matches[1].' litri';
                }  else {
                    return $matches[1].' litro';
                }              
            }
        }
                
        $value2 = preg_replace("/[^A-Za-z0-9\-\,\" ]/", '', $value );        
        //Se si tratta di un valore in mhz ES: 1449 mhz o 1.550 mhz
        if (preg_match("/([0-9]+)mb/i", $value2, $matches) || preg_match("/([0-9\.]+)mb/i", trim( $value2 ), $matches) ) {            
            if( !empty( $matches[1] ) ) {           
                $matches[1] = str_replace( '.', '', $matches[1] );        
                if( trim( $matches[1] ) > 999 ) {                                   
                    $newValue =  !empty( $matches[1] ) ? round( ( $matches[1] / 1000 ), 1 ) ." GB" : $value;                                        
                    return str_replace( $matches[0], $newValue.' ', $value2 );
                }                
            }
        }
        
        //Se si tratta di un valore in mhz ES: 1449 mhz o 1.550 mhz
        if (preg_match("/([0-9\.]+) mhz/i", $value, $matches) || preg_match("/([0-9\.]+)mhz/i", $value, $matches) ) {            
            if( !empty( $matches[1] ) ) {         
                $matches[1] = str_replace( '.', '', $matches[1] );                
                if( trim( $matches[1] ) > 999 ) {                    
                    $newValue =  !empty( $matches[1] ) ? round( ( $matches[1] / 1000 ), 1 )." GHz" : $value;                                        
                    return str_replace( $matches[0], $newValue.' ', $value );
                }                
            }
        }
                                
        //Se si tratta di un valore in millimetri ES: 1449 mm
        if (preg_match("/([0-9\,\.]+) mm /i", $value, $matches) || preg_match("/([0-9\,\.]+)mm /i", $value, $matches) ) {                  
            if( !empty( $matches[1] ) ) {      
                if( trim( $matches[1] ) > 9 ) {                    
                    $newValue =  !empty( $matches[1] ) ? ( floatval($matches[1]) / 10)." cm" : $value;       
                    return str_replace( array($matches[0],'.'), array( $newValue, ',' ), $value );
                } else {
                    return str_replace( array('.'), array( ',' ), $value );
                }                
            }
        }
                 
        //Se si tratta di un valore in millimetri ES: 1449 g
        if (preg_match("/([0-9\,]+) g /i", $value, $matches) || preg_match("/([0-9\,]+)g /i", $value, $matches) ) {
            if( !empty( $matches[1] ) ) {
                if( trim( $matches[1] ) > 999 ) {
                    $newValue = !empty( $matches[1] ) ? round( ( $matches[1] / 1000 ), 1 )." KG" : $value;
                    return str_replace( $matches[0], $newValue.' ', $value );
                } else {
                    return str_replace( $matches[0], $matches[1].' grammi ', $value );                    
                }
            }
        }
        
        $value2 = preg_replace("/[^A-Za-z0-9\-\,\" ]/", '', $value );        
        //Se si tratta di un valore in numero di pezzi
        if (preg_match("/([0-9\,]+)pz/i", $value2, $matches) || preg_match("/([0-9\,]+) pz/i", $value2, $matches) ) {       
            if( !empty( $matches[0] ) && !empty( $matches[1] ) && $matches[1] > 1 )  {                
                return str_replace( $matches[0], $matches[1].'', $value2 );                                  
            } else {
                return str_replace( $matches[0], $matches[1].'', $value2 );      
            }
        }
        
        $value2 = preg_replace("/[^A-Za-z0-9\-\,\" ]/", '', $value );        
        //Se si tratta di un valore in watt
        if (preg_match("/([0-9]+)w /i", $value2, $matches) || preg_match("/([0-9]+) w /i", $value2, $matches) ) {       
            if( !empty( $matches[0] ) )  {                
                return str_replace( $matches[0], $matches[1].' watt', $value2 );                                  
            }
        }
        
        $value2 = preg_replace("/[^A-Za-z0-9\-\,\"\. ]/", '', $value );        
        //Se si tratta di un valore in pollici
        if (preg_match("/([0-9\,\.]+)\"/i", $value2, $matches) || preg_match("/([0-9\,\.]+) \"/i", $value2, $matches) ) {       
            if( !empty( $matches[0] ) )  {                
                return str_replace( array( $matches[0], ',' ), array( $matches[1].' pollici','.' ), $value2 );                                  
            }
        }        
                         
       $finalMatch = array();
        //Se si tratta di una stringa di valori separati da virgola
        if (   preg_match_all("/([a-zA-Z0-9\(\)\-\.\]+),([a-zA-Z0-9\(\)\-\.]+)/i", $value, $matches) 
            || preg_match_all("/([a-zA-Z0-9\(\)\-\.\]+), ([a-zA-Z0-9\(\)\-\.]+)/i", $value, $matches) 
            || preg_match_all("/([a-zA-Z0-9\(\)\-\.\]+)<br>([a-zA-Z0-9\(\)\-\.\ ]+)/i", $value, $matches) ) {   
            
            if( substr_count( $value, ',' ) > 0 ) {
                
                $tempValue = str_replace( '×', '', $value);
                $matchesTemp = explode( ',', $tempValue );
                
                if(is_numeric( $matchesTemp[0] ) ) {
                    return $value;
                }
                
                $matches = explode( ',', $value );                                                
                $tot =  floor( ( count( $matches ) / 100 ) * 100 );
                                
                for( $x = 0; $x < $tot; $x++ ) {    
                    $key = array_rand($matches);
                    $finalMatch[] = trim( preg_replace("/\([^)]+\)/","", $matches[$key] ) );
                    unset( $matches[$key]);                
                }
                return ( implode( ' - ', $finalMatch ) );
            }            
        }                
        
        return $value;
    }
    
    private  function convertToHoursMins($time, $format = '%d ore %02d minuti') {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        $text = sprintf($format, $hours, $minutes);
        return str_replace( '00 minuti', '', $text );
    }
    
    private function getRandValue( $arrayRand, $aItem, $pagomenoValue ) {
        if( empty( $arrayRand ) ) {
            return false;
        }
        
        $numberRand = array_rand( $arrayRand );                      
        if( empty( $pagomenoValue[strtolower( trim( $aItem[$numberRand]) )] ) ) {
            unset( $arrayRand[$numberRand] );            
            $numberRand = $this->getRandValue($arrayRand, $aItem, $pagomenoValue);
        }
        return $numberRand;
    }
    
    /**
     * Avvia il recupero della scheda tecnica da pagomeno.it
     * @param type $url
     * @return string
     */
    public function getTecnicalPagomeno( $url ) {
        return '';
        $finalUrl = 'http://tricchetto.homepc.it/wgetInfo/rxndu9034tur0934tun3904tun309tu3490?url='.$url;                
        echo $result = file_get_contents( $finalUrl );
        exit;
//        $result = mb_convert_encoding($result, 'HTML-ENTITIES', "UTF-8"); 

        
        $result = str_replace( '<br>', ',', $result );
        $result = str_replace( '&nbsp;', ' ', $result );
        
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );
        
        $elements = $xpath->query("//div[contains( @class, 'listcontainer')]//tr");
        if( $elements->length == 0 ) {
            exit;
        }

        $text = '';
        foreach( $elements AS $element ) {
            $th = $xpath->query( "th", $element );
            if( $th->length == 0 ) {
                return;
            }
            $td = $xpath->query( "td", $element );
            if( $td->length == 0 ) {
                return;
            }

            $h3 = $xpath->query( "h3", $th[0] );
            
            $tdValue = trim( str_replace( array( 'Suggerisci una modifica', '&nbsp;', 'Sì', 'Contribuisci', 'Â' ), array('-','-','SI','','') , $td[0]->nodeValue ) )  ;
//                $tdValue = preg_replace("/[^A-Za-z0-9\,\. ]/", '', $tdValue);
           

            if( $h3->length == 0  ) {       
//                $tdValue = trim( $tdValue ) == 'colori' ? 'SI' : $tdValue;
                $text .= $th[0]->nodeValue.':'.$tdValue.';';
            } else {
                $text .= $th[0]->nodeValue.';';
            }
        }                        
        
        
        return $text;
    }
    
    /**
     * Avvia il recupero della scheda tecnica da pagomeno.it
     * @param type $url
     * @return string
     */
    public function getTecnicalIdealo( $url ) {
        
//        exec('wget '.$url.'  --output-document=/tmp/provaidealo.html');
//        
//        
//        $result = file_get_contents( '/tmp/provaidealo.html' );
        
        $finalUrl = 'http://tricchetto.homepc.it/wgetInfo/rxndu9034tur0934tun3904tun309tu3490?url='.$url;                
        $result = file_get_contents( $finalUrl );
        
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );
        
        $elements = $xpath->query("//div[@id='Scheda prodotto']//li[contains( @class, 'datasheet-listItem')]");
        if( $elements->length == 0 ) {
            return '';
        }

        $text = '';
        foreach( $elements AS $element ) {              
            $th = $xpath->query( "span[contains( @class, 'listItemKey')]", $element );
            if( $th->length == 0 ) {
                continue;
            }            
            $td = $xpath->query( "span[contains( @class, 'listItemValue')]", $element );
            if( $td->length == 0 ) {
                continue;
            }

            $tdValue = trim( str_replace( array( 'Suggerisci una modifica', '&nbsp;', 'Sì', 'Contribuisci', 'Â' ), array('-','-','SI','','') , $td[0]->nodeValue ) )  ;
                $text .= trim( $th[0]->nodeValue ).':'.$tdValue.';';
        }
        return $text;
    }
    /**
     * Avvia il recupero della scheda tecnica da trovaprezzi.
     * @param type $url
     * @return string
     */
    public function getTecnicalTrovaprezzi( $url ) {        
        
        $finalUrl = 'http://tricchetto.homepc.it/wgetInfo/rxndu9034tur0934tun3904tun309tu3490?url='.$url;                
//        $result = file_get_contents( $finalUrl );
        
        
        include( "/home/prod/site/acquistigiusti/frontend/src/AppBundle/Service/SpiderService/ProxyConnector/proxyConnector.class.php" );        
        $this->prxC = proxyConnector::getIstance();
        $this->prxC->newIdentity();
        $result = $this->prxC->getContentPage( $url );
        
        
        
//        $result = file_get_contents( $url );            
        $result = mb_convert_encoding($result, 'HTML-ENTITIES', "UTF-8"); 
        
//        $result = file_get_contents( '/tmp/provatxt.txt' );
//        $result = mb_convert_encoding($result, 'HTML-ENTITIES', "UTF-8"); 
        
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );
        
        $elements = $xpath->query('//div[@id="product_info_section"]//table/tbody//tr');
        if( $elements->length == 0 ) {
            return '';
        }

        $text = '';
        foreach( $elements AS $element ) {              
            $item = $xpath->query( "td", $element );
            if( $item->length == 0 ) {
                continue;
            }            
            

            $tdValue = trim( str_replace( array( 'Suggerisci una modifica', '&nbsp;', 'Sì', 'Contribuisci', 'Â' ), array('-','-','SI','','') , $item[1]->nodeValue ) )  ;
            $text .= trim( $item[0]->nodeValue ).':'.$tdValue.';';
        }
        
        return $text;
    }
    
    public function arrayToObject( $array ) {
        if( is_object( $array ) )
            return $array;
        return json_decode(json_encode($array), FALSE);
    }    
    
    /**
     * Converte i tag ima in tag amp-img
     * @param type $string
     * @return type
     */
    function html5toampImage( $string, $layout = 'fixed', $width = false, $height = false ) {
        $originalLayout = $layout;
        preg_match_all("/<img.*\/>/",$string,$out);        
        if( empty( $out ) )
            return $string;
        

        foreach( $out[0] AS $img ) {
            preg_match('/src="(.+?)"/', $img, $src);
            $srcAttribute = $src[0];
            
            preg_match('/style="(.+?)"/', $img, $styles);
            
            preg_match('/data-layout="(.+?)"/', $img, $layouts);
            if( !empty( $layouts ) ) {
                $layout = $layouts[1];
            } else {
                $layout = $originalLayout;
            }
            
            $sizes = getimagesize( str_replace( array( 'src="','"'), array( '',''),$srcAttribute) );
            
            $heightAttribute = 'height="'.$sizes[1].'"';
            $widthAttribute = 'width="'.$sizes[0].'"';
            
            if( !empty( $styles ) ) {
                $style = $styles[1];

                $allData = explode(";",$style);

                foreach($allData as $data) {
                    if($data) {
                        list($key,$value) = explode(":",$data);
                        if(trim($key)=="height") {
                        $heightAttribute =  trim($key).'="'.trim(str_replace("px","",$value)).'"'; 
                        }
                    if(trim($key)=="width") {
                        $widthAttribute =  trim($key).'="'.trim(str_replace("px","",$value)).'"';
                        }       
                    }
                }
            }
            
            $ampImageTag = '<amp-img '.$srcAttribute.' '.$heightAttribute.' '.$widthAttribute.' layout="'.$layout.'"></amp-img>';
            $string = str_replace($img , $ampImageTag, $string);
        }   
        return $string;
    } 
    
    
    //Converte le unita di misura
    public function bytesToSize( $bytes, $precision = 2 )	{  
		$kilobyte = 1024;
		$megabyte = $kilobyte * 1024;
		$gigabyte = $megabyte * 1024;
		$terabyte = $gigabyte * 1024;

		if (($bytes >= 0) && ($bytes < $kilobyte)) {
			return $bytes . ' B';

		} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
			return round($bytes / $kilobyte, $precision) . ' KB';

		} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
			return round($bytes / $megabyte, $precision) . ' MB';

		} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
			return round($bytes / $gigabyte, $precision) . ' GB';

		} elseif ($bytes >= $terabyte) {
			return round($bytes / $terabyte, $precision) . ' TB';
		} else {
			return $bytes . ' B';
		}
	}
    
    /**
	 * Versione generica Metodo riscrittura url
	 */
	public function rewriteUrl( $string, $version = 1, $options = false ) {
        switch($version) {
            case 1:
                return $this->rewriteUrl_v1($string, $options);
            break;
            case 2:
                return $this->rewriteUrl_v2($string, $options);
            break;
        }    
    }
       
    public function getNameImageProduct( $string ) {
        return $this->rewriteUrl( $string );
    }
    
    /**
	 * Versione 1 Metodo riscrittura url
	 */
	public function rewriteUrl_v1( $string, $options = false ) {
		$sep = !empty( $options->sep ) ? $options->sep : '_';
		$string = trim( $string );
		$string = strip_tags( $string );
		$string = str_replace( array( 'à','á','é','è','í','ì','ó','ò','ú','ù', 'ä', 'ö', 'ü', 'ë' ),array( 'a','a','e','e','i','i','o','o','u','u','a','o','u', 'e' ), $string ); 
		$string = str_replace( array( 'À','Á','É','È','Í','Ì','Ó','Ò','Ú','Ù','Ä','Ü','Ö','ß' ),array( 'A','A','E','E','I','I','O','O','U','U','A','U','O','B' ), $string );
		$string = preg_replace( '/[^\w\s]+/', $sep, $string);
		$string = str_replace( '/', $sep, $string );
		$string = preg_replace( '/-+/', $sep, $string );
		$string = preg_replace( '/-$/', $sep, $string );
		$string = str_replace( '-', $sep, $string );
		$string = str_replace( ' ', $sep, $string );
		$string = preg_replace( '/['.$sep.']+/', $sep,$string );
		$string = trim( $string, $sep );
		$string = strtolower( $string );	
		return $string; 
	}
	
	/**
	 * Versione 2 Metodo riscrittura url
	 */
    public function rewriteUrl_v2( $string, $options = false ) {        
		$sep = !empty( $options->sep ) ? $options->sep : '_';
		$string = trim( $string );
		$string = strip_tags( $string );
		$string = preg_replace( '/[^a-zA-Z0-9àáéèíìóòúùäöüëÀÁÉÈÍÌÓÒÚÙÄÜÖ\s]+/', $sep, $string );
        $string = preg_replace( '/[^\w\s]+/', $sep, $string);
		$string = str_replace( '\/', $sep, $string );
		$string = preg_replace( '/-+/', $sep, $string );
		$string = preg_replace( '/-$/', $sep, $string );
		$string = str_replace( '-', $sep, $string );
		$string = str_replace( ' ', $sep, $string );
		$string = preg_replace( '/['.$sep.']+/', $sep,$string );
		$string = trim( $string, $sep );
		$string = strtolower( $string );	       
		return $string; 
	}
    
    /**
	 * Metodo di decodifica della rewriteUrl
	 */
    public function decodeRewriteUrl($string) {
         $string= str_replace("_", " ", $string);
         $string = preg_replace('/(?<=team )\d+/u', '', $string);
         $string = ucwords($string);
        return $string;
    }
    
   
}//End Class


//$keyB = false;
//foreach( $initTmplate AS $item ) {
//    if( strpos( ' '.$item, '[LABEL]' ) !== FALSE ) {
//        $aItem = explode( '[#]', $item );
//        $keyB = trim( str_replace( '[LABEL]', '', $aItem[1] ) );
//        continue;
//    }
//    $aItem = explode( '[#]', $item );
//    print_r($aItem);
//    if( !empty( $aItem[1] ) )
//        $brefing[$keyB][] = $aItem[1];                
//} 
//
//foreach( $elements AS $element ) {
//    $th = $xpath->query( "th", $element );
//    if( $th->length == 0 ) {
//        return;
//    }
//    $td = $xpath->query( "td", $element );
//    if( $td->length == 0 ) {
//        return;
//    }                                
//
//    $accept['Lettore di schede di memoria'] = 'Schede di memoria';
//    $accept['Dimensioni RAM'] = 'RAM';
//    $accept['Bluetooth'] = 'Bluetooth';
//    $accept['Comunicazione'] = 'Comunicazione';
//    $accept['Capacità della batteria'] = 'Alimentazione';
//    $accept['Connettore dati'] = 'Connettore';
//    $accept['Memorizzazione'] = 'Memorizzazione';
//    $accept['Dimensioni'] = 'Dimensioni';
//    $accept['Peso del prodotto'] = 'Peso';
//
//    $tdValue = trim( str_replace( array( 'Suggerisci una modifica', '&nbsp;' ), array(' ') , $td[0]->nodeValue ) )  ;
//    $tdValue = preg_replace("/[^A-Za-z0-9àòùèì]/", '', $tdValue);
//    $thValue = trim( preg_replace("/[^A-Za-z0-9àòùèì ]/", '', $th[0]->nodeValue) );
//
//
////                echo $thValue.'<br>;';
//    if( !empty( $accept[$thValue] ) ) {
////                    if(  !empty( $tdValue ) ) {                
////                        $text .= $accept[$thValue].':'.$tdValue.';';
////                    } else {
////                        $text .= $accept[$thValue].';';
////                    }
//
//        foreach ( $brefing AS &$item ) {
//            foreach ( $item AS $key => &$value) {
//                if( $key == $accept[$thValue] ) {                                
//                    $item[$key] = $tdValue;
//                }
//            }                   
//        }
//    }
//}
//
//foreach ( $brefing AS $key2 => &$item ) {
//    $text .= $key2.';';
//    foreach ( $item AS $key => &$value) {                                                
//        $text .= $key.':'.preg_replace("/[^A-Za-z0-9 ]/", '', $value ).';';                    
//    }                   
//}