<?php

namespace AppBundle\Service\EbayService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;

class EbayApi {
    private $container;
    private $doctrine;
    private $prxC; 
   
    private $accessKeyId = "AKIAJQXGXEZE3SBVHWYQ";
    private $secret_key = "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";
    private $endpoint = "webservices.amazon.it";
    private $uri = "/onca/xml";
        
    public function __construct( ObjectManager $doctrine, Container $container, GlobalUtility $globalUtility ) {
        $this->doctrine = $doctrine;
        $this->container = $container;  
        $this->globalUtility = $globalUtility; 
    }

    /**
     * Metodo che recupera un prodotto tramite l'id del prodotto di ebay per verificare i cambiamento di prezzo
     * @param type $ASIN
     * @return boolean
     */
    public function getManualProduct( $ASIN ) {
         $request_url = 'https://svcs.ebay.com/services/search/FindingService/v1?'
                . 'OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0'
                . '&GLOBAL-ID=EBAY-IT'
                . '&SECURITY-APPNAME=Alessand-Offertep-PRD-18bba853c-44c9e593'
                . '&keywords='.$ASIN.'' 
                . '&affiliate.networkId=9'
                . '&affiliate.trackingId=5338343180'
                . '&RESPONSE-DATA-FORMAT=XML';
        
        
        $document = @simplexml_load_file($request_url, 'SimpleXMLElement', LIBXML_NOCDATA);
        if( empty( $document ) || empty( $document->searchResult['count'] ) ) {
            return false;
        }          
        
        $result['title']    = (string)$document->searchResult->item->title;
        $result['deepLink'] = (string)$document->searchResult->item->viewItemURL;
        $result['impressTo'] = md5( (string)$document->searchResult->item->viewItemURL );
        $result['ASIN'] = (string)$ASIN;
        $result['price'] = (int)str_replace( array( 'EUR',',', '.'), array('','.','.'), $document->searchResult->item->sellingStatus->currentPrice );
        $result['shippingCost'] = (int)str_replace( array( 'EUR',',', '.'), array('','.','.'), $document->searchResult->item->shippingInfo->shippingServiceCost );
        return json_encode($result );
        
        
        exit;
    }
    
    /**
     * Metodo che recupera un prodotto tramite l'id del prodotto di ebay per verificare i cambiamento di prezzo
     * @param type $ASIN
     * @return boolean
     */
    public function getUpdateProduct( $ASIN ) {
        $request_url = 'https://svcs.ebay.com/services/search/FindingService/v1?'
                . 'OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0'
                . '&GLOBAL-ID=EBAY-IT'
                . '&SECURITY-APPNAME=Alessand-Offertep-PRD-18bba853c-44c9e593'
                . '&keywords='.$ASIN.'' 
                . '&affiliate.networkId=9'
                . '&affiliate.trackingId=5338343180'
                . '&RESPONSE-DATA-FORMAT=XML';
        
        
        $document = @simplexml_load_file($request_url, 'SimpleXMLElement', LIBXML_NOCDATA);
        if( empty( $document ) || empty( $document->searchResult['count'] ) ) {
            return false;
        }          
        
        $aPrices = array();
        $x = 0;
        if( empty( $document ) ) {
            return false;
        }
        
        if( !empty( $document->searchResult ) && !empty( $document->searchResult->item ) && !empty( $document->searchResult->item->sellingStatus ) ) {
            return (float)$document->searchResult->item->sellingStatus->currentPrice;
        }
    }
    
    /**
     * Metodo che effettua la ricerca su ebay di un modello e ne restituisce il risultato
     * @param type $search
     * @param type $advisedPrice
     * @param type $model
     * @param type $insert
     * @return boolean
     */
    public function getSearch( $search, $advisedPrice, $model, $insert = false  ) {                
        $minPrice = 1;
        $maxPrice = 5000;        
        
        if( !empty( $model->price )  || !empty( $advisedPrice ) ) {
            
            if( method_exists( $model, 'getId') )                    
                $minPrice = !empty( $model->getPrice() ) ? (int)$model->getPrice() - ( (int)$model->getPrice() / 100 ) * 20 : (int)$advisedPrice - ( (int)$advisedPrice / 100 ) * 20;
            else
                $minPrice = !empty( $model->price ) ? (int)$model->price - ( (int)$model->price / 100 ) * 20 : (int)$advisedPrice - ( (int)$advisedPrice / 100 ) * 20;
        }
        $minPrice = (int)$minPrice;  
        
        $request_url = 'https://svcs.ebay.com/services/search/FindingService/v1?'
                . 'OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0'
                . '&GLOBAL-ID=EBAY-IT'
                . '&SECURITY-APPNAME=Alessand-Offertep-PRD-18bba853c-44c9e593'
                . '&keywords='.$search.''
                . '&paginationInput.entriesPerPage=1&sortOrder=BestMatch'
                . '&itemFilter(0).name=ListingType&itemFilter(0).value=FixedPrice'
                . '&itemFilter(1).name=MinPrice&itemFilter(1).value='.(int)$minPrice.''
                . '&itemFilter(2).name=MaxPrice&itemFilter(2).value='.(int)$maxPrice.''
                . '&itemFilter(3).name=Condition&itemFilter(3).value=New'
                . '&affiliate.networkId=9'
                . '&affiliate.trackingId=5338343180'
                . '&RESPONSE-DATA-FORMAT=XML';
        
        
        $document = @simplexml_load_file($request_url, 'SimpleXMLElement', LIBXML_NOCDATA);
        if( empty( $document ) || empty( $document->searchResult['count'] ) ) {
            return false;
        }        
        
        $resultsAws = array();
        $resultsAws['products'] = false;
        $resultsAws['extraModel'] = false;
        $resultsAws['model'] = false;
        
        $aPrices = array();
        $x = 0;
        if( empty( $document ) ) {
            return $resultsAws;
        }
                
        $ASIN = false;
        foreach( $document->searchResult->item AS $item ) {                           
            if( empty( $item->sellingStatus->currentPrice ) )
                continue;            
            
            $search = str_replace( 'gb', '', strtolower( $search ) );
            $search = str_replace( '(5g)', '', strtolower( $search ) );
            
            $words = explode( ' ', trim( $search ) );
            $match = 0; 
            
            //Cicla tutte le parole di un modello, e se le trova inctementa i match
            foreach ( $words as $key => $value ) {
                if( empty( $value ) ) {
                    unset($words[$key]);
                    continue;
                }
                $value = str_replace( 'gb', '', strtolower( $value ) );
                $titleSearch =  substr( $item->title, 0, strlen( $search ) + 75 );
                if( strpos( strtolower( ' '.$titleSearch ), strtolower( $value ), '0' ) !== false ) {
                    $match++;
                }                
            }            
            
            if( intval( $match ) != intval( count( $words ) ) ) {
                $match = 0;

                foreach ( $words as $key => $value ) {
                    if( empty( $value ) ) {
                        unset($words[$key]);
                        continue;
                    }
                    $value = str_replace( 'gb', '', strtolower( $value ) );
                    $titleSearch =  substr( $item->title, 0, strlen( $search ) + 75 );
                    if( strpos( strtolower( ' '.str_replace( '-','',$titleSearch ) ), strtolower( $value ), '0' ) !== false ) {
                        $match++;
                    }                
                }
                
                if( intval( $match ) != intval( count( $words ) ) ) {                    
                    continue;
                }
            }

            
            if( $x == 0 ) {
                $resultsAws['model']['name']                        = $search;
                $resultsAws['model']['shortDescription']            = (string)$item->subtitle;
                $resultsAws['model']['longDescription']             = '';                
                $resultsAws['model']['img']                         = !empty( $item->galleryPlusPictureURL ) ? (string)$item->galleryPlusPictureURL : (string)$item->galleryURL;
                $resultsAws['model']['imgExternal']                 = true;
                
                try {
                    $imgSize = getimagesize($resultsAws['model']['img']);       
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                } catch ( \Symfony\Component\Debug\Exception\ContextErrorException $e) {
                    $imgSize = array( 0 => false, 1 => false );
                }
                          
                $resultsAws['model']['widthSmall']                  = $imgSize[0];
                $resultsAws['model']['heightSmall']                 = $imgSize[1];      

                $resultsAws['extraModel']['technicalSpecifications']     = '';
                $resultsAws['extraModel']['bulletPoints'] = false;
//                foreach( $item->ItemAttributes->Feature As $feauture ) {
//                    if( !empty( $feauture ) )
//                        $resultsAws['extraModel']['bulletPoints'][] = $feauture;
//                }
            }           
            
            $ASIN =  $item->itemId;                 
            $resultsAws['products'][$x]['ASIN']                             = (string)$ASIN;
            $resultsAws['products'][$x]['description']                      = '';
            $resultsAws['products'][$x]['affiliation']['img']               = 'e/9/1/2/16.jpg';
            $resultsAws['products'][$x]['affiliation']['name']              = 'Ebay';
            $resultsAws['products'][$x]['affiliation']['widthSmall']        = 160;
            $resultsAws['products'][$x]['affiliation']['heightSmall']       = 69;
            $resultsAws['products'][$x]['affiliation']['payments']          = json_decode( '["visa","mastercard","americanExpress","paypal","postpay"]' );
            $resultsAws['products'][$x]['affiliation']['contact']           = '';
            
            $resultsAws['products'][$x]['name']                             = (string)$item->title;
            if( !empty( $item->sellingStatus->currentPrice ) ) {   
                $resultsAws['products'][$x]['price']                            = (float)$item->sellingStatus->currentPrice;
                $resultsAws['products'][$x]['merchantName']                     = '';
                $aPrices[$x] = $resultsAws['products'][$x]['price'] ;
                
            } else {
                $resultsAws['products'][$x]['price']                            = '';
                $resultsAws['products'][$x]['merchantName']                     = '';                
            }
 
            $resultsAws['products'][$x]['affiliation']['img']               = 'e/9/1/2/16.jpg';
            $resultsAws['products'][$x]['affiliation']['name']              = 'Ebay';
            $resultsAws['products'][$x]['affiliation']['widthSmall']        = 80;
            $resultsAws['products'][$x]['affiliation']['heightSmall']       = 34;           
            
            $resultsAws['products'][$x]['handlingCost']                     = (string)$item->shippingInfo->shippingServiceCost;
            $resultsAws['products'][$x]['sizeStockStatus']                  = $item->sellingStatus->sellingState == 'Active' ? 'in stock' : 'out of stock';
            $resultsAws['products'][$x]['deepLink']                         = (string)$item->viewItemURL;
            $resultsAws['products'][$x]['impressionLink']                   = md5( $item->viewItemURL );
            
            $resultsAws['products'][$x]['priorityImg']['img']               = !empty( $item->galleryPlusPictureURL ) ? (string)$item->galleryPlusPictureURL : (string)$item->galleryURL;
            $resultsAws['products'][$x]['priorityImg']['widthSmall']        = $imgSize[0];
            $resultsAws['products'][$x]['priorityImg']['heightSmall']       = $imgSize[1];
            $resultsAws['products'][$x]['priorityImg']['imgExternal']       = true;
            
            $resultsAws['products'][$x]['images'][0]['img']                 = !empty( $item->galleryPlusPictureURL ) ? (string)$item->galleryPlusPictureURL : (string)$item->galleryURL;
            $resultsAws['products'][$x]['images'][0]['imgExternal']         = true;
            $resultsAws['products'][$x]['images'][0]['widthSmall']          = $imgSize[0];
            $resultsAws['products'][$x]['images'][0]['heightSmall']         = $imgSize[1];            
            $x++;
        }                        
        
        $resultsAws['model']['price']                   = $resultsAws['products'][0]['price'];        
        return $resultsAws;        
    }
   
    /**
	 * Metodo che controlla e sistema i dati perche siano buoni per essere inertiti in query sql
	 * @param type $data
	 */
	public function controlDataInsert($data, $stripTags = true) {
		if ($stripTags)
			$data = strip_tags($data);
    return "'".trim($data)."'";
	}
    
    private function debug( $msg ) {
        echo "\n####################\n";
        echo $msg;        
    }
    
}

#################### 