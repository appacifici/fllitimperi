<?php

//$menu = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' )."menu_" . $this->versionSite . "_" . $sport);
////$menu = false; 
//
//if ( !$menu ) {
//    $seasonRepository = $this->entityManager->getRepository( 'AppBundle:Tournament' );
//    $tournaments = $seasonRepository->findTopTournamentBySport( $sport );
//    
//    $topTournaments = array();
//    foreach ( $tournaments as &$v ) {
//        $topTournaments[$v->getFeedUniqueTournamentId()]['nameTournament']              = $v->getNameIt();         
//        $topTournaments[$v->getFeedUniqueTournamentId()]['id']                          = $v->getId();
//        $topTournaments[$v->getFeedUniqueTournamentId()]['feedTournamentId']            = $v->getFeedTournamentId();
//
//        $season = $this->entityManager->getRepository( 'AppBundle:Season' )->getLastSeasonByTournamentId( $v->getId(), false );
//        $topTournaments[$v->getFeedUniqueTournamentId()]['lastSeasonId']                = $season->getId();
//        $topTournaments[$v->getFeedUniqueTournamentId()]['lastFeedSeasonId']            = $season->getFeedSeasonId();
//    }        
//    $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' )."top_Tournament" . $sport, json_encode( $topTournaments ) );
//    
//    $menu = array(
//        array(
//            'label' => $this->container->get('translator')->trans('Top Campionati'),
//            'class' => 'category border-top topmenu topChampionship'
//        )
//    );
//    
//    $menu[] = array(
//        "label" => 'Mondiali',
//        "page" => '/calcio/internazionale/torneo_mondiali/risultati',
//        "icon" => false,
//        "img" => $this->container->getParameter( 'app.cdn' ).'/images/flags/World.png'
//    );
////
////    $menu[] = array(
////            "label" => 'Europei 2016',
////            "page" => '/calcio/internazionale/europei_2016/risultati',
////            "icon" => false,
////            "img" => $this->container->getParameter( 'app.cdn' ).'/images/flags/World.png'
////    );
//    
//    foreach ($tournaments as &$v) {
//        $season = $v->getSeasons();        
//        $season = $season[0];                            
//        
//        $urlSeason = $this->container->get('router')->generate('resultsSeason', array(
//            'sport' => $v->getCategory()->getSport()->getNameUrlIt(),
//            'category' => $v->getCategory()->getNameUrlIt(),
//            'season' => $this->globalUtility->rewriteUrl_v2($season->getNameUrlIt()),
//                )
//        );        
//        
//        $menu[] = array(
//            "label" => str_replace( array('UEFA','15/16', 'Primera Division'), array('','', 'Liga'), $v->getNameIt() ),
//            "page" => $urlSeason,
//            "icon" => false,
//            "img" => $this->container->getParameter( 'app.cdn' ).'/images/flags/' . $v->getCategory()->getImg()
//        );
//    }
//    
//    $menu[] = array(
//        'widget' => 'widget_BannerMenu',
//        'core' => 'core_bannerMenu'
//    );
//
//    $categoryRepository = $this->entityManager->getRepository('AppBundle:Category');
//    $categories = $categoryRepository->findCategoriesMenuBySport($sport);
//    $menu[] = array(
//        'label' => $this->container->get('translator')->trans('Paesi del Mondo'),
//        'class' => 'category border-top topmenu text-center'
//    );
//    $levelInit=100;
//    foreach ($categories as &$v) {
//        $tournaments = $v->getTournaments();
//        $childsCategory = array();
//        
//        foreach ($tournaments as &$t) {
//            
//            $season = $t->getSeasons();
//            $season = $season[0];
//            
//            
////            $urlSeason = $this->container->get('router')->generate('resultsSeason', array( 'season' => $this->globalUtility->rewriteUrl_v2( $t->getNameIt() ), 'seasonId' => $season->getId() ));
//
//            $urlSeason = $this->container->get('router')->generate('resultsSeason', array(
//                'sport' => $t->getCategory()->getSport()->getNameUrlIt(),
//                'category' => $t->getCategory()->getNameUrlIt(),
//                'season' => $this->globalUtility->rewriteUrl_v2($season->getNameUrlIt()),
//                    )
//            );
//            
//            $level = $t->getLevel() == '100' ?  $levelInit : $t->getLevel();
//            if( !empty( $childsCategory[$level] ) )
//                $level = $level+100;
//            
//            $childsCategory[$level] = array(
//                "label" => $t->getNameIt(),
//                "page" => $urlSeason,
//                "LEVEL" => $t->getLevel()
//            );
//            $levelInit = $levelInit+1;
//            
//        }
//        ksort( $childsCategory );
//        $menu[] = array(
//            "label" => $v->getNameIt(),
//            "icon" => false,
//            "img" => $this->container->getParameter( 'app.cdn' ).'/images/flags/' . $v->getImg(),
//            "type" => "collapse",
//            "page" => $childsCategory);
//    }
//    
//    $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' )."menu_" . $this->versionSite . "_" . $sport, $menu);
//} 
////else {
////    $this->memcached->destroy("menu_" . $this->versionSite . "_" . $sport);
////}
//
////$modifyEvents = null;
////if( !empty( $this->user->isActivity ) ) {
////    $modifyEvents = array(
////        'label' => 'Inserisci Evento',
////        'icon' => 'fa icon-settings-wheel-fill',
////        'page' => $this->rewrite->getUrlModifyEvents()
////    );
////}

$configMenu['menu'] = array(
    'admin' => array()



//     
//		array(
//			'label' => 'Filter Custom HTML',
//			'class' => 'reset',
//			'file' => 'filter.php'
//		),
//	)
);