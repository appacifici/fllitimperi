<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Device;
use AppBundle\Entity\DeviceApp;
use AppBundle\Service\AffiliationService\AffiliationUtility;

class AdminManageController extends TemplateController {
    
    /**
     * @Route( "/admin/createProduct", name="createProduct" )     
     */
    public function createProductAction( Request $request ) {        
        if( $_GET['type'] == 'amazon') {
            $aws = $this->container->get('app.amazonApi');
            $product = $aws->getManualProduct( $_GET['url'] );
            echo $product;exit;
        } else {
            $aws = $this->container->get('app.ebayApi');
            $product = $aws->getManualProduct( $_GET['url'] );
            echo $product;exit;
        }            
    }
    
    /**
     * @Route( "/admin/changeTableModels/{newtable}", name="changeTableModels" )     
     */
    public function changeTableModelsAction( Request $request, $newtable ) {       
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }        
        
        $dbHost = $this->container->getParameter('database_host');
        $dbName = $this->container->getParameter('database_name');
        $dbUser = $this->container->getParameter('database_user');
        $dbPswd = $this->container->getParameter('database_password');        
        $this->mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);
        
        $this->mySql->exec("set names utf8");
        
        $params = new \stdClass();
        $params->mySql          = $this->mySql;
        $params->dbName         = $dbName;
        $params->container      = $this->container;
        $params->debug          = false;
                
        $currentTable = $newtable == 'models' ? 'disabled_models' : 'models';
//        echo 'tabella corrente =>'.$currentTable;
//        echo 'tabella nuova =>'.$newtable;
        
        
        $sql = "SELECT * FROM $dbName.$currentTable where id = ".$_GET['modelId'];
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $model = $sth->fetch( \PDO::FETCH_OBJ );          
        
        $sqlUp = "INSERT INTO $dbName.$newtable( name, name_url, name_url_pm, category_id, subcategory_id, typology_id, micro_section_id, is_active, date_import, is_top, last_read_price, date_release )
            VALUES(
            ".$this->mySql->quote( $model->name ).",
            ".$this->mySql->quote( $model->name ).",
            ".$this->mySql->quote( $model->name_url_pm ).",
            ".$this->mySql->quote( $model->category_id ).",
            ".$this->mySql->quote( $model->subcategory_id ).",
            ".( !empty( $model->typology_id ) ? $model->typology_id : 'NULL' ).",
            ".( !empty( $model->micro_section_id ) ? $model->micro_section_id : 'NULL' ).",
            '0',
            '".$model->date_import ."',
            $model->is_top,
            '2019-01-01 00:00:00',
            '2019-01-01 00:00:00'
        )";
//        $this->debug( $sqlUp );
        $this->mySql->query( $sqlUp );
        $id = $this->mySql->lastInsertId();
        if( !empty( $id  ) ) {                        
            $sql = "DELETE FROM $dbName.$currentTable where id = ".$_GET['modelId'];
            $sth = $this->mySql->prepare( $sql );
            $sth->execute();                        
            echo '1';
            exit;
        } 
        echo '0';
        exit;
    }
    
    
    /**
     * @Route( "/admin/insertFakeProduct/{affId}/{modelId}", name="insertFakeProduct" )     
     */
    public function insertFakeProductAction( Request $request, $affId, $modelId ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $resp = array();
        $dbHost = $this->container->getParameter('database_host');
        $dbName = $this->container->getParameter('database_name');
        $dbUser = $this->container->getParameter('database_user');
        $dbPswd = $this->container->getParameter('database_password');        
        $mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);
        
        $this->fkSubcatAffiliation = !empty( $this->fkSubcatAffiliation ) ? $this->fkSubcatAffiliation : 'NULL';
        echo $sql = "
            INSERT INTO ".$dbName.".products (
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
                ".$affId.",
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                $modelId,
                'PROVA',
                0,
                'AA',
                'aa',
                '".rand(0, 50000 )."',
                '".date('Y-m-d H:i:s')."',
                '".date('Y-m-d H:i:s')."',
                '".str_replace( 'T',' ',date('Y-m-d H:i:s') )."',
                1,
                0,
                NULL,
                NULL,
                NULL,
                'in stock',
                NULL
            )
        ";
        $stn = $mySql->query( $sql );
        if( !empty( $stn ) )
            return new Response( $mySql->lastInsertId() );
        else 
            return new Response( 0 );
    }
    
    /**
     * @Route( "/admin/restoremodel", name="rest", defaults={"id"=false} )     
     */
    public function restoremodel( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $dbHost = $this->container->getParameter('database_host');
        $dbName = $this->container->getParameter('database_name');
        $dbUser = $this->container->getParameter('database_user');
        $dbPswd = $this->container->getParameter('database_password');        
        $this->mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);
        
        $this->mySql->exec("set names utf8");
        
        $params = new \stdClass();
        $params->mySql          = $this->mySql;
        $params->dbName         = $dbName;
        $params->container      = $this->container;
        $params->debug          = false;
        $affiliationUtility = new AffiliationUtility( $params );
        
        
        $sql = "SELECT * FROM $dbName.products where affiliation_id = 5 limit 1";
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $products = $sth->fetchAll( \PDO::FETCH_OBJ );          
        echo $products[0]->description;
        
        echo mb_detect_encoding($products[0]->description);
        exit;
        
        foreach( $products AS $product ) {   
            
            //Se la categoria è abbigliamento avvio il check per l'associazione della tipologia
            if( !empty( $product->category_id ) &&  $product->category_id != NULL && $product->category_id != 'NULL' && $product->category_id == 8 ) {
                $affiliationUtility->checkTypology( $product->subcategory_id, $product->name, $product->id, $product->description, false, $product->category_id );
                
                $affiliationUtility->checkSex( $product );
                $affiliationUtility->checkSize( $product );  
                $affiliationUtility->checkColor( $product );
                
            //Se c'è la sottocategoria, associata grazie alla lookup,
            //prova a recuperare modello prodotto se possibile
            } else if( !empty( $product->subcategory_id )  ) {
                echo 'eieiei';
                $affiliationUtility->checkModel( $product->subcategory_id, $product->name, $product->id, $product->description, false );
                exit;
            }            
            
        }
    }
    
    /**
     * @Route( "/admin/lookupSubcategories", name="loockupSubcategories", defaults={"id"=false} )     
     */
    public function extraConfigAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "lookupSubcategories.xml", $request ) );  
    } 
    
    /**
     * @Route( "/admin/offLoockupSubcategorySiteAffiliation/{id}", name="offLoockupSubcategory", defaults={"id"=false} )     
     */
    public function offLoockupSubcategoryAction( Request $request, $id ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $item = $this->getDoctrine()->getRepository('AppBundle:SubcategorySiteAffiliation')->find( $id );        
        $item->setIsActive( 2 );        
        $em = $this->getDoctrine()->getManager();        
        
        try {
            $em->persist( $item );
            $em->flush();
            $resp['error'] = false;
            $resp['msg'] = 'COMPLIMENTI: SubcategorySiteAffiliation SPENTA';
        } catch (Exception $e) {
            $resp['error'] = true;
            $resp['msg'] = 'ERRORE SubcategorySiteAffiliation SPENTA';
        }
        return new Response( json_encode( $resp ) );        
    } 
    
    
    /**
     * @Route( "/admin/dubbioLoockupSubcategorySiteAffiliation/{id}", name="dubbioLoockupSubcategory", defaults={"id"=false} )     
     */
    public function dubbioLoockupSubcategoryAction( Request $request, $id ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $item = $this->getDoctrine()->getRepository('AppBundle:SubcategorySiteAffiliation')->find( $id );        
        $item->setIsActive( 3 );        
        $em = $this->getDoctrine()->getManager();        
        
        try {
            $em->persist( $item );
            $em->flush();
            $resp['error'] = false;
            $resp['msg'] = 'COMPLIMENTI: SubcategorySiteAffiliation IN DUBBIO';
        } catch (Exception $e) {
            $resp['error'] = true;
            $resp['msg'] = 'ERRORE SubcategorySiteAffiliation IN DUBBIO';
        }
        return new Response( json_encode( $resp ) );        
    } 
    
    /**
     * @Route( "/admin/getProductsSubcategorySiteAffiliation/{id}", name="getProductsSubcategorySiteAffiliation", defaults={"id"=false} )     
     */
    public function getProductsSubcategorySiteAffiliationAction( Request $request, $id ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $aProducts = $this->getDoctrine()->getRepository('AppBundle:Product')->findBy( array( 'fkSubcatAffiliation' => $id ), array(), 14 );        
        $products = array();
        
        $x = 0;
        foreach( $aProducts AS $product ) {
            if( !empty( $product->getPriorityImg() ) ) {
                $products[$x]['img'] = $this->container->getParameter('app.folder_imgProductsSmall').$product->getPriorityImg()->getImg();
                $products[$x]['deepLink'] = $product->getDeepLink();
                $x++;
            }        
        }        
        return new JsonResponse( $products );
    } 
     
    /**
     * @Route( "/admin/setLoockupSubcategories/{idSubcatAff}/{category}/{subcategory}/{typology}", name="setLoockupSubcategories", defaults={"typology"=false} )     
     */
    public function setLoockupSubcategoriesAction( Request $request, $idSubcatAff, $category, $subcategory, $typology = false ) { 
        ini_set('max_execution_time', 300); 
        
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }
                
        $affiliationId = $_REQUEST['affiliationId'];
        
        
        $dbHost = $this->container->getParameter('database_host');
        $dbName = $this->container->getParameter('database_name');
        $dbUser = $this->container->getParameter('database_user');
        $dbPswd = $this->container->getParameter('database_password');        
        $this->mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);
        if( $typology == 'undefined' )
            $typology = false;  
        
        $resp = array();
        $resp['error'] = false;
        $resp['msg'] = 'Loockup eseguita con successo';        
        $typologyId = !empty( $typology ) ? $typology : false;
        $typology   = !empty( $typology ) ? $typology : 'NULL';        
        
        $sql = "SELECT * FROM $dbName.lookup_subcategories WHERE subcategorySiteAffiliation_id = $idSubcatAff";
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $loockup = $sth->fetch( \PDO::FETCH_OBJ );  
        if( empty( $loockup ) ) {
            //Inserisce una nuova loockup
            $sql = "INSERT INTO $dbName.lookup_subcategories (subcategory_id,subcategorySiteAffiliation_id, typology_id)
                VALUE ( $subcategory, $idSubcatAff, $typology )
            ";
            $stn = $this->mySql->query( $sql );
//            echo $sql."<br>";
            
            if( !$stn ) {
                $resp['error'] = true;
                $resp['msg'] = 'Errore query: '. $sql;
            }
        } else {
            //Modifica la sottocategoria di loockup
            $sql = "UPDATE $dbName.lookup_subcategories SET subcategory_id = $subcategory, typology_id = $typology
                WHERE subcategorySiteAffiliation_id = $idSubcatAff
            ";
            $stn = $this->mySql->query( $sql ); 
//            echo $sql."<br>";
            if( !$stn ) {
                $resp['error'] = true;
                $resp['msg'] = 'Errore query: '. $sql;
            }
        }        
        
        //Attiva la sottocategoria affiliation
        $sql = "UPDATE $dbName.subcategorySiteAffiliations SET is_active = 1
            WHERE id = $idSubcatAff
        ";
        $stn = $this->mySql->query( $sql ); 
//        echo $sql."<br>";
        
        if( empty( $stn )) {
            $resp['error'] = true;
            $resp['msg'] = 'Errore query: '. $sql;
        }
        
        //Setta i dati sulla loockup
        $sql2 = "UPDATE $dbName.products SET category_id = $category, subcategory_id = $subcategory, typology_id = $typology
            WHERE fk_subcat_affiliation_id = $idSubcatAff
        ";
        $stn = $this->mySql->query( $sql2 ); 
//        echo $sql2."<br>";
        
        if( !$stn ) {
            $resp['error'] = true;
            $resp['msg'] = 'Errore query: '. $sql;
        }        
        
//        
//        $params = new \stdClass();
//        $params->mySql          = $this->mySql;
//        $params->dbName         = $dbName;
//        $params->container      = $this->container;
//        $params->debug          = false;
//        $affiliationUtility = new AffiliationUtility( $params );
//        
//        $whereTypology = $typology == 'NULL'  ? 'typology_id is null' : ' typology_id = '.$typology;
//        
//        //Vado a ciclare i prodotti loockuppati per settare typologia o modello
//        $sql = "SELECT * FROM $dbName.products 
//            WHERE affiliation_id = $affiliationId AND category_id = $category AND subcategory_id = $subcategory and $whereTypology";
//        
//        
//        $sth = $this->mySql->prepare( $sql );
//        $sth->execute();
//        $products = $sth->fetchAll( \PDO::FETCH_OBJ );          
//        $affiliationUtility->insertAfter = false;
//        
//        foreach( $products AS $product ) {         
//            $affiliationUtility->prepareQueryInsertProduct( false, $product );
//            //Se la categoria è abbigliamento avvio il check per l'associazione della tipologia
//            if( !empty( $product->category_id ) &&  $product->category_id != NULL && $product->category_id != 'NULL' && $product->category_id == 8 ) {
//                $affiliationUtility->checkTypology( $product->subcategory_id, $product->name, $product->id, $product->description, $typologyId, $product->category_id );
//                
//                $affiliationUtility->checkSex( $product );
//                $affiliationUtility->checkSize( $product );  
//                $affiliationUtility->checkColor( $product );
//                
//            //Se c'è la sottocategoria, associata grazie alla lookup,
//            //prova a recuperare modello prodotto se possibile
//            } else if( !empty( $subcategory ) && $subcategory != NULL && $subcategory != 'NULL'  ) {
//                $affiliationUtility->checkModel( $product->subcategory_id, $product->name, $product->id, $product->description, $typologyId );
//            }            
//        }
        
        return new Response( json_encode( $resp ) );        
    } 
    
    /**
     * @Route( "/admin/changeProductSection", name="changeProductSection" )     
     */
    public function changeProductSection( Request $request ) {
        //SPOSTA I PRODOTTI SELEZIONATI IN UN ALTRA SEZIONE
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $resp = array();
        $dbHost = $this->container->getParameter('database_host');
        $dbName = $this->container->getParameter('database_name');
        $dbUser = $this->container->getParameter('database_user');
        $dbPswd = $this->container->getParameter('database_password');        
        $this->mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);
                
        $category       = $_GET['category_change'];
        $subcategory    = $_GET['subcategory_change'];
        $typology       = $_GET['typology_change'];
        $typology       = !empty( $typology ) ? $typology : 'NULL';        
        
        if( empty( $category ) || empty( $subcategory ) ) {
            $resp['error'] = true;
            $resp['msg'] = 'Seleziona le sezioni in cui spostare i prodotti: '. $sql;
            return new Response( json_encode( $resp ) );      
        }
        
        $productsId = trim( $_GET['productsId'],' ,' );
        
        $sql = "UPDATE $dbName.products
            SET category_id = $category, subcategory_id = $subcategory, typology_id = $typology, model_id = NULL, is_active = 1
                WHERE id in ( $productsId )
        ";                  
        $stn = $this->mySql->query( $sql ); 
        
        if( !$stn ) {
            $resp['error'] = true;
            $resp['msg'] = 'Errore: '. $sql;
        } else {
            $resp['error'] = false;
            $resp['msg'] = 'Prodotti spostati con successo';
        }
        
        return new Response( json_encode( $resp ) );        
    }
    
    /**
     * @Route( "/admin/changeProductModel", name="changeProductModel" )     
     */
    public function changeProductModel( Request $request ) {
        //SPOSTA I PRODOTTI SELEZIONATI IN UN ALTRA SEZIONE
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $resp = array();
        $dbHost = $this->container->getParameter('database_host');
        $dbName = $this->container->getParameter('database_name');
        $dbUser = $this->container->getParameter('database_user');
        $dbPswd = $this->container->getParameter('database_password');        
        $this->mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);
        
        if( empty( $_GET['modelId'] ) ) {
            $resp['error'] = true;
            $resp['msg'] = 'Seleziona l\'id del modello da settare';
            return new Response( json_encode( $resp ) );      
        }
        
        $sql = "SELECT id, category_id,subcategory_id,typology_id FROM  $dbName.models WHERE id =".trim($_GET['modelId']);
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $model = $sth->fetch( \PDO::FETCH_OBJ );      
        
         if( empty( $model ) ) {
            $resp['error'] = true;
            $resp['msg'] = 'Errore: '. $sql;
            return new Response( json_encode( $resp ) );  
        }        
        
                        
        $modelId        = $model->id;
        $category       = $model->category_id;
        $subcategory    = $model->subcategory_id;
        $typology       = $model->typology_id;
        $typology       = !empty( $typology ) ? $typology : 'NULL';        
        
        if( empty( $category ) || empty( $subcategory ) ) {
            $resp['error'] = true;
            $resp['msg'] = 'Seleziona le sezioni in cui spostare i prodotti: '. $sql;
            return new Response( json_encode( $resp ) );      
        }
        
        $productsId = trim( $_GET['productsId'],' ,' );
        
        $sql = "UPDATE $dbName.products
            SET category_id = $category, subcategory_id = $subcategory, typology_id = $typology, model_id = $modelId, is_active = 1
                WHERE id in ( $productsId )
        ";                  
        $stn = $this->mySql->query( $sql ); 
        
        if( !$stn ) {
            $resp['error'] = true;
            $resp['msg'] = 'Errore: '. $sql;
        } else {
            $resp['error'] = false;
            $resp['msg'] = 'Prodotti spostati con successo';
        }
        
        return new Response( json_encode( $resp ) );        
    }
    
    
    /**
     * @Route( "/admin/getProductInKelkooApi", name="getProductInKelkooApi" )     
     */
    public function getProductInKelkooApi( Request $request ) { 
        $search     = $_GET['name'];
        $order      = $_GET['order'];
        $minPrice   = $_GET['minPrice'];
        $maxPrice   = $_GET['maxPrice'];
        $url =  $this->UrlSigner('http://it.shoppingapis.kelkoo.com','96955639', 'XiuYWGiR', '/V3/productSearch?query='.urlencode( $search ).'+&sort='.$order.'&start=1&results=20&price_min='.$minPrice.'&price_max='.$maxPrice.'&show_products=1&show_subcategories=1&show_refinements=0');
        $document = simplexml_load_file( $url, 'SimpleXMLElement', LIBXML_NOCDATA);
        
        $resp = array();
        $x = 0;
        foreach ( $document->Products->Product as $item ) {
            $product = $item->Offer;
            $productName = $product->Title;                            
            $imagesProduct = (string)$product->Images->Image->Url;             
            
            $attributes = $product->attributes();
            $productNumber = $attributes['id'];       
            
            $merchantName = $product->Merchant->Name;            
            $merchantLogo = $product->Merchant->Logo->Url;            

            $resp[$x]['name'] = (string)$productName;
            $resp[$x]['number'] = (string)$productNumber;
            $resp[$x]['image'] = (string)$imagesProduct;
            $resp[$x]['merchantName'] = (string)$merchantName;
            $resp[$x]['merchantLogo'] = (string)$merchantLogo;
            $x++;
        }    
        return new Response(json_encode( $resp ) );        
    }
    
    /**
     * @Route( "/admin/insertProductsKelkooModelBtn/{affId}/{modelId}", name="insertProductsKelkooModelBtn" )     
     */
    public function insertProductsKelkooModelBtn( Request $request, $affId, $modelId ) {
        $this->baseParameters();
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }

        $aNumber = $_POST['productsNumber'];
        
        $model = $this->getDoctrine()->getRepository('AppBundle:Model')->find( $modelId );
        
        $affiliation = $this->getDoctrine()->getRepository('AppBundle:Affiliation')->find( $affId );
        
        $linkFeed = str_replace( ' ', '_', $affiliation->getName() );
        
        $pathBase = $this->container->getParameter( 'app.catalogsPath' );
        
        $search     = $_GET['name'];
        $order      = $_GET['order'];
        $minPrice   = $_GET['minPrice'];
        $maxPrice   = $_GET['maxPrice'];
        $url =  $this->UrlSigner('http://it.shoppingapis.kelkoo.com','96955639', 'XiuYWGiR', '/V3/productSearch?query='.urlencode( $search ).'+&sort='.$order.'&start=1&results=20&price_min='.$minPrice.'&price_max='.$maxPrice.'&show_products=1&show_subcategories=1&show_refinements=0');
        $document = simplexml_load_file( $url, 'SimpleXMLElement', LIBXML_NOCDATA);
        
        $resp = array();
        $x = 0;
        
            
        
        $resp = array();
        $x = 0;
        $response = array();
        $response['success'] = 0;
        $response['error']   = 0;
        
        foreach ( $document->Products->Product as $item ) {
            $product = $item->Offer;
            $attributes = $product->attributes();
            $productNumber = $attributes['id'];   
            
            if( !in_array( $productNumber, $aNumber  ) )
                continue;
                                
            $resp = array();
            $dbHost = $this->container->getParameter('database_host');
            $dbName = $this->container->getParameter('database_name');
            $dbUser = $this->container->getParameter('database_user');
            $dbPswd = $this->container->getParameter('database_password');        
            $mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);

            $this->fkSubcatAffiliation = !empty( $this->fkSubcatAffiliation ) ? $this->fkSubcatAffiliation : 'NULL';
            
            $categoryId     = $model->getCategory()->getId();
            $subcategoryId  = $model->getSubcategory()->getId();
            $typologyId     = !empty( $model->getTypology() ) ? $model->getTypology()->getId() : 'NULL';
            $deepLink       = $product->Url;
            $shortDescription       = $product->Description;
            $price  = $product->Price->Price;
            $shippingHandlingCosts  = $product->Price->DeliveryCost;
            $shippingHandlingCosts  = !empty( $shippingHandlingCosts ) ? $shippingHandlingCosts : 0;
            
            $merchantImg = $product->Merchant->Logo->Url;
            
            $productName = $product->Title;
            $sql = "
                INSERT INTO ".$dbName.".products (
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
                    ".$affId.",
                    NULL,
                    $categoryId,
                    $subcategoryId,
                    NULL,
                    $typologyId,
                    $modelId,
                    ".$mySql->quote( (string)$productName ).",
                    ".(string)$price.",
                    '".$deepLink."',
                    '".md5( $deepLink )."',
                    '".$productNumber."',
                    '".date('Y-m-d H:i:s')."',
                    '".date('Y-m-d H:i:s')."',
                    '".str_replace( 'T',' ',date('Y-m-d H:i:s') )."',
                    1,
                    $shippingHandlingCosts,
                    NULL,
                    NULL,
                    NULL,
                    'in stock',
                    ".$mySql->quote( (string)$shortDescription )."
                )
            ";
//            echo $sql;
            $stn = $mySql->query( $sql );
            if( !empty( $stn ) ) {
                $response['success']++;
                
                $idProduct = $mySql->lastInsertId();
                
                $rewriteName = $this->globalConfigManager->globalUtility->getNameImageProduct( $product->Merchant->Name );
                if( !file_exists( $this->container->getParameter('app.folder_imgAffiliations_small_write').$rewriteName.'.jpg' ) ) {
                
                    $myFile = array();
                    $myFile['name'][0] = $merchantImg;
                    $myFile['tmp_name'][0] = $merchantImg;               
                    $myFile['type'][0] = $this->globalConfigManager->globalUtility->imageUtility->myGetTypeImg( $merchantImg  );

                    $widthFoto =  $this->container->getParameter('app.imgAffiliations_small_width');
                    $heightFoto =  $this->container->getParameter('app.imgAffiliations_small_height');
                    $rewriteName = $this->globalConfigManager->globalUtility->getNameImageProduct( $product->Merchant->Name );

                    $file = $fileSmall = $this->globalConfigManager->globalUtility->imageUtility->myUpload( 
                            $myFile, 
                            $this->container->getParameter('app.folder_imgAffiliations_small_write'), 
                            $this->container->getParameter('app.folder_tmp'), 
                            $widthFoto, 
                            $heightFoto, 
                            "Product", 
                            session_id(), 
                            $idProduct, 
                            array(), 
                            false,
                            'jpg',
                            $rewriteName ,
                            true
                    );
                }
                if ( !empty( $rewriteName ) ) {
                    $sql = "UPDATE ".$dbName.".products SET merchant_img = '".$rewriteName.".jpg' WHERE id = ".$idProduct;
                    $mySql->query( $sql );
                }
                
            } else {
                $response['error']++;
            }
        }
        return new Response(json_encode( $response) );
    }
    
    
    /**
     * @Route( "/admin/getProductInFeedByName", name="getProductInFeedByName" )     
     */
    public function getProductInFeedByName( Request $request ) { 
        $affiliation = $this->getDoctrine()->getRepository('AppBundle:Affiliation')->find( $_GET['affiliationId'] );
        $linkFeed = str_replace( ' ', '_', $affiliation->getName() );
        
        $pathBase = $this->container->getParameter( 'app.catalogsPath' );
        
        $document = simplexml_load_file( $pathBase.$linkFeed.'.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
        $resp = array();
        $x = 0;
        
        $documentProduct = $document->product;
        
        if( $_GET['affiliationId'] == 23 )
            $documentProduct = $document->merchant->prod;
        
        foreach ( $documentProduct as $product ) {
            $productName = !empty( $product->name ) ? $product->name : ( !empty( $product->product_name ) ? $product->product_name : '' );
            if( empty( $productName ) && !empty( $product->text ) ) {
                $productName = $product->text->name;
            }
            
            //Descrizione del prodotto
            $description = '';
            if ( !empty( $product->longDescription ) )
                $description = $product->longDescription;
            else if ( !empty( $product->description ) )
                $description = $product->description;
            else if ( !empty( $product->product_short_description ) )
                $description = $product->product_short_description;
            else if ( !empty( $product->desc ) )
                $description = $product->desc;
            
            
            if( strpos( ' '. strtolower ( $productName ).' '.$description.' ', strtolower( $_GET['name']  ) ) !== FALSE ) {    
                $imagesProduct = !empty( $this->product->mediumImage ) ? $this->product->mediumImage : ( !empty( $this->product->largeImage ) ? $this->product->largeImage : false );
                $imagesProduct = !empty( $imagesProduct ) ? $imagesProduct : ( !empty( $this->product->smallImage ) ? $this->product->smallImage : false );
                if( empty( $imagesProduct ) and !empty( $product->imageUrl ) )
                    $imagesProduct = (string)$product->imageUrl;
                
                if( empty( $imagesProduct ) and !empty( $product->uri->awImage ) )
                    $imagesProduct = (string)$product->uri->awImage;
                
                
                $productNumber = !empty( $product->number ) ? (string)$product->number : (string)$product->TDProductId;
                if( empty( $productNumber ) )   
                    $productNumber = isset( $product->aw_product_id ) ? (string)$product->aw_product_id : $productNumber;
                if( empty( $productNumber ) )   
                    $productNumber = isset( $product->pId ) ? (string)$product->pId : $productNumber;
                
                $resp[$x]['name'] = (string)$productName.' - ';
                $resp[$x]['number'] = $productNumber;
                $resp[$x]['image'] = (string)$imagesProduct;
                $resp[$x]['affId'] = (string)$_GET['affiliationId'];
                $x++;
            } 
        }
        return new Response(json_encode( $resp ) );        
    }
    
    /**
     * @Route( "/admin/insertProductInFeedByName/{affId}/{modelId}/{productsNumber}", name="insertProductInFeedByName" )     
     */
    public function insertProductInFeedByName( Request $request, $affId, $modelId, $productsNumber ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }

        $aNumber = explode( ',', $productsNumber );
        
        $model = $this->getDoctrine()->getRepository('AppBundle:Model')->find( $modelId );
        
        $affiliation = $this->getDoctrine()->getRepository('AppBundle:Affiliation')->find( $affId );
        
        $linkFeed = str_replace( ' ', '_', $affiliation->getName() );
        
        $pathBase = $this->container->getParameter( 'app.catalogsPath' );
        
        $document = simplexml_load_file( $pathBase.$linkFeed.'.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
        $resp = array();
        $x = 0;
        $response = array();
        $response['success'] = 0;
        $response['error']   = 0;
        
        $documentProduct = $document->product;
        
        if( $affId == 23 )
            $documentProduct = $document->merchant->prod;
        
        
        foreach ( $documentProduct as $product ) {
            $productNumber = !empty( $product->number ) ? (string)$product->number : (string)$product->TDProductId;
                if( empty( $productNumber ) )   
                    $productNumber = isset( $product->aw_product_id ) ? (string)$product->aw_product_id : $productNumber;          
                
                if( empty( $productNumber ) )   
                    $productNumber = isset( $product->pId ) ? (string)$product->pId : $productNumber;
            
            if( !in_array( $productNumber, $aNumber  ) )
                continue;
                    
            $resp = array();
            $dbHost = $this->container->getParameter('database_host');
            $dbName = $this->container->getParameter('database_name');
            $dbUser = $this->container->getParameter('database_user');
            $dbPswd = $this->container->getParameter('database_password');        
            $mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);

            $this->fkSubcatAffiliation = !empty( $this->fkSubcatAffiliation ) ? $this->fkSubcatAffiliation : 'NULL';
            
            $categoryId     = !empty( $model->getCategory() ) ? $model->getCategory()->getId() : 'NULL';
            $subcategoryId  = !empty( $model->getSubcategory() ) ? $model->getSubcategory()->getId(): 'NULL';
            $typologyId     = !empty( $model->getTypology() ) ? $model->getTypology()->getId() : 'NULL';
            $deepLink       = isset( $product->deepLink ) ? $product->deepLink : $product->productUrl;
            if( empty( $deepLink ))
                $deepLink = isset( $product->aw_deep_link ) ? $product->aw_deep_link : false;  
            if( empty( $deepLink ) && !empty( $product->uri->awTrack) )
                $deepLink = isset( $product->uri->awTrack ) ? $product->uri->awTrack : false;  
            
            $shortDescription       = isset( $product->shortDescription ) ? $product->shortDescription : 'NULL';
            if( empty( $shortDescription ) && !empty( $product->text->desc ) )
                $shortDescription = $product->text->desc;
            
            $shippingHandlingCosts = isset( $product->shippingHandlingCost ) ? $product->shippingHandlingCost : $product->shippingCost;
            $shippingHandlingCosts  = !empty( $shippingHandlingCosts ) ? $shippingHandlingCosts : 0;
            if( empty( $shippingHandlingCosts ) && !empty( $product->price ) )
                $shortDescription = $product->price->delivery;
            
            
            $productName = !empty( $product->name ) ? $product->name : ( !empty( $product->product_name ) ? $product->product_name : '' );
            if( empty( $productName ) && !empty( $product->text ) ) {
                $productName = $product->text->name;
            }
            
            $price = !empty( $product->price ) ? $product->price  : ( !empty( $product->search_price ) ? $product->search_price : false );
            if(is_object( $price ) && !empty( $product->price->buynow ) )
                $price = $product->price->buynow;
            
              
            
            $sql = "
                INSERT INTO ".$dbName.".products (
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
                    ".$affId.",
                    NULL,
                    $categoryId,
                    $subcategoryId,
                    NULL,
                    $typologyId,
                    $modelId,
                    ".$mySql->quote( (string)$productName ).",
                    ".(string)$price.",
                    '".$deepLink."',
                    '".md5( $deepLink )."',
                    '".$productNumber."',
                    '".date('Y-m-d H:i:s')."',
                    '".date('Y-m-d H:i:s')."',
                    '".str_replace( 'T',' ',date('Y-m-d H:i:s') )."',
                    1,
                    $shippingHandlingCosts,
                    NULL,
                    NULL,
                    NULL,
                    'in stock',
                    ".$mySql->quote( (string)$shortDescription )."
                )
            ";
//            echo $sql;
            $stn = $mySql->query( $sql );
            if( !empty( $stn ) )
                $response['success']++;
            else 
                $response['error']++;
        }
        return new Response(json_encode( $response) );
    }
    
    function UrlSigner($urlDomain, $partner, $key, $urlPath ){
        settype($urlDomain, 'String');
        settype($urlPath, 'String');
        settype($partner, 'String');
        settype($key, 'String');

        $URL_sig = "hash";
        $URL_ts = "timestamp";
        $URL_partner = "aid"; 
        $URLreturn = "";
        $URLtmp = "";
        $s = "";
        // get the timestamp
        $time = time();

        // replace " " by "+"
        $urlPath = str_replace(" ", "+", $urlPath);
        // format URL
        $URLtmp = $urlPath . "&" . $URL_partner . "=" . $partner . "&" . $URL_ts . "=" . $time;

        // URL needed to create the tokken
        $s = $urlPath . "&" . $URL_partner . "=" . $partner . "&" . $URL_ts . "=" . $time . $key;
        $tokken = "";
        $tokken = base64_encode(pack('H*', md5($s)));
        $tokken = str_replace(array("+", "/", "="), array(".", "_", "-"), $tokken);
        $URLreturn = $urlDomain . $URLtmp . "&" . $URL_sig . "=" . $tokken;
        return $URLreturn;
        }
    
}