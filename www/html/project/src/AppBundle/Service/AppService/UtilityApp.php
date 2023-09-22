<?php

namespace AppBundle\Service\AppService;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Doctrine\Common\Persistence\ObjectManager;

class UtilityApp {
    
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
    public function __construct( Logger $logger, ObjectManager $doctrine
    ) {
        
        $this->doctrine = $doctrine;
//        $this->setPathFile();        
    }

    /**
     * Metodo che elimina il DeviceId quando i match seguiti sono terminati da più di un giorno
     * @param array $config
     * @param json $data
     */
    public function deleteDevicesEndedMatches( $day ) {
        
        $date = date('Y-m-d',strtotime("-$day days"));
        $matches = $this->doctrine->getRepository('AppBundle:MatchEvent')->getOldMatches( $date, true);
        
        //cicla tutti i device che seguono almeno una e individua quelli le cui partite seguite sono terminate da più di un giorno
        $arrayOldMatches = array ();
        foreach ( $matches AS $match ) {
            $arrayOldMatches[] = $match['feedMatchId'];
        }        
        $this->doctrine->getRepository('AppBundle:Device')->deleteDeviceFromId($arrayOldMatches);
    }
}

//https://gist.github.com/joashp/b2f6c7e24127f2798eb2
//https://developers.google.com/cloud-messaging/http-server-ref
