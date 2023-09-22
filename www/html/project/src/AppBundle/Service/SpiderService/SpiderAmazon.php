<?php

namespace AppBundle\Service\SpiderService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;

class SpiderAmazon {
    private $container;
    private $doctrine;
    private $prxC;
    private $typeCurl = 'proxy';
    private $category_id;
    private $subcategory_id;
    private $typology_id;
    private $trademark_id;
    private $modelId;
    private $debugActive = true;
        
    public function __construct( ObjectManager $doctrine, Container $container, GlobalUtility $globalUtility ) {
        $this->doctrine = $doctrine;
        $this->container = $container; 
        $this->globalUtility = $globalUtility; 
    }

    /**
     * Metodo che elimina le immagini top News quando gli articoli sono stati pubblicati da più di un mese
     */
    public function run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $action ) {
        $this->action       = $action;
        $this->dbHost       = $dbHost;
        $this->dbPort       = $dbPort;
        $this->dbName       = $dbName;
        $this->dbUser       = $dbUser;
        $this->dbPswd       = $dbPswd;
        $this->mySql        = new \PDO('mysql:host='.$dbHost.';port='.$dbPort.';', $dbUser, $dbPswd);
        
//        include( "ProxyConnector/proxyConnector.class.php" );        
//        $this->prxC = proxyConnector::getIstance();
//        $this->prxC->newIdentity();
                
        switch( $action ) {
            case 'getModelEmptyProduct':
                $this->getModelEmptyProduct();
            break;            
            case 'getModelEmptyProductFromAmazonApi':
                $this->getModelEmptyProductFromAmazonApi();
            break;            
            case 'getUpdateProductAsin':
                $this->getUpdateProductAsin();
            break;            
        }
    }
    
    /**
     * Metodo che effettua l'aggiornamento del prezzo di un prodotto amazon
     */
    private function getUpdateProductAsin() {
        $totCallApi = 0;
        $sql = "select count(1) as tot from $this->dbName.products WHERE affiliation_id in (3,4)";
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $count = $sth->fetch( \PDO::FETCH_OBJ );
        print_r($count->tot );
        echo "\n".$sql."\n";
                
        $day = 1;
        $sleep = 5;
        if( $count->tot <= 1000 ) {
            $day = 3;
            $sleep = 10;
        } else if( $count->tot <= 2000 ) {
            $day = 4;
            $sleep = 7;
        } else if( $count->tot <= 3000 ) {
            $day = 6;
            $sleep = 5;
        } else if( $count->tot <= 4000 ) { 
            $day = 8;
            $sleep = 4;
        } else if( $count->tot <= 5000 ) { 
            $day = 10;
            $sleep = 2;
        }           
        
        $sql = "SELECT id, number, price, prices, last_read, manual_off FROM  $this->dbName.products 
                WHERE affiliation_id in (3,4)  and last_read  <=  (DATE(NOW()) - INTERVAL $day DAY) and manual_off != 1 order by id desc";        
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $products = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        echo "\n".$sql."\n";                         
        
        $aws = $this->container->get('app.amazonApi');
        foreach( $products AS $product ) {         
            if( empty( $product->number ) )
                continue;
            
            sleep($sleep); 
            
            echo "\n$product->number";
            
            $response = $aws->getUpdateProduct( $product->number );      
            if( empty( $response ) ) {
                $this->disabledProduct( $product->id );
                continue;
            }                
            
            $response = $response['ItemsResult']['Items'][0];           
            
            if( empty( $response['Offers'] ) ) {
                $this->disabledProduct( $product->id );
                continue;
            }
            
            //setto l'affiliazione giusta tra prime o no
            $affiliationId = 3;
            if( !empty( $response['Offers']['Listings'][0]['DeliveryInfo']['IsPrimeEligible']  ) ) {
                $newPrice = $response['Offers']['Listings'][0]['DeliveryInfo']['IsPrimeEligible'] ;
                $affiliationId = 4;
            }            
            
            $newPrice = $response['Offers']['Listings'][0]['Price']['Amount'] ;              
            if( !empty( $response['Offers']['Listings'][0]['Price']['Amount']  ) ) {
                $newPrice = $response['Offers']['Listings'][0]['Price']['Amount'] ;

            } else if( !empty( $response['Offers']['Summaries'][0]['LowestPrice']['Amount'] ) ) {
                $newPrice = $response['Offers']['Summaries'][0]['LowestPrice']['Amount'];
            }
            
//            echo "\n".$product->price .'!='. (int) $newPrice."\n";
            
//            echo ": ".$product->price .'!='. $newPrice."\n";
                                   
//            if( !empty( $newPrice ) ) {
                $totCallApi++;
//            }
            
            if( !empty( $newPrice ) && $product->price != $newPrice ) {
                
                $prices = $product->prices;
                if ( !empty( $product->prices ) ) {
                    $prices = json_decode( $product->prices );
                    $index = count( $prices ) - 1;
                    if ( trim( $prices[$index] ) != trim( $newPrice ) )
                        $prices[] = $newPrice;
                } else {
                    $prices[] = trim( $newPrice );
                }
                $pricesJson = json_encode( $prices );                
                
                $sql = "UPDATE ".$this->dbName.".products SET affiliation_id = $affiliationId,
                        price = '".$newPrice."', last_price = '".$product->price."', prices = '".$pricesJson."', last_read=  '" . date('Y-m-d H:i:s') . "',
                        last_change_price=  '" . date('Y-m-d H:i:s') . "', is_active = 1
                WHERE id = $product->id"; 
                $this->debug( $sql );
                $this->mySql->query( $sql );                                    
                
            } else {
                $this->changeLastRead( $product->id, $affiliationId );
            }                        
        }
        
        echo "\n TOTALE CHIAMATE AD AMAZON $totCallApi\n";
    }
    
    /**
     * Aggiuorna la data ultima lettura su amazon
     * @param type $productId
     * @param type $affiliationId
     */
    public function changeLastRead( $productId, $affiliationId = false ) {
        $where = '';
        if( !empty( $affiliationId ) ) {
            $where = "affiliation_id = $affiliationId,";
        }
        
        echo "\n";
        $sql = "UPDATE ".$this->dbName.".products SET $where last_read = '" . date('Y-m-d H:i:s') . "', is_active = 1 WHERE id = $productId"; 
        $this->debug( $sql );
        $this->mySql->query( $sql );
    }
    
    /**
     * Disabilita il prodotto
     * @param type $productId
     * @param type $affiliationId
     */
    public function disabledProduct( $productId, $affiliationId = false ) {
        $where = '';
        if( !empty( $affiliationId ) ) {
            $where = "affiliation_id = $affiliationId,";
        }
        
        
        echo "\n";
        $sql = "UPDATE ".$this->dbName.".products SET $where is_active = 0, data_disabled = '" . date('Y-m-d H:i:s') . "' WHERE id = $productId"; 
        $this->debug( $sql );
        $this->mySql->query( $sql );
    }
    
    /**
    * Funzione che per il recupero del contenuto di una pagina remota in due modalit� differenti
    * @params strinf $proxy ( se proxy chiama il metodo della classe proxyConnector altrimenti il metodo nativo php file_get_contents )
    * @return string
    */
   public function fileGetContent( $file, $type = 'proxy' ) {
       try {
            $type = '';
            if ( $type == 'proxy' ) {                    
                $string = $this->prxC->getContentPage( $file );
            } else {                
               $string = file_get_contents( $file );
            }
        } catch (Symfony\Component\Debug\Exception\ContextErrorException $e) {          
            return false;
        } catch (\Exception $e) {
            return false; 
        }
        return  $string ;
    }
    
    
    
    private function getModelEmptyProductFromAmazonApi() {
        //Recupera i modelli che hanno ricevute visite nell'ultimo periodo che non hanno prodotti amazon
        $sql1 = "SELECT models.* FROM $this->dbName.models 
             JOIN $this->dbName.products on products.model_id = models.id
            WHERE models.period_views > 2 and products.affiliation_id not in(3,4) 
            group by models.id order by models.period_views desc limit 300";
        $this->debug( $sql1 );
        $sth = $this->mySql->prepare( $sql1 );
        $sth->execute();
        $rows1 = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        //Recupera i modelli settati a top o in showcase che non hanno prodotti amazon
        $sql2 = "SELECT models.* FROM $this->dbName.models  
            WHERE ( models.is_top 1 or models.in_showcase = 1 ) and ( models.has_products = 0 or models.has_products is null )
            order by models.id desc limit 300";
        $this->debug( $sql2 );
        $sth = $this->mySql->prepare( $sql2 );
        $sth->execute();
        $rows2 = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        //Recupera i modelli che non hanno prodotti in generale o che non ne hanno di amazon
        $sql = "SELECT models.* FROM $this->dbName.models 
                WHERE models.has_products = 0 or models.has_products is null 
                order by models.id desc limit 1000";

        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $rows3 = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        $rows = array_merge( $rows3, $rows2, $rows1 );      
        
        $aws = $this->container->get('app.amazonApi');
        
        $x = 1;
        foreach( $rows As $model ) {       
            sleep(2);
            echo $model->name." ".$model->id."\n";
            
            $resultsAws = $aws->getSearch( $model->name, $model->advised_price, $model );
            $resultsAws = json_decode(json_encode($resultsAws), FALSE);
            
            
            if( empty( $resultsAws->products ) ) {
                if( $model->has_products == 0 ) {
                    $sql = "UPDATE ".$this->dbName.".models SET 
                    is_active= 0
                    WHERE id = $model->id"; 
                    $this->debug( $sql );
                    $this->mySql->query( $sql );                                        
                }
                continue;
            }
            
            $price                           = (string)trim(str_replace(array('EUR','.',','),array('','','.'),$resultsAws->model->price ));
            $this->product = new \stdClass;                        
            $this->product->description      = '';
            $this->product->fkTrademark      = !empty( $model->trademark_id ) ? $model->trademark_id : 'NULL';
            $this->product->fkCategory       = !empty( $model->category_id ) ? $model->category_id : 'NULL';
            $this->product->fkSubcategory    = !empty( $model->subcategory_id ) ? $model->subcategory_id : 'NULL';        		
            $this->product->price            = !empty( $price ) ? $this->controlDataInsert( (string)$price ) : 'NULL';        
            $this->fkSubcatAffiliation       = 'NULL';
            $this->product->fkTypology       = !empty( $model->typology_id ) ? $model->typology_id : 'NULL';
            $this->product->nameProduct      = $this->controlDataInsert( (string) $resultsAws->products[0]->name->{0} );
            $this->product->orderProduct     = 0;
            $this->product->number           = $resultsAws->products[0]->ASIN;
            $this->product->dataImport       = date('Y-m-d H:i:s');
            $this->product->lastModified     = date('Y-m-d H:i:s');
            $this->product->lowestPrices     = 1;
            $this->product->hasOtherProducts = 0;				
            $this->product->shippingHandlingCosts = $resultsAws->products[0]->handlingCost;
            $this->product->deliveryTime     = null;
            $this->product->stockAmount      = 0;
            $this->product->ean              = $resultsAws->products[0]->ean;
            $this->product->sizeStockStatus  = 'in stock';
            $this->product->fkAffiliation    = $resultsAws->products[0]->prime->{0} > 0 ? 4 : 3;
            $this->product->deepLink         = $resultsAws->products[0]->deepLink->{0};
            $this->product->modelId          = $model->id;
            $this->product->modelName        = $model->name;
            $this->product->shortDescription = !empty( $resultsAws->model->shortDescription ) ? $resultsAws->model->shortDescription->{0} : false;
            
            
            $imagesProduct = false;
            if( empty( $model->img ) && !empty( $resultsAws->products[0]->priorityImg ) && !empty( $resultsAws->products[0]->priorityImg->img ) && !empty( $resultsAws->products[0]->priorityImg->img->{0} ) )
                $imagesProduct = $resultsAws->products[0]->priorityImg->img->{0};
            
            //Setta json per storico prezzi
            $prices[] = trim( $price );
            $this->product->pricesJson = json_encode( $prices );	
                        
            $this->product->bulletPointsString = '';
            
            if( !empty( $resultsAws->extraModel->bulletPoints ) ) {
                $b = 0;
                foreach( $resultsAws->extraModel->bulletPoints AS $bulletPoint ) {
                    if( $b >=4 )
                        continue;
                    
                    $this->product->bulletPointsString .= $bulletPoint->{0}.";";
                    $b++;
                }
                $this->product->bulletPointsString = trim( $this->product->bulletPointsString, ';' );
            }            
            
            $advisedPrice = $resultsAws->model->advisedPrice;
            
            $advisedPrice = (int)$price + rand( 10,30);
            echo "\nInserisco prodotto: ".$model->id."\n";
            $this->insertProduct( $imagesProduct, $model, $advisedPrice );            
        }                
    }
    
    /**
     * Avvia lo spider totale per trovaprezzi a partire da una categoria
     */
    private function getModelEmptyProduct() {
        return;
        $sql = "SELECT * FROM $this->dbName.models WHERE is_active = 1 and ( has_products = 0 or has_products is null ) order by id asc";
//        $sql = "SELECT * FROM $this->dbName.models WHERE id = 5838 limit 1";
//        $this->debug( $sql );
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $rows = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        $x = 1;
        foreach( $rows As $model ) {       
//            sleep(3);
            $newIdenity = $x % 50 == 0 ? true : false;
            if( $newIdenity ) {
                echo '=================cambiooooo=================';
                sleep( 10 );
//                $this->prxC->setUserAgentewIdentity();
            }
            
            $rulEncode = urlencode( $model->name );
            $url = 'https://www.amazon.it/s/ref=nb_sb_noss?field-keywords='.$rulEncode;            
            $result = $this->fileGetContent( $url, $this->typeCurl );
            
            if( empty( $result ) ) {
                $sql = "UPDATE ".$this->dbName.".models SET 
                is_active= 0
                WHERE id = $model->id";
                $this->debug( $sql );
                $this->mySql->query( $sql );                 
                continue;
            }

            $doc = new \DOMDocument();
            libxml_use_internal_errors( true );
            $doc->loadHTML( $result );
            libxml_clear_errors();       
            $xpath = new \DOMXpath( $doc );            
            
            $elements = $xpath->query('//h1[@id="noResultsTitle"]');
            if ( $elements->length != 0 ) {
                $this->debug( 'non ci sono risultati' ); 
                
                $sql = "UPDATE ".$this->dbName.".models SET 
                is_active= 0
                WHERE id = $model->id";
                $this->debug( $sql );
                $this->mySql->query( $sql );                 
                continue;
            }
            $elements = $xpath->query('//div[@id="rightContainerATF"]//div[@id="atfResults"]//li');
            if ( $elements->length == 0 ) {
                $this->debug( 'captcha nlock' ); 
                $sql = "UPDATE ".$this->dbName.".models SET 
                is_active= 0
                WHERE id = $model->id";
                $this->debug( $sql );
                $this->mySql->query( $sql );                 
                continue;
            }
            
            $name = $xpath->query('//div[@id="rightContainerATF"]//div[@id="atfResults"]//li[1]//a/h2' );
            
            $url = $xpath->query('//div[@id="rightContainerATF"]//div[@id="atfResults"]//li[1]//a/@href' );
            $deepLink = $url[0]->nodeValue.'&tag=miglioreprezz-21';
            
            $img = $xpath->query('//div[@id="rightContainerATF"]//div[@id="atfResults"]//li[1]//img/@src' );
            $imagesProduct = $img[0]->nodeValue;
            
//            $price = $xpath->query('//div[@id="rightContainerATF"]//div[@id="atfResults"]//li[1]//a/span[1]' );
            $price = $xpath->query('//div[@id="rightContainerATF"]//div[@id="atfResults"][1]//li[1]//a[1]/span[contains(@class,"a-color-price")][1]' );
            if( empty( $price) || empty( $price[0] ) )
                continue;
            
            $sCost = 0;
//            $shippingCost = $xpath->query('//div[@class="a-row a-spacing-mini"][1]//div[contains(@class,"a-row a-spacing-none")]//span[contains(@class,"a-size-small a-color-secondary")]' );
//            if( !empty( $shippingCost ) && !empty( $shippingCost[0] ) ) {
//                $aShp = explode( ' ', $shippingCost[0]->nodeValue );
//                $sCost = $shippingCost[0]->nodeValue == 'Spedizione GRATUITA' ? 0 : str_replace( ',', '.', $aShp[2] );
//            }            
            
            $prime = $xpath->query('//div[@id="rightContainerATF"]//div[@id="atfResults"]//li[1]//i[contains(@class,"a-icon-prime")]' );
            $fkAffiliation = $prime->length > 0 ? 4 : 3;
            
            $this->product = new \stdClass;
            //Valorizzazioni dati
            $price                           = (string)trim(str_replace(array('EUR','.',','),array('','','.'),$price[0]->nodeValue));
            $this->product->description      = '';
            $this->product->fkTrademark      = !empty( $model->trademark_id ) ? $model->trademark_id : 'NULL';
            $this->product->fkCategory       = !empty( $model->category_id ) ? $model->category_id : 'NULL';
            $this->product->fkSubcategory    = !empty( $model->subcategory_id ) ? $model->subcategory_id : 'NULL';        		
            $this->product->price            = !empty( $price ) ? $this->controlDataInsert( (string)$price ) : 'NULL';        
            $this->fkSubcatAffiliation       = 'NULL';
            $this->product->fkTypology       = !empty( $model->typology_id ) ? $model->typology_id : 'NULL';
            $this->product->nameProduct      = $this->controlDataInsert( (string) $name[0]->nodeValue );
            $this->product->orderProduct     = 0;
            $this->product->number           = 'NULL';
            $this->product->dataImport       = date('Y-m-d H:i:s');
            $this->product->lastModified     = date('Y-m-d H:i:s');
            $this->product->lowestPrices     = 1;
            $this->product->hasOtherProducts = 0;				
            $this->product->shippingHandlingCosts = $sCost;
            $this->product->deliveryTime     = null;
            $this->product->stockAmount      = 0;
            $this->product->ean              = 0;
            $this->product->sizeStockStatus  = 'in stock';
            $this->product->fkAffiliation    = $fkAffiliation;
            $this->product->deepLink         = $deepLink;
            $this->product->impression_link  = md5( $deepLink );
            $this->product->modelId          = $model->id;
            $this->product->modelName        = $model->name;
            $this->product->shortDescription = false;

            //Setta json per storico prezzi
            $prices[] = trim( $price );
            $this->product->pricesJson = json_encode( $prices );		
            
            $advisedPrice = (int)$price + rand( 10,30)."\n";
            echo 'Inserisco prodotto: '.$model->name;
            $this->insertProduct( $imagesProduct, $model, $advisedPrice );
            $x++;
        }                
    }
    
    public function setProduct( $product  ) {
        $this->product = $product;
    }
    
    /**
     * Elimino un prodotto amazon non piu esist
     * @param type $ASIN
     */
    public function removeProductAmazon( $ASIN ) {
        echo $sql = "DELETE FROM ".$this->dbName.".products WHERE number = '$ASIN'";
        $res = $this->mySql->query( $sql );    
    }
    
    public function insertProduct( $imagesProduct, $model, $advisedPrice ) {        
        $this->fkSubcatAffiliation = !empty( $this->fkSubcatAffiliation ) ? $this->fkSubcatAffiliation : 'NULL';
        $sql = "
            INSERT INTO ".$this->dbName.".products (
                affiliation_id,
                trademark_id,
                category_id,
                subcategory_id,
                fk_subcat_affiliation_id,
                typology_id,
                model_id,
                name,
                price,
                deep_link,
                impression_link,
                number,
                data_import,
                last_read,
                last_modify,				
                is_active,
                handling_cost,
                delivery_time,
                stock_amount,
                ean,
                size_stock_status,
                description
            ) VALUES (
                ".$this->product->fkAffiliation.",
                ".$this->product->fkTrademark.",
                ".$this->product->fkCategory.",
                ".$this->product->fkSubcategory.",
                ".$this->fkSubcatAffiliation.",
                ".$this->product->fkTypology.",
                ".$this->product->modelId.",
                ".$this->product->nameProduct.",
                ".$this->product->price.",
                '".$this->product->deepLink."',
                '".md5($this->product->deepLink)."',
                '".$this->product->number."',
                '".$this->product->dataImport."',
                '".$this->product->dataImport."',
                '".str_replace( 'T',' ',$this->product->lastModified )."',
                1,
                '".$this->product->shippingHandlingCosts."',
                '".$this->product->deliveryTime."',
                ".$this->product->stockAmount.",
                '".$this->product->ean."',
                '".$this->product->sizeStockStatus."',
                ". $this->mySql->quote(  substr( $this->product->description, 0, 499 ) ) ."
            )
        ";
        
        
        $res = $this->mySql->query( $sql );            
        if( !empty( $res ) ) {
            $this->debug( $sql );
            $this->setImgModel( $imagesProduct, $this->product->modelId, $this->product->modelName, $this->product->price, $this->product->pricesJson, $advisedPrice );                
        } else {
            
        }
    }
    
    public function setImgModel( $imagesProduct, $modelId, $modelName, $price, $prices, $advisedPrice ) {
        if( !empty( $imagesProduct ) ) {
            $myFile = array();
            $myFile['name'][0] = $imagesProduct;
            $myFile['tmp_name'][0] = $imagesProduct;
            $myFile['type'][0] = $this->globalUtility->imageUtility->myGetTypeImg( $imagesProduct  );

            $widthFoto =  $this->container->getParameter('app.img_models_width');
            $heightFoto =  $this->container->getParameter('app.img_models_height');

            $rewriteName = $this->globalUtility->getNameImageProduct( $modelName );

            $file = $fileSmall = $this->globalUtility->imageUtility->myUpload( 
                    $myFile, 
                    $this->container->getParameter('app.folder_img_models_write'), 
                    $this->container->getParameter('app.folder_tmp'), 
                    $widthFoto, 
                    $heightFoto, 
                    "Model", 
                    session_id(), 
                    $modelId, 
                    array(), 
                    false,
                    'jpg',
                    $rewriteName 
            );

            $setImg = '';
            $widthFoto = $heightFoto = 0;
            if ( !empty( $file['dim'][0]['width'] ) || !empty( $file['dim'][0]['height'] ) || $myFile['type'][0] ) {
                $imgName = !empty( $file['foto'][0] ) ? $file['foto'][0] : '';     
                $widthFoto = $file['dim'][0]['width'];
                $heightFoto = $file['dim'][0]['height'];
                $setImg = "img = '$imgName',             
                width_small = '$widthFoto',
                height_small = '$heightFoto',";
            }
        } else {
            $setImg = '';
            $widthFoto = 0;
            $heightFoto = 0;
        }
        
        $bulletPointsString = !empty( $this->product->bulletPointsString ) ? $this->product->bulletPointsString : '';
        $shortDescription   = !empty( $this->product->shortDescription ) ? $this->product->shortDescription : 'NULL';
        
         $sql = "UPDATE ".$this->dbName.".models SET   
            $setImg
            has_products = has_products+1,
            price = $price,
            last_price = $price,
            advised_price = '".trim($advisedPrice)."',                       
            is_active= 1
        WHERE id = $modelId";
        $this->debug( $sql );
        $this->mySql->query( $sql );   
//        bullet_points = ".$this->mySql->quote( $bulletPointsString ).",
//        short_description = ".$this->mySql->quote( $shortDescription ).",     
    }
    
    /**
	 * Metodo che controlla e sistema i dati perche siano buoni per essere inertiti in query sql
	 * @param type $data
	 */
	public function controlDataInsert($data, $stripTags = true) {
		if ($stripTags)
			$data = strip_tags($data);
		return trim($this->mySql->quote($data));
	}
    
    public function offDebug() {
        $this->debugActive = false;
    }
    
    private function debug( $msg ) {
        if( $this->debugActive ) {            
            echo $msg;        
            echo "\n####################\n";
        }
    }
    
}