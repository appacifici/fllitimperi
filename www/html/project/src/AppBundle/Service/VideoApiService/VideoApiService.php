<?php

namespace AppBundle\Service\VideoApiService;
use AppBundle\Service\VideoApiService\Dailymotion;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Doctrine\Common\Persistence\ObjectManager;

class VideoApiService {

    private $apiKey     = 'dfed35d7d302490308fc';
    private $apiSecret  = '0093e55e0be1889d64b7d5a4283f2e0c68936ce8';
    
    /**
     * The injected Monolog service
     * @var Logger
     */
    public $logger;

    /**
     * When creating a new parseRestClient object
     * send array with 'restkey' and 'appid'
     * 
     */
    public function __construct(
        Logger $logger, 
        ObjectManager $doctrine,
        Container $container
    ) {
        $this->logger       = $logger; 
        $this->doctrine     = $doctrine;
        $this->container    = $container;
//
        $this->api = new Dailymotion();
//        $api->setGrantType(Dailymotion::GRANT_TYPE_AUTHORIZATION, $this->apiKey, $this->apiSecret);
//        $this->logger->pushHandler(new StreamHandler( '/tmp/getVideo.txt', Logger::DEBUG)); // <<< uses a stream
    }
    
    public function getVideoLastGoalMatches() {
        
        $this->cacheUtility = $this->container->get('app.cacheUtility');
        $this->cacheUtility->initPhpCache();        
        $this->cacheUtility->prefix = $this->container->getParameter( 'session_memcached_prefix' );
        
        $top = $this->cacheUtility->phpCacheGet( $this->cacheUtility->prefix."top_TournamentCalcio"  );
        $top = json_decode( $top, true );
        print_r( $top );       
        
        $memcachedLastGoal = $this->cacheUtility->phpCacheGet( $this->cacheUtility->prefix.'lastGoal' );     
        $memcachedLastGoal = json_decode( $memcachedLastGoal, true );
        
        uasort( $memcachedLastGoal, function($a, $b) { //Sort the array using a user defined function
            return ( $a['createTime'] < $b['createTime'] );
        });
        
        $memcachedLastGoal = json_decode(json_encode($memcachedLastGoal), FALSE);
        
        $x = 0;
        foreach( $memcachedLastGoal AS &$lastGoal ) {
            if(  !empty( $lastGoal->hasVideo ) || !array_key_exists( $lastGoal->utId, $top ) )
                continue;
//            
            $aSigle = array( 
                'ac ', 'a.c ', 'as ', 'a.s ', 'us ', 'u.s ', 'uc ', 'u.c ', 'fc ', 'f.c ', 'ss ', 's.s ', 'fs ', 'f.s ', 'sc ', 's.c ',
                'afc ', 'a.f.c ', 'cd ', 'c.d', 'cp', 'c.p ', 'gd ', 'g.d ', 'cf ', 'c.f ', 'ud ', 'u.d ', 'rc ', 'r.c ', 'cs ', 'c.s ',
                
                'AC ', 'A.C ', 'AS ', 'A.S ', 'US ', 'U.S ', 'UC ', 'U.C ', 'FC ', 'F.C ', 'SS ', 'S.S ', 'FS ', 'F.S ', 'SC ', 'S.C ',
                'AFC', 'A.F.C ', 'CD ', 'C.D', 'CP ', 'C.P ', 'GD ', 'G.D ', 'CD ', 'C.F ', 'UD ', 'U.D ', 'RC ', 'R.C ', 'CS ', 'C.S ',
                
            );
            
            $lastGoal->teamNameEn1 = !empty( $lastGoal->teamNameEn1 ) ? $lastGoal->teamNameEn1 : 'undefinedundefinedundefined';
            $lastGoal->teamNameEn2 = !empty( $lastGoal->teamNameEn2 ) ? $lastGoal->teamNameEn2 : 'undefinedundefinedundefined';
            
            $teamEn1 = str_replace( $aSigle, '', trim( utf8_decode(utf8_encode( $lastGoal->teamNameEn1 ) ) ) ) ;
            $teamEn2 = str_replace( $aSigle, '', trim( utf8_decode(utf8_encode( $lastGoal->teamNameEn2 ) ) ) );
            
            $team1   = str_replace( $aSigle, '',  trim( utf8_decode(utf8_encode( $lastGoal->teamName1 ) ) ) );
            $team2   = str_replace( $aSigle, '', trim( utf8_decode(utf8_encode( $lastGoal->teamName2 ) ) ) );
            
            $specialReplaceInit = array( 'Espanyol Barcellona', 'u00f1');
            $specialReplaceEnd = array( 'Espanyol', 'n' );
            
            $teamEn1 = str_replace( $specialReplaceInit, $specialReplaceEnd,  $teamEn1 )  ;
            $teamEn2 = str_replace( $specialReplaceInit, $specialReplaceEnd,  $teamEn2 ) ;
            
            $team1   = str_replace( $specialReplaceInit, $specialReplaceEnd,  $team1 );
            $team2   = str_replace( $specialReplaceInit, $specialReplaceEnd, $team2 ) ;
            
            
            $resultMatch = strtolower( $lastGoal->homeTeamScore.'-'.$lastGoal->awayTeamScore ); 
//            
//            $team1 = 'Porto';
//            $team2 = 'Crotone';
//            $resultMatch = '2-0'; 
            
            //prova a recuperare il video per massimo 10 volte
            $stopGetVideo = true;
            if( empty( $lastGoal->getVideo ) || $lastGoal->getVideo < 40 ) {
                $video = $this->getVideo( $team1, $team2, $resultMatch, $teamEn1, $teamEn2, true );  
                if( empty( $video ) ) {
                    $video = $this->getVideo( strtolower( $team1 ), strtolower( $team2 ), $resultMatch, strtolower( $teamEn1 ), strtolower( $teamEn2 ) );  
                }
                $lastGoal->getVideo = !empty( $lastGoal->getVideo ) ? $lastGoal->getVideo+1 : 1;     
                $stopGetVideo = false;
            }
                        
            if( !empty( $video ) && !empty( $video['id'] ) ) {                                
                $liveMatch = $this->doctrine->getRepository( 'AppBundle:LiveMatch' )->findOneBy( array( 'feedMatchId' => $lastGoal->matchId ) );
                if( !empty( $liveMatch ) ) {
                    $lastVideoIds = $liveMatch->getDailymotionVideos();
                    if( empty( $lastVideoIds ) ) {
                        $lastVideoIds = array();
                    } else {
                        
                       $lastVideoIds = json_decode($lastVideoIds, true); 
                    }     
                    
                    $lastVideoIds[$video['id']]['title']     = $team1. ' vs '.$team2.': '.$resultMatch;
                    $lastVideoIds[$video['id']]['type']      = 'dailymotion';
                    $lastVideoIds[$video['id']]['id']        = $video['id'];                                        
                    $lastVideoIds[$video['id']]['thumb']     = $video['thumbnail_480_url'];                                        
                    
                    print_r( $lastVideoIds ); 
                    
//                    $this->logger->info( 'OK:', $lastVideoIds );
//                    print_r($lastVideoIds);
                    $liveMatch->setDailymotionVideos( json_encode( $lastVideoIds ) );
                    $this->doctrine->flush();
                    
                    
                    $checkFieldMatch = $this->doctrine->getRepository( 'AppBundle:CheckFieldMatch' )->findOneBy( array( 'feedMatchId' => $lastGoal->matchId ) );
                    $checkFieldMatch->setHasVideo( 1 );
                    $this->doctrine->flush();
                    
                    $lastGoal->hasVideo = array( 'type' => 'dailymotion', 'id' => $video['id'] );    
                    
                }
            }
            
            $x++;
            if( $x == 30)
                break;            
            
            if( !$stopGetVideo)
                sleep( 1 );
            
//            if( $team1 == 'brescia')
//            exit;
        }

        //riordino all'inverso i record
        $memcachedLastGoal = json_decode(json_encode($memcachedLastGoal), true);
        uasort( $memcachedLastGoal, function($a, $b) { //Sort the array using a user defined function
            return ( $a['createTime'] > $b['createTime'] );
        });                
        $this->cacheUtility->phpCacheSet( $this->cacheUtility->prefix.'lastGoal', json_encode( $memcachedLastGoal ), ( 3600 * 48 ) );        
    }
    
    /**
     * 
     * @param type $team1
     * @param type $team2
     * @param type $resultMatch
     */
    function getVideo( $team1, $team2, $resultMatch, $teamEn1, $teamEn2, $emptyResult = false ) {
        try {
            $searchResultMatch = $emptyResult ? '' : $resultMatch;
            echo "Cerco video: /videos?search=$team1 $team2 $resultMatch&limit=10\n";
//            $this->logger->info( 'Cerco video:', array('/videos?search='.$team1.' '.$team2.' '.$searchResultMatch.'&limit=10\n') );
            $result = $this->api->get(
                "/videos?search=$team1 $team2 $resultMatch&limit=10",
                array( 'fields' => array( 'id', 'title', 'owner', 'embed_url', 'created_time', 'thumbnail_480_url') )
            );
            
            $result = $result['list'];            
            usort( $result, function($a, $b) { //Sort the array using a user defined function
                return ( $a['created_time'] <= $b['created_time'] );
            });            
//            print_r($result);
            $myVideos = array();
            foreach( $result AS &$item ) {
                $videoOk = true;
                $titleVideo  = strtolower( str_replace( ' ', '', $item['title'] ) );
                $team1       = strtolower( str_replace( ' ', '', $team1 ) );
                $team2       = strtolower( str_replace( ' ', '', $team2 ) );
                $teamEn1     = strtolower( str_replace( ' ', '', $teamEn1 ) );
                $teamEn2     = strtolower( str_replace( ' ', '', $teamEn2 ) );
                $resultMatch = strtolower( str_replace( ' ', '', $resultMatch ) );
                
                
//                $this->logger->info( 'title video:', array($titleVideo ) ); 
//                $this->logger->info( 'team1:', array($team1 ) ); 
//                $this->logger->info( 'team2:', array($team2 ) ); 
//                $this->logger->info( 'team1:', array($team1 ) ); 
//                $this->logger->info( 'team2:', array($team2 ) ); 
//                $this->logger->info( 'result match:', array($resultMatch ) ); 
                
                
                if( strpos(  $titleVideo , $team1 , '0' ) === false && strpos(  $titleVideo , $teamEn1 , '0' ) === false ) {
//                    $this->logger->info( 'esco 1:', array() ); 
                    $videoOk = false;
                }
                if( strpos( $titleVideo , $team2 , '0' ) === false && strpos( $titleVideo , $teamEn2 , '0' ) === false ) {
                    $videoOk = false;
//                    $this->logger->info( 'esco 2:', array() ); 
                }
                if( strpos( $titleVideo ,  $resultMatch , '0' ) === false ) {
                    $videoOk = false;
//                    $this->logger->info( 'esco 3:', array() ); 
                }                
                
                $item['create'] = date( 'Y-m-d H:i:s', $item['created_time'] );                
                $today      = date( 'Y-m-d' ); 
//                $today      = '2016-09-19';
                $dayVideo  = date( 'Y-m-d', $item['created_time'] );
                if( $videoOk && $today == $dayVideo ) {                    
                    $myVideos[] = $item;
                } else {
//                    if( $videoOk )
//                        $this->logger->info( 'esco data vecchia:', array() ); 
                }  
            }
                        
        }
        catch (DailymotionAuthRequiredException $e) {
            // If the SDK doesn't have any access token stored in memory, it tries to
            // redirect the user to the Dailymotion authorization page for authentication.
            print_r( $e );
        }
        catch (DailymotionAuthRefusedException $e) {
            // Handle the situation when the user refused to authorize and came back here.
            // <YOUR CODE>
        }
//        print_R($myVideos);
//        exit;
        return !empty( $myVideos ) ? $myVideos[0] : false;
    }
    
}