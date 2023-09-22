<?php

namespace AppBundle\Service\AmazonService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;

class AmazonApi {
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
        $this->spiderAmazon = $this->container->get('app.SpiderAmazon');
    }

    public function getManualProduct( $ASIN ) {
//        $params = array(
//            "Service" => "AWSECommerceService",
//            "Operation" => "ItemLookup",
//            "AWSAccessKeyId" => $this->accessKeyId,
//            "AssociateTag" => "offerteprezzi87-21",
//            "ItemId" => $ASIN,
//            "IdType" => "ASIN",
//            "ResponseGroup" => "Images,ItemAttributes,Offers",
//        );
//                
//        // Set current timestamp if not set
//        if (!isset($params["Timestamp"])) {
//            $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
//        }
//
//        // Sort the parameters by key
//        ksort($params);
//
//        $pairs = array();
//
//        foreach ($params as $key => $value) {
//            array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
//        }
//
//        // Generate the canonical query
//        $canonical_query_string = join("&", $pairs);
//
//        // Generate the string to be signed
//        $string_to_sign = "GET\n".$this->endpoint."\n".$this->uri."\n".$canonical_query_string;
//  
//       // Generate the signature required by the Product Advertising API
//        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this->secret_key, true));
//
//        // Generate the signed URL
//        echo $request_url = 'http://'.$this->endpoint.$this->uri.'?'.$canonical_query_string.'&Signature='.$signature;
//        
//        $document = @simplexml_load_file($request_url, 'SimpleXMLElement', LIBXML_NOCDATA);
//        
//        $resultsAws = array();
//        $resultsAws['products'] = false; 
//        $resultsAws['extraModel'] = false; 
//        $resultsAws['model'] = false;
//        $result['title']    = (string)$document->Items->Item->ItemAttributes->Title;
//        $result['deepLink'] = (string)$document->Items->Item->DetailPageURL;
//        $result['impressTo'] = md5( (string)$document->Items->Item->DetailPageURL );
//        $result['ASIN'] = (string)$ASIN;
//        $result['ean'] = (string)$document->Items->Item->ItemAttributes->EAN;
//        
//        $result['price'] = 0;
//        
//        //prova a recuperare il prezzo dal formatted price        
//        if( !empty( $document->Items->Item[0]->OfferSummary ) && !empty( $document->Items->Item[0]->OfferSummary->LowestNewPrice[0]->FormattedPrice ) ) {
//            $result['price'] = str_replace( array( 'EUR', '.',','), array('','','.'), $document->Items->Item[0]->OfferSummary->LowestNewPrice[0]->FormattedPrice );            
//            
//        } else if( !empty( $document->Items->Item[0]->Offers ) && !empty( $document->Items->Item[0]->Offers->Offer[0]->OfferListing ) ) {
//            $result['price'] = str_replace( array( 'EUR', '.',','), array('','','.'), $document->Items->Item[0]->Offers->Offer[0]->OfferListing[0]->Price[0]->FormattedPrice );
//        }  
//                
////        if( !empty( $document->Items->Item->Offers->Offer[0]->OfferListing ) ) {
////            $result['price'] = (int)str_replace( array( 'EUR',',', '.'), array('','.','.'), $document->Items->Item->Offers->Offer[0]->OfferListing[0]->Price[0]->FormattedPrice );
////        } else {
////            
////        }
//        
//        $result['shippingCost'] = 0;
//        return json_encode($result );
                        
        $response = $this->getInitSearchGlobalAmazon( $ASIN );
        if( empty ( $response )) {
            return false;
        }
        
        $response = json_decode( $response, true );
        $response = $response['ItemsResult']['Items'][0];
        
        
        $resultsAws = array();
        $resultsAws['products'] = false; 
        $resultsAws['extraModel'] = false; 
        $resultsAws['model'] = false;
        $result['title']    = (string)$response['ItemInfo']['Title']['DisplayValue'];
        $result['deepLink'] = (string)$response['DetailPageURL'];
        $result['impressTo'] = md5( (string)$response['DetailPageURL'] );
        $result['ASIN'] = (string)$ASIN;
        $result['ean'] = !empty( $response['ItemInfo']['ExternalIds']) ?  (string)$response['ItemInfo']['ExternalIds']['EANs']['DisplayValues'][0] : '';
        
        $result['price'] = 0;
        
        //prova a recuperare il prezzo dal formatted price        
        if( !empty( $response['Offers']['Listings'][0]['Price']['Amount']  ) ) {
            $result['price'] =  $response['Offers']['Listings'][0]['Price']['Amount'] ;
            
        } else if( !empty( $response['Offers']['Summaries'][0]['LowestPrice']['Amount'] ) ) {
            $result['price'] = $response['Offers']['Summaries'][0]['LowestPrice']['Amount'];
        }
                
//        if( !empty( $document->Items->Item->Offers->Offer[0]->OfferListing ) ) {
//            $result['price'] = (int)str_replace( array( 'EUR',',', '.'), array('','.','.'), $document->Items->Item->Offers->Offer[0]->OfferListing[0]->Price[0]->FormattedPrice );
//        } else {
//            
//        }
        
        $result['shippingCost'] = 0;
        return json_encode($result );
    }
    
    public function getInitSearchGlobalAmazon( $ASIN ) {
        $serviceName="ProductAdvertisingAPI";
        $region="eu-west-1";
        $accessKey="AKIAJQXGXEZE3SBVHWYQ";
        $secretKey= $this->secret_key;
        $payload="{"
                ." \"ItemIds\": ["
                ."  \"$ASIN\""
                ." ],"
                ." \"Resources\": ["
                ."  \"ItemInfo.ExternalIds\","
                ."  \"ItemInfo.Title\","
                ."  \"Offers.Listings.DeliveryInfo.IsPrimeEligible\","
                ."  \"Offers.Listings.Price\","
                ."  \"Offers.Summaries.LowestPrice\""
                ." ],"
                ." \"PartnerTag\": \"offerteprezzi87-21\","
                ." \"PartnerType\": \"Associates\","
                ." \"Marketplace\": \"www.amazon.it\""
                ."}";
        $host="webservices.amazon.it";
        $uriPath="/paapi5/getitems";
        $awsv4 = new AwsV4 ($accessKey, $secretKey);
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath ($uriPath);
        $awsv4->setPayload ($payload);
        $awsv4->setRequestMethod ("POST");
        $awsv4->addHeader ('content-encoding', 'amz-1.0');
        $awsv4->addHeader ('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader ('host', $host);
        $awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.GetItems');
        $headers = $awsv4->getHeaders ();
        $headerString = "";
        foreach ( $headers as $key => $value ) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }
        $params = array (
                'http' => array (
                    'header' => $headerString,
                    'method' => 'POST',
                    'content' => $payload
                )
            );
        $stream = stream_context_create ( $params );

        $fp = fopen ( 'https://'.$host.$uriPath, 'rb', false, $stream );

        if (! $fp) {
            return false;
        }
        $response = @stream_get_contents ( $fp );
        if ($response === false) {
            return false;
        }
        return $response;
    }
    
    
    public function getUpdateProduct( $ASIN ) {
////        $params = array(
////            "Service" => "AWSECommerceService",
////            "Operation" => "ItemLookup",
////            "AWSAccessKeyId" => $this->accessKeyId,
////            "AssociateTag" => "offerteprezzi87-21",
////            "ItemId" => $ASIN,
////            "IdType" => "ASIN",
////            "ResponseGroup" => "Images,ItemAttributes,Offers",
////        );
////                
////        // Set current timestamp if not set
////        if (!isset($params["Timestamp"])) {
////            $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
////        }
////
////        // Sort the parameters by key
////        ksort($params);
////
////        $pairs = array();
////
////        foreach ($params as $key => $value) {
////            array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
////        }
////
////        // Generate the canonical query
////        $canonical_query_string = join("&", $pairs);
////
////        // Generate the string to be signed
////        $string_to_sign = "GET\n".$this->endpoint."\n".$this->uri."\n".$canonical_query_string;
////
////        // Generate the signature required by the Product Advertising API
////        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this->secret_key, true));
////
////        // Generate the signed URL
////        echo $request_url = 'http://'.$this->endpoint.$this->uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
////        
////        $document = @simplexml_load_file($request_url, 'SimpleXMLElement', LIBXML_NOCDATA);
////        $resultsAws = array();
////        $resultsAws['products'] = false;
////        $resultsAws['extraModel'] = false;
////        $resultsAws['model'] = false;
////        
////        $aPrices = array();
////        $x = 0;
////        if( empty( $document ) ) {
////            return false;
////        }
//        
//        //prova a recuperare il prezzo dal formatted price        
//        if( !empty( $document->Items->Item[0]->OfferSummary ) && !empty( $document->Items->Item[0]->OfferSummary->LowestNewPrice[0]->FormattedPrice ) ) {
//            echo "\nDA FormattedPrice\n";
//            return str_replace( array( 'EUR', '.',','), array('','','.'), $document->Items->Item[0]->OfferSummary->LowestNewPrice[0]->FormattedPrice );            
//        }
//        
//        //prova a recuperqare il prezzo dal campo offert
//        if( !empty( $document->Items->Item[0]->Offers ) && !empty( $document->Items->Item[0]->Offers->Offer[0]->OfferListing ) ) {
//            echo "\nDA OfferListing\n";
//            return str_replace( array( 'EUR', '.',','), array('','','.'), $document->Items->Item[0]->Offers->Offer[0]->OfferListing[0]->Price[0]->FormattedPrice );
//        }  
        
        
        $response = $this->getInitSearchGlobalAmazon( $ASIN );
        if( empty ( $response )) {
            return false;
        }
        
        $response = json_decode( $response, true );
        
        if( !empty( $response['Errors'] ) ) {            
            $this->spiderAmazon->removeProductAmazon( $ASIN );       
            return false;
        }
        
        
        if( empty( $response['ItemsResult'] ) ) {           
            return false;
        }
//        $response = $response['ItemsResult']['Items'][0];
        return $response;                        
                
    }
    
     public function getSearchReview( $search ) {        
        $params = array(
            "Service" => "AWSECommerceService",
            "Operation" => "ItemSearch",
            "AWSAccessKeyId" => $this->accessKeyId,
            "AssociateTag" => "offerteprezzi87-21",
            "SearchIndex" => "All",
            "ResponseGroup" => "Reviews",
            "Keywords" => $search,
        );
                
           // Set current timestamp if not set
        if (!isset($params["Timestamp"])) {
            $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
        }

        // Sort the parameters by key
        ksort($params);

        $pairs = array();

        foreach ($params as $key => $value) {
            array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
        }

        // Generate the canonical query
        $canonical_query_string = join("&", $pairs);

        // Generate the string to be signed
        $string_to_sign = "GET\n".$this->endpoint."\n".$this->uri."\n".$canonical_query_string;

        // Generate the signature required by the Product Advertising API
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this->secret_key, true));

        // Generate the signed URL
        $request_url = 'http://'.$this->endpoint.$this->uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
//
//        echo "Signed URL: \"".$request_url."\"";
        
        $document = @simplexml_load_file($request_url, 'SimpleXMLElement', LIBXML_NOCDATA);
        if( !empty( $document->Items->Item->CustomerReviews ) ) {
            return $document->Items->Item->CustomerReviews->IFrameURL;
        } else {
            return false;
        }
     }
    
    public function getSearch( $search, $advisedPrice, $model, $insert = false  ) {
        $minPrice = 1;
        $maxPrice = 3000;        
        
        if( !empty( $model->price )  || !empty( $advisedPrice ) ) {
            
            if( method_exists( $model, 'getId') )                    
                $minPrice = !empty( $model->getPrice() ) ? (int)$model->getPrice() - ( (int)$model->getPrice() / 100 ) * 20 : (int)$advisedPrice - ( (int)$advisedPrice / 100 ) * 20;
            else
                $minPrice = !empty( $model->price ) ? (int)$model->price - ( (int)$model->price / 100 ) * 20 : (int)$advisedPrice - ( (int)$advisedPrice / 100 ) * 20;
        }
        $minPrice = (int)$minPrice;        
        
        $params = array(
            "Service" => "AWSECommerceService",
            "Operation" => "ItemSearch",
            "AWSAccessKeyId" => $this->accessKeyId,
            "AssociateTag" => "offerteprezzi87-21",
            "SearchIndex" => "All",
            "ResponseGroup" => "Images,ItemAttributes,Offers,Reviews",
            "Keywords" => $search,
            "MinimumPrice" => $minPrice."00"
        );
                
        // Set current timestamp if not set
        if (!isset($params["Timestamp"])) {
            $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
        }

        // Sort the parameters by key
        ksort($params);

        $pairs = array();

        foreach ($params as $key => $value) {
            array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
        }

        // Generate the canonical query
        $canonical_query_string = join("&", $pairs);

        // Generate the string to be signed
        $string_to_sign = "GET\n".$this->endpoint."\n".$this->uri."\n".$canonical_query_string;

        // Generate the signature required by the Product Advertising API
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this->secret_key, true));

        // Generate the signed URL
        $request_url = 'http://'.$this->endpoint.$this->uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
//
//        echo "Signed URL: \"".$request_url."\"";
////        
        
        $document = @simplexml_load_file($request_url, 'SimpleXMLElement', LIBXML_NOCDATA);
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
        foreach( $document->Items->Item AS $item ) {
                                    
            if( empty( $item->Offers->Offer ) )
                continue;
            
            if( $x == 4 )
                break;            
            
            
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
                $titleSearch =  substr( $item->ItemAttributes->Title, 0, strlen( $search ) + 75 );
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
                    $titleSearch =  substr( $item->ItemAttributes->Title, 0, strlen( $search ) + 75 );
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
                $resultsAws['model']['shortDescription']            = $item->ItemAttributes->Title;
                $resultsAws['model']['longDescription']             = '';                
                $resultsAws['model']['img']                         = $item->MediumImage->URL;
                $resultsAws['model']['imgExternal']                         = true;
                $resultsAws['model']['widthSmall']                  = $item->MediumImage->Width;
                $resultsAws['model']['heightSmall']                 = $item->MediumImage->Height;                

                $resultsAws['extraModel']['technicalSpecifications']     = '';
                $resultsAws['extraModel']['bulletPoints'] = false;
                foreach( $item->ItemAttributes->Feature As $feauture ) {
                    if( !empty( $feauture ) )
                        $resultsAws['extraModel']['bulletPoints'][] = $feauture;
                }
            }                                    
            
            $ASIN =  $item->ASIN;
            $resultsAws['products'][$x]['ASIN']                             = (string)$ASIN;
            $resultsAws['products'][$x]['ean']                             = (string)$item->ItemAttributes->EAN;
            $resultsAws['products'][$x]['description']                      = '';
            $resultsAws['products'][$x]['affiliation']['img']               = '3/f/5/2/3.jpg';
            $resultsAws['products'][$x]['affiliation']['name']              = 'Amazon';
            $resultsAws['products'][$x]['affiliation']['widthSmall']        = 160;
            $resultsAws['products'][$x]['affiliation']['heightSmall']       = 160;
            $resultsAws['products'][$x]['affiliation']['payments']          = json_decode( '["visa","mastercard","americanExpress","paypal","postpay"]' );
            $resultsAws['products'][$x]['affiliation']['contact']           = '';
            
            $resultsAws['products'][$x]['name']                             = $item->ItemAttributes->Title;
            if( !empty( $item->Offers->Offer ) ) {   
                $resultsAws['products'][$x]['price']                            = (int)str_replace( array( 'EUR', '.'), '', $item->Offers->Offer[0]->OfferListing[0]->Price[0]->FormattedPrice );
                $resultsAws['products'][$x]['prime']                            = $item->Offers->Offer[0]->OfferListing[0]->IsEligibleForPrime;
                $resultsAws['products'][$x]['merchantName']                     = $item->Offers->Offer[0]->Merchant->Name;
                $aPrices[$x] = $resultsAws['products'][$x]['price'] ;
                
            } else {
                $resultsAws['products'][$x]['price']                            = '';
                $resultsAws['products'][$x]['prime']                            = false;
                $resultsAws['products'][$x]['merchantName']                     = '';                
            }
            
            if( !empty( $resultsAws['products'][$x]['prime'] ) ) {
                $resultsAws['products'][$x]['affiliation']['img']               = 'c/b/0/4/4.jpg';
                $resultsAws['products'][$x]['affiliation']['name']              = 'Amazon Prime';
                $resultsAws['products'][$x]['affiliation']['widthSmall']        = 80;
                $resultsAws['products'][$x]['affiliation']['heightSmall']       = 33;
                
            } else {
                $resultsAws['products'][$x]['affiliation']['img']               = '3/f/5/2/3.jpg';
                $resultsAws['products'][$x]['affiliation']['name']              = 'Amazon';
                $resultsAws['products'][$x]['affiliation']['widthSmall']        = 80;
                $resultsAws['products'][$x]['affiliation']['heightSmall']       = 23;
            }
            
            
            $resultsAws['products'][$x]['handlingCost']                     = 0;
            $resultsAws['products'][$x]['sizeStockStatus']                  = '';
            $resultsAws['products'][$x]['deepLink']                         = $item->DetailPageURL;
            $resultsAws['products'][$x]['impressionLink']                   = false;
            $resultsAws['products'][$x]['merchantImg']                      = false;
            
            $resultsAws['products'][$x]['priorityImg']['img']               = $item->MediumImage->URL;
            $resultsAws['products'][$x]['priorityImg']['widthSmall']        = $item->MediumImage->Width;
            $resultsAws['products'][$x]['priorityImg']['heightSmall']       = $item->MediumImage->Height;
            $resultsAws['products'][$x]['priorityImg']['imgExternal']       = true;
            
            $resultsAws['products'][$x]['images'][0]['img']                 = $item->MediumImage->URL;
            $resultsAws['products'][$x]['images'][0]['imgExternal']         = true;
            $resultsAws['products'][$x]['images'][0]['widthSmall']          = $item->MediumImage->Width;
            $resultsAws['products'][$x]['images'][0]['heightSmall']         = $item->MediumImage->Height;
            
            if( !empty( $item->Offers->Offer ) ) {                
//                echo $item->Offers->Offer[0]->OfferListing[0]->Price[0]->FormattedPrice."<br>";
//                echo $item->Offers->Offer[0]->OfferListing[0]->Availability."<br>";
//                echo $item->Offers->Offer[0]->OfferListing[0]->IsEligibleForPrime."<br>";
            }
//            echo "<br><br>";
            $x++;
        }               
        
        
        if( !empty( $resultsAws['products'] ) ) {
            usort( $resultsAws['products'], function($a, $b) { //Sort the array using a user defined function
                return ( $a['price'] > $b['price'] );
            });
        }                
        
        if( !empty( $aPrices ) ) {                             
            sort($aPrices );
            $minPrice = $aPrices[0];                
            $maxPrice = (int)end( $aPrices );
                        
            //rimuove il prodotto se si discosta piu del 50% da quello più alto
            foreach( $resultsAws['products'] as $key => $product ) {
                $percMax = (int)( $maxPrice / 100 ) * 50;
                if( $product['price'] < $percMax ) {
                    unset( $resultsAws['products'][$key] );                    
                    unset( $aPrices[$key] );                    
                }
            }
            $resultsAws['products'] = array_values($resultsAws['products']);
            $aPrices = array_values($aPrices);
            
            sort($aPrices );
            $minPrice = $aPrices[0];                
            $maxPrice = (int)end( $aPrices );

            if( !empty( $item->Offers->Offer ) ) {   
                $resultsAws['model']['price']                   = $minPrice;
            } else {
                $resultsAws['model']['price']                   = false;
            }
            $difference = $maxPrice - $minPrice;
         
            if( $difference >= 2 ) {            
//                $resultsAws['model']['advisedPrice'] = !empty( $advisedPrice ) ? (int)$advisedPrice : $maxPrice - rand( 0, $difference - 2 );
                $resultsAws['model']['advisedPrice'] = !empty( $advisedPrice ) ? (int)$advisedPrice : $maxPrice + rand( 10, 50  );
                $resultsAws['extraModel']['saving'] =  $resultsAws['model']['advisedPrice'] - $minPrice;
                
            } else {
                $resultsAws['model']['advisedPrice'] = !empty( $advisedPrice ) ? (int)$advisedPrice : $maxPrice + rand( 10, 50  );
                $resultsAws['extraModel']['saving'] =  $resultsAws['model']['advisedPrice'] - $minPrice;
            }
        }
        
        if( $insert ) {
            $this->spiderAmazon = $this->container->get('app.SpiderAmazon');
            
            $sCost = 0;
            $this->product = new \stdClass;
            //Valorizzazioni dati
            $price                           = (string)$resultsAws['products'][0]['price'];
            $this->product->description      = '';
            $this->product->fkTrademark      = !empty( $model->getTrademark() ) ? $model->getTrademark()->getId() : 'NULL';
            $this->product->fkCategory       = !empty( $model->getCategory() ) ? $model->getCategory()->getId() : 'NULL';
            $this->product->fkSubcategory    = !empty( $model->getSubcategory() ) ? $model->getSubcategory()->getId() : 'NULL';        		
            $this->product->price            = !empty( $price ) ? $this->controlDataInsert( (string)$price ) : 'NULL';        
            $this->fkSubcatAffiliation       = 'NULL';
            $this->product->fkTypology       = !empty( $model->getTypology() ) ? $model->getTypology()->getId() : 'NULL';
            $this->product->nameProduct      = $this->controlDataInsert( (string) $resultsAws['products'][0]['name'] );
            $this->product->orderProduct     = 0;
            $this->product->number           = (string)$resultsAws['products'][0]['ASIN'];
            $this->product->dataImport       = date('Y-m-d H:i:s');
            $this->product->lastModified     = date('Y-m-d H:i:s');
            $this->product->lowestPrices     = 1;
            $this->product->hasOtherProducts = 0;				
            $this->product->shippingHandlingCosts = $sCost;
            $this->product->deliveryTime     = null;
            $this->product->stockAmount      = 0;
            $this->product->ean              = (string)$resultsAws['products'][0]['ean'];
            $this->product->sizeStockStatus  = 'in stock';
            $this->product->fkAffiliation    = !empty( $resultsAws['products'][$x]['prime'] ) ? 4 : 3;
            $this->product->deepLink         = $resultsAws['products'][0]['deepLink'];
            $this->product->impression_link  = md5( $resultsAws['products'][0]['deepLink'] );
            $this->product->modelId          = $model->getId();
            $this->product->modelName        = $model->getName();
            $this->product->shortDescription = false;


            //Setta json per storico prezzi
            $prices[] = trim( $price );
            $this->product->pricesJson = json_encode( $prices );		

            $advisedPrice = (int)$price + rand( 10,30)."\n";
            
             $this->product->bulletPointsString = '';
            
            if( !empty( $resultsAws['extraModel']['bulletPoints'] ) ) {
                $b = 0;
                foreach( $resultsAws['extraModel']['bulletPoints'] AS $bulletPoint ) {
                    if( $b >=4 )
                        continue;
                    
                    $this->product->bulletPointsString .= $bulletPoint[0].";";
                    $b++;
                }
                $this->product->bulletPointsString = trim( $this->product->bulletPointsString, ';' );
            }            
            $this->product->shortDescription = !empty( $resultsAws['model']['shortDescription'] ) ? $resultsAws['model']['shortDescription'][0] : false;
            
            
            $imagesProduct = $resultsAws['products'][0]['priorityImg']['img'];
            
            $dbHost = $this->container->getParameter('database_host');
            $dbName = $this->container->getParameter('database_name');
            $dbUser = $this->container->getParameter('database_user');
            $dbPswd = $this->container->getParameter('database_password');
            $dbPort = $this->container->getParameter('database_port');
            $this->spiderAmazon->run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, false  );

            $this->spiderAmazon->offDebug();            
            $this->spiderAmazon->setProduct( $this->product );       
            $this->spiderAmazon->insertProduct( $imagesProduct, $model, $advisedPrice );
         
        }
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

class AwsV4 {

    private $accessKey = null;
    private $secretKey = null;
    private $path = null;
    private $regionName = null;
    private $serviceName = null;
    private $httpMethodName = null;
    private $queryParametes = array ();
    private $awsHeaders = array ();
    private $payload = "";

    private $HMACAlgorithm = "AWS4-HMAC-SHA256";
    private $aws4Request = "aws4_request";
    private $strSignedHeader = null;
    private $xAmzDate = null;
    private $currentDate = null;

    public function __construct($accessKey, $secretKey) {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->xAmzDate = $this->getTimeStamp ();
        $this->currentDate = $this->getDate ();
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setServiceName($serviceName) {
        $this->serviceName = $serviceName;
    }

    function setRegionName($regionName) {
        $this->regionName = $regionName;
    }

    function setPayload($payload) {
        $this->payload = $payload;
    }

    function setRequestMethod($method) {
        $this->httpMethodName = $method;
    }

    function addHeader($headerName, $headerValue) {
        $this->awsHeaders [$headerName] = $headerValue;
    }

    private function prepareCanonicalRequest() {
        $canonicalURL = "";
        $canonicalURL .= $this->httpMethodName . "\n";
        $canonicalURL .= $this->path . "\n" . "\n";
        $signedHeaders = '';
        foreach ( $this->awsHeaders as $key => $value ) {
            $signedHeaders .= $key . ";";
            $canonicalURL .= $key . ":" . $value . "\n";
        }
        $canonicalURL .= "\n";
        $this->strSignedHeader = substr ( $signedHeaders, 0, - 1 );
        $canonicalURL .= $this->strSignedHeader . "\n";
        $canonicalURL .= $this->generateHex ( $this->payload );
        return $canonicalURL;
    }

    private function prepareStringToSign($canonicalURL) {
        $stringToSign = '';
        $stringToSign .= $this->HMACAlgorithm . "\n";
        $stringToSign .= $this->xAmzDate . "\n";
        $stringToSign .= $this->currentDate . "/" . $this->regionName . "/" . $this->serviceName . "/" . $this->aws4Request . "\n";
        $stringToSign .= $this->generateHex ( $canonicalURL );
        return $stringToSign;
    }

    private function calculateSignature($stringToSign) {
        $signatureKey = $this->getSignatureKey ( $this->secretKey, $this->currentDate, $this->regionName, $this->serviceName );
        $signature = hash_hmac ( "sha256", $stringToSign, $signatureKey, true );
        $strHexSignature = strtolower ( bin2hex ( $signature ) );
        return $strHexSignature;
    }

    public function getHeaders() {
        $this->awsHeaders ['x-amz-date'] = $this->xAmzDate;
        ksort ( $this->awsHeaders );

        // Step 1: CREATE A CANONICAL REQUEST
        $canonicalURL = $this->prepareCanonicalRequest ();

        // Step 2: CREATE THE STRING TO SIGN
        $stringToSign = $this->prepareStringToSign ( $canonicalURL );

        // Step 3: CALCULATE THE SIGNATURE
        $signature = $this->calculateSignature ( $stringToSign );

        // Step 4: CALCULATE AUTHORIZATION HEADER
        if ($signature) {
            $this->awsHeaders ['Authorization'] = $this->buildAuthorizationString ( $signature );
            return $this->awsHeaders;
        }
    }

    private function buildAuthorizationString($strSignature) {
        return $this->HMACAlgorithm . " " . "Credential=" . $this->accessKey . "/" . $this->getDate () . "/" . $this->regionName . "/" . $this->serviceName . "/" . $this->aws4Request . "," . "SignedHeaders=" . $this->strSignedHeader . "," . "Signature=" . $strSignature;
    }

    private function generateHex($data) {
        return strtolower ( bin2hex ( hash ( "sha256", $data, true ) ) );
    }

    private function getSignatureKey($key, $date, $regionName, $serviceName) {
        $kSecret = "AWS4" . $key;
        $kDate = hash_hmac ( "sha256", $date, $kSecret, true );
        $kRegion = hash_hmac ( "sha256", $regionName, $kDate, true );
        $kService = hash_hmac ( "sha256", $serviceName, $kRegion, true );
        $kSigning = hash_hmac ( "sha256", $this->aws4Request, $kService, true );

        return $kSigning;
    }

    private function getTimeStamp() {
        return gmdate ( "Ymd\THis\Z" );
    }

    private function getDate() {
        return gmdate ( "Ymd" );
    }
}
