<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Menu;
use AppBundle\Entity\TopTrademarksSection;
use AppBundle\Entity\Subcategory;
use AppBundle\Entity\User;
use AppBundle\Entity\Image;
use AppBundle\Entity\Poll;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\DBAL\Types\DateTimeType;
use AppBundle\Service\SpiderService\proxyConnector;


class AdminController extends TemplateController {            
    
    /**
     * @Route( "/chat", name="chat" )     
     */
    public function chatAction( Request $request ) { 
       return new Response( $this->init( "chat.xml", $request ) );  
    }
    
    /**
     * @Route( "/logoutExternalUser", name="logoutExternalUser" )     
     */
    public function logoutExternalUserAction( Request $request ) { 
        if ( !empty($_COOKIE['externalUserCode'] ) )
//                    return $this->redirectToRoute('homepage');

//        $cacheUtility = $this->container->get('app.cacheUtility');
//        $cacheUtility->initPhpCache();
//        $cacheUtility->phpCacheRemove($this->container->getParameter( 'session_memcached_prefix' ).'user_'.$_COOKIE['externalUserCode']);
        unset($_COOKIE['externalUserCode']);        
        
        setcookie("externalUserCode", '', time()-3600, "/", $_SERVER['HTTP_HOST'] );            

         try {
            $resp = true;

            return new Response(json_encode($resp));

        } catch (Exception $e) {
            
            $resp['error'] = true;
            $resp['msg'] = 'Ops... si è verificato un errore';
            return new Response(json_encode($resp));
        }
    }
    
    /**
     * @Route( "/admin", name="admin" )     
     */
    public function indexAction( Request $request ) { 
        $um = $this->container->get('app.usermanager');    
        
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        } else {
            return $this->redirectToRoute('adminListArticles');
        }
                         
        return new Response( $this->init( "homepage.xml", $request ) );  
    }
    
    //--------------------------------------------------------------
     
    /**
     * @Route( "/admin/login", name="login" )     
     */
    public function loginAction( Request $request ) { 
        $um = $this->container->get('app.usermanager');  
        
        if ( !empty( $um->isLogged() ) )
            return $this->redirectToRoute('adminListArticles');  
        
        $isAjax = $request->isXmlHttpRequest();                        
        if( $isAjax ) {
            $userName = $request->query->get("username");
            $password = md5($request->query->get("password"));
            if ( $um->loginUser($userName, $password) ) {
                return new Response(1);
            } else {
                return new Response(0);
            }
        }
        
        $params = new \stdClass;                            
        return new Response( $this->init( "homepage.xml", $request, $params ) );  
    }  
    
    /**
     * @Route( "/admin/userLogged", name="userLogged" )     
     */
    public function userLoggedAction( Request $request ) { 
        $um = $this->container->get('app.usermanager');  

        if ( !empty( $this->checkIsValidRequestAdmin($request) ) ) {             
            return new Response(1);
        } else {
            return new Response(0);
        }
    }
        
    
    /**
     * @Route( "/admin/logout", name="logout" )     
     */
    public function logoutAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $cacheUtility = $this->container->get('app.cacheUtility');
        $cacheUtility->initPhpCache();
        $cacheUtility->phpCacheRemove($this->container->getParameter( 'session_memcached_prefix' ).'user_'.$_COOKIE['userCode']);
        unset($_COOKIE['userCode']);        
        
        setcookie("userCode", '', time()-3600, "/", $_SERVER['HTTP_HOST'] );            
        
        return $this->redirectToRoute('login');
    }   
    
     /**
     * @Route( "/admin/trading", name="trading" )     
     */
    public function tradingAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "trading.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/bestDiscount", name="bestDiscount" )     
     */
    public function bestDiscountAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "bestDiscountedPrices.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/topTrademarkSection", name="topTrademarkSection" )     
     */
    public function topTrademarkSectionAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "topTrademarkSection.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/category", name="category" )     
     */
    public function categoryAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "category.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/editCategoryMP/{id}", name="editCategoryMP", defaults={"id"=false} )     
     */
    public function editCategoryMPAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editCategoryMP.xml", $request ) );  
    }

    /**
     * @Route( "/admin/listTypology", name="listTypology" )     
     */
    public function typologyAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listTypology.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/editTypology/{id}", name="editTypology", defaults={"id"=false} )     
     */
    public function editTypologyAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editTypology.xml", $request ) );  
        exit;
    }
        
    /**
     * @Route( "/admin/listMicroSection", name="listMicroSection" )     
     */
    public function listMicroSectionAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listMicroSection.xml", $request ) );  
        exit;
    }
    
        
    /**
     * @Route( "/admin/editMicroSection/{id}", name="editMicroSection", defaults={"id"=false} )     
     */
    public function editMicroSectionAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editMicroSection.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/listSearchTerms", name="listSearchTerms" )     
     */
    public function listSearchTermsAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listSearchTerms.xml", $request ) );  
        exit;
    }
            
    /**
     * @Route( "/admin/editSearchTerm/{id}", name="editSearchTerm", defaults={"id"=false} )     
     */
    public function editSearchTermsAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editSearchTerms.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/listSex", name="listSex" )     
     */
    public function listSexAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listSex.xml", $request ) );  
        exit;
    }
            
    /**
     * @Route( "/admin/editSex/{id}", name="editSex", defaults={"id"=false} )     
     */
    public function editSexAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editSex.xml", $request ) );  
        exit;
    }
        
    /**
     * @Route( "/admin/listSizes", name="listSizes" )     
     */
    public function listSizeAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listSize.xml", $request ) );  
        exit;
    }
            
    /**
     * @Route( "/admin/editSize/{id}", name="editSize", defaults={"id"=false} )     
     */
    public function editSizeAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editSize.xml", $request ) );  
        exit;
    }
        
    /**
     * @Route( "/admin/listColors", name="listColors" )     
     */
    public function listColorsAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listColor.xml", $request ) );  
        exit;
    }
            
    /**
     * @Route( "/admin/editColor/{id}", name="editColor", defaults={"id"=false} )     
     */
    public function editColorAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editColor.xml", $request ) );  
        exit;
    }
    
    
    /**
     * @Route( "/admin/listModel", name="listModel" )     
     */
    public function modelAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listModel.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/listComparison", name="listComparison" )     
     */
    public function listComparisonAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listComparison.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/editComparison", name="editComparison" )     
     */
    public function editComparisonAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editComparison.xml", $request ) );  
        exit;
    }
    
    
    /**
     * @Route( "/admin/listDisabledModel", name="listDisabledModel" )     
     */
    public function listDisabledModelAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listDisabledModel.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/editModel/{id}", name="editModel", defaults={"id"=false} )     
     */
    public function editModelAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editModel.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/listProduct", name="listProductsAdmin" )     
     */
    public function productAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listProduct.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/editProduct/{id}", name="editProduct", defaults={"id"=false} )     
     */
    public function editProductAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editProduct.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/listTrademark", name="listTrademark" )     
     */
    public function trademarkAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listTrademark.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/editTrademark/{id}", name="editTrademark", defaults={"id"=false} )     
     */
    public function editTrademarkAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editTrademark.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/listAffiliation", name="listAffiliation" )     
     */
    public function affiliationAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listAffiliations.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/editAffiliation/{id}", name="editAffiliation", defaults={"id"=false} )     
     */
    public function editAffiliationAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editAffiliation.xml", $request ) );  
        exit;
    }
    
    /**
     * @Route( "/admin/listDinamycPage", name="listDinamycPage" )     
     */
    public function listDinamycPageAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "dinamycPage.xml", $request ) );  
        exit;
    }   
    
    /**
     * @Route( "/admin/editDinamycPage/{id}", name="editDinamycPage" )     
     */
    public function dinamycPageAction( Request $request, $id = false ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editDinamycPage.xml", $request ) );  
        exit;
    }   
    
    //-------------------------------------------------------------
    
    /**
     * @Route( "/admin/updateOrderMenu/{ids}", name="updateOrderMenu" )     
     */
    public function updateOrderMenuAction( Request $request, $ids) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        // Creazione array con il nuovo ordine delle categorie
        $aIds = explode(",", $ids);
        // Ciclo che itera tutti gli id e setta il nuovo ordine
        foreach( $aIds AS $orderMenu => $id ) {


            $em = $this->getDoctrine()->getManager();
            $menu = $em->getRepository('AppBundle:Menu')->findOneById($id);
            if (!$menu) {
                return new Response(0);
            }
            $menu->setOrderMenu($orderMenu+1);
            $em->flush();
        }
        

        try {
            $resp['error'] = false;
            $resp['msg'] = 'Modifica avvenuta con successo';

            return new Response(json_encode($resp));

        } catch (Exception $e) {
            
            $resp['error'] = true;
            $resp['msg'] = 'Ops... si è verificato un errore';
            return new Response(json_encode($resp));
        }
    }   
    //-------------------------------------------------------------
    
    /**
     * @Route( "/admin/addTopTrademarkSection/{trademarkId}/{subcatId}/{typoId}", name="addTopTrademarkSection" )     
     */
    public function addTopTrademarkSection( Request $request, $trademarkId, $subcatId, $typoId ) {
            if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
                return $this->redirectToRoute('login');
            }
            
            $em = $this->getDoctrine()->getManager();
            
            // Si controlla che il marchio non sia già presente tra i top
            $topTrademark = $this->getDoctrine()->getRepository('AppBundle:TopTrademarksSection')
                ->checkTrademarkSection( $trademarkId, $subcatId, $typoId );
            // Si controlla se il marchio esiste: se esiste entra e restituisce il messaggio
            if ( !empty( $topTrademark ) ) {
                $resp['error'] = true;
                $resp['msg'] = "Elemento già presente!";
                return new Response(json_encode($resp));
            }
            
            try {

                $newItem = new TopTrademarksSection();
                $newItem->setTrademarkId( $trademarkId );
                $newItem->setSubcategoryId( $subcatId );
                $newItem->setIsActive( true );
                
                if( !empty( $typoId ) )
                    $newItem->setTypologyId( $typoId );

                $em->persist($newItem );
                $em->flush();

                $resp['error'] = false;
                $resp['msg'] = 'Marchio Aggiunto Correttamente';

                return new Response(json_encode($resp));
                    
                
            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            }
    } 
    
    /**
     * @Route( "/admin/deleteTopTrademarkSection/{id}", name="deleteTopTrademarkSection" )     
     */
    public function deleteTopTrademarkSection( Request $request, $id ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
            
        $topTrademark = $this->getDoctrine()->getRepository('AppBundle:TopTrademarksSection')
                  ->findOneById($id);   
         
        try {
            // Si effettua la rimozione del marchio
            $this->getDoctrine()->getManager()->remove($topTrademark);
            $this->getDoctrine()->getManager()->flush();

            $resp['error'] = false;
            $resp['msg'] = 'Cancellazione avvenuta con successo';

            return new Response(json_encode($resp));

            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            }
    }
    
    /**
     * @Route( "/admin/updateOrderTopTrademarks", name="updateOrderTopTrademarks" )     
     */
    public function updateOrderTopTrademarksAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $orderTrademarks = $request->request->get('orderTrademark');
        
        // Ciclo che itera tutti gli id e setta il nuovo ordine
        foreach( $orderTrademarks AS $orderMenu => $trademarkInfo ) {


            $em = $this->getDoctrine()->getManager();
            $trademark = $em->getRepository( 'AppBundle:TopTrademarksSection' )->findOneById( $trademarkInfo['id'] );
            
            if ( empty( $trademark ) ) {
                return new Response(0);
            }
            
            $trademark->setPosition($orderMenu+1);
            $trademark->setLimitModels($trademarkInfo['limitModels']);
            $em->flush();
        }
        

        try {
            $resp['error'] = false;
            $resp['msg'] = 'Modifica avvenuta con successo';

            return new Response(json_encode($resp));

        } catch (Exception $e) {
            
            $resp['error'] = true;
            $resp['msg'] = 'Ops... si è verificato un errore';
            return new Response(json_encode($resp));
        }
    }
    
    /**
     * @Route( "/admin/addItem/{menuType}/{entity}/{id}/", name="addItem" )     
     */
    public function addItemAction( Request $request, $menuType, $entity, $id ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $em = $this->getDoctrine()->getManager();
            
            // Si controlla il tipo di menu: entra se si tratta del menu con position 1 (menu principale)
            if ( $menuType == 1)  {
                // Si recupera il team selezionato per vedere se è già presente nel menu principale
                $subcategory = $this->getDoctrine()->getRepository('AppBundle:Menu')
                    ->checkCategoryFromMenu( 1, $id);
                // Si controlla se la categoria esiste: se esiste entra e restituisce il messaggio
                if ( !empty( $subcategory ) ) {
                    $resp['error'] = true;
                    $resp['msg'] = "Elemento già presente in questo menu";
                    return new Response(json_encode($resp));
                }
                 
                 
            // Si controlla il tipo di menu: entra se si tratta del menu con position 3 (menu 3)
            } elseif ( $menuType == 3 ) {
                
                // Si recupera la categoria selezionata per vedere se è già presente nel menu con position 3
                $category1 = $this->getDoctrine()->getRepository('AppBundle:Menu')
                    ->checkCategoryFromMenu( 3, $id);
                // Si controlla se la categoria esiste: se esiste entra e restituisce il messaggio
                if ( !empty( $category1 ) ) {
                    $resp['error'] = true;
                    $resp['msg'] = "Elemento già presente in questo menu";
                    return new Response(json_encode($resp));
                }
            // Si controlla il tipo di menu: entra se si tratta del menu con position 2 (menu 2)
            } elseif ( $menuType == 2  ) {
                
                // Si recupera la categoria selezionata per vedere se è già presente nel menu con position 2
                $category2 = $this->getDoctrine()->getRepository('AppBundle:Menu')
                    ->checkSubcatTypologyFromMenu( 2, $id, $entity);
                // Si controlla se la categoria esiste: se esiste entra e restituisce il messaggio
                if ( !empty( $category2 ) ) {
                    $resp['error'] = true;
                    $resp['msg'] = "Elemento già presente in questo menu";
                    return new Response(json_encode($resp));
                }                            
            } else  {
                // Si effettua lo string replace che permette di ottenere il parentId
                $parentId = str_replace('subcat_','', $menuType); 
                // Si recupera la categoria selezionata per vedere se è già presente nel menu con parentId associato
                $subcategories = $this->getDoctrine()->getRepository('AppBundle:Menu')
                    ->checkSubcatTypologyByParentIdNotNull( $parentId, $id, $entity);
                // Si controlla se la sottocategoria esiste: se esiste entra e restituisce il messaggio
                if ( !empty( $subcategories ) ) {
                    $resp['error'] = true;
                    $resp['msg'] = "Elemento già presente in questo menu";
                    return new Response(json_encode($resp));
                }       
            }  
            
            try {
            // Si effettua il set della nuova categoria (parametri abbondantemente da rivedere) Entra se il position è = 1 o = 2 o = 3
                if ( ( $menuType == 1 || $menuType == 2 || $menuType == 3 ) && empty($category)) {
                    // Switch case che costruisce l'entità, il messaggio e il set specifico a seconda del menu
                    switch ( $menuType ) {
                        case 1:
                        case 3:
                            $repository = 'Category';
                            $msg = 'Categoria aggiunta correttamente';
                            $fnSet = 'setCategory';
                        break;
                        case 2:
                            $repository = $entity;
                            $msg = $entity.'aggiunta correttamente';
                            $fnSet = 'set'.$entity;
                        break;
                    }
                    
                    $categoryInstance = $this->getDoctrine()->getRepository('AppBundle:'.$repository)->find( $id );

                    $newItem = new Menu();
                    $newItem->setPosition( $menuType );
                    $newItem->$fnSet($categoryInstance);
                    $newItem->setColor("");
                    $newItem->setOrderMenu(1);

                    $em->persist($newItem );
                    $em->flush();

                    $resp['error'] = false;
                    $resp['msg'] = $msg;
                    
                    return new Response(json_encode($resp));
            
                } else {
                    // Si effettua il set della nuova categoria (parametri abbondantemente da rivedere) Entra se il menu non è 1 o 2 o 3
                    $subcatTypologyInstance = $this->getDoctrine()->getRepository('AppBundle:'.$entity)->find( $id );
                    $fnSet = 'set'.$entity;
                    // Replace che costruisce il parent id
                    $parentId = str_replace('subcat_','', $menuType); 
                    // Inserisce la sottocategoria nella categoria specifica del menu principale
                    $newItem = new Menu();
                    $newItem->setPosition( 1 );
                    $newItem->setCategory( null );
                    $newItem->setParentId( $parentId );
                    $newItem->$fnSet( $subcatTypologyInstance );
                    $newItem->setColor("");
                    $newItem->setOrderMenu(1);
                    
                    $em->persist($newItem );
                    $em->flush();

                    $resp['error'] = false;
                    $resp['msg'] = $entity." aggiunta correttamente";
                    
                    return new Response(json_encode($resp));
                  }
                
            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            }
    } 
    
    
     //--------------------------------------------------------------

    /**
     * @Route( "/admin/updateArticleDate/{id}", name="updateArticleDate" )     
     */
    public function updateArticleDateAction( Request $request, $id ) {  
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $isAjax = $request->isXmlHttpRequest();
        if( !$isAjax ) { 
            return $this->redirectToRoute('login');
        }
            
        $em = $this->getDoctrine()->getManager();
        
        $article = $this->getDoctrine()->getRepository('AppBundle:DataArticle')->find( $id );

        try {
            $article->setPublishAt(new \DateTime());
            $em->persist($article);
            $em->flush(); 
            $resp['error'] = false;
            $resp['msg'] = 'Data aggiornata con successo';
            return new Response(json_encode($resp));

            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            }
    }   

    /**
     * @Route( "/admin/deleteTopNewsImg/{id}", name="deleteTopNewsImg" )     
     */
    public function deleteTopNewsImgAction( Request $request, $id ) {  
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }

        $em = $this->getDoctrine()->getManager();
        
        $article = $this->getDoctrine()->getRepository('AppBundle:DataArticle')->find( $id );
        $src = $article->getTopNewsImg();
        
        try {
            if( !empty( $article ) ) {
                $article->setTopNewsImg( null );
                $em->persist($article);
                $em->flush();
            }
            $resp['error'] = false;
            $resp['msg'] = 'Immagine rimossa con successo';

            unlink( $this->container->getParameter('app.folder_imgTopNews_default_write').$src );
            
            return new Response(json_encode($resp));

            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            }
    }   
    
    /**
     * @Route( "/admin/listTopNewsImg", name="listTopNewsImg" )     
     */
    public function listTopNewsImgAction( Request $request ) {  
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $em = $this->getDoctrine()->getManager();
        $articles = $this->getDoctrine()->getRepository('AppBundle:DataArticle')->getAllTopNewsImg();
        $topNewsImgsList = array();
        $topNewsIdList = array();
        if ( !empty( $articles ) ) {
            foreach ( $articles as $article ) {
                array_push( $topNewsImgsList, array(
                    'src' => $article->getTopNewsImg(),
                    'position' => !empty( $article->getPositionTopNewsImg() ) ? $article->getPositionTopNewsImg() : 10 )
                );
            }

            $resp['error'] = false;
            $resp['imgs'] = $topNewsImgsList;
        } else {
            $resp['error'] = true;
            $resp['msg'] = 'Non sono presenti immagini per il Primo Piano';
        }

        return new Response(json_encode($resp));
    }
    
    /**
     * @Route( "/admin/setTopNewsImg", name="setTopNewsImg" )     
     */
    public function setTopNewsImgAction( Request $request ) {  
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $base = $this->container->getParameter( 'app.folder_imgTopNews_default_write' );
        $articleId = $request->request->get('articleId');
        $src = $request->request->get('src');
        $position = $request->request->get('position');
//        
        preg_match('/\d\w+/', $src, $imgId );
        $newSrc = str_replace($imgId[0], $articleId, $src);
        copy($base.$src, $base.$newSrc);
        
        
        $em = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository('AppBundle:DataArticle')->find( $articleId );
        
        if ( !empty( $article ) ) {   
            try {
                $article->setPositionTopNewsImg( $position );
                $article->setTopNewsImg( $newSrc );
                                
                $em->persist( $article );
                $em->flush(); 
                                
                $resp['error'] = false;
                $resp['msg'] = 'Immagine associata con successo';
                $resp['src'] = $newSrc;
                
                return new Response( json_encode( $resp ) );
                
            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response( json_encode( $resp ) );
            }
        } else {
            $resp['error'] = true;
            $resp['msg'] = 'Ops... si è verificato un errore';
        }
        return new Response(json_encode($resp));
    }   
    
    /**
     * @Route( "/admin/scheduleArticleDate/{id}", name="scheduleArticleDate" )     
     */
    public function scheduleArticleAction( Request $request, $id ) {  
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
//        $isAjax = $request->isXmlHttpRequest();
//        if( !$isAjax ) { 
//            return;
        
        $em = $this->getDoctrine()->getManager();
        
        $article = $this->getDoctrine()->getRepository('AppBundle:DataArticle')->find( $id );
        try {
            $article->setCreateAt(new \DateTime());
            $em->persist($article);
            $em->flush();
            $resp['error'] = false;
            $resp['msg'] = 'Data aggiornata con successo';
            return new Response(json_encode($resp));

            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            }
    }   
    
    
      //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/deleteItemMenu/{id}", name="deleteItemMenu", defaults={"id"=false} )     
     */
    public function deleteItemMenuAction( Request $request, $id ) {  
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
//        $isAjax = $request->isXmlHttpRequest();
//        if( !$isAjax ) { 
//            return;
        // Si cerca l'id nella tabella Menu
        $menu = $this->getDoctrine()->getRepository('AppBundle:Menu')
                  ->findOneById($id);   
         
        try {
            // Si effettua la rimozione della voce di menu dalla tabella
            $this->getDoctrine()->getManager()->remove($menu);
            $this->getDoctrine()->getManager()->flush();

            $resp['error'] = false;
            $resp['msg'] = 'Cancellazione avvenuta con successo';

            return new Response(json_encode($resp));

            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            }
    }
    
    //--------------------------------------------------------------

    /**
     * @Route( "/admin/deleteArticles/{id}", name="deleteArticles" )     
     */
    public function deleteAction( Request $request, $id ) {  
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
//        $isAjax = $request->isXmlHttpRequest();
//        if( !$isAjax ) { 
//            return;
        $articleDelete = $this->getDoctrine()->getRepository('AppBundle:DataArticle')
                  ->findOneById($id);   

        try {
                $this->getDoctrine()->getManager()->remove($articleDelete);
                $this->getDoctrine()->getManager()->flush();
                return new Response(1);

        } catch (Exception $e) {
                return new Response(0);
        }
    }   
           
    /**
     * @Route( "/admin/listRedirects", name="adminListRedirects" )     
     */
    public function listRedirectsAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        $um = $this->container->get('app.usermanager');
        if( empty( $um->isLogged() ) )
            return $this->redirectToRoute('login');
            
        return new Response( $this->init( "listRedirects.xml", $request ) );  
    }    
    
    /**
     * @Route( "/admin/editRedirect/{id}", name="editRedirect", defaults={"id"=false} )     
     */
    public function editRedirectAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editRedirect.xml", $request ) );  
    } 
    
    /**
     * @Route( "/admin/dashboard", name="dashboard" )     
     */
    public function dashboardAction( Request $request ) {  
        $this->checkIsValidRequestAdmin($request);
        $um = $this->container->get('app.usermanager'); 
        if( empty( $um->isLogged() ) ) 
            return $this->redirectToRoute('login');
            
        return new Response( $this->init( "dashboard.xml", $request ) );  
    }
    
    /** 
     * @Route( "/admin/listArticles", name="adminListArticles" )     
     */
    public function listArticlesAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        $um = $this->container->get('app.usermanager');
        if( empty( $um->isLogged() ) )
            return $this->redirectToRoute('login');
            
        return new Response( $this->init( "listArticles.xml", $request ) );  
    }
    
    /** 
     * @Route( "/admin/listQuestions", name="adminListQuestions" )     
     */
    public function listQuestionsAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        $um = $this->container->get('app.usermanager');
        if( empty( $um->isLogged() ) )
            return $this->redirectToRoute('login');
            
        return new Response( $this->init( "listQuestions.xml", $request ) );  
    }
    
    /**
     * @Route( "/admin/editQuestion/{id}", name="editQuestion", defaults={"id"=false} )     
     */
    public function editQuestionAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editQuestion.xml", $request ) );  
    } 
    
    /**
     * @Route( "/admin/listGroupPermission", name="adminListGroupPermission" )     
     */
    public function listGroupPermissionAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        $um = $this->container->get('app.usermanager');
        if( empty( $um->isLogged() ) )
            return $this->redirectToRoute('login');
            
        return new Response( $this->init( "listGroupPermission.xml", $request ) );  
    }
    
    /**
     * @Route( "/admin/imageArticle/{id}", name="imageArticle" )     
     */
    public function imageArticleAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        return new Response( $this->init( "imageArticle.xml", $request ) );  
    }
    
    /**
     * @Route( "/admin/uploadImgArticleIframe", name="uploadImgArticleIframe" )     
     */
    public function uploadImgArticleIframeAction( Request $request ) {        
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $this->baseParameters();
        
        
        $image = new Image();
        $titleImg = $request->request->get('title');
        $file = $request->files;
        
        if ( empty( $titleImg ) || empty( $file->get('src') )  ) {
            header( 'Content-Type: text/html; charset=utf-8' );
            echo "<script> window.parent.widgetImageArticle.readResponseTargetIframe(2);</script>";
            exit;
        }
        
        
        // Recupero l'ArticleId
        $em = $this->getDoctrine()->getManager();
        $url = $request->server->get('HTTP_REFERER');
        $parseUrl = parse_url( $url );
        $route = $this->container->get('router')->match( $parseUrl['path'] );
        $articleId = $route['id'];
        $imgSize = array('formats' => array(
                            'small' => array(
                                'width' => $this->container->getParameter( 'app.img_small_width' ),
                                'height' => $this->container->getParameter( 'app.img_small_height' ),
                                'pathFileWrite' => $this->container->getParameter( 'app.folder_img_small_write' ),
                                'rewriteName' => $this->globalConfigManager->globalUtility->rewriteUrl( $titleImg )
                            ),
                            'medium' => array(
                                'width' => $this->container->getParameter( 'app.img_medium_width' ),
                                'height' => $this->container->getParameter( 'app.img_medium_height' ),
                                'pathFileWrite' => $this->container->getParameter( 'app.folder_img_medium_write' ),
                                'rewriteName' => $this->globalConfigManager->globalUtility->rewriteUrl( $titleImg )
                            ),
                            'big' => array(
                                'width' => $this->container->getParameter( 'app.img_big_width' ),
                                'height' => $this->container->getParameter( 'app.img_big_height' ),
                                'pathFileWrite' => $this->container->getParameter( 'app.folder_img_big_write' ),
                                'rewriteName' => $this->globalConfigManager->globalUtility->rewriteUrl( $titleImg )
                            )
                        ));
        $fm = $this->container->get('app.formManager');
        
        $photos = $fm->uploadFile($file->get('src'), $imgSize, 'image', $image, 'src');
        
        if ( empty( $photos ) ) {
            header( 'Content-Type: text/html; charset=utf-8' );
            echo "<script> window.parent.widgetImageArticle.readResponseTargetIframe(0, null, null);</script>";
            exit;
        }
        
        $image->setSrc($photos[0]['src']);
        $image->setTitleImg($titleImg);
        $image->setSearch(true);
        
        foreach( $photos[0]['dim'] AS $key => $photo) {                                
            foreach( $photo AS $key2 => $photo2) {                                    
                $fnSet = 'set'. ucfirst( $key ).ucfirst( $key2 );
                $image->$fnSet( $photo2 );
            }
        }
        $article    = $em->getRepository('AppBundle:DataArticle')->find($articleId);
        
        try {
            $em->persist( $image );
            $article->addImage($image);
            $article->setPriorityImg($image);
            $em->persist($article);
            $em->flush();

            header( 'Content-Type: text/html; charset=utf-8' );
            echo "<script> window.parent.widgetImageArticle.readResponseTargetIframe(1, '".$image->getSrc()."', '".$image->getId()."');</script>";
            exit;
            
        } catch ( Exception $e) {
            header( 'Content-Type: text/html; charset=utf-8' );
            echo "<script> window.parent.widgetImageArticle.readResponseTargetIframe(0, null, null);</script>";
            exit;
        }
    }
    
    /**
     * @Route( "/admin/addImageArticle/{ids}/{articleId}", name="addImageArticle" )     
     */
    public function addImageArticleAction( Request $request, $ids, $articleId ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        $aImage     = array();
        $ImgId      = array();
        $em         = $this->getDoctrine()->getManager();
        $article    = $em->getRepository('AppBundle:DataArticle')->find($articleId);
        
        $ids        = explode( "," , $ids );
        
        $response = array();
        $succ = 0;
        $err = 0;
        
        $lastImages = array();
        foreach( $article->getImages() As $articleImage ) {                            
            $lastImages[$articleImage->getId()] = $articleImage->getId();
        }
                
        foreach ($ids as $imgId) {
            if(in_array($imgId, $lastImages))
                continue;
            
            
            $image = $em->getRepository('AppBundle:Image')->find($imgId);
            array_push($aImage, $image->getSrc());
            array_push($ImgId, $image->getId());
            
            try {     
                    
                    if( !empty($image) ) {
                        $article->addImage($image);                                        
                        $em->persist($article);
                        $em->flush();

                        $article->setPriorityImg( $image );                                      
                        $em->persist($article);
                        $em->flush();
                    }
                    
                    $response['success'][$succ]['img'] =  $image->getSrc();
                    $response['success'][$succ]['imgId'] = $image->getId();
                    $response['success'][$succ]['priorityId'] = $article->getPriorityImg()->getId();
                    $response['success'][$succ]['msg'] = 'Immagine associata con successo!';
                    $succ++;
                    
            } catch ( \Exception $e) {            
//                    switch (get_class($e)) {
//                        case 'Doctrine\DBAL\Exception\UniqueConstraintViolationException':
//                            echo  $e;
//                            break;
//                        case 'Doctrine\DBA\DBAException':
//                            echo "Doctrine\DBA\DBAException<br />";
//                            break;
//                        default:
//                            throw $e;
//                            break;
//                    }
                
                    
                    $response['error'][$err]['img'] =  $image->getSrc();
                    $response['error'][$err]['imgId'] = $image->getId();
                    $response['error'][$err]['msg'] = 'Errore associazione!';                    
                    $err++;
            } 
            
            
        }        
        return new Response(json_encode($response));
    }
    
    /**
     * @Route( "/admin/setPriorityImageArticle/{id}/{articleId}", name="setPriorityImageArticle" )     
     */
    public function setPriorityImageArticleAction( Request $request, $id, $articleId ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        $response = array();
        $em      = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:DataArticle')->find($articleId);
        $image   = $em->getRepository('AppBundle:Image')->find($id);
        
        if( !empty($image) && !empty($article) ) {
            $article->setPriorityImg( $image );
        }
        
        try {            
                $em->persist($article);
                $em->flush();

                $response['success']['img'] =  $image->getSrc();
                $response['success']['imgId'] = $image->getId();
                $response['success']['priorityId'] = $article->getPriorityImg()->getId();
                $response['success']['msg'] = 'Immagine prioritaria scelta correttamente!';

            } catch ( \Exception $e) {            
                switch (get_class($e)) {
                    case 'Doctrine\DBAL\Exception\UniqueConstraintViolationException':
                        break;
                    case 'Doctrine\DBA\DBAException':
                        break;
                    default:
                        break;
                }

                $response['error']['img'] =  $image->getSrc();
                $response['error']['imgId'] = $image->getId();
                $response['error']['msg'] = 'Errore!';
            }
            
        return new Response(json_encode($response));
    }
    
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/removeImageArticle/{ids}/{articleId}", name="removeImageArticle" )     
     */
    public function removeImageArticleAction( Request $request, $ids, $articleId ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
                
        $secondLevelCacheUtility = $this->getSecondLevelCache();                        
        
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:DataArticle')->setCacheUtility( $secondLevelCacheUtility );
        
        $article = $em->getRepository('AppBundle:DataArticle')->findOneById( $articleId );
        $query = $em->getRepository('AppBundle:DataArticle')->getArticleDetailSQL( $articleId );
                
        $hash = $this->getHash( $query->getSQL() );
        $ids = explode( "," , $ids );
        
        foreach ($ids as $imgId) {
            $image = $em->getRepository('AppBundle:Image')->find($imgId);
            
            unlink( $this->container->getParameter( 'app.folder_img_small_write' ).$image->getSrc() );
            unlink( $this->container->getParameter( 'app.folder_img_medium_write' ).$image->getSrc() );
            unlink( $this->container->getParameter( 'app.folder_img_big_write' ).$image->getSrc() );
            
            if( !empty($image) )
                $article->removeImage($image);
            
        }
        
        try {            
                $em->persist($article);
                $em->flush();
                                
                foreach ( $ids AS $id ) {
                    $this->globalConfigManager->secondLevelCacheUtility->removeKey( 'my_data_article_region_query', $hash );
                    $this->globalConfigManager->secondLevelCacheUtility->removeKey( '_region_result', 'dataarticle_'.$articleId );
                    $this->globalConfigManager->secondLevelCacheUtility->removeKey( '_region_result', 'contentarticle_'.$articleId );
                }                
                
                $resp['error']  = false;
                $resp['ids']    = $ids;
                $resp['msg']    = 'Immagine rimossa con successo!';

                return new Response(json_encode($resp));

        } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Si è verificato un errore!';

                return new Response(json_encode($resp));
        } 
    }
    
    
        
    
    
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/manageMenu", name="manageMenu" )     
     */
    public function menuAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "menu.xml", $request ) );  
    }
    
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/users", name="manageUser" )     
     */
    public function userAction( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "users.xml", $request ) );  
    }
    
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/externalusers", name="manageExternalUser" )     
     */
    public function externalUserAction( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "externalUsers.xml", $request ) );  
    } 
    
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/banners", name="manageBanners" )     
     */
    public function bannerAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listBanners.xml", $request ) );  
    }
    
    /**
     * @Route( "/admin/listFeedsImport", name="listFeedsImport" )     
     */
    public function listFeedsImportAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listFeedsImport.xml", $request ) );  
    }
    
    //--------------------------------------------------------------
    
     /**
     * @Route( "/admin/manageArticle/{id}", name="manageArticle", defaults={"id" = false} )     
     */
    public function manageArticleAction( Request $request ) {     
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }

        return new Response( $this->init( "editArticle.xml", $request) );  
    }  
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/addImg", name="addImg" )     
     */
    public function addImgAction( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $em = $this->getDoctrine()->getManager();        
        $fm = $this->container->get('app.formmanager');
        $images = json_decode( $request->request->get('img'), true );
        
        $formats = array('formats' => array(
                        'small' => array(
                            'width' => $this->container->getParameter( 'app.img_small_width' ),
                            'height' => $this->container->getParameter( 'app.img_small_height' ),
                            'pathFileWrite' => $this->container->getParameter( 'app.folder_img_small_write' ),
                        ),
                        'medium' => array(
                            'width' => $this->container->getParameter( 'app.img_medium_width' ),
                            'height' => $this->container->getParameter( 'app.img_medium_height' ),
                            'pathFileWrite' => $this->container->getParameter( 'app.folder_img_medium_write' ),
                        ),
                        'big' => array(
                            'width' => $this->container->getParameter( 'app.img_big_width' ),
                            'height' => $this->container->getParameter( 'app.img_big_height' ),
                            'pathFileWrite' => $this->container->getParameter( 'app.folder_img_big_write' ),
                        )
                        )
                    );
        
        $results = $fm->uploadImgByRemoteUrl($images, $formats, 'Image' );
        
    }     
        
    /**
     * @Route( "/admin/editBanner/{id}", name="editBanner", defaults={"id"=false} )     
     */
    public function editBannerAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editBanner.xml", $request ) );  
    }   
    
    /**
     * @Route( "/admin/editGroup/{id}", name="editGroup", defaults={"id"=false} )     
     */
    public function editGroupAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editGroup.xml", $request ) );  
    }   
    
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/addUser/{data}", name="addUser" )     
     */
    public function addUserAction( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
//        $user = $this->getDoctrine()->getRepository('AppBundle:User')
//                  ->findOneByEmail($email);
        $em = $this->getDoctrine()->getManager();
        // Vengono settati i vari campi tramite i parametri ricevuti in {data}
        $name          = $request->query->get('name');
        $surname       = $request->query->get('surname');
        $username      = $request->query->get('username');
        $password      = $request->query->get('password');
        $mail          = $request->query->get('email');
        $role          = $request->query->get('role');
        // Viene creato un nuovo utente e vengono assegnati i parametri recuperati 
        $user = new User();
        $user->setName($name);
        $user->setSurname($surname);
        $user->setEmail($mail);
        $user->setUsername($username);
        $user->setPassword("password");
        $user->setRole($role);
        $user->setCanc(1);
        $user->setClose(1);
        $user->setLastDbId(1);

        $em->persist($user);
        $em->flush();
        
        try {
            
            $resp['error'] = false;
            $resp['msg'] = 'Inserito un nuovo utente!';

            return new Response(json_encode($resp));

            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            }    
            
        }   
    //--------------------------------------------------------------
    
    
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/deleteBanner/", name="deleteBanner" )     
     */
    public function deleteBannerAction( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();     
        $banner = $em->getRepository('AppBundle:Banner')->find( $request->request->get('id') );              
        try {
                $this->getDoctrine()->getManager()->remove($banner);
                $this->getDoctrine()->getManager()->flush();
                return new Response(1);

        } catch (Exception $e) {
                return new Response(0);
        }
    }   
    /**
     * @Route( "/admin/modifyBanner/", name="modifyBanner" )     
     */
    public function modifyBannerAction( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $fm = $this->get( 'app.formManager' );
        
        $em = $this->getDoctrine()->getManager();        
        $entity = $em->getRepository('AppBundle:Banner')->find( $request->request->get('id') );     
        
        $jsonResponse = $fm->saveEntity( $entity , $request->request );        
        return new Response( $jsonResponse );
    }   
        
    
     /**
     * @Route( "/admin/modifyUser/", name="modifyUser" )     
     */
    public function modifyUserAction( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $fm = $this->get( 'app.formManager' );
        
        $em = $this->getDoctrine()->getManager();        
        $entity = $em->getRepository('AppBundle:User')->find( $request->request->get('id') );     
        
        $jsonResponse = $fm->saveEntity( $entity , $request->request );   
        return new Response( $jsonResponse );

    }  
    
    //--------------------------------------------------------------
    
    /**
     * @Route( "/admin/categories", name="manageCategories" )     
     */
    public function categoriesAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listCategories.xml", $request ) );  
    }
    
    /**
     * @Route( "/admin/subcategories", name="manageSubcategories" )     
     */
    public function subcategoriesAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listTeams.xml", $request ) );  
    }
    
    /**
     * @Route( "/admin/listDictionary", name="listDictionary" )     
     */
    public function listDictionaryAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listDictionary.xml", $request ) );  
    }
    
    
    /**
     * @Route( "/admin/editDictionary/{id}", name="editDictionary", defaults={"id"=false} )     
     */
    public function editDictionaryAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editDictionary.xml", $request ) );  
    }
    
    /**
     * @Route( "/dictionary/getItem/{id}", name="getItemDictionary" )     
     */
    public function getItemDictionaryAction( Request $request, $id ) {         
        $dictionary = $this->getDoctrine()->getRepository('AppBundle:Dictionary')->findOneById( $id );
        
        $resp = array();
        $resp['name'] = $dictionary->getName();
        $resp['body'] = $dictionary->getBody();
        
        return new JsonResponse( $resp );  
    }
    
    
     /**
     * @Route( "/admin/editCategory/{id}", name="editCategory", defaults={"id"=false} )     
     */
    public function editCategoryAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editCategory.xml", $request ) );  
    }
    
     /**
     * @Route( "/admin/editTournament/{id}", name="editTournament", defaults={"id"=false} )     
     */
    public function editTournamentAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editTournament.xml", $request ) );  
    }   
     /**
     * @Route( "/admin/editSubcategory/{id}", name="editSubcategory", defaults={"id"=false} )     
     */
    public function editSubcategoryAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editTeam.xml", $request ) );  
    }   
     /**
     * @Route( "/admin/editUser/{id}", name="editUser", defaults={"id"=false} )     
     */
    public function editUserAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editUser.xml", $request ) );  
    }
    
     /**
     * @Route( "/admin/editExternalUser/{id}", name="editExternalUser" )     
     */
    public function editExternalUserAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editExternalUser.xml", $request ) );  
    }   
        
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    /******************************************************************************************************************************************************/
    
    
     /**
     * @Route( "/admin/saveInlineForm", name="saveInlineForm" )     
     */
    public function saveInlineFormAction( Request $request ) {   
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $fm = $this->get( 'app.formManager' );
        
        $em = $this->getDoctrine()->getManager();        
        
        if( !empty( $request->request->get('id') ) ) {
            $entity = $this->getDoctrine()->getRepository('AppBundle:'.ucfirst( $request->request->get( 'entity' ) ) )
                  ->findOneById( $request->request->get('id') );
        } else {            
            $entity = $fm->createUse( $request->request->get( 'entity' ) );            
        }
            
        $jsonResponse = $fm->saveEntity( $entity , $request->request );   
        return new Response( $jsonResponse );

    }  
    
    
    /**
     * @Route( "/admin/deleteItemEntity", name="deleteItemEntity" )     
     */
    public function deleteItemEntityAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        // Si recupera l'id tramite l'id che arriva dalla chiamata Ajax
        $entity = $this->getDoctrine()->getRepository('AppBundle:'.ucfirst( $request->request->get( 'entity' ) ) )
                  ->findOneById( $request->request->get('id') );
        
        try {
            // Si effettua la rimozione dell'utente dalla tabella Users
            $this->getDoctrine()->getManager()->remove( $entity );
            $this->getDoctrine()->getManager()->flush();

            
            
            
            $resp['error'] = false;
            $resp['msg'] = 'Cancellazione avvenuta con successo';

            return new Response(json_encode($resp));

        } catch (Exception $e) {
            $resp['error'] = true;
            $resp['msg'] = 'Ops... si è verificato un errore';
            return new Response(json_encode($resp));
        }                
    }   
    
    /**
     * @Route( "/admin/getSelectOptions", name="getSelectOptions" )     
     */
    public function getSelectOptionsAction( Request $request )  {         
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $id = $request->request->get('id');
        $children = json_decode( $request->request->get('children') );        
        
        $findBy = $children->find;
        
//        if( $findBy == 'findTeamsByLastSeason' ) {
//            $season = $this->getDoctrine()->getRepository('AppBundle:Season' )->getLastSeasonByTournamentId( $id, false, true );
//            $id = $season['id'];
//        }
        
        $entity = $this->getDoctrine()->getRepository('AppBundle:'.ucfirst( $children->entity ) )->$findBy( $id );

        $result = array();
        foreach( $entity AS $item ) {
            $result[$item->getId()] = $item->getName();
        }  
        
        echo json_encode( $result );
        exit;
    }
    
    /**
     * @Route( "/admin/uploadImages", name="adminUploadImages" )     
     */
    public function uploadImagesAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
            
        return new Response( $this->init( "uploadImages.xml", $request ) );  
    }
    
    /**
     * @Route( "/admin/listPoll", name="listPoll" )     
     */
    public function listPollAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listPoll.xml", $request ) );  
    }
    
    /**
     * @Route( "/admin/editPoll/{id}", name="editPoll", defaults={"id"=false} )     
     */
    public function editPollAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editPoll.xml", $request ) );  
    } 
    
    /**
     * @Route( "/admin/insertPoll/{question}/{answers}/{articleId}", name="insertPoll", defaults={"articleId"=false} )     
     */
    public function insertPollAction( Request $request, $question, $answers, $articleId=null ) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $em = $this->getDoctrine()->getManager();
        $answers = explode( "," , $answers );
        $arrayAnswers = array();
        foreach ( $answers as $key => $item ) {
            $arrayAnswers[$key]['voti'] = 0;
            $arrayAnswers[$key]['answer'] = $item;
        }
        
        $jsonAnswers = json_encode($arrayAnswers);
        
        $poll = new Poll();
        if ( !empty( $question ) )
            $poll->setQuestion( $question );
        
        $poll->setJsonAnswers($jsonAnswers);        
        
        $articleId = !empty( $articleId ) && $articleId != '0' ? $articleId : null;
        $poll->setDataArticleId($articleId);
        
        try {
            $em->persist($poll);
            $em->flush();

            $resp['error'] = false;
            $resp['msg'] = 'Inserito un nuovo sondaggio!';

            return new Response(json_encode($resp));

        } catch (Exception $e) {
            $resp['error'] = true;
            $resp['msg'] = 'Ops... si è verificato un errore';
            return new Response(json_encode($resp));
        } 
                
    } 
    
    /**
     * @Route( "/admin/updatePoll/{id}/{question}/{answers}/{articleId}", name="updatePoll", defaults={"articleId"=false} )     
     */
    public function updatePollAction( Request $request, $id, $question, $answers, $articleId) {         
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $em = $this->getDoctrine()->getManager();        
        $poll = $this->getDoctrine()->getRepository('AppBundle:Poll')->find($id);
        $lastAnwsers = json_decode( $poll->getJsonAnswers() );
        print_r($lastAnwsers);
        exit;
        
        $answers        = explode( "," , $answers );
        $arrayAnswers = array();
        
        
        foreach ( $answers as $key => $item ) {
            $arrayAnswers[$key]['voti'] = 0;
            $arrayAnswers[$key]['answer'] = $item;
        }
        
        $jsonAnswers = json_encode($arrayAnswers);
        
        

        if ( !empty( $question ) )
            $poll->setQuestion( $question );
        
        $poll->setJsonAnswers($jsonAnswers);
        
        $articleId = !empty( $articleId ) && $articleId != '0' ? $articleId : null;
        
        $poll->setDataArticleId($articleId);
        
        try {
                $em->persist($poll);
                $em->flush();
        
                $resp['error'] = false;
                $resp['msg'] = 'Aggiornamento eseguito con successo!';

                return new Response(json_encode($resp));

            } catch (Exception $e) {
                $resp['error'] = true;
                $resp['msg'] = 'Ops... si è verificato un errore';
                return new Response(json_encode($resp));
            } 
        
        
    } 
    
     /**
     * @Route( "/admin/extraConfigs", name="extraConfig", defaults={"id"=false} )     
     */
    public function extraConfigAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "extraConfigs.xml", $request ) );  
    } 
    
        /**
     * @Route( "/admin/editExtraConfig/{id}", name="editExtraConfig", defaults={"id"=false} )     
     */
    public function editExtraConfigAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editExtraConfig.xml", $request ) );  
    }
    
     /**
     * @Route( "/admin/updateExtraConfigs/", name="updateExtraConfigs" )     
     */
    public function updateExtraConfigAction( Request $request) { 
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        $um = $this->container->get('app.usermanager');
        if( empty( $um->isLogged() ) )
            return $this->redirectToRoute('login');
            
            $id = $request->request->get('id');
            $value = $request->request->get('value');
            
            $em = $this->getDoctrine()->getManager();
            $extraConfig = $em->getRepository('AppBundle:ExtraConfig')->findOneById($id);
            
            if (!$extraConfig) {
                return new Response(0);
            }
            $extraConfig->setValue($value);
            $em->flush();
        try {
            $resp['error'] = false;
            $resp['msg'] = 'Modifica avvenuta con successo';

            return new Response(json_encode($resp));

        } catch (Exception $e) {
            
            $resp['error'] = true;
            $resp['msg'] = 'Ops... si è verificato un errore';
            return new Response(json_encode($resp));
        }
    }
    
    /**
     * @Route( "/admin/redisflushall/", name="redisflushall" )     
     */
    public function redisCliCOmmand( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        $return = true;
        
//        exec( 'redis-cli -n '.$this->container->getParameter('redis_sncredis_db_n' ).' flushdb', $resp );
//        if( empty( $resp ) && $resp[0] != 'OK' )
//            return new Response(0);
        
        exec( 'redis-cli -n '.$this->container->getParameter('redis_sncredisDoctrineResult' ).' flushdb', $resp2 );        
        if( empty( $resp2 ) && $resp2[0] != 'OK' ) 
            return new Response(0);
        
        exec( 'redis-cli -n '.$this->container->getParameter('redis_sncredisDoctrineQueryCache' ).' flushdb', $resp3 );
        if( empty( $resp3 ) && $resp3[0] != 'OK' ) 
            return new Response(0);
        
        exec( 'redis-cli -n '.$this->container->getParameter('redis_secondLevelCache' ).' flushdb', $resp4 );
        if( empty( $resp4 ) && $resp4[0] != 'OK' ) 
            return new Response(0);
        
        
        $cacheUtility = $this->container->get('app.cacheUtility');
        $cacheUtility->initPhpCache();
        $cacheUtility->removeKey( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesById' );      
        $cacheUtility->removeKey( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesById' );
        $cacheUtility->removeKey( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesById' );              
        $cacheUtility->removeKey( $this->container->getParameter( 'session_memcached_prefix' ).'tecnicalTemplate' );              
        
        $cacheUtility->removeKey( $this->container->getParameter( 'session_memcached_prefix' ).'categoriesByName' );      
        $cacheUtility->removeKey( $this->container->getParameter( 'session_memcached_prefix' ).'subcategoriesByName' );      
        $cacheUtility->removeKey( $this->container->getParameter( 'session_memcached_prefix' ).'typologiesByName' );                      
        $cacheUtility->removeKey( $this->container->getParameter( 'session_memcached_prefix' ).'tecnicalTemplate' );                      
        
        return new Response(1);
    }
    
     /**
     * @Route( "/admin/offProduct", name="offProduct" )     
     */
    public function offProduct( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->findOneById($_GET['id']);
        $priceProduct = $product->getPrice();
        $product->setIsActive( 0 );
        $product->setManualOff( 1 );
        $em->persist($product);
        $em->flush();
        
        
        $lowProduct = $em->getRepository('AppBundle:Product')->findProductsByModel( $product->getModel()->getId(), 1 );
        if( empty( $lowProduct ) ) {
            $lowPriceNew = 0;
        } else {
            $lowPriceNew =  $lowProduct[0]->getPrice();
        }
        
        
        //Elimina il prezzo del prodotto disattivato dallo storico prezzi
        $modelPrices =  $product->getModel()->getPrices();
        $modelPrices = json_decode( $modelPrices );        
        
        if (($key = array_search($priceProduct, $modelPrices)) !== false) {
            unset($modelPrices[$key]);
        }
        
        if( end( $modelPrices ) != $lowPriceNew )
            $modelPrices[] = $lowPriceNew;
        
        
        $product->getModel()->setPrices( json_encode( array_values( $modelPrices) ) );        
        $product->getModel()->setPrice( end( $modelPrices ) );
        
        
        $em->persist($product);
        $em->flush();
        
        return new Response(1);
    }
    
    /**
     * @Route( "/admin/checkModelinfo/", name="checkModelinfo" )     
     */
    public function checkModelinfo( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, true ) ) ) {
            return $this->redirectToRoute('login');
        }
        
        include( "../src/AppBundle/Service/SpiderService/ProxyConnector/proxyConnector.class.php" );
        $this->prxC = proxyConnector::getIstance( false );
//        $this->prxC->newIdentity();
        
        $result = $this->prxC->getContentPage( $_GET['url'] );
//        $result = $this->prxC->getContentPage( $_GET['url'] );
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $result );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );

        $elements = $xpath->query("//section[contains( @class, 'product_info_section')]//div[@class='content desc']");
        
        $url = parse_url( $_GET['url'] );
        
        $em = $this->getDoctrine()->getManager();
        $model = $em->getRepository('AppBundle:Model')->findOneByNameUrlTp( trim( $url['path'], '/' ) );
        if ($model) {
            $model->setRevisioned( 1);
            $em->flush();
        }                
        return new Response( $elements->length );
    } 
    
    /**
     * @Route( "/admin/tecnicalTemplate", name="tecnicalTemplate" )     
     */
    public function tecnicalTemplateAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "listTecnicalTemplate.xml", $request ) );  
        exit;
    }
    
    /**   
     * @Route( "/admin/editTecnicalTemplate/{id}", name="editTecnicalTemplate", defaults={"id"=false} )     
     */
    public function editTecnicalTemplateAction( Request $request ) { 
        if( empty( $this->checkIsValidRequestAdmin($request) ) ) {
            return $this->redirectToRoute('login');
        }
        
        return new Response( $this->init( "editTecnicalTemplate.xml", $request ) );  
        exit;
    }
    
    
    /**   
     * @Route( "/admin/getYouTubeVideo", name="getYouTubeVideo", defaults={"id"=false} )     
     */
    public function getYouTubeVideoAction( Request $request ) { 
        $MAX_RESULTS = 10;
        $keyword = $_GET['keyword'];
        $apikey = 'AIzaSyCSKZ8hSv103tRa3sUiDHBgsFo4zD_CiRY'; 
        
//        echo $this->getImageGoogle('iphone x');
//        exit;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/youtube/v3/search?part=snippet&q=". urlencode( $keyword )."&maxResults=8&key=$apikey");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result);
          
        $videos = array();
        $x = 0;
        foreach( $data->items AS $video ) {
            
            $videos[$x]['id'] = $video->id->videoId;
            $videos[$x]['title'] = $video->snippet->title;
            $videos[$x]['description'] = $video->snippet->description;
            $videos[$x]['thumb'] = $video->snippet->thumbnails->medium->url;
            $videos[$x]['channelTitle'] = $video->snippet->channelTitle;
            $x++;
        }
        return new JsonResponse( $videos );
    }
    
    /**   
     * @Route( "/admin/getImagesGoogleApi", name="getImagesGoogleApi", defaults={"id"=false} )     
     */
    public function getImagesGoogleApi( ) {
        $query = $_GET['keyword'];
        $url = "https://www.googleapis.com/customsearch/v1?key=AIzaSyBo5L26ooAF6HANTFrbo6YB4je-dIMDKqs&cx=017190664953723757708:WMX-481331709&q=".utf8_encode( str_replace( ' ', '%20', $query ) )."&searchType=image";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false );
//        curl_setopt($ch, CURLOPT_REFERER, /* Enter the URL of your site here */);
        

        $json = curl_exec($ch);
        $jset = json_decode( $json );
        $x = 0;
        $images1 = array();
        if( empty( $jset->items ) )
            return new JsonResponse(array());
        
        foreach( $jset->items  AS $item ) {
            
            $images1[$x]['link'] = $item->link;
            $images1[$x]['title'] = $item->title;            
            $x++;
        }
        
        $url = "https://www.googleapis.com/customsearch/v1?key=AIzaSyBo5L26ooAF6HANTFrbo6YB4je-dIMDKqs&cx=017190664953723757708:WMX-481331709&start=11&q=".utf8_encode( str_replace( ' ', '%20', $query ) )."&searchType=image";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false );
//        curl_setopt($ch, CURLOPT_REFERER, /* Enter the URL of your site here */);
        

        $json = curl_exec($ch);
        $jset = json_decode( $json );
        $x = 0;
        $images2 = array();
//        print_r($jset);
        foreach( $jset->items  AS $item ) {
            
            $images2[$x]['link'] = $item->link;
            $images2[$x]['title'] = $item->title;            
            $x++;
        }
        return new JsonResponse( array_merge( $images1, $images2 ) );        
    }
    
    /**
     * @Route( "/admin/insertImagesGoogle", name="insertImagesGoogle" )     
     */
    public function insertImagesGoogle( Request $request ) {
        $this->baseParameters();
        
        $files1 = array();
        $files2 = array();
        if( !empty( $_REQUEST['images'] ) ) {
            $files1 =  json_decode( $_REQUEST['images'] );
        }
        if( !empty( $_REQUEST['remoteUrls'] ) ) {
            $files2 =  explode( '[#]', $_REQUEST['remoteUrls'] );
        }
        $files = array_merge( $files1, $files2 );
        
        $modelName =   trim( $_GET['modelName'] );
        $modelId =   $_GET['modelId'] ;
        $formatsImg = array( 'image/gif', 'image/png', 'image/jpeg', 'image/jpeg', 'image/jpeg');        
        shuffle( $files );
//        
//        $files = array();
//        $files[] = 'https://www.apple.com/newsroom/images/product/iphone/standard/iphone8_iphone8plus_product_red_front_back_041018_big.jpg.large.jpg';
//        $files[] = 'https://img.purch.com/iphone-6s-vs-8-back-jpeg/w/755/aHR0cDovL21lZGlhLmJlc3RvZm1pY3JvLmNvbS9FL1YvNzMyNzc1L29yaWdpbmFsL2lwaG9uZS02c192c184LWJhY2suanBlZw==';
//        $files[] = 'https://cnet4.cbsistatic.com/img/aefWpmdKzZVDXuaobmHUF48DhIQ=/830x467/2017/09/18/1fd793ba-7a62-4312-b8bd-28311999c912/iphone-8-03.jpg';
//        $files[] = 'https://amp.businessinsider.com/images/595e359ba3630f5b508b73d7-750-563.jpg';
//        $files[] = 'https://cnet4.cbsistatic.com/img/KDaRvaqertKyhFL_WXbW_DDtWHM=/1600x900/2017/09/12/dc519941-4135-4c11-a2f4-8d2bfe707b2d/apple-091217-iphone-8-3892.jpg';
////        
        
        $index = 1;
        foreach( $files AS $file ) {
            $myFile                 = array();
            $myFile['name'][0]      = $file;
            $myFile['tmp_name'][0]  = $file;
//            $imgInfo = getimagesize($file);
            
            $this->imageUtility = $this->get('app.imageUtility');               
//            $myFile['type'][0]      = $this->imageUtility->myGetTypeImg( $imgInfo['mime'] );
            $myFile['type'][0]      = 'image/jpeg';
            
            
            $formats = array();
            $formats[0]['width'] = $this->container->getParameter( 'app.img_small_models_width_gallery' );;
            $formats[0]['height'] = $this->container->getParameter( 'app.img_small_models_height_gallery' ); 
            $formats[0]['pathFileWrite'] = $this->container->getParameter( 'app.folder_img_small_models_gallery_write' );
            
            $formats[1]['width'] = $this->container->getParameter( 'app.img_models_width_gallery' );;
            $formats[1]['height'] = $this->container->getParameter( 'app.img_models_height_gallery' ); 
            $formats[1]['pathFileWrite'] = $this->container->getParameter( 'app.folder_img_models_gallery_write' );            
                        
            
            if( in_array( $myFile['type'][0], $formatsImg ) ) {                                                         
                $resPhoto = array();
                //Crea i vari formati richiesti per l'immagine caricata
                foreach( $formats AS $key => $format ) {       
                    $modelName = $this->globalConfigManager->globalUtility->getNameImageProduct( $modelName );
                    $photo = $this->imageUtility->myUpload( $myFile, $format['pathFileWrite'], '/tmp/', $format['width'], $format['height'], 'Model', $index, $modelId, $modelName, false, 'jpg', $modelName ); 
                    $aSrc = explode( '/', $photo['foto'][0] );
                    
                    $newSrc = explode ( '.', $aSrc[count($aSrc)-1] );
                    $newExt = $newSrc[1];
//                    $newSrc = $newSrc[0] + $index;                                        
//                    $src = str_replace(  $aSrc[count($aSrc)-1], $newSrc, $photo['foto'][0] ) .'.'. $newExt;
                    
                    if( !empty( $photo['dim'][0]['width'] ) && !empty( $photo['dim'][0]['height'] ) ) {
                        $src = $photo['foto'][0];                                       
                        $resPhoto['src'] = $src;
                        $resPhoto['dim']['width'][$key]  = floor( $photo['dim'][0]['width'] );
                        $resPhoto['dim']['height'][$key] = floor( $photo['dim'][0]['height'] );            
                    }
                }
                if( !empty( $resPhoto ) ) {
                    $photos[] = $resPhoto; 
                }
                
            }
            $index++;
        }
        
        $em = $this->getDoctrine()->getManager();
        $model = $em->getRepository('AppBundle:Model')->find( $modelId );        
        if ($model && !empty( $photos ) ) {
            $model->setImagesGallery(json_encode( $photos ) );
            $em->flush();
            return new Response( json_encode( $photos ) );
        }            
        
        return new Response(0);
        exit;    
    }
    
     /**
     * @Route( "/admin/modifyGalleryModelImages", name="modifyGalleryModelImages" )     
     */
    public function modifyGalleryModelImages( Request $request ) {
        $this->baseParameters();
        $resPhoto = array();
        $photos = array();
        
        $modelName =   $_REQUEST['modelName'] ;
        $modelId =   $_REQUEST['modelId'] ;
                
        foreach( $_REQUEST['lastsrc'] AS $key => $src ) {
            $pathFileWriteSmall = $this->container->getParameter( 'app.folder_img_small_models_gallery_write' );
            $pathFileWriteBig = $this->container->getParameter( 'app.folder_img_models_gallery_write' );
            
            
            $exp = explode( '_', $src );
            $newSrc = $exp[0].'_'.$_REQUEST['src'][$key].'.jpg';
            $newSrc = str_replace( ' ', '_', trim( $newSrc ) );
            
            $filename = $pathFileWriteSmall.'/'.$src;            
            $destination = $pathFileWriteSmall.'/'.$newSrc;                        
            rename($filename, $destination);
            
            
            $filename = $pathFileWriteBig.'/'.$src;
            $destination = $pathFileWriteBig.'/'.$newSrc;
            @rename($filename, $destination);
            
            
            $resPhoto['src'] = $newSrc;
            $resPhoto['alt'] = $_REQUEST['alt'][$key];
            $resPhoto['dim']['width'][0]  = floor( $_REQUEST['widthSmall'][$key] );
            $resPhoto['dim']['height'][0] = floor( $_REQUEST['heightSmall'][$key] );   
            $resPhoto['dim']['width'][1]  = floor( $_REQUEST['widthBig'][$key] );
            $resPhoto['dim']['height'][1] = floor( $_REQUEST['heightBig'][$key] );   
            if( !empty( $resPhoto ) ) {
                $photos[] = $resPhoto; 
            }
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $model = $em->getRepository('AppBundle:Model')->find( $modelId );        
        if ($model && !empty( $photos ) ) {
            $model->setImagesGallery(json_encode( $photos ) );
            $em->flush();
            $resp = json_encode( $photos );
            
            header( 'Content-Type: text/html; charset=utf-8' );
            echo "<script> window.parent.mainAdmin.responseIframe( '".$resp."');</script>";
            exit;
        }            
        
        return new Response(0);
        exit;
                
    }
    
     /**
     * @Route( "/admin/insertGalleryModelImages", name="insertGalleryModelImages" )     
     */
    public function insertGalleryModelImages( Request $request ) {
        $this->baseParameters();
        
        $files = $request->files;        
        
        $modelName =   $_REQUEST['modelName'] ;
        $modelId =   $_REQUEST['modelId'] ;
        $formatsImg = array( 'image/gif', 'image/png', 'image/jpeg', 'image/jpeg', 'image/jpeg');        

        
        $index = 1;
        foreach( $files->get('src') AS $file ) {            
            $myFile                 = array();
            $myFile['name'][0]      = $file->getPathName();
            $myFile['tmp_name'][0]  = $file->getPathName();
//            $imgInfo = getimagesize($file);
            
            $this->imageUtility = $this->get('app.imageUtility');               
//            $myFile['type'][0]      = $this->imageUtility->myGetTypeImg( $imgInfo['mime'] );
            $myFile['type'][0]      = $file->getMimeType();
            
            
            $formats = array();
            $formats[0]['width'] = $this->container->getParameter( 'app.img_small_models_width_gallery' );
            $formats[0]['height'] = $this->container->getParameter( 'app.img_small_models_height_gallery' ); 
            $formats[0]['pathFileWrite'] = $this->container->getParameter( 'app.folder_img_small_models_gallery_write' );
            
            $formats[1]['width'] = $this->container->getParameter( 'app.img_models_width_gallery' );
            $formats[1]['height'] = $this->container->getParameter( 'app.img_models_height_gallery' ); 
            $formats[1]['pathFileWrite'] = $this->container->getParameter( 'app.folder_img_models_gallery_write' );            
                        
            
            if( in_array( $myFile['type'][0], $formatsImg ) ) {                                                         
                $resPhoto = array();
                //Crea i vari formati richiesti per l'immagine caricata
                foreach( $formats AS $key => $format ) {      
                    
                    if( !empty( $_REQUEST['alt'] ) && !empty( $_REQUEST['alt'][$index-1] ) ) {
//                        $title = $_REQUEST['title'][$index-1];
                        $alt = $_REQUEST['alt'][$index-1];
                        $modelNameFinal = $this->globalConfigManager->globalUtility->getNameImageProduct( $_REQUEST['alt'][$index-1]  );
                    } else {
//                        $title = $modelName;
                        $alt   = $modelName;
                        $modelNameFinal = $this->globalConfigManager->globalUtility->getNameImageProduct( $modelName );
                    }                    
                                      
                    
                    $photo = $this->imageUtility->myUpload( $myFile, $format['pathFileWrite'], '/tmp/', $format['width'], $format['height'], 'Model', $index, $modelId, array(), false, 'jpg', $modelId.'_'.$modelNameFinal );                                        
                    
                    $aSrc = explode( '/', $photo['foto'][0] );
                    
                    $newSrc = explode ( '.', $aSrc[count($aSrc)-1] );
                    $newExt = $newSrc[1];
//                    $newSrc = $newSrc[0] + $index;                                        
//                    $src = str_replace(  $aSrc[count($aSrc)-1], $newSrc, $photo['foto'][0] ) .'.'. $newExt;
                    
                    if( !empty( $photo['dim'][0]['width'] ) && !empty( $photo['dim'][0]['height'] ) ) {
                        $src = $photo['foto'][0];                                       
                        $resPhoto['src'] = $src;
//                        $resPhoto['title'] = $title;
                        $resPhoto['alt'] = $alt;
                        $resPhoto['dim']['width'][$key]  = floor( $photo['dim'][0]['width'] );
                        $resPhoto['dim']['height'][$key] = floor( $photo['dim'][0]['height'] );            
                    }
                }
                if( !empty( $resPhoto ) ) {
                    $photos[] = $resPhoto; 
                }
                
            }
            $index++;
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $model = $em->getRepository('AppBundle:Model')->find( $modelId );        
        if ($model && !empty( $photos ) ) {
            $model->setImagesGallery(json_encode( $photos ) );
            $em->flush();
            $resp = json_encode( $photos );
            
            header( 'Content-Type: text/html; charset=utf-8' );
            echo "<script> window.parent.mainAdmin.responseIframe( '".$resp."');</script>";
            exit;
        }            
        
        return new Response(0);
        exit;    
    }
    
    
    /**
     * @Route( "/admin/insertProductToModelIde", name="insertProductToModelIde" )     
     */
    public function insertProductToModelIde() {
        $products = json_decode( $_REQUEST['productsIde'], true );
        
        foreach( $products AS $key => $product ) {
            $url = 'https://www.idealo.it'.$product['link'];
            $redirectedUrl = '';
            
            //TODO Effettuare la stessa chiamata che viene a tricchetto per una url specifica e creare il servizio che risposta la corrente            
            $finalUrl = 'http://tricchetto.homepc.it/recirectUrlInfo/rxndu9034tur0934tun3904tun309tu3490?link='.$url;                
            $redirectedUrl = file_get_contents( $finalUrl );
            
            if( empty( $redirectedUrl ) || $redirectedUrl == trim( $url ) ) {
                echo 'REDIRECT NON TROVATA: '.$url;
                break;
            }

            $products[$key]['redirectUrl'] = trim( $redirectedUrl );
//            $products[$key]['redirectUrl'] = 'prova';
            $products[$key]['modelId'] = $_GET['modelId'];
            $products[$key]['shopName'] = trim( $product['shopName'] );
            $products[$key]['price'] = str_replace( array( '.',',' ), array( '' ,'.'), $product['price'] );
            sleep( 2 ); 
        }
        

        $em = $this->getDoctrine()->getManager();
        $model = $em->getRepository('AppBundle:Model')->findOneById($_GET['modelId']);
        
        
        $resp = array();
        $dbHost = $this->container->getParameter('database_host');
        $dbName = $this->container->getParameter('database_name');
        $dbUser = $this->container->getParameter('database_user');
        $dbPswd = $this->container->getParameter('database_password');        
        $mySql = new \PDO('mysql:host='.$dbHost.';', $dbUser, $dbPswd);
        
        
        $response = array();
        $response['success'] = 0;
        $response['error'] = 0;
        
        $globalUtility = $this->container->get('app.globalUtility');  
        
        foreach( $products AS $product ) {
            
            $sql = "SELECT * FROM ".$dbName.".affiliations WHERE name = '".trim( $product['shopName'] )."'";
            $stn = $mySql->prepare( $sql );
            $stn->execute();
            if ( $stn->rowCount() == 0 ) {
                
                $rewriteName = $globalUtility->getNameImageProduct( $product['shopName'] );
                
                $myFile = array();
                $myFile['name'][0] = $product['img'];
				$myFile['tmp_name'][0] = $product['img'];              
				$myFile['type'][0] = $globalUtility->imageUtility->myGetTypeImg( $product['img']  );
                
                
                $file = $fileSmall = $globalUtility->imageUtility->myUpload( 
                        $myFile, 
                        $this->container->getParameter('app.folder_imgAffiliations_small_write'), 
                        $this->container->getParameter('app.folder_tmp'), 
                        $this->container->getParameter('app.imgAffiliations_small_width'), 
                        $this->container->getParameter('app.imgAffiliations_small_height'), 
                        "Affiliation", 
                        session_id(), 
                        1, 
                        array(), 
                        false,
                        'jpg',
                        $rewriteName 
                );
                
                $widthSmall =  !empty( $fileSmall['dim'][0]['width'] ) ? $fileSmall['dim'][0]['width'] : 0;
				$heightSmall = !empty( $fileSmall['dim'][0]['height'] ) ? $fileSmall['dim'][0]['height'] : 0;
                $fileName = $file['foto'][0];
                
                
                $sql = "INSERT INTO ".$dbName.".affiliations ( name, url, img, width_small, height_small ) VALUES (
                        ".$mySql->quote( $product['shopName'] ).",
                        'fake_url',
                        '$fileName',
                        '$widthSmall',
                        '$heightSmall'
                )";
                                
                
                $stn = $mySql->query( $sql );
                if( !empty( $stn ) )
                    $affiliationId = $mySql->lastInsertId();
            } else {
                $row = $stn->fetch(\PDO::FETCH_OBJ );  
                $affiliationId = $row->id;
            }
                        
            if( empty( $affiliationId ) ) {
                $response['error']++; 
                continue;
            }
            
            $sql = "SELECT * FROM ".$dbName.".products WHERE affiliation_id = '".$affiliationId."' AND  impression_link = '".md5( $product['redirectUrl'] )."'";
            $stn = $mySql->prepare( $sql );
            $stn->execute();
            if ( $stn->rowCount() > 0 ) {
                $response['error']++; 
                continue;
            }
            
                                    
            $typology = !empty( $model->getTypology() ) ? $model->getSubcategory()->getId() : 'NULL';
            
            $this->fkSubcatAffiliation = !empty( $this->fkSubcatAffiliation ) ? $this->fkSubcatAffiliation : 'NULL';
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
                    original_link,
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
                    description,
                    fake_product
                ) VALUES (
                    $affiliationId,
                    NULL,
                    ".$model->getCategory()->getId().",
                    ".$model->getSubcategory()->getId().",
                    ".$typology.",
                    NULL,
                    ".$product['modelId'].",
                    ".$mySql->quote( $product['title'] ).",
                    ".$mySql->quote( $product['price'] ).",
                    ".$mySql->quote( $product['redirectUrl'] ).",
                    ".$mySql->quote( md5( $product['redirectUrl'] ) ).",
                    ".$mySql->quote( $product['link'] ).",
                    '".$product['productId'].rand(0, 50000 )."',
                    '".date('Y-m-d H:i:s')."',
                    '".date('Y-m-d H:i:s')."',
                    '".str_replace( 'T',' ',date('Y-m-d H:i:s') )."',
                    1,
                    0,
                    NULL,
                    NULL,
                    NULL,
                    'in stock',
                    NULL,
                    1
                )
            ";
            
//            echo $sql."\n";
            
            $stn = $mySql->query( $sql );
            if( !empty( $stn ) ) {
                $response['success']++; 
//              Response( $mySql->lastInsertId() );
//              
                 //Aggiorna la data di lettura del modello per idealo                
                $sql = "UPDATE $dbName.models SET has_products_ide = 1 WHERE id = ".$model->getId();
                $sth = $mySql->prepare( $sql );
                $sth->execute();
//                echo "\n".$sql."\n";                
            }
            else 
                $response['error']++; 
        }        
        return new Response(json_encode( $response ) );
    }
    
    
    /**
     * @Route( "/admin/getInfosModelExternalSite/", name="checkModelinfo" )     
     */
    public function getInfosModelExternalSite( Request $request ) {
        if( empty( $this->checkIsValidRequestAdmin( $request, false ) ) ) {
            return $this->redirectToRoute('login');
        }        
        
        $this->baseParameters();
        
        switch( $_GET['type'] ) {
            case 'schedaPagomeno':
                $urlPagomeno        = !empty( $_GET['urlPagomeno'] ) ? 'https://pagomeno.it/'.str_replace( 'product.php?p', 'product.php?p', $_GET['urlPagomeno'] ) : '';
                $urlIdealo          = !empty( $_GET['urlIdealo'] ) ? 'https://www.idealo.it/'.$_GET['urlIdealo'] : '';
                $urlTrovaprezzi     = !empty( $_GET['urlTrovaprezzi'] ) ? 'https://www.trovaprezzi.it/'.$_GET['urlTrovaprezzi'] : '';
            break;
            case 'bulletsPagomeno':
                $urlPagomeno = 'https://pagomeno.it/'.str_replace( 'product.php?p', 'product.php?e', $_GET['urlPagomeno'] );
            break;
            case 'bulletsIdealo':
                $urlIdealo = 'https://www.idealo.it/'.$_GET['urlIdealo'];
            break;
            case 'amazonAsinReview':
                $aws = $this->container->get('app.amazonApi');
                echo $aws->getSearchReview( $_GET['amazonAsinReview'] );
                exit;
            break;
        }
        
        $text = "";
        if( $_GET['type'] == 'schedaPagomeno' ) {
            
            $textPagomeno = '';
            $textIdealo = '';
            $textTrovaprezzi = '';
            if( !empty( $urlPagomeno ) ) {
//                $textPagomeno       = $this->globalConfigManager->globalUtility->getTecnicalPagomeno( $urlPagomeno );
//                $text = $textPagomeno;
            }
            if( !empty( $urlIdealo ) ) {
                $textIdealo = $this->globalConfigManager->globalUtility->getTecnicalIdealo( $urlIdealo );
                $text .= $textIdealo; 
            }
            if( !empty( $urlTrovaprezzi ) ) {
//                $textTrovaprezzi = $this->globalConfigManager->globalUtility->getTecnicalTrovaprezzi( $urlTrovaprezzi );
//                $text .= $textTrovaprezzi;
            }
            
//            echo $text;
            
            $model = $this->getDoctrine()->getRepository('AppBundle:Model')->find( $_GET['modelId'] );            
            $externalTecnical = $this->getDoctrine()->getRepository('AppBundle:ExternalTecnicalTemplate')->findOneByModel( $_GET['modelId'] );
            if( empty( $externalTecnical ) ) {
                $externalTecnical = new \AppBundle\Entity\ExternalTecnicalTemplate();     
                
            }
            
            $em = $this->getDoctrine()->getManager();
            $externalTecnical->setTecnicalTp( $textTrovaprezzi );           
            $externalTecnical->setTecnicalPm( $textPagomeno );           
            $externalTecnical->setTecnicalIde( $textIdealo );           
            $externalTecnical->setModel( $model );
            $em->persist( $externalTecnical );
            $em->flush();
                                    
            $model->setExternalTecnicalTemplate( $externalTecnical );
            $em->persist( $model );
            $em->flush();
            
            $text = str_replace( array( 'colore:si;' ) , array( '' ), strtolower( $text ) );
            
            $aTecnicals = $this->globalConfigManager->getTecnicalTemplates();
            $getTecnicalTemplateId = !empty( $aTecnicals[$_GET['tecnicalType']] ) ? $aTecnicals[$_GET['tecnicalType']] : false;
                        
                
            echo $this->globalConfigManager->globalUtility->getTecnicalTemplates( $getTecnicalTemplateId, $text );            
//          $extraModel['bulletPoints'] = $this->wm->globalUtility->getBulletPoints( $getTecnicalTemplateId, $extraModel['technicalSpecifications'] );            
            exit;
        }
        
        
        if( $_GET['type'] == 'bulletsPagomeno' ) {
            $result = file_get_contents( $url );
//        $result = mb_convert_encoding($result, 'HTML-ENTITIES', "UTF-8"); 
        
            $doc = new \DOMDocument();
            libxml_use_internal_errors( true );
            $doc->loadHTML( $result );
            libxml_clear_errors();       
            $xpath = new \DOMXpath( $doc );
            
            $elements = $xpath->query("//li[@id='big_tab_eg']//span");
            if( $elements->length == 0 ) {
                exit;
            }
            
            $aRes = array();
            foreach( $elements AS $element ) {
                $value = trim( preg_replace("/[^A-Za-z0-9 ]/", '', $element->nodeValue ) );
                if( !empty( $value ) )
                    $aRes[$value] = $value;
            }
            echo $text = implode( ';', $aRes);
            exit;
        }
        
    } 
       
    /**
     * Metodo che effettua l wget di una pagina e la restituisce
     * @param Request $request
     * @param type $code
     * @param type $pathOutput
     */
    public function wgetInfoAction( Request $request, $code, $pathOutput ) {        
        if( $code != 'rxndu9034tur0934tun3904tun309tu3490' ) {
            exit;
        }
        
        $url = $_GET['url'];        
        exec('wget "'.$url.'"  --output-document=/tmp/'.$pathOutput.'.html');                                
        $result = file_get_contents( '/tmp/'.$pathOutput.'.html' );
        echo $result;        
        exit;
    }
    
       
    /**
     * Metodo che effettua l wget di una pagina e la restituisce
     * @param Request $request
     * @param type $code
     * @param type $pathOutput
     */
    public function recirectUrlInfoAction( Request $request, $code ) {        
        if( $code != 'rxndu9034tur0934tun3904tun309tu3490' ) {
            exit;
        }
        
        $url = $_GET['link'];
        $redirectedUrl = '';

        //TODO Effettuare la stessa chiamata che viene a tricchetto per una url specifica e creare il servizio che risposta la corrente            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $html = curl_exec($ch);
        $redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        echo trim( $redirectedUrl );
        exit;
    }
    
    private function getHash( $sql ) {
        $query  = $sql;
        $hints  = array();
        $params = array();
        
        $hash = sha1($query . '-' . serialize($params) . '-' . serialize($hints));        
        $hash = sha1($hash. '--'  );
        return $hash;
    }
    
}