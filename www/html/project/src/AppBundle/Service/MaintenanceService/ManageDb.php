<?php

namespace AppBundle\Service\MaintenanceService;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;
use AppBundle\Service\AffiliationService\AffiliationUtility;
use AppBundle\Service\SpiderService\SpiderTrovaprezzi;

class ManageDb {

    private $container;
    private $doctrine;

    /**
     * When creating a new parseRestClient object
     * send array with 'restkey' and 'appid'
     * 
     */
    public function __construct(ObjectManager $doctrine, Container $container, GlobalUtility $globalUtility) {
        $this->doctrine = $doctrine;
        $this->container = $container;
        $this->globalUtility = $globalUtility;
    }

    /**
     * Metodo che elimina le immagini top News quando gli articoli sono stati pubblicati da più di un mese
     */
    public function run($dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $routerManager, $action, $container, $limit = 5000) {
        $this->dbHost = $dbHost;
        $this->dbPort = $dbPort;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPswd = $dbPswd;
        $this->container = $container;
        $this->routerManager = $routerManager;
        $this->limit = $limit;
        $this->mySql = new \PDO('mysql:host=' . $dbHost . ';port=' . $dbPort . ';', $dbUser, $dbPswd);

        $params = new \stdClass();
        $params->mySql = $this->mySql;
        $params->dbName = $this->dbName;
        $this->affiliationUtility = new AffiliationUtility($params);

        switch ( $action ) {
            case 'setHasModelsProducts':
                $this->affiliationUtility->setNumberProducts();
            break;
            case 'setPricesModelsProducts':
                $this->setPricesModelsProducts();
            break;
            case 'getAdvisedPriceModel':
                $this->getAdvisedPriceModel();
            break;
            case 'checkAssocModelProducts':
                $this->checkAssocModelProducts();
            break;
            case 'deleteImgNotUsed':
                $this->deleteImgNotUsed();
            break;
            case 'fixSubcategoriesTypologiesUrl':
                $this->fixSubcategoriesTypologiesUrl();
            break;
            case 'restoreProductsAssocModel':
                $this->restoreProductsAssocModel();
            break;
            case 'setAlphaCheckModel':
                $this->setAlphaCheckModel();
            break;
            case 'setSynonymsModels':
                $this->setSynonymsModels();
            break;
            case 'setASINamazon':
                $this->setASINamazon();
            break;            
            case 'removeCorruptDeepLink':
                $this->removeCorruptDeepLink();
            break;            
            case 'setEmptyImgProductNotFound':
                $this->setEmptyImgProductNotFound();
            break;
            case 'resetPeriodViewsModelProduct':
                $this->resetPeriodViewsModelProduct();
            break;
            case 'resetViewsModelProduct':
                $this->resetViewsModelProduct();
            break;
            case 'setImpressionLink':
                $this->setImpressionLink();
            break;
            case 'setImgModelEmpty':
                $this->setImgModelEmpty();
            break;
            case 'deleteDuplicateModels':
                $this->deleteDuplicateModels();
            break;
            case 'openPageForSetInHttpCache':
                $this->openPageForSetInHttpCache();
            break;
            case 'removeNullTopTrademarksSection':
                $this->removeNullTopTrademarksSection();
            break;
            case 'removeNullTopTrademarksSection':
                $this->removeNullTopTrademarksSection();
            break;
            case 'removeProductErrorPrice':
                $this->removeProductErrorPrice();
            break;
            case 'deleteExcessiveProducts':
                $this->deleteExcessiveProducts();
            break;
            case 'deleteDisabledProduct':
                $this->deleteDisabledProduct();
            break;            
            case 'fixRelationshipModelExternalTecnical':
                $this->fixRelationshipModelExternalTecnical();
            break;             
            case 'moveTableComparison':
                $this->moveTableComparison();
            break;            
        } 
    }     
    
    private function moveTableComparison() {
        $models    = $this->doctrine->getRepository( 'AppBundle:Model' )->getModelHasComparison(  '0,10000' );
        
        $x = 0;    
        $finalComparison = array();
        foreach( $models AS $model ) {            
            if( empty( $model->getComparisonModels() ) )
                continue;
            
            $idModels = str_replace( ',','[#]' ,$model->getComparisonModels() );        
            $aIds = explode( '[#]' ,$idModels );        

            if( strpos( ' '.$idModels, '[#]' ) !== FALSE ) {            
                $comparisonModels = $this->doctrine->getRepository('AppBundle:Model')->findModelByIds( $aIds );
            } else {
                $urls = explode( '-vs-' ,$idModels );        
                $comparisonModels = $this->doctrine->getRepository('AppBundle:Model')->findModelByNameUrls( $urls );
            }
            foreach( $comparisonModels As $comparisonModel ) {
                
                $indexModel  = $comparisonModel->getId() < $model->getId() ? 1 : 0;
                $indexModel2 = $indexModel == 1 ? 0 : 1;

                $finalComparison[$x]['id'][$indexModel] = $model->getId();
                $finalComparison[$x]['name'][$indexModel] = $model->getName();
                $finalComparison[$x]['nameUrl'][$indexModel] = $model->getNameUrl();
            
                
                $finalComparison[$x]['id'][$indexModel2] = $comparisonModel->getId();
                $finalComparison[$x]['name'][$indexModel2] = $comparisonModel->getName();
                $finalComparison[$x]['nameUrl'][$indexModel2] = $comparisonModel->getNameUrl();
              
                $sModels =  $finalComparison[$x]['nameUrl'][0].'-vs-'.$finalComparison[$x]['nameUrl'][1];
                $finalComparison[$x]['url'] = $sModels;
                $x++;
            }
        }
        foreach( $finalComparison AS $comparison ) {
            $modelId1   = $comparison['id'][0];
            $modelId2   = $comparison['id'][1];
            $url        = $comparison['url'];
            $sql = "INSERT INTO $this->dbName.comparisons ( model_id_one, model_id_two, name_url ) "
                    . "VALUES( $modelId1, $modelId2, ".$this->mySql->quote( $url ).") ";
            $this->mySql->query($sql);
            echo "\n".$sql ."\n";  
        }
    }
    
    /**
     * Rimuove i prodotti tipo quelli di amazon 0.99 centesimi che sono errati, o quelli che hanno un prezzo inferiore al 75% del prezzo consigliato
     * perche altamente probabile siano errati
     */
    private function removeProductErrorPrice() {
        $sql = "delete p from $this->dbName.products p join $this->dbName.models m on m.id = p.model_id where p.price < ( m.advised_price - ((m.advised_price/100)*75 ) )";
        $this->mySql->query($sql);
        echo "\n".$sql ."\n";  
    }
    
    /**
     * Elimina i recordo settati con position a null
     */
    private function removeNullTopTrademarksSection() {
        $sql = "UPDATE $this->dbName.topTrademarksSection set position = 50 where position is null";
        $this->mySql->query($sql);
        echo "\n".$sql ."\n";           
    }
    
    /**
     * Metodo che rimuove i trademark duplicati
     */
    private function deleteDuplicateModels() {
        $sql = "select * from $this->dbName.trademarks where name_url like '%-%'";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $trademarks = $sth->fetchAll(\PDO::FETCH_OBJ);

        $x = 0;
        foreach ($trademarks AS $trademark) {        
            $sql = "select * from $this->dbName.trademarks where name_url = '".str_replace('-','_', $trademark->name_url )."'";
            $sth = $this->mySql->prepare($sql);
            $sth->execute();
            $model = $sth->fetch(\PDO::FETCH_OBJ);            
            if( !empty( $model ) ) {                
                $sql = "DELETE from $this->dbName.models where trademark_id = ".$model->id;
                $this->mySql->query($sql);
                echo $sql."\n";

                $sql = "DELETE from $this->dbName.trademarks where name_url = '".str_replace('-','_', $trademark->name_url )."'";
                $this->mySql->query($sql);
                echo $sql."\n";
            }
            
            $sql = "UPDATE $this->dbName.trademarks SET name_url = '".str_replace('-','_', $trademark->name_url )."' 
                WHERE id = ".$trademark->id; 
            $this->mySql->query($sql);
            echo $sql."\n";
        }
        echo count($trademarks);
    }
    
    
    /**
     * Metodo che genera impressionLink per il tracciamento dei click sui deepLink
     */
    private function setImpressionLink() {
        $sql = "select * from $this->dbName.products where impression_link is null or impression_link = '' or impression_link = 0 ";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $products = $sth->fetchAll(\PDO::FETCH_OBJ);
        print_R($products[0]);

        $x = 0;
        foreach ($products AS $product) {            
            $sql = "UPDATE $this->dbName.products set impression_link = '".md5($product->deep_link)."' WHERE id = $product->id";
            $this->mySql->query($sql);
            echo $sql."\n";
        }
    }
    
    /**
     * Resetta i contatori delle visite per periodo dei prodotti e dei modelli
     */
    private function resetPeriodViewsModelProduct() {
        $sql = "UPDATE $this->dbName.products set period_views = 0";
        $this->mySql->query($sql);
        echo $sql."\n";
        
        $sql = "UPDATE $this->dbName.models set period_views = 0";
        $this->mySql->query($sql);
        echo $sql."\n";
    }
    
    /**
     * Resetta i contatori delle visite dei prodotti e dei modelli
     */
    private function resetViewsModelProduct() {
        $sql = "UPDATE $this->dbName.products set views = 0";
        $this->mySql->query($sql);
        echo $sql."\n";
        
        $sql = "UPDATE $this->dbName.models set views = 0";
        $this->mySql->query($sql);
        echo $sql."\n";
    }
    
    /**
     * Elimina i deepLink rotti dei prodotti
     */
    private function setEmptyImgProductNotFound() {
        echo $sql = "select * from $this->dbName.image_products";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();        
        $images = $sth->fetchAll(\PDO::FETCH_OBJ);
        foreach( $images AS $image ) {
            if( !file_exists(  $this->container->getParameter( 'app.folder_imgProductsSmall_write' ).$image->img ) ) {
                echo 'non esite: '.$this->container->getParameter( 'app.folder_imgProductsSmall_write' ).$image->img."\n" ;
                
                $sql1 = "UPDATE $this->dbName.products set priority_img_id = NULL where priority_img_id = $image->id";
                $this->mySql->query($sql1);
                echo $sql1."\n";
                
                $sql2 = "DELETE from $this->dbName.image_products where id = $image->id";
                $this->mySql->query($sql2);
                echo $sql2."\n";
            }
            echo '.';
        }
    }

    /**
     * Elimina i deepLink rotti dei prodotti
     */
    private function removeCorruptDeepLink() {
        echo $sql = "delete from $this->dbName.products where deep_link like '/gp/bestsellers%'";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();        
    }
    
    /**
     * Metodo che genere il codice alphaCheckModel per il modello
     */
    private function setAlphaCheckModel() {                
        $sql = "select models.id,models.name,models.synonyms, models.subcategory_id, trademarks.name as trademark from $this->dbName.models 
            left join $this->dbName.trademarks on trademarks.id = models.trademark_id 
        where models.alphaCheckModel is null order by models.id desc";
        
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $models = $sth->fetchAll(\PDO::FETCH_OBJ);
                
        foreach ( $models AS $model ) {            
            $words = array();
            $aModel = explode( ' ', $model->name );
            foreach( $aModel AS $item ) {                          
                $item = preg_replace("/(\d+)(mb |gb |tb |ml )/i", '', $item.' ' );
                $item = str_replace( array( '(',')','3D ' ), array( '','',' ' ), $item );
                $item = trim( $item );
                
                if ( strtolower( $model->trademark ) != strtolower( $item ) 
                        && ( preg_match( "/[a-z]/i", $item ) && preg_match('/\\d+/', $item ) ) 
                        && !$this->lastCharIsOnlyNumber( $item ) ) {                                       
                    
                    if(  strlen( $item ) > 3
                            && strpos(strtolower($item), 'gb ', '0') === false 
                            && strpos(strtolower($item), 'mb ', '0') === false
                            && strpos(strtolower($item), 'tb ', '0') === false) {
                                     
                        //Filtra e prende solo quelli che hanno più di 2 numeri nella stringa
                        preg_match_all('/\d+/', $item, $matches);                        
                        $active = count( $matches[0] ) > 1 || strlen( $matches[0][0] ) > 0 ? true : false;                        
                        
                        switch( $model->subcategory_id ) {
                            //Obbiettivi fotocamere
                            case 96:
                                $limitAlpha = 0;
                            break;
                            default:
                                $limitAlpha = 1;
                            break;
                        }
                        
                        //Controlla che siano presenti almeno 2 lettere 
                        if( $active ) {
                            preg_match_all('/[a-z]/i', $item, $matches);      
                            $active = count( $matches[0] ) > 1 || strlen( $matches[0][0] ) > $limitAlpha ? true : false;
                        }                        
                        
                        if( $active ) {
                            $words[] = $item;                             
                        }
                    }
                }
            }
            
            $alphaCheckModel = '';
            if( count( $words ) > 1 ) {
                $trademark = '';
                switch( $model->subcategory_id ) {
                    case 96:
                        $trademark = $model->trademark.' ';
                    break;
                }
                
                //Deve stare sempre per primo l'implode per spazio
                $alphaCheckModel .= $trademark.implode( ' ', $words ).'; ';     
                
                //Verifica se nel codice è presente uno / lo mette
                $hasSlash = false;
                $notSlashWord = '';
                foreach( $words AS $word ) {
                    if( strpos( strtolower( $word ), '/', '0') !== false ) {
                        $hasSlash = true;
                    }
                    $notSlashWord .= str_replace( '/', '', $word ).' ';
                }
                if( $hasSlash ) {
                    $alphaCheckModel .= $trademark.trim( $notSlashWord ).'; ';
                }

                $alphaCheckModel .= $model->trademark.' '.implode( ' ', $words ).'; ';
                $alphaCheckModel .= $trademark.implode( '-', $words ).'; ';
                $alphaCheckModel .= $trademark.implode( ' - ', $words ).'; ';
                $alphaCheckModel .= $trademark.implode( '/', $words ).'; ';
                foreach( $words AS $word ) {
                    $alphaCheckModel .= $trademark.$word.'; ';
                }                
                $alphaCheckModel= trim( $alphaCheckModel, '; ' );
                
            } else if( !empty( $words ) ) {
                $alphaCheckModel .= $model->trademark.' '.$words[0].'; ';
                $alphaCheckModel .= $words[0];
            }
            
            if( !empty( $alphaCheckModel ) ) {
                echo $model->name."\n";
                $sql = "UPDATE $this->dbName.models SET alphaCheckModel =  '$alphaCheckModel'
                    where id = $model->id ";
                echo $sql."\n";
                $this->mySql->query($sql);        
            }
        }
    }
   
    /**
     * Determina se l'ultimo char è un numero e se è l'unico ad essere presente
     * @param type $string
     */
    private function lastCharIsOnlyNumber( $string ) {
        preg_match_all('/\d+/', $string, $matches);                        
        $onlyOneNumber = count( $matches[0] ) > 1 || strlen( $matches[0][0] ) > 1 ? false : true;
        
        $string  = trim( $string );
        $charInit = substr( $string, -1, 1 ); 
        $charEnd = substr( $string, 0, 1 );
        
        if( $onlyOneNumber && ( is_numeric( $charInit ) || is_numeric( $charEnd ) ) ) {
            return true;
        }
        return false;
    }
    
    /**
     * Metodo che crea i sinonimi per i modelli
     */
    private function setSynonymsModels() {
        echo $sql = "select models.id,models.name,models.synonyms, trademarks.name as trademark from $this->dbName.models 
            join $this->dbName.trademarks on trademarks.id = models.trademark_id where models.synonyms is null
            order by models.id desc";
        
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $models = $sth->fetchAll(\PDO::FETCH_OBJ);

        $pp = 0;
        foreach ($models AS $model) {
            $modelName = $model->name;
            //VERIFICA SE ELIMINANDO LE COSE TRA PARENTESI LE PAROLE SONO MINORI DI 3 SALTA IL MODELLO
//            $tempName = preg_replace("/\([^)]+\)+/", "", strtolower( $modelName ) );                        
//            $modelName = preg_replace("/\s+/", " ", $modelName );                        

            $modelName = str_replace(array('(', ')'), " ", $modelName);
            $modelName = preg_replace("/\s+/", " ", $modelName);

//            echo $modelName;
//            if( $this->strWordCount( trim($modelName) ) < 3 ) {
//                echo 'ESCO SUBITO: '.$model->name."\n";
//                continue;
//            }

            $arr1 = $this->replaceItemsModel($modelName, $model);

            $modelName = $model->name;
            if (strpos(strtolower($modelName), ' - ', '0') !== false || strpos(strtolower($modelName), '/', '0') !== false || strpos(strtolower($modelName), "'", '0') !== false || strpos(strtolower($modelName), ".", '0') !== false
            ) {
                $replace = trim(str_replace(array(' - ', '/', "'", "."), ' ', strtolower($modelName)));
//                if( $this->strWordCount( $replace ) > 2 )
                $modelName = $replace;
            }

            $tempName = preg_replace("/\([^)]+\)+/", "", strtolower($modelName));
            $tempName = preg_replace("/\s+/", " ", $tempName);

            $arr2 = $this->replaceItemsModel($tempName, $model);

            if (strpos(strtolower($modelName), '-', '0') !== false
            ) {
                $replace = trim(str_replace(array(strtolower($model->trademark), 'gb'), array('', ''), strtolower($modelName)));
                $replace = trim(str_replace(array('-', '', "'"), ' ', strtolower($replace)));
                $replace = preg_replace("/\s+/", " ", $replace);
                if ($this->strWordCount($replace) > 0)
                    $arr2[] = $replace;
            }

            $aSyn = array_merge($arr1, $arr2);

            foreach ($aSyn AS $key => $word) {
                //Controlla se è una sola parole e non è alfanumerica la toglie dall'array
                if ($this->strWordCount($word) == 1 && (!preg_match("/[a-z]/i", $word) || !preg_match('/\\d/', $word) )) {
                    unset($aSyn[$key]);
                }
            }

            if (empty($aSyn)) {
                $sql = "UPDATE $this->dbName.models SET synonyms =  '' "
                    . "where id = $model->id ";
                $this->mySql->query($sql);
                echo 'ESCO DOPO: ' . $modelName . "\n";                
                continue;
            }

            $finalArray = array_unique($aSyn);            
//
//            $finalSysonyms = implode(', ', $finalArray);
//            if(strlen( $finalSysonyms) > 500 ) {
//                echo 'cazzo';
//            }
//            echo strlen( $finalSysonyms).'<==';
//            
             $sql = "UPDATE $this->dbName.models SET synonyms =  '" . implode('; ', $finalArray) . "' "
                    . "where id = $model->id ";
            $this->mySql->query($sql);
//            echo strtolower( $model->name ) ."\n";
            echo $pp . "\n";
            $pp++;
        }
    }

    function replaceItemsModel($modelName, $model) {
        $aSyn = array();

        //STACCA LA PAROLA -
        if (strpos(strtolower($modelName), ' - ', '0') !== false || strpos(strtolower($modelName), '/', '0') !== false || strpos(strtolower($modelName), "'", '0') !== false
        ) {
            $replace = trim(str_replace(array(' - ', '', "'"), ' ', strtolower($modelName)));
            $replace = preg_replace("/\s+/", " ", $replace);
            if ($this->strWordCount($replace) > 0)
                $modelName = $replace;
            $aSyn[] = $replace;
        }

        //RIMUOVE IL NOME DEL MARCHIO
        if (strpos(strtolower($modelName), strtolower($model->trademark), '0') !== false) {
            $replace = trim(str_replace(strtolower($model->trademark), '', strtolower($modelName)));
            $replace = preg_replace("/\s+/", " ", $replace);
            if ($this->strWordCount($replace) > 0)
                $aSyn[] = $replace;
        }

        //RIMUOVE NOME DEL MARCHIO E ANCHE GB
        if (strpos(strtolower($modelName), strtolower($model->trademark), '0') !== false &&
                strpos(strtolower($modelName), 'gb', '0') !== false
        ) {
            $replace = trim(str_replace(array(strtolower($model->trademark), 'gb'), array('', ''), strtolower($modelName)));
            $replace = preg_replace("/\s+/", " ", $replace);
            if ($this->strWordCount($replace) > 0)
                $aSyn[] = $replace;
        }

        //STACCA LA PAROLA GB
        if (strpos(strtolower($modelName), 'gb', '0') !== false) {
            $replace = trim(str_replace('gb', ' gb', strtolower($modelName)));
            $replace = preg_replace("/\s+/", " ", $replace);
            if ($this->strWordCount($replace) > 0)
                $aSyn[] = $replace;
        }

        //RIMUOVE LE COSE TRA PARENTESI
        if (preg_match("/\([^)]+\)+/", strtolower($modelName))) {
            $replace = preg_replace("/\([^)]+\)+/", "", strtolower($modelName));
            $replace = preg_replace("/\s+/", " ", $replace);
            if ($this->strWordCount($replace) > 0) {
                $modelName = $replace;
                $aSyn[] = $replace;
            }
        }

//        echo '==>'.$modelName;exit;
        if (strpos(strtolower($modelName), '-', '0') !== false || strpos(strtolower($modelName), '/', '0') !== false || strpos(strtolower($modelName), "'", '0') !== false || strpos(strtolower($modelName), ".", '0') !== false
        ) {
            $replace = trim(str_replace(array(strtolower($model->trademark), 'gb'), array('', ''), strtolower($modelName)));
            $replace = trim(str_replace(array('-', '/', "'", "."), '', strtolower($replace)));
            if ($this->strWordCount($replace) > 0)
                $aSyn[] = $replace;

//            exit;
        }


        return $aSyn;
    }   

    /**
     * Metodo che tenta di associare i prodotti non associati a qualche modello
     */
    private function checkAssocModelProducts() {
        $params = new \stdClass();
        $params->mySql = $this->mySql;
        $params->dbName = $this->dbName;
        $params->container = $this->container;
        $params->debug = false;
        $affiliationUtility = $this->affiliationUtility;        
        $affiliationUtility->insertAfter = false;
        
        //Recupera solo i prodotti associati alla sottocategoria che ha modelli
        echo $sql = "select products.* from $this->dbName.products 
                join ".$this->dbName.".subcategories on products.subcategory_id = subcategories.id
                where subcategories.has_models > 0 and products.typology_id is null
                and products.model_id is null and products.category_id != 8 order by products.id desc";
        
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $products1 = $sth->fetchAll(\PDO::FETCH_OBJ);          
                       
        $x = 0;
        foreach ($products1 AS $product) {
            $affiliationUtility->prepareQueryInsertProduct( false, $product );
            
            $typologyId = !empty($product->typology_id) ? $product->typology_id : false;
            //Se la categoria è abbigliamento avvio il check per l'associazione della tipologia
            if (!empty($product->category_id) && $product->category_id != NULL && $product->category_id != 'NULL' && $product->category_id == 8) {

            } else if (!empty($product->subcategory_id)) {           
                $affiliationUtility->checkModel($product->subcategory_id, $product->name, $product->id, $product->description, $typologyId);
                echo "==>" . $x . ": " . $product->id." " . "<===\n";
            }                       
            $x++;
        }
        
         //Recupera solo i prodotti per tipologia che ha i modelli
        echo $sql = "select products.* from $this->dbName.products 
                join ".$this->dbName.".typologies on products.typology_id = typologies.id
                where typologies.has_models > 0 and products.model_id is null and products.category_id != 8 order by products.id desc";
        
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $products2 = $sth->fetchAll(\PDO::FETCH_OBJ);        
        $x = 0;
        foreach ($products2 AS $product) {
            $affiliationUtility->prepareQueryInsertProduct( false, $product );
            
            $typologyId = !empty($product->typology_id) ? $product->typology_id : false;
            //Se la categoria è abbigliamento avvio il check per l'associazione della tipologia
            if (!empty($product->category_id) && $product->category_id != NULL && $product->category_id != 'NULL' && $product->category_id == 8) {

            } else if (!empty($product->subcategory_id)) {           
                $affiliationUtility->checkModel($product->subcategory_id, $product->name, $product->id, $product->description, $typologyId);
                echo "==>" . $x . ": " . $product->id." " . "<===\n";
            }                       
            $x++;
        }
    }
    
    
    /**
     * Metodo che risetta i modelli per ogni prodotto
     */
    private function restoreProductsAssocModel() {
        $params = new \stdClass();
        $params->mySql = $this->mySql;
        $params->dbName = $this->dbName;
        $params->container = $this->container;
        $params->debug = false;
        $affiliationUtility = $this->affiliationUtility;

//519048
//        $sql = "select * from $this->dbName.products WHERE ( model_id is  null or model_id = '' ) and typology_id is null";
        $sql = "select * from $this->dbName.products where subcategory_id = 130  and affiliation_id = 14 order by id asc";
//        $sql = "select * from $this->dbName.products where id = 2758063883 order by id asc";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $products = $sth->fetchAll(\PDO::FETCH_OBJ);
//        print_R($products[0]);

        $x = 0;
        foreach ($products AS $product) {
            $typologyId = !empty($product->typology_id) ? $product->typology_id : false;
            //Se la categoria è abbigliamento avvio il check per l'associazione della tipologia
            if (!empty($product->category_id) && $product->category_id != NULL && $product->category_id != 'NULL' && $product->category_id == 8) {
                echo 'Abb: ' . $product->name . "\n";
                $affiliationUtility->checkTypology($product->subcategory_id, $product->name, $product->id, $product->description, $typologyId, $product->category_id);

//                $affiliationUtility->checkSex( $product );
//                $affiliationUtility->checkSize( $product );  
//                $affiliationUtility->checkColor( $product );
                //Se c'è la sottocategoria, associata grazie alla lookup,
                //prova a recuperare modello prodotto se possibile
            } else if (!empty($product->subcategory_id)) {
                $affiliationUtility->checkModel($product->subcategory_id, $product->name, $product->id, $product->description, $typologyId);
            }
            echo "==>" . $x . ": " . $product->id . "<===\n";
            $x++;
        }
    }

    /*
     * Metodo che ricava l'id prodotto per effettuare la chiamata api ad amazon per aggiornamento dati prodotto
     */

    private function setASINamazon() {
        $sql = "SELECT id, deep_link FROM  $this->dbName.products where affiliation_id in (3,4) and number is null";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $products = $sth->fetchAll(\PDO::FETCH_OBJ);

        foreach ($products AS $product) {
            $ASINNumber = '';
            $aLink = explode('/', $product->deep_link);

            if (!empty($aLink) && !empty($aLink[5]) && strlen($aLink[5]) == 10) {
                $ASINNumber = $aLink[5];
            } else {
                if (!empty($aLink) && !empty($aLink[5]) && strlen($aLink[5]) != 10) {
                    $finalLink = explode('?', $aLink[5]);
                    $ASINNumber = strlen($finalLink[0]) == 10 ? $finalLink[0] : '';
                } else {
                    continue;
                }
            }

            $sql = "UPDATE $this->dbName.products SET number = '" . $ASINNumber . "' 
                where id = $product->id ";
            $this->mySql->query($sql);
            echo $sql . "\n";
        }
    }

    /**
     * Sistema le url delle sottocategorie
     */
    private function fixSubcategoriesTypologiesUrl() {
        $sql = "SELECT * FROM  $this->dbName.subcategories";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $subcategories = $sth->fetchAll(\PDO::FETCH_OBJ);
        foreach ($subcategories AS $subcategory) {
            $sql = "UPDATE $this->dbName.subcategories SET name_url = '" . str_replace('-', '_', $subcategory->name_url) . "' "
                    . "where id = $subcategory->id ";
            $this->mySql->query($sql);
            echo $sql . "\n";
        }

        $sql = "SELECT * FROM  $this->dbName.typologies";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $typologies = $sth->fetchAll(\PDO::FETCH_OBJ);
        foreach ($typologies AS $typology) {
            $sql = "UPDATE $this->dbName.typologies SET name_url = '" . str_replace('-', '_', $typology->name_url) . "' "
                    . "where id = $typology->id ";
            $this->mySql->query($sql);
            echo $sql . "\n";
        }
    }

    /**
     * Metodo che recupera i prezzi consigliati per i modelli che non lo hanno
     */
    private function getAdvisedPriceModel() {
        $spider = $this->container->get('app.spiderTrovaprezzi');
        $spider->run($this->dbHost, $this->dbPort, $this->dbName, $this->dbUser, $this->dbPswd, 'getAdvisedPriceModel', false);

        $sql = "SELECT * FROM  $this->dbName.models WHERE advised_price is null order by id asc";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $models1 = $sth->fetchAll(\PDO::FETCH_OBJ);

        $sql = "SELECT * FROM  $this->dbName.models WHERE advised_price = 0 and has_products > 0 order by id asc";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $models2 = $sth->fetchAll(\PDO::FETCH_OBJ);
        
        
        $x = 0;
        foreach ($models1 AS $model) {
            $newIdenity = $x % 200 == 0 ? true : false;
            if ($newIdenity)
                echo "\ncambio identita\n";

            if (!$spider->getAdvisedPriceModel($model->name_url_tp, $model->id, $newIdenity)) {                
                if( empty( $model->price ) ) {                                
                    $sql = "UPDATE $this->dbName.models SET advised_price = '0' where id = $model->id ";
                } else {
                   $diff        = (int)( $model->price / 100 ) * rand( 3,15 ) ;
                   $advicePrice = (int)( $model->price ) + $diff;
                   $sql = "UPDATE $this->dbName.models SET advised_price = '$advicePrice' where id = $model->id ";
                }
                $this->mySql->query($sql);
                echo $sql . "\n";                
            }
            $x++;
        }
        
        $x = 0;
        foreach ($models2 AS $model) {                                
            if( !empty( $model->price ) ) {                                                    
               $diff        = (int)( $model->price / 100 ) * rand( 3,15 ) ;
               $advicePrice = (int)( $model->price ) + $diff;
               $sql = "UPDATE $this->dbName.models SET advised_price = '$advicePrice' where id = $model->id ";
               $this->mySql->query($sql);
                echo $sql . "\n";
            }                                
            $x++;
        }
    }

    /**
     * Elimina le immagini non più usate
     */
    private function deleteImgNotUsed() {
        $sql = "SELECT * FROM  $this->dbName.image_products";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $imagesInit = $sth->fetchAll(\PDO::FETCH_OBJ);

        foreach ($imagesInit AS $image) {
            $sql = "SELECT * FROM  $this->dbName.product_imageproduct 
                JOIN $this->dbName.products on products.id = product_imageproduct.product_id
                    where image_product_id = " . $image->id;
            $sth = $this->mySql->prepare($sql);
            $sth->execute();
            $check = $sth->fetch(\PDO::FETCH_OBJ);
            
            if ( empty( $check ) ) {
                echo 'cancello immagine: ' . $this->container->getParameter('app.folder_imgProductsSmall_write') . $image->img . "\n";
                @unlink($this->container->getParameter('app.folder_imgProductsSmall_write') . $image->img);
                $sql = "DELETE FROM  $this->dbName.image_products WHERE id = " . $image->id;
                $this->mySql->query($sql);
                echo $sql . "\n";
                
                $sql = "DELETE FROM  $this->dbName.product_imageproduct where image_product_id = " . $image->id;
                $this->mySql->query($sql);
                echo $sql . "\n";
            }
        }
        
        //Elimina immagini per prodotto duplicate
        $sql = "select product_id, count(product_id)  from $this->dbName.product_imageproduct GROUP BY product_id HAVING count(product_id) > 1";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $products = $sth->fetchAll(\PDO::FETCH_OBJ);
        foreach( $products AS $product ) {
            //prende una singola row
            $sql = "select image_product_id from $this->dbName.product_imageproduct 
                JOIN $this->dbName.products ON products.id = product_imageproduct.product_id
                    where product_id = $product->product_id limit 1";
            $sth = $this->mySql->prepare($sql);
            $sth->execute();
            $p = $sth->fetch(\PDO::FETCH_OBJ);
            echo $sql."\n";
            
            $sql = "select * from $this->dbName.product_imageproduct WHERE product_id = $product->product_id AND image_product_id != $p->image_product_id";
            $sth = $this->mySql->prepare($sql);
            $sth->execute();
            $images = $sth->fetchAll(\PDO::FETCH_OBJ);
            
            foreach( $images AS $image ) {
                
                $sql = "SELECT * FROM  $this->dbName.image_products where id = $image->image_product_id";
                $sth = $this->mySql->prepare($sql);
                $sth->execute();
                $removeImg = $sth->fetch(\PDO::FETCH_OBJ);
                
                echo 'immagine non presente: ' . $this->container->getParameter('app.folder_imgProductsSmall_write') . $removeImg->img . "\n";
                @unlink($this->container->getParameter('app.folder_imgProductsSmall_write') . $removeImg->img);
                $sql = "DELETE FROM  $this->dbName.image_products WHERE id = " . $removeImg->id;
                $this->mySql->query($sql);
                echo $sql . "\n";
                
                $sql = "DELETE FROM  $this->dbName.product_imageproduct where image_product_id = " . $removeImg->id;
                $this->mySql->query($sql);
                echo $sql . "\n";
            }            
        }                
        
        foreach ($imagesInit AS $image) {
            if( !file_exists( $this->container->getParameter('app.folder_imgProductsSmall_write') . $image->img ) ) {
                echo 'cancello immagine: ' . $this->container->getParameter('app.folder_imgProductsSmall_write') . $image->img . "\n";
                @unlink($this->container->getParameter('app.folder_imgProductsSmall_write') . $image->img);
                $sql = "DELETE FROM  $this->dbName.image_products WHERE id = " . $image->id;
                $this->mySql->query($sql);
                echo $sql . "\n";
                
                $sql = "DELETE FROM  $this->dbName.product_imageproduct where image_product_id = " . $image->id;
                $this->mySql->query($sql);
                echo $sql . "\n";
                
                $sql = "UPDATE  $this->dbName.products SET priority_img_id = NULL  where priority_img_id = " . $image->id;
                $this->mySql->query($sql);
                echo $sql . "\n";                                
            }
        }
        
        
    }

    /**
     * Metodo che setta i prezzi dei modelli
     */
    private function setPricesModelsProducts() {
        echo $sql = "SELECT * FROM  $this->dbName.models WHERE has_products > 0 ";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $models = $sth->fetchAll(\PDO::FETCH_OBJ);

        foreach ($models AS $model) {
            $sql = "SELECT * FROM  $this->dbName.products WHERE is_active = 1 and model_id = $model->id and to_update = 1 order by price asc limit 1";
            echo $sql . "\n";
            $sth = $this->mySql->prepare($sql);
            $sth->execute();
            $product = $sth->fetch(\PDO::FETCH_OBJ);

            $prices = array();
            if (!empty($model->prices)) {
                $prices = json_decode($model->prices);
            }

//            if( !empty( $product ) )
//                $product->price = 500; 
//            
            if (!empty($product) && $product->price != $model->price) {
                $prices[] = $product->price;

                $sql = "UPDATE $this->dbName.models 
                SET last_price = price, price = $product->price, prices = '" . json_encode($prices) . "' , last_read_price = '" . date('Y-m-d H:i:s') . "'
                WHERE id = $model->id";
                $this->mySql->query($sql);
                echo $sql . "\n"; 
            }
        }
    } 
    
    /**
     * Metodo che setta le immagini ai modelli mancanti
     */
    private function setImgModelEmpty() {
        echo $sql = "select models.id, models.name, image_products.img as productImg from $this->dbName.models 
            JOIN $this->dbName.products on products.model_id = models.id
            JOIN $this->dbName.image_products on image_products.id = products.priority_img_id
            where models.img is null 
            and models.is_top = 1
            and models.in_showcase = 1 and products.priority_img_id is not null
             ";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $models = $sth->fetchAll(\PDO::FETCH_OBJ);
        foreach( $models AS $model ) {
            $imagesProduct = $this->container->getParameter('app.folder_imgProductsSmall_write').$model->productImg;            
            $this->setImgModel( $imagesProduct, $model->id, $model->name );
        }        
    }
    
    /**
     * Catica l'immagine per il modello sul server e nel db
     * @param type $imagesProduct
     * @param type $modelId
     * @param type $modelName
     */
    public function setImgModel( $imagesProduct, $modelId, $modelName ) {
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
                height_small = '$heightFoto'";
                $sql = "UPDATE ".$this->dbName.".models SET  $setImg WHERE id = $modelId";        
                $this->mySql->query( $sql );   
                echo $sql."\n";
            }            
        } else {
            $setImg = '';
            $widthFoto = 0;
            $heightFoto = 0;
        }                                
    }
        
    /**
     * Apre le pagine in produzione per forzare subito il cache
     */
    private function openPageForSetInHttpCache() {
        $sql = "SELECT id, categories.name_url FROM ".$this->dbName.".categories WHERE categories.is_active =1";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $categories = $sth->fetchAll( \PDO::FETCH_OBJ );
        
//        echo file_get_contents('https://www.acquistigiusti.it');
        foreach( $categories AS $category ) {
            $path = 'https://www.acquistigiusti.it'.$this->routerManager->generate( 'catSubcatTypologyProduct', array( 'section1' => $category->name_url ), false );
            echo $path."\n";
            file_get_contents($path);
        }
        
        echo $sql = "SELECT categories.name_url as keyUrlCategory, subcategories.id, subcategories.name_url as keyUrlSubcategory, typologies.name_url as keyUrlTypologies,
            subcategories.has_models
            FROM ".$this->dbName.".subcategories left outer join ".$this->dbName.".typologies on typologies.subcategory_id = subcategories.id
            LEFT JOIN ".$this->dbName.".categories on categories.id = subcategories.category_id
            WHERE subcategories.is_active =1  and categories.is_active =1 
            order by subcategories.id ASC";
        
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $subcategories = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        foreach( $subcategories AS $subcategory ) {
            $path = 'https://www.acquistigiusti.it'.$this->routerManager->generate( 'catSubcatTypologyProduct', array(
                'section1' => $subcategory->keyUrlCategory,
                'section2' => $subcategory->keyUrlSubcategory ) , false );            
            echo $path."\n";
            file_get_contents($path);
        }
        
        echo $sql = "SELECT categories.name_url as keyUrlCategory, typologies.id, typologies.name_url as keyUrlTypology, 
            typologies.has_products, typologies.has_models, subcategories.name_url as keyUrlSubcateogry
            FROM ".$this->dbName.".typologies 
                JOIN ".$this->dbName.".categories on categories.id = typologies.category_id
                JOIN ".$this->dbName.".subcategories on subcategories.id = typologies.subcategory_id
            WHERE
            typologies.is_active = 1 and
            categories.is_active = 1 and
            subcategories.is_active = 1             
            order by typologies.id ASC";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $typologies = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        foreach( $typologies AS $typology ) {
             $path = 'https://www.acquistigiusti.it'.$this->routerManager->generate( 'catSubcatTypologyProduct', array(
                'section1' => $typology->keyUrlCategory,
                'section2' => $typology->keyUrlSubcateogry, 
                'section3' => $typology->keyUrlTypology) , false );            
            echo $path."\n";
            file_get_contents($path);
        }
//        
        //Apre le ricerche
        echo $sql = "SELECT search_terms.name nameSearch, categories.name_url as keyUrlCategory, typologies.name_url as keyUrlTypology,  subcategories.name_url as keyUrlSubcateogry
            FROM ".$this->dbName.".search_terms 
                JOIN ".$this->dbName.".categories on categories.id = search_terms.category_id
                JOIN ".$this->dbName.".subcategories on subcategories.id = search_terms.subcategory_id
                LEFT JOIN ".$this->dbName.".typologies on typologies.id = search_terms.typology_id
            WHERE
            categories.is_active = 1 and
            subcategories.is_active = 1             
            order by typologies.id ASC";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $searchTerms = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        
        foreach( $searchTerms AS $searchTerm ) {
             $path = 'https://www.acquistigiusti.it'.$this->routerManager->generate( 'catSubcatTypologyProduct', array(
                'section1' => $searchTerm->keyUrlCategory,
                'section2' => $searchTerm->keyUrlSubcateogry, 
                'section3' => $searchTerm->keyUrlTypology.'-'.$searchTerm->nameSearch) , false );            
            echo $path."\n";
            file_get_contents($path);
        }
        
        
        echo $sql = "SELECT content_articles.permalink,  megazine_sections.name_url, megazine_sections.id as megazineId
            FROM ".$this->dbName.".data_articles
                JOIN ".$this->dbName.".content_articles on content_articles.data_article_id = data_articles.id
                JOIN ".$this->dbName.".megazine_sections on megazine_sections.id = data_articles.megazine_section_id";            
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $articles = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        
        foreach( $articles AS $article ) {
            $path = 'https://www.acquistigiusti.it'.$this->routerManager->generate( 'detailNews'.$article->megazineId , 
                array(                         
                    'title' => $article->permalink
            ), false );                                       
            echo $path."\n";
            file_get_contents($path);
        }
        
        
        
    }
    
    /**
     * Cancella i prodotti che sono eccessivi dal database
     */
    private function deleteExcessiveProducts() {
        //CANCELLA PRODOTTI DELLE TIPOLOGIE CHE HANNO MODELLI MA I PRODOTTI NON SONO ASSOCIATI A NESSUNO DI QUESTI
        $sql = "SELECT id FROM ".$this->dbName.".typologies WHERE has_models > 0";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $typologies = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        foreach ( $typologies AS $typology ) {
            $sql = "DELETE FROM ".$this->dbName.".products WHERE typology_id = ".$typology->id." AND model_id is null";
            echo $sql ."\n";
            $this->mySql->query( $sql );   
        }
//        
        //CANCELLA PRODOTTI DELLE SOTTOCATEGORIA CHE NON HANNO TIPOLOGIE MA HANNO DEI MODELLI DIRETTAMENTE NELLA SOTTOCATEGORIA E I PRODOTTI NON SONO ASSOCIATI AD ESSA
        $sql = "SELECT subcategories.id, subcategories.name
            FROM ".$this->dbName.".subcategories left outer join ".$this->dbName.".typologies on typologies.subcategory_id = subcategories.id
            WHERE subcategories.has_models > 0 
            and typologies.id is null ";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $subcategories = $sth->fetchAll( \PDO::FETCH_OBJ );
                
        foreach ( $subcategories AS $subcategory ) {
            $sql = "DELETE FROM ".$this->dbName.".products WHERE subcategory_id = ".$subcategory->id." AND model_id is null";
            echo $sql ."\n";
            $this->mySql->query( $sql );   
        }
        
        //CANCELLA PRODOTTI DELLE TIPOLOGIE CHE NON HANNO MODELLI E LIMITA I PRODOTTIA ESSE A 1000
        $sql = "SELECT id,name FROM ".$this->dbName.".typologies WHERE has_models = 0";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $typologies = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        foreach ( $typologies AS $typology ) {
            $sql = "SELECT count(*) as tot FROM ".$this->dbName.".products WHERE typology_id = ".$typology->id." ";
            $sth = $this->mySql->prepare($sql);
            $sth->execute();
            $count = $sth->fetch( \PDO::FETCH_OBJ );
            echo $typology->name."\n";
            $limit = (int)$count->tot - 1000;
            if( $limit > 0 ) {            
                $sql = "DELETE FROM ".$this->dbName.".products WHERE typology_id = ".$typology->id." order by last_read asc limit $limit";
                echo $sql ."\n";
                $this->mySql->query( $sql );   
            }
        }        
        
        //CANCELLA PRODOTTI DELLE SOTTOCATEGORIE CHE NON HANNO TIPOLOGIE E CHE NON HANNO MODELLI E LIMITA I PRODOTTIA ESSE A 1000
        echo $sql = "SELECT subcategories.id, subcategories.name
            FROM ".$this->dbName.".subcategories left outer join ".$this->dbName.".typologies on typologies.subcategory_id = subcategories.id
            WHERE subcategories.has_models = 0 
            and typologies.id is null ";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $subcategories = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        foreach ( $subcategories AS $subcategory ) {
            $sql = "SELECT count(*) as tot FROM ".$this->dbName.".products WHERE subcategory_id = ".$subcategory->id." ";
            $sth = $this->mySql->prepare($sql);
            $sth->execute();
            $count = $sth->fetch( \PDO::FETCH_OBJ );
            echo $subcategory->name."\n";
            $limit = (int)$count->tot - 1000;
            if( $limit > 0 ) {            
                $sql = "DELETE FROM ".$this->dbName.".products WHERE subcategory_id = ".$subcategory->id." order by last_read asc limit $limit";
                echo $sql ."\n";
                $this->mySql->query( $sql );   
            }
        }    
        $this->deleteDisabledProduct();
    }
    
    //Elimina i prodotti disabilitati
    private function deleteDisabledProduct() {
        $date = date( 'Y-m-d H:i:s' );
        echo $sql  = "DELETE FROM ".$this->dbName.".products WHERE is_active = 0 and data_disabled is not null and data_disabled <=  CURRENT_DATE - INTERVAL 60 DAY";
        $this->mySql->query( $sql ); 
    }    
    
    private function fixRelationshipModelExternalTecnical() {
        $sql = "SELECT id,name FROM ".$this->dbName.".models";
        $sth = $this->mySql->prepare($sql);
        $sth->execute();
        $models = $sth->fetchAll( \PDO::FETCH_OBJ );
        
        foreach ( $models AS $model ) {
            echo $model->name;            
            echo $sql = "SELECT id FROM ".$this->dbName.".external_tecnical_template where model_id = '".$model->id."'";
            $sth = $this->mySql->prepare($sql);
            $sth->execute();
            $external = $sth->fetch( \PDO::FETCH_OBJ );
            
            if( !empty( $external ) ) {
                echo $external->id."\n";
                $sql = "UPDATE ".$this->dbName.".models SET external_tecnical_id = $external->id where id = $model->id";
                echo $sql."\n";
                $sth = $this->mySql->prepare($sql);
                $sth->execute();
            }
        }
    }
    
    /**
     * Conta il numero di parole alphanumeriche nella stringa
     * @param type $string
     * @return type
     */
    private function strWordCount($string) {
        $words = explode(' ', $string);
        return count($words);
    }
}