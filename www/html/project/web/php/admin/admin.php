<?php

    ini_set( 'display_errors', getenv( 'viewErrors' ) );
    session_start();	
	require_once getenv( 'pathSetting' ).'/InitSetting.class.php';	
	require_once getenv( 'pathSite' ).'/lib/Main.class.php';	

	$main = Main::getInstance();
    $main->initGlobalParamsSite();
	$main->printDebugVariables();
	$main->checkDisclaimer();
	
	//Inizializzo i meta di default del sito
	$main->var->app_id = '';
	$main->var->type = '';
	$main->var->metaTitle = 'TEST';
	$main->var->metaDescription = '';
	$main->var->metaKeywords = '';
	$main->var->metaImg = $main->config->urlSite.'/images/logo.png';
	$main->var->metaUrl = $main->config->urlSite.'/index.html';
	$main->var->metaFragment = false;
	//$main->var['getProductsAjax'] = true;		
    
	$rewrite = new Rewrite();	
	$main->smarty->assign( 'page', !empty( $main->get['page'] ) ? $main->get['page'] : '' );
	
	//Controllo sulle variabili in della url per determinare la struttura xml da lanciare
	$scriptJS = array();
	$scriptCSS = array();    
        
    if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'logout' ) {
		$main->user->logout();	
        header( 'Location: /' );
    }    
    
	if ( !empty( $main->get['page'] ) && $main->get['page'] == 'errorPage' ) {
		$pageSite = 'errorPage';
		$fileStructure = "/errorPage.xml";
			
	} else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'signup' ) {
        $pageSite = 'signup';
		$fileStructure = "/signup.xml";
        
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'user' ) {
        $pageSite = !empty( $main->get['userId'] ) ? 'user' : 'photos';
        $fileStructure = !empty( $main->get['userId'] ) ? '/user.xml' : '/userManager.xml';
        
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'photos' && !empty( $main->get['userSection'] ) ) {
        $pageSite = !empty( $main->get['userId'] ) ? 'userPhoto' : 'photosManager';
        $fileStructure = !empty( $main->get['userId'] ) ? '/userPhoto.xml' : '/userPhotosManager.xml';
        
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'videos' && !empty( $main->get['userSection'] ) ) {
        $pageSite = !empty( $main->get['userId'] ) ? 'userVideo' : 'videos';
        $fileStructure = !empty( $main->get['userId'] ) ? '/userVideos.xml' : '/userVideosManager.xml';
        		
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'friends' ) {
        $pageSite = 'friends';
		$fileStructure = "/friends.xml";
        
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'notifications' ) {
        $pageSite = 'notifications';
		$fileStructure = "/userNotifications.xml";
		
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'viewsProfile' ) {
        $pageSite = 'viewsProfile';
		$fileStructure = "/viewsProfile.xml";
		
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'messages' ) {
        $pageSite = 'messages';
		$fileStructure = "/messages.xml";
    
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'photos' && !empty( $main->get['id'] ) ) {
        $pageSite = 'photo';
        $fileStructure = '/photos.xml';
        
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'videos' && !empty( $main->get['id'] ) ) {
        $pageSite = 'videos';
        $fileStructure = '/videos.xml';
        
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'lastminutes' ) {
        $pageSite = 'lastminutes';
		$fileStructure = "/lastminutes.xml";
        
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'online' ) {
        $pageSite = 'online';
		$fileStructure = "/usersOnline.xml";
        
    } else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'usersSearch' ) {
        $pageSite = 'usersSearch';
		$fileStructure = "/usersSearch.xml";
		
//		$aCategory = !empty( $main->var['aCategory'][$main->var['idCategory']] ) ? $main->var['aCategory'][$main->var['idCategory']] : false;		
//		$main->var['metaTitle'] = !empty( $aCategory['metaTitle'] ) ? $aCategory['metaTitle'] : 'I prodotti di '.$main->var['category'].' al prezzo migliore.';
//		$main->var['metaDescription'] = !empty( $aCategory['metaDescription'] ) ? $aCategory['metaDescription'] : 'Approfitta degli sconti e delle promozioni offerte e acquista prodotti di '.strtoupper( $main->var['category'] ).' a prezzi stracciati';		
//		$main->var['metaKeywords'] = !empty( $aCategory['metaKeywords'] ) ? $aCategory['metaKeywords'] : 'migliore prezzo '.$main->var['category'].', prezzo migliore online '.$main->var['category'].', offerte  '.$main->var['category'].', offerta migliore prezzo '.$main->var['category'];
//		$main->var['metaImg'] = $main->config->urlSite.'/images/logo.png';
//		
//		$main->setMetaPropertys();
//		$main->headerSiteContent( $aCategory );
//		
	} else if ( !empty( $main->get['page'] ) && $main->get['page'] == 'disclaimer' ) {
        $pageSite = 'disclaimer';
		$fileStructure = "/disclaimer.xml";
        
    } else {				
		$pageSite = 'home';
		$fileStructure = "/home.xml";
		$main->setMetaPropertys();
		$main->headerSiteContent( array() );
	}	
	$main->smarty->assign( "pageSite", $pageSite );
	$main->smarty->assign( "scriptCSS", $scriptCSS );
	$main->smarty->assign( "scriptJS",  $scriptJS );
    
    $main->smarty->assign( "urlLastminute",  $main->rewrite->getUrlLastminute() );
    $main->smarty->assign( "urlDataProfile",  $main->rewrite->getUrlTimelineAccout() );
	
    //Array dei tpl che necessitano che l'utente sia loggato    
	$tplViewTplSessionActive = array(
		null => 'widget_AccountLoginUser',
		null => 'widget_Statistics',
		'widget_NavbarLogin' => 'structure_Navbar'
	);
	
	//Lancia i metodi di Smarty per creare e visualizzare a video l'html finale della pagina
	$main->smarty->setSmartClassFunctionProject( $main );	
	$main->smarty->setXml( $main->config->cartellaXmlSmarty, $fileStructure );	
	$main->smarty->setSessionActive( true, $main->user->sessionActive );
	$main->smarty->setViewTplSessionActive( $tplViewTplSessionActive );	
	$main->smarty->initTemplate();
	
	//Stampa a debug di firebug le query
	if ( $main->obj->typeClassDb == ZEND_DB ) {
		$main->obj->profiler->getStringToFirebug();
		$main->obj->channel->flush();
	  	$main->obj->response->sendHeaders();
	}	
	$main->setMetaPropertys();
    $main->addDependencies();
	
	//Aggiungo configurazioni in run time
	//$main->config->getProductsAjax = !empty( $main->var['getAjaxTemplates'] ) ? 1 : 0;

	if ( $main->config->debugPHP ) {
		$main->printDebugQuery();
		ob_end_clean();
	}		
    
	//Stampo l'html
	$main->smarty->printTemplate( $main->config->compactSite );