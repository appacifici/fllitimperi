<?php

namespace AppBundle\Service\SpiderService;


class proxyConnector {
	
    private static $instance;
    private $destinationUrl;
    private $userAgent;
    private $timeout;
    private $vector;
    private $payload;
    private $returnData;
    private $ip;
    private $port;
    private $controlPort;
    private $controlPassword;
    private $switchIdentityAfterRequest = true;
    public  $changeIdentity = true;
    public  $lastRemoteIp;
    private $numberReloadIp;
    static $debug = true;

    public static function getIstance( $debug = true ) {
        self::$debug = $debug;
        if ( !isset( self::$instance ) ) {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        return self::$instance;
    }

    /**
     * SetUp the proxy configuration
     * @param string $extIp Proxy Ip
     * @param number $extPort  Proxy Port
     */
    public function setProxy( $extIp="127.0.0.1", $extPort="8118" ) {
        $this->ip = $extIp;
        $this->port =$extPort;
    }

    /**
     * SetUp the control information
     * used by a Tor proxy to renew identity
     * @param string $extPort Proxy Ip
     * @param number $extPassword Proxy Control Port
     */
    public function setControlParameters( $extPort, $extPassword ) {
        $this->controlPassword = '"'.$extPassword.'"';
        $this->controlPort = $extPort;
    }

   /**
    * Request a remote url using Curl
    * @param string $extUrl
    * @param string $extVector
    * @param number $extTimeout
    */
   public function launch( $extUrl, $extVector, $extTimeout = null, $resetReload = true ) {
   			if ( $resetReload )
   				$this->numberReloadIp = 0;
   	
        //set parameters
        $this->destinationUrl = str_replace( " ","%20",$extUrl );
        $this->myLog( $this->destinationUrl );
        $this->vector = $extVector;
        
        //set payload
        $this->setPayload();

        //if a timeout is set in the args, use it
        if( isset( $timeout ) ) {
            $this->timeout = $extTimeout;
        }

        //run cURL action against url
        $this->setCurl(); 

        //renew identity
        /*
        if ( $this->switchIdentityAfterRequest && $this->changeIdentity ) {
            $this->newIdentity();
            $this->setUserAgent();
        }
        */
    }

    /**
     * Return downloaded data from the proxy
     * @return array
     *          url: requested url
     *          userAgent: used userAgent
     *          timeout: used timeout
     *          proxy: proxy address
     *          payload: payload
     *          return: url content
     */
    public function getProxyData() {
        return array(
                'url' => $this->destinationUrl,
                'userAgent' => $this->userAgent,
                'timeout' => $this->timeout,
                'proxy' => $this->ip .":". $this->port,
                'payload' => $this->payload,
                'return' => $this->returnData
        );
    }


    /**
     * Change identity in the Tor Network
     * (change public IP Address)
     * @return bool
     *          true is new identity is created
     *          false is fail creating a new identity
     */
    public function newIdentity( $resetReload = true ) {
        if ( $resetReload )
            $this->numberReloadIp = 0;
        
        $fp = fsockopen( $this->ip, $this->controlPort, $errno, $errstr, 30 );
        if ( !$fp ) {
            echo "$errstr ($errno)<br />\n";
            return false; //can't connect to the control port
        }
        
        fputs( $fp, "AUTHENTICATE ".$this->controlPassword."\r\n" );
        $response = fread($fp, 1024);        
        
        list($code, $text) = explode(' ', $response, 2);
        
        if ($code != '250') {
            echo $response;
            return false; //authentication failed
        }

        //send the request to for new identity
        fputs( $fp, "signal NEWNYM\r\n" );
        $response = fread( $fp, 1024 );
        list( $code, $text ) = explode( ' ', $response, 2 );
        if ( $code != '250' ) {
        	echo $code;
        	return false; //signal failed
        }
        fclose( $fp );
        $this->setUserAgent();
        
        $this->numberReloadIp++;
        $this->controlLastIp();
        
        return true;
    }

		/**
     * Funzione che controlla se il cambio di indentita sia andato a buona fine 
     * in caso l'esito sia negativo ritenta il cambio fino ad un massimo di 100 volte
     */
		public function controlLastIp() {
			if ( $this->numberReloadIp > 50 ) {
				$this->myLog( $this->numberReloadIp );
				return false;
			}
            $this->launch( "http://tricchetto.homepc.it/ip.php", null, null, false );
			$data = $this->getProxyData();		
			//$ip = $this->getRemoteIp( $data['return'] );
			$ip = $data['return'];
			
            
            $this->myLog( $ip .'[==]'. $this->lastRemoteIp );
            
			if ( !$ip || $ip == $this->lastRemoteIp ) {
                $this->myLog( 'ritenta' );
                sleep( 10 ); 
				$this->newIdentity( false );
            } else {
				$this->lastRemoteIp = $ip;
            }
            
		}
		
		public function getRemoteIp( $string ) {
			$regexp = "#UTF-8[\s]*(.*)#";
			preg_match( $regexp, $string , $ip );
			$ip = isset( $ip[1] ) || !empty( $ip[1] ) ? $ip[1] : false;
			return $ip;
		}
		
		public function getContentPage( $url ) {
			$this->launch(  $url , null);
			$data = $this->getProxyData();
			return $data['return'];
		}
		
    /**
     * Load the default configuration for the proxy connection
     * located in "proxyConfiguration.ini"
     */
    public function loadDefaultSetUp( $fileIni = "proxyConfiguration.ini" ) {
        $loaded_ini_array = parse_ini_file( $fileIni, true );
        $this->destinationUrl = null;
        $this->userAgent = null;
        $this->vector = null;
        $this->payload = null;
        $this->returnData = null;

        $this->timeout = $loaded_ini_array["general"]["timeout"];
        $this->ip = $loaded_ini_array["general"]["ip"];
        $this->port = $loaded_ini_array["general"]["port"];
        $this->controlPort = $loaded_ini_array["TOR"]["controlPort"];
        $this->controlPassword = '"'.$loaded_ini_array["TOR"]["controlPassword"].'"';
        $this->switchIdentityAfterRequest = $loaded_ini_array["TOR"]["switchIdentityAfterRequest"];
    }


    //PRIVATE
    private function  __construct() {
        $this->loadDefaultSetUp();
    }
		
		/**
     * Funzione che cambia lo userAgent della richiesta in maniera random
     */
    private function setUserAgent() {
        //list of browsers
        $agentCrawler = array(
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.19 (KHTML, like Gecko) Chrome/1.0.154.53 Safari/525.19',
                'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Ubuntu/10.10 Chromium/8.0.552.237 Chrome/8.0.552.237 Safari/534.10',
                'Mozilla/5.0 (X11; Linux i686; rv:30.0) Gecko/20100101 Firefox/30.0',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:58.0) Gecko/20100101 Firefox/58.0',
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; cs; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8',
                'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Win64; x64; Trident/6.0)',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15',
                'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; de-de) AppleWebKit/125.2 (KHTML, like Gecko) Safari/125.7',
                'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2376.0 Safari/537.36 OPR/31.0.1857.0',
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36 OPR/20.0.1387.91',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.38 Safari/537.36',
                'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/534.20 (KHTML, like Gecko) Chrome/11.0.672.2 Safari/534.20',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.38 Safari/537.36',
        );
        
        //list of browsers
        $agentBrowser = array(
                'Firefox',
                'Safari',
                'Opera',
                'Flock',
                'Internet Explorer',
                'Seamonkey',
                'Konqueror',
                'GoogleBot'
        );
        //list of operating systems
        $agentOS = array(
                'Windows 3.1',
                'Windows 95',
                'Windows 98',
                'Windows 2000',
                'Windows NT',
                'Windows XP',
                'Windows Vista',
                'Redhat Linux',
                'Ubuntu',
                'Fedora',
                'AmigaOS',
                'OS 10.5'
        );
        //randomly generate UserAgent
//        $this->userAgent = $agentBrowser[rand(0,7)].'/'.rand(1,8).'.'.rand(0,9).' (' .$agentOS[rand(0,11)].' '.rand(1,7).'.'.rand(0,9).'; it-IT;)';
        $this->userAgent = $agentCrawler[rand(0,13)];
    }

		/**
     * Metodo che effettua la chiamata curl all'url indicato tramite il proxy per il recupero dei dati
     */
    private function setCurl() {    
        $this->myLog( 'inizio curl: '.$this->ip .":". $this->port );
        $this->setUserAgent();
        $action = curl_init();
        curl_setopt( $action, CURLOPT_HTTPPROXYTUNNEL, true );
        curl_setopt( $action, CURLOPT_PROXY, $this->ip .":". $this->port );
        curl_setopt( $action, CURLOPT_URL, $this->payload );
        curl_setopt( $action, CURLOPT_HEADER, 0 );
        curl_setopt( $action, CURLOPT_USERAGENT, $this->userAgent );
        curl_setopt( $action, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $action, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $action, CURLOPT_TIMEOUT, $this->timeout );
        
        curl_setopt($action, CURLOPT_FAILONERROR, true);
        curl_setopt($action, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($action, CURLOPT_FRESH_CONNECT, TRUE);
        $headers = array( 
                 "Cache-Control: no-cache", 
                ); 
        curl_setopt($action, CURLOPT_HTTPHEADER, $headers);
        
        $this->returnData = curl_exec( $action );
//         print_r($this->returnData);
        curl_close( $action );
        $this->myLog( 'fine curl' );
        
    }

    private function setPayload() {
        $this->payload = $this->destinationUrl . $this->vector;
    }

    private function  __clone() {
        trigger_error( "Clonig not allowed" );
    }
    
    //Funzione per i messaggi di log
    private function myLog( $msg ) {
        return;
        if( self::$debug ) {
    	 echo "###########################";
    	 echo $msg;
    	 echo "###########################\n";
         }
    }

}//End Class
