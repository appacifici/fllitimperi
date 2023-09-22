<?php

$menu = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' )."menu_mobile" . $this->versionSite . "_" . $sport);

if ( !$menu ) {
    $seasonRepository = $this->entityManager->getRepository( 'AppBundle:Tournament' );
    $tournaments = $seasonRepository->findTopTournamentBySport( $sport );
    
    $topTournaments = array();
    foreach ( $tournaments as &$v ) {
        $topTournaments[$v->getFeedUniqueTournamentId()]['nameTournament']              = $v->getNameIt();         
        $topTournaments[$v->getFeedUniqueTournamentId()]['id']                          = $v->getId();
        $topTournaments[$v->getFeedUniqueTournamentId()]['feedTournamentId']            = $v->getFeedTournamentId();

        $season = $this->entityManager->getRepository( 'AppBundle:Season' )->getLastSeasonByTournamentId( $v->getId(), false );
        $topTournaments[$v->getFeedUniqueTournamentId()]['lastSeasonId']                = $season->getId();
        $topTournaments[$v->getFeedUniqueTournamentId()]['lastFeedSeasonId']            = $season->getFeedSeasonId();
    }
    $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' )."top_Tournament" . $sport, json_encode( $topTournaments ) );
        
    
    $menu = array(        
    );
//
//    $menu[] = array(
//            "label" => 'Europei 2016',
//            "page" => '/calcio/internazionale/europei_2016/risultati',
//            "icon" => false,
//            "img" => $this->container->getParameter( 'app.cdn' ).'/images/flags/World.png'
//    );
    
    foreach ($tournaments as &$v) {
        $season = $v->getSeasons();
        $season = $season[0];                
            
        $urlSeason = $this->container->get('router')->generate('resultsSeason', array(
            'sport' => $v->getCategory()->getSport()->getNameUrlIt(),
            'category' => $v->getCategory()->getNameUrlIt(),
            'season' => $this->globalUtility->rewriteUrl_v2($season->getNameUrlIt()),
                )
        );        
        $menu[] = array(
            "label" => str_replace( array('UEFA','15/16'), array('',''), $v->getNameIt() ),
            "page" => $urlSeason,
            "icon" => false,
            "img" => '/images/flags/' . $v->getCategory()->getImg()
        );
    }

    $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' )."menu_mobile" . $this->versionSite . "_" . $sport, $menu);
} 