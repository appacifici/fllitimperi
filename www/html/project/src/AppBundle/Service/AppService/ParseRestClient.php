<?php

namespace AppBundle\Service\AppService;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class ParseRestClient {

    // (Android)API access key from Google API's Console.
	private static $API_ACCESS_KEY_ANDROID  = 'AIzaSyCFgWffAkJU_Eds-WRsFiekbhaR9hHboBk';
	private static $API_ACCESS_KEY_IOS      = 'AIzaSyBMJeePMJG3LTAbyO0Ik2GrTlJxZv0fF64';
                                               
	// (iOS) Private key's passphrase.
	private static $passphrase = 'joashp';
	// (Windows Phone 8) The name of our push channel.
    private static $channelName = "joashp";

    
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

//        $this->setPathFile();              
//        $this->logger->pushHandler(new StreamHandler( '/tmp/sendtoapp.txt', Logger::DEBUG)); // <<< uses a stream
//        $this->logger->info( 'Init Import' );   

    }

    /**
     * Metodo che avvia l'invio delle push tramite google
     * @param array $config
     * @param json $data
     */
    public function initPush( $data ) {
        $this->cacheUtility = $this->container->get('app.cacheUtility');
        $this->cacheUtility->initPhpCache();        
        $this->cacheUtility->prefix = $this->container->getParameter( 'session_memcached_prefix' );

        $memcachedLastGoal = $this->cacheUtility->phpCacheGet( $this->cacheUtility->prefix.'lastGoal' );     
        $memcachedLastGoal = json_decode( $memcachedLastGoal,true );

        $data = json_decode( $data );
        
        if( $data->LiveMatch->data->newGoalScores == false )
            return;
        
        foreach ( $data->LiveMatch->data->goals AS $goal ) {
            $teamId = 'teamId' . $goal->team;
            $teamId = $goal->{$teamId};
            
            
            $fakeIdGoal = $goal->matchId.$goal->homeTeamScore.$goal->awayTeamScore;            
            if( empty( $memcachedLastGoal[$fakeIdGoal] ) || !empty( $memcachedLastGoal[$fakeIdGoal]['sendPush'] ) ) {   
//                $this->logger->info( 'esco memcached '. $goal->appMessage  );                
                continue;
            }
            
            $devices = $this->doctrine->getRepository('AppBundle:Device')->findFollowDevice( $teamId, $goal->matchId );
            $devices = json_decode( json_encode( $devices ), FALSE );

            $devicesIdsAndroid =  array();
            $devicesIdsIos      = array();

            //cicla tutti i device che seguono quel team o quella partita e li divide per dispositivo
            foreach ( $devices AS $device ) {
                if ( $device->device == 'android' )
                    $devicesIdsAndroid[] = trim( $device->deviceId );
                else
                    $devicesIdsIos[] = trim( $device->deviceId );
            }
                        
            $this->android( $goal, $devicesIdsAndroid, self::$API_ACCESS_KEY_ANDROID, 'android' );
            $this->android( $goal, $devicesIdsIos, self::$API_ACCESS_KEY_IOS, 'ios' );
            
            //setto sul array di memcached che è stata inviata la push
            $memcachedLastGoal[$fakeIdGoal]['sendPush'] = 1;  
//            $this->logger->info( 'setto push '. $fakeIdGoal.' '.$goal->appMessage );
        }                        
        $this->cacheUtility->phpCacheSet( $this->cacheUtility->prefix.'lastGoal', json_encode( $memcachedLastGoal ), ( 3600 * 48 ) );            
    }

    /**
     * Invia la notifica push android tramite google
     * @param object$goal
     * @param array $devicesIds
     */
    private function android( $goal, $devicesIds, $apikey, $type ) {
        $registrationIds = $devicesIds;

        $teamsNames = $this->rewriteUrl_v2( $goal->teamName1 ).'-'.$this->rewriteUrl_v2( $goal->teamName2 );
        $url = 'Calcio/'.$goal->countryIt.'/'.$goal->touName.'/'.$goal->matchId.'-'.$teamsNames;
        
        if( $type == 'android' ) {
            $message =  array(
                'subtitle' => 'GOAL! '.$goal->touName,
                'tickerText' => '',
                'vibrate' => 1,
                'sound' => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon',
                'title' => 'GOAL! '.$goal->touName,
                'message' => $goal->appMessage,
                'url' => $url
            );
            
            $fields = array(
	            'registration_ids' => $registrationIds,
	            'data' => $message,
	        );
            
        } else {
            $fields = array(
                "registration_ids" => $registrationIds,
                "notification" => array(
                    "title" => 'GOAL! '.$goal->touName,
                    "body" => $goal->appMessage,                    
                ),
                "priority" => "high",
                'data' => array(
                    'url' => $url
                )
            );  
        }
        
       $url = 'https://fcm.googleapis.com/fcm/send';
//	        
        $headers = array(
            'Authorization: key=' .$apikey,
            'Content-Type: application/json'
        );

//        print_r($registrationIds);
//        print_r(json_encode( $fields ));
//        print_r( $apikey );

        $resp =  $this->useCurl( $url, $headers, json_encode( $fields ) );
        $resp =  json_decode( $resp );

        if( !empty( $resp ) && is_object( $resp ) ) {
//            print_r($resp->results);
            foreach( $resp->results AS $key => $result ) {
                if( !empty( $result->error ) ) {                            
//                        $this->logger->info( 'ERROR:', $result->error );   

                    $delete = false;
                    switch( $result->error ) {
                        case 'InvalidRegistration':
                        case 'NotRegistered':
                            $delete = true;
                        break;
                    }
                    if( !empty( $delete ) ) {
                        echo "cancello device ".$registrationIds[$key]."\n";
                        $devices = $this->doctrine->getRepository('AppBundle:Device')->findByDeviceId( $registrationIds[$key]  );
                        foreach( $devices AS $device ) {
                            $this->doctrine->remove( $device );
                            $this->doctrine->flush();
                        }
                    }

                } else {
//                        $this->logger->info( 'OK:', $result );   
                }
            }
        }
//            $this->logger->info( 'END', array() );   
    }

    // Sends Push's toast notification for Windows Phone 8 users
    public function WP( $data, $uri ) {
        $delay = 2;
        $msg = "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                "<wp:Notification xmlns:wp=\"WPNotification\">" .
                "<wp:Toast>" .
                "<wp:Text1>" . htmlspecialchars( $data['mtitle'] ) . "</wp:Text1>" .
                "<wp:Text2>" . htmlspecialchars( $data['mdesc'] ) . "</wp:Text2>" .
                "</wp:Toast>" .
                "</wp:Notification>";

        $sendedheaders = array(
            'Content-Type: text/xml',
            'Accept: application/*',
            'X-WindowsPhone-Target: toast',
            "X-NotificationClass: $delay"
        );

        $response = $this->useCurl( $uri, $sendedheaders, $msg );

        $result = array();
        foreach ( explode("\n", $response ) as $line ) {
            $tab = explode( ":", $line, 2 );
            if ( count($tab) == 2 )
                $result[$tab[0]] = trim( $tab[1] );
        }
        return $result;
    }

    // Sends Push notification for iOS users
    public function iOS( $data, $devicetoken ) {
        $deviceToken = $devicetoken;
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option( $ctx, 'ssl', 'local_cert', 'ck.pem' );
        stream_context_set_option( $ctx, 'ssl', 'passphrase', self::$passphrase );
        // Open a connection to the APNS server
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['mtitle'],
                'body' => $data['mdesc'],
            ),
            'sound' => 'default'
        );
        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);
        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered' . PHP_EOL;
    }

    // Curl 
    private function useCurl( $url, $headers, $fields = null) {
        // Open connection
        $ch = curl_init();
        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }

            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);

            return $result;
        }
    }

    public function setPathFile($folder = 'app') {
        $base = '/home/prod/site/livescoreServices/var/backupSportradar';
        if (!file_exists($base))
            $base = '/home/ale/backupSportradar';

        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $path = "{$base}/{$year}/{$month}/{$day}/{$folder}";

        $old = umask(0);
        if (!file_exists("{$base}/{$year}"))
            mkdir("{$base}/{$year}", 0777);

        if (!file_exists("{$base}/{$year}/{$month}"))
            mkdir("{$base}/{$year}/{$month}", 0777);

        if (!file_exists("{$base}/{$year}/{$month}/{$day}"))
            mkdir("{$base}/{$year}/{$month}/{$day}", 0777);

        if (!file_exists("{$base}/{$year}/{$month}/{$day}/{$folder}"))
            mkdir("{$base}/{$year}/{$month}/{$day}/{$folder}", 0777);

        umask($old);
//      $this->logger->pushHandler(new StreamHandler($path . '/sendToApp.log', Logger::DEBUG)); // <<< uses a stream
    }
    
    /**
	 * Versione 2 Metodo riscrittura url
	 */
    public function rewriteUrl_v2( $string, $options = false ) {        
		$sep = !empty( $options->sep ) ? $options->sep : '_';
		$string = trim( $string );
		$string = strip_tags( $string );
		$string = preg_replace( '/[^a-zA-Z0-9àáéèíìóòúùäöüëÀÁÉÈÍÌÓÒÚÙÄÜÖ\s]+/', $sep, $string );
        $string = preg_replace( '/[^\w\s]+/', $sep, $string);
		$string = str_replace( '\/', $sep, $string );
		$string = preg_replace( '/-+/', $sep, $string );
		$string = preg_replace( '/-$/', $sep, $string );
		$string = str_replace( '-', $sep, $string );
		$string = str_replace( ' ', $sep, $string );
		$string = preg_replace( '/['.$sep.']+/', $sep,$string );
		$string = trim( $string, $sep );
		$string = strtolower( $string );	       
		return $string; 
	}

}

//https://gist.github.com/joashp/b2f6c7e24127f2798eb2
//https://developers.google.com/cloud-messaging/http-server-ref
