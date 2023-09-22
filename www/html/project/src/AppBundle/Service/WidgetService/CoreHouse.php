<?php

namespace AppBundle\Service\WidgetService;
use AppBundle\Entity\House;

class CoreHouse {
    
    /**
     * @var array
     */
    protected $houses = [];

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager) {
        $this->wm = $widgetManager;      
    }
    
       
    public function processData( $options = false ) :array {        
        $aImmo          = $this->getCurlImmo( );
        $aCDV           = $this->getCurlCaseDaVedere( );
        $aCasaIt        = $this->getCurlCasaIt( );
        $aIdea          = $this->getCurlIdealista( );
                       
        $this->houses   = array_merge( $aImmo, $aCasaIt, $aCDV, $aIdea );
        $this->manageHouse();
        
        $houses = $this->wm->doctrine->getRepository('AppBundle:House')->getHouses( $_GET );
        return array(
            'houses' => $houses
        );
    }
    
    /**
     * Cicla tutte le case se non presenti nel db la inserisce
     * @return void
     */
    private function manageHouse():void {
                
        foreach( $this->houses AS $item ) {
            if( empty( $item->name ) ) {
                continue;
            }
            
            $name       = ucwords( strtolower( $item->name ) );
            $link       = trim( $item->url );
            $locals     = trim( $item->locals );
            $price      = trim( $item->price );
            $surface    = trim( $item->surface );
            $bathroom   = trim( $item->bathroom );
            $floor      = trim( $item->floor );            
            $src        = trim( $item->src );         
            
            $house = $this->wm->doctrine->getRepository( 'AppBundle:House' )->findOneByLink( $link );
            if( !empty( $house ) ) {
                continue;                                
            }
            
            $newHouse = new House();
            $newHouse->setLink( $link );
            $newHouse->setName( $name );
            $newHouse->setLocals( $locals );
            $newHouse->setPrice( $price );
            $newHouse->setSurface( $surface );
            $newHouse->setBathroom( $bathroom );
            $newHouse->setFloor( $floor );
            $newHouse->setImg( $src );
            $newHouse->setCheckStatus( 0 );
            $newHouse->setNote( '' );
            $this->wm->doctrine->persist( $newHouse );
            $this->wm->doctrine->flush();                        
        }
    }
    
    
    /**
     * Recupera case per ludovica da immobiliare
     * @return array
     */
    private function getCurlImmo():array {
        
        $results = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'_curlImmo' );
        if( !empty( $results ) ) {
            return $results;
        }
        
        $curl = 'curl \'https://www.immobiliare.it/vendita-case/tivoli/?criterio=dataModifica&ordine=desc&prezzoMassimo=140000&superficieMinima=60&superficieMassima=100&balcone=1&idMZona\[\]=11663&idMZona\[\]=11665&idMZona\[\]=11664&idMZona\[\]=11661&idMZona\[\]=11662\' \
        -H \'authority: www.immobiliare.it\' \
        -H \'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\' \
        -H \'accept-language: it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7\' \
        -H \'cache-control: max-age=0\' \
        -H \'cookie: AB_TESTS_category_order=categories_to_right; _ga=GA1.2.1412983614.1658229606; cookie_base=1; cookie_stats=1; cookie_mktg=1; cookieBanner=1; ABTest_3dmap-detail=0; kameleoonVisitorCode=_js_biv91saxo02n488l; IMMSESSID=9a1765b54ae62932e47bd46eddfc257d; imm_pl=it; imm_toresu={"distinct_id":"66b7a8cf-b174-596e-8623-8df96f3d8622","$device_id":"dd0d9b6f-bfca-4695-8c0f-6242d4cf7650","startSession":1658229613,"$initial_referring_domain":"https://www.immobiliare.it","$initial_referrer":"https://www.immobiliare.it/","Channel":"Desktop","$search_engine":"google","Language":"it_IT","Experimental Flags":[],"InWebView":false,"$user_id":"66b7a8cf-b174-596e-8623-8df96f3d8622"}; brazeUserDefined=eyJ2ZXJzaW9uIjoidjciLCJ1c2VyIjoiNjZiN2E4Y2YtYjE3NC01OTZlLTg2MjMtOGRmOTZmM2Q4NjIyIn0=; _hjSessionUser_1373150=eyJpZCI6IjJiNTBjM2IzLWQxYTEtNTJkNi1hYjExLTkxN2U5MDEyMGEyNCIsImNyZWF0ZWQiOjE2NjU2MDA2NDgyNTMsImV4aXN0aW5nIjpmYWxzZX0=; _gcl_aw=GCL.1666370992.Cj0KCQjwhsmaBhCvARIsAIbEbH5oyU8bnVPU2uPd2ABxZM8hthKJPmPjVPKp0GfSTqrk32eru2uhna8aAqKLEALw_wcB; _gcl_au=1.1.1765126444.1666370992; _gac_UA-2884366-1=1.1662048880.Cj0KCQjwhsmaBhCvARIsAIbEbH5oyU8bnVPU2uPd2ABxZM8hthKJPmPjVPKp0GfSTqrk32eru2uhna8aAqKLEALw_wcB; _gac_UA-2884366-10=1.1666371147.Cj0KCQjwhsmaBhCvARIsAIbEbH5oyU8bnVPU2uPd2ABxZM8hthKJPmPjVPKp0GfSTqrk32eru2uhna8aAqKLEALw_wcB; __utmz=106237211.1667070249.20.12.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); _ta=it~1~e9db2d2c0148f35c8465dff725c3c584; _tac=false~self|google; IM_PAP_TI=eyJudW0iOjMsInVybCI6ImJmZTM3YjdmOWUzMzdjM2ZjNzExOTAyNmQ0MjZkMGQyIn0=; PHPSESSID=0bfdd76321fad9271567877b76d9a1f9; _gid=GA1.2.567315163.1669226283; __utmc=106237211; didomi_token=eyJ1c2VyX2lkIjoiMTg0YTVhM2ItZTM1NC02Y2ZhLWIwNDYtODgxMjE2OTQzMWI1IiwiY3JlYXRlZCI6IjIwMjItMTEtMjNUMTc6NTg6MDQuODA3WiIsInVwZGF0ZWQiOiIyMDIyLTExLTIzVDE3OjU4OjA0LjgwN1oiLCJ2ZW5kb3JzIjp7ImVuYWJsZWQiOlsiZ29vZ2xlIiwiYzpnb29nbGVhbmEtNFRYbkppZ1IiXX0sInZlbmRvcnNfbGkiOnsiZW5hYmxlZCI6WyJnb29nbGUiXX0sInZlcnNpb24iOjIsImFjIjoiQVVhQUVBRmtBb3dBLkFVYUFDQVVZIn0=; euconsent-v2=CPi5dkAPi5dkAAHABBENCrCgAPNAAE7AABCYF5wAwAIABbAXmBecAEBeYAAA.fmgACdgAAAAA; ab.storage.sessionId.fe67ee0d-3b20-47d7-95bc-dbbe2778b467=%7B%22g%22%3A%222bc541f0-0618-d5c3-88af-954af96f7cef%22%2C%22e%22%3A1669233440744%2C%22c%22%3A1669231640765%2C%22l%22%3A1669231640765%7D; ab.storage.deviceId.fe67ee0d-3b20-47d7-95bc-dbbe2778b467=%7B%22g%22%3A%22a5c02371-418e-4f63-df7e-3c76339aa95a%22%2C%22c%22%3A1651487236264%2C%22l%22%3A1669231640771%7D; ab.storage.userId.fe67ee0d-3b20-47d7-95bc-dbbe2778b467=%7B%22g%22%3A%2266b7a8cf-b174-596e-8623-8df96f3d8622%22%2C%22c%22%3A1664380353405%2C%22l%22%3A1669231640772%7D; _uetsid=6129d7706b5811eda948ff9e94b14184; _uetvid=6d15d020b8e811ec816633bf73364ebf; __utma=106237211.1412983614.1658229606.1669226284.1669231642.27; __utmt_UA-2884366-1=1; __utmb=106237211.1.10.1669231642; cto_bundle=2Zhxv19LVmVkNHNQQndxTWdZbjNCdlBpVzg0NEFGUVRDS3RlUUdZN1ElMkY4Z1ZmcEI1NGs5V3BWaCUyQnNyOG1IVXVEOGMyamFROTVEend6NVRhcmFHQWhLTXNpbHc5RVM5RWRWbFcwM3NUV1NncWZnSXBrZ1pCTFpCQ1Y1YnBHMkMxckFyRiUyQkZDMzdLWWp3aXQ4czllNVp0akZrbTk2cmtWT2F5d1Y0Y3RQYzM2c3F2ZnE3T3RlMGxOa3hvNHlrdGs1Nm1lSmFmJTJCVVpHNVdXcU84YUhvTTJTc3F6VlElM0QlM0Q; _tas=l1du9rlo18m; _gat_UA-2884366-10=1\' \
        -H \'sec-ch-ua: "Google Chrome";v="107", "Chromium";v="107", "Not=A?Brand";v="24"\' \
        -H \'sec-ch-ua-mobile: ?0\' \
        -H \'sec-ch-ua-platform: "macOS"\' \
        -H \'sec-fetch-dest: document\' \
        -H \'sec-fetch-mode: navigate\' \
        -H \'sec-fetch-site: same-origin\' \
        -H \'sec-fetch-user: ?1\' \
        -H \'upgrade-insecure-requests: 1\' \
        -H \'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36\' \
        --compressed';        
        $html = shell_exec( $curl );
        file_put_contents( '/tmp/immo.html', $html );
        
        $doc = new \DOMDocument;
        @$doc->loadHTML( file_get_contents( '/tmp/immo.html')  );
        
        $xpath = new \DOMXPath($doc);
        $lis = $xpath->query("//body//li[contains(@class, 'in-realEstateResults__item')]");
        
        $results = [];
        $x = 0;
        for ( $i = 0; $i < count($lis); $i++ ) {
//            echo $li->nodeValue . PHP_EOL;

            $images =  $xpath->query("//div[@class='nd-slideshow__item'][$i]/img", $lis[$i]) ;            
            $src = !is_null($images[0]) ? $images[0]->getAttribute('src') :'';
                          
            
            $a              = $xpath->query("//div[contains(@class, 'nd-mediaObject__content')]/a", $lis[$i] );
            $name           = $a[$i]->nodeValue;
            $url            = $a[$i]->getAttribute('href');
            
            $locals         = $xpath->query("//div[contains(@class, 'nd-mediaObject__content')]//ul/li[@aria-label='locali']", $lis[$i] );
            $locals         = is_object( $locals[$i] ) ? $locals[$i]->nodeValue : null;
            
            $price          = $xpath->query("//div[contains(@class, 'nd-mediaObject__content')]//ul/li[contains(@class, 'in-realEstateListCard__features--main')]", $lis[$i] );
            $price          = is_object( $price[$i] ) ? $price[$i]->nodeValue : null;
            
            $surface     = $xpath->query("//div[contains(@class, 'nd-mediaObject__content')]//ul/li[@aria-label='superficie']", $lis[$i] );
            $surface     = is_object( $surface[$i] ) ? $surface[$i]->nodeValue : null;
            
            $bathroom          = $xpath->query("//div[contains(@class, 'nd-mediaObject__content')]//ul/li[@aria-label='bagno']", $lis[$i] );
            $bathroom          = is_object( $bathroom[$i] ) ? $bathroom[$i]->nodeValue : null;
            
            $floor          = $xpath->query("//div[contains(@class, 'nd-mediaObject__content')]//ul/li[@aria-label='piano']", $lis[$i] );
            $floor          = is_object( $floor[$i] ) ?  $floor[$i]->nodeValue : null;
            
            
            $results[$i]['name']        = $name;
            $results[$i]['url']         = $url;
            $results[$i]['locals']      = $locals;
            $results[$i]['price']       = $price;
            $results[$i]['surface']     = $surface;
            $results[$i]['bathroom']    = $bathroom;
            $results[$i]['floor']       = $floor;
            $results[$i]['src']         = $src;                        
            $x++;
        }        
        
        
        $this->wm->cacheUtility->phpCacheSet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'_curlImmo', $results, 3600 );                        
        return $results;                
    }
    
    /**
     * Recupera case per Ludovica da casedavedere
     * @return array
     */
    private function getCurlCaseDaVedere():array {
        $results = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'_curlCasaDavedere' );
        if( !empty( $results ) ) {
            return $results;
        }
        
        $curl = 'curl \'https://www.casedavedere.it/vendita-case/tivoli-roma/prezzo=140000,tipologia=appartamento,mq_min=60,locali_min=2,\' \
        -H \'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\' \
        -H \'Accept-Language: it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7\' \
        -H \'Cache-Control: max-age=0\' \
        -H \'Connection: keep-alive\' \
        -H \'Cookie: lang=italian; _gcl_au=1.1.1125960608.1669226450; HstCfa88341=1669226450193; HstCmu88341=1669226450193; HstCnv88341=1; c_ref_88341=https%3A%2F%2Fwww.google.com%2F; _ga=GA1.2.244397411.1669226450; _gid=GA1.2.1277961494.1669226450; HstCla88341=1669228313625; HstPn88341=3; HstPt88341=3; HstCns88341=2\' \
        -H \'Referer: https://www.casedavedere.it/vendita-case/tivoli-roma/prezzo=140000,\' \
        -H \'Sec-Fetch-Dest: document\' \
        -H \'Sec-Fetch-Mode: navigate\' \
        -H \'Sec-Fetch-Site: same-origin\' \
        -H \'Sec-Fetch-User: ?1\' \
        -H \'Upgrade-Insecure-Requests: 1\' \
        -H \'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36\' \
        -H \'sec-ch-ua: "Google Chrome";v="107", "Chromium";v="107", "Not=A?Brand";v="24"\' \
        -H \'sec-ch-ua-mobile: ?0\' \
        -H \'sec-ch-ua-platform: "macOS"\' \
        --compressed';        
        
        $html   = shell_exec( $curl );
        file_put_contents( '/tmp/casedavedere.html', $html );
        
        $doc    = new \DOMDocument;
        @$doc->loadHTML( file_get_contents( '/tmp/casedavedere.html')  );
        
        $xpath  = new \DOMXPath($doc);
        $lis    = $xpath->query("//body//table//table[contains(@class, 'imm')]");
        
        $results = [];
        $x = 0;
        for ( $i = 0; $i < count($lis); $i++ ) {
            
            $img        = $xpath->query("//table[contains(@class, 'tabella1')]//img", $lis[$i] );
            $src        = $img[$i]->getAttribute('src');
                        
            $td2        = $xpath->query("//tr//td[2]//a[contains(@class, 'citta')]", $lis[$i] );
            $name       = $td2[$i]->nodeValue;
            $url        = $td2[$i]->getAttribute('href');
            
            $td2        = $xpath->query("//tr//td[2]//table//table[2]//tr[2]/td[2]", $lis[$i] );
            $surface    = $td2[$i]->nodeValue;
            
            $td2        = $xpath->query("//tr//td[2]//table//table[2]//tr[3]/td[2]", $lis[$i] );
            $price      = $td2[$i]->nodeValue;
            
            $results[$i]['name']        = trim( $name );
            $results[$i]['url']         = $url;                        
            $results[$i]['price']       = $price;
            $results[$i]['surface']     = $surface;
            $results[$i]['src']         = $src;
            $results[$i]['locals']      = null;
            $results[$i]['bathroom']    = null;
            $results[$i]['floor']       = null;                        
            
        }
        
        $this->wm->cacheUtility->phpCacheSet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'_curlCasaDavedere', $results, 3600 );
        return $results;
    }
    
    /**
     * Recupera case per Ludovica da caseIt
     * @return array
     */
    private function getCurlCasaIt():array {
        $results = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'_curlCasaIt' );
        if( !empty( $results ) ) {
            return $results;
        }
        
        $curl = 'curl \'https://www.casa.it/srp/?tr=vendita&balcony=true&lift=3&mqMin=60&mqMax=90&priceMax=140000&propertyTypeGroup=case&q=2dfa74f6\' \
        -H \'authority: www.casa.it\' \
        -H \'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\' \
        -H \'accept-language: it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7\' \
        -H \'cache-control: max-age=0\' \
        -H \'cookie: OptanonAlertBoxClosed=2022-10-29T18:42:49.389Z; _gcl_au=1.1.1798265088.1668965206; X-Casa-AB-PDPnw=false; X-Casa-AB-RLSVariants=3; eupubconsent-v2=CPhmyjAPhmyjAAcABBENCrCsAP_AAAAAAChQIytf_X__b2_j-_5_f_t0eY1P9_7__-0zjhfdl-8N3f_X_L8X42M7vF36pq4KuR4Eu3LBIQdlHOHcTUmw6okVryPsbk2cr7NKJ7PEmnMbOydYGH9_n13TuZKY7___f_7z_v-v_v_3__f_7-3f3__p_3_--_e_V_99zbn9_____9nP___9v-_9_________-AAAAYJAEABAADQAIgC8xUAEBeYyACAvMdAEABAADQAIgC8yUAIAIgC8ykAQAEAANAAiALz.f_gAAAAAAAAA; _gid=GA1.2.1830793152.1669228348; X-Casa-AB-Quality=B; _ga=GA1.2.669422779.1667068967; OptanonConsent=isIABGlobal=false&datestamp=Wed+Nov+23+2022+19%3A32%3A31+GMT%2B0100+(Ora+standard+dell%E2%80%99Europa+centrale)&version=6.36.0&hosts=&consentId=240e96a2-d35e-427d-af2c-fe7dea48a64e&interactionCount=1&landingPath=NotLandingPage&groups=C0001%3A1%2CC0002%3A1%2CBG50%3A1%2CBG51%3A1%2CC0004%3A1&geolocation=IT%3B62&AwaitingReconsent=false; cto_bundle=REnNzV9ycnBUN2lMM3huM1lLbEQ2RGxvcVlWYm1rVEFISWZHNE04MEpFYU5aaU51TlVWWWolMkJ2dzk5dHBrVzJhZFhzM1g0eFNEMkV2NmtiRU5zMkNCMGtHVnlzWmN0JTJCN1AlMkIwb3klMkZwY2IzSEgyNXVFcndkUEZzcVJDOUJyTjQxM1EzRUpScGZheWppdFRSU2k3ZVhyUkpGcnNBUSUzRCUzRA; datadome=2-wQT60tR1~oxvQ98T5iQpnpGehyz19SxSa3Rf4d5xi_5F~Rb~IcJdSLdG2nRgelq9YnKV5zEw2Y635A7YnF8naSiralhMC0j5eVyPkW8k8BbPrlPYkMf1DyUvz-_RsL; _ga_FNXRYZ9VWF=GS1.1.1669228347.4.1.1669228730.0.0.0\' \
        -H \'referer: https://www.casa.it/\' \
        -H \'sec-ch-ua: "Google Chrome";v="107", "Chromium";v="107", "Not=A?Brand";v="24"\' \
        -H \'sec-ch-ua-mobile: ?0\' \
        -H \'sec-ch-ua-platform: "macOS"\' \
        -H \'sec-fetch-dest: document\' \
        -H \'sec-fetch-mode: navigate\' \
        -H \'sec-fetch-site: same-origin\' \
        -H \'sec-fetch-user: ?1\' \
        -H \'upgrade-insecure-requests: 1\' \
        -H \'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36\' \
        --compressed';
        
        $html = shell_exec( $curl );
        file_put_contents( '/tmp/casait.html', $html );
        
        $doc = new \DOMDocument;
        @$doc->loadHTML( file_get_contents( '/tmp/casait.html')  );
        
        $xpath = new \DOMXPath($doc);
        $lis = $xpath->query("//body//article");
        
        $results = [];
        $x = 0;
        for ( $i = 0; $i < count($lis); $i++ ) {
//            echo $li->nodeValue . PHP_EOL;

            $images =  $xpath->query("//div[contains(@class, 'csa-gallery')]//img", $lis[$i]) ;
            foreach( $images AS $image ) {
                $src = $image->getAttribute('data-src');                
            }
                        
            $a             = $xpath->query("//div[contains(@class, 'is-clickable')]/div[2]//a", $lis[$i] );
            $name          = is_object( $a[$i] ) ?  $a[$i]->nodeValue : null;
            $url           = is_object( $a[$i] ) ?  'https://www.casa.it/'.$a[$i]->getAttribute('href') :'';            
            
            $price         = $xpath->query("//div[contains(@class, 'is-clickable')]//div[1]/div[1]/p", $lis[$i] );
            $price         = is_object( $price[$i] ) ? $price[$i]->nodeValue : null;
                        
            $surface    = $xpath->query("//div[contains(@class, 'is-clickable')]//div[1]/div[2]/div[1]/div[1]", $lis[$i] );
            $surface    = is_object( $surface[$i] ) ? $surface[$i]->nodeValue : null;
            
            $locals        = $xpath->query("//div[contains(@class, 'is-clickable')]//div[1]/div[2]/div[1]/div[2]", $lis[$i] );
            $locals        = is_object( $locals[$i] ) ? $locals[$i]->nodeValue : null;
                        
            $results[$i]['name']            = $name;            
            $results[$i]['url']             = $url;
            $results[$i]['locals']          = $locals;
            $results[$i]['price']           = $price;
            $results[$i]['surface']      = $surface;            
            $results[$i]['src']             = $src;       
            $results[$i]['bathroom']          = null;
            $results[$i]['floor']          = null;            
            
            $x++;
        }
        
        $this->wm->cacheUtility->phpCacheSet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'_curlCasaIt', $results, 3600 );
        return $results;
    }
    
    /**
     * Recupera case per Ludovica da idealista
     * @return array
     */
    private function getCurlIdealista():array {
        $results = $this->wm->cacheUtility->phpCacheGet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'_curlIdealista' );
        if( !empty( $results ) ) {
            return $results;
        }
        
        $curl = 'curl \'https://www.idealista.it/vendita-case/tivoli-roma/con-prezzo_140000,dimensione_60,dimensione-max_100,appartamenti/?ordine=pubblicazione-desc\' \
        -H \'authority: www.idealista.it\' \
        -H \'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9\' \
        -H \'accept-language: it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7\' \
        -H \'cache-control: max-age=0\' \
        -H $\'cookie: euconsent-v2=CPSQ4wAPSQ4wAAHABBENCeCoAP_AAAAAAAAAF5wBAAIAAtAC2AvMAAABAaADAAEEeyUAGAAII9lIAMAAQR7IQAYAAgj2OgAwABBHsJABgACCPYyADAAEEexUAGAAII9g.f_gAAAAAAAAA; atuserid=%7B%22name%22%3A%22atuserid%22%2C%22val%22%3A%22788c712a-398e-4ea0-87ee-558a064f8729%22%2C%22options%22%3A%7B%22end%22%3A%222023-10-03T16%3A14%3A45.334Z%22%2C%22path%22%3A%22%2F%22%7D%7D; atidvisitor=%7B%22name%22%3A%22atidvisitor%22%2C%22val%22%3A%7B%22vrn%22%3A%22-582070-%22%7D%2C%22options%22%3A%7B%22path%22%3A%22%2F%22%2C%22session%22%3A15724800%2C%22end%22%3A15724800%7D%7D; _gcl_au=1.1.1473728185.1662048885; afUserId=602a9392-010e-425a-9fbd-6281d116d124-p; _hjSessionUser_250322=eyJpZCI6IjY2Y2E2ZDY1LTQxNDMtNTE0NS05MTY2LTQ1ZjcwZjhlNDZkMSIsImNyZWF0ZWQiOjE2NjIwNDg4ODU4MDcsImV4aXN0aW5nIjp0cnVlfQ==; _cb=D4QkVqVhZGwojJ4X; atreman=%7B%22name%22%3A%22atreman%22%2C%22val%22%3A%7B%22camp%22%3A%22sec-1194-goo-%5Bit-IT-DSA-news%5D-617357026705-s%22%2C%22date%22%3A462737.7946261111%7D%2C%22options%22%3A%7B%22path%22%3A%22%2F%22%2C%22session%22%3A2592000%2C%22end%22%3A2592000%7D%7D; _gcl_aw=GCL.1665856061.CjwKCAjwtKmaBhBMEiwAyINuwAFwiqsLl9dBaPCTvwElvbP9UmYdnKM5w_Qn9-kk2t0tcoK0QbnRDBoChfoQAvD_BwE; _chartbeat2=.1641315010409.1668640277281.0000000000000001.BCiLMVaIo3LtHvN4B6DFHMBVZ5aN.1; userUUID=e518fdc5-22e2-49ef-a8b6-aa6bc476ad7a; SESSION=fb3d38dd5a1f5e99~f4760951-f7c2-460b-99ad-de3facaf50ee; _hjIncludedInSessionSample=1; _hjSession_250322=eyJpZCI6ImE1NmRmZWQyLWZkMTEtNGQxMi1iODcyLWQ1OWE0ZmVjM2I2YyIsImNyZWF0ZWQiOjE2NjkyMjg5NzYxNDUsImluU2FtcGxlIjp0cnVlfQ==; _hjAbsoluteSessionInProgress=1; _hjCachedUserAttributes=eyJhdHRyaWJ1dGVzIjp7ImlkX3BhZ2VMYW5ndWFnZSI6Iml0IiwiaWRfdXNlclJvbGUiOiIifSwidXNlcklkIjpudWxsfQ==; contactf4760951-f7c2-460b-99ad-de3facaf50ee="{\'email\':null,\'phone\':null,\'phonePrefix\':null,\'friendEmails\':null,\'name\':null,\'message\':null,\'message2Friends\':null,\'maxNumberContactsAllow\':10,\'defaultMessage\':true}"; askToSaveAlertPopUp=true; sendf4760951-f7c2-460b-99ad-de3facaf50ee="{\'friendsEmail\':null,\'email\':null,\'message\':null}"; listingGalleryBoostEnabled=false; cookieSearch-1="/vendita-case/tivoli-roma/con-prezzo_140000,dimensione_60,dimensione-max_100,appartamenti/:1669230430818"; utag_main=v_id:0182f9d551700044a558c1c0620c0507500ee06d00ac8$_sn:9$_se:24$_ss:0$_st:1669232232358$ses_id:1669228974743%3Bexp-session$_pn:13%3Bexp-session$_prevVtSource:searchEngines%3Bexp-1669232575047$_prevVtCampaignCode:%3Bexp-1669232575047$_prevVtDomainReferrer:google.com%3Bexp-1669232575047$_prevVtSubdomaninReferrer:www.google.com%3Bexp-1669232575047$_prevVtUrlReferrer:https%3A%2F%2Fwww.google.com%2F%3Bexp-1669232575047$_prevVtCampaignLinkName:%3Bexp-1669232575047$_prevVtCampaignName:%3Bexp-1669232575047$_prevVtRecommendationId:%3Bexp-1669232575047$_prevCompletePageName:11%3A%3A%3A%3A%3A%3A%3A%3AviewResults%3Bexp-1669234033361$_prevLevel2:11%3Bexp-1669234033361$_prevCompleteClickName:; ABTasty=uid=d1s3kdpyasx8b4yx&fst=1669228991858&pst=-1&cst=1669228991858&ns=1&pvt=37&pvis=37&th=; ABTastySession=mrasn=&sen=36&lp=https%253A%252F%252Fwww.idealista.it%252Fvendita-case%252Ftivoli-roma%252Fmappa; cto_bundle=nPPEgV9MNlBRYTh0MEFlQnRPRUEzd0l1SDJ4Wk9VWDN2QndYYkhjU1NYb2pEWlI2eUtzTlhRRjZFNU1Ydmk3MGVpRWZIZlVwR3lGRGxjJTJCYjhwRDJ4RFE0Z2IwbXBnRGhkZGNJUHF2R0RRTG1vZWlqYkdnWjFmOEowb052RzFRQ3JjR085N1YyejMlMkZicENJRUhqN2tIOHBvTEY1NkZLVHFsQkllcURnYVY5WVhTcVVxZjRJVUxJb0Z3elgyZzFxRW9tJTJGUE1xTEZFSWpib2VUdXhjVzRob1RuTTB3JTNEJTNE; datadome=5ozdTOyCs_BtBuW9h61-SiopAowN295m-Et~8Qz37PqnQVe52~sHQl74rs9Rbm~qJNXfgoc5KzzI7vTfJpR9NXg8eGmC18PR5wv8HaPyZ2p-RZ44aO20gIkdUIKqIz~z\' \
        -H \'referer: https://www.idealista.it/vendita-case/tivoli-roma/mappa\' \
        -H \'sec-ch-ua: "Google Chrome";v="107", "Chromium";v="107", "Not=A?Brand";v="24"\' \
        -H \'sec-ch-ua-mobile: ?0\' \
        -H \'sec-ch-ua-platform: "macOS"\' \
        -H \'sec-fetch-dest: document\' \
        -H \'sec-fetch-mode: navigate\' \
        -H \'sec-fetch-site: same-origin\' \
        -H \'sec-fetch-user: ?1\' \
        -H \'upgrade-insecure-requests: 1\' \
        -H \'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36\' \
        --compressed ;';
        
        $html = shell_exec( $curl );
        file_put_contents( '/tmp/idealista.html', $html );
        
        $doc = new \DOMDocument;
        @$doc->loadHTML( file_get_contents( '/tmp/idealista.html')  );
        
        $xpath = new \DOMXPath($doc);
        $lis = $xpath->query("//body//main//article");
        
        $results = [];
        $x = 0;
        for ( $i = 0; $i < count($lis); $i++ ) {
//            echo $li->nodeValue . PHP_EOL;

            $images =  $xpath->query("//picture//img", $lis[$i]) ;
            foreach( $images AS $image ) {
               $src = $image->getAttribute('src');                
            }
                        
            $a             = $xpath->query("//div[contains(@class, 'item-info-container')]/a", $lis[$i] );
            $name          = is_object( $a[$i] ) ?  $a[$i]->nodeValue : null;
            $url           = is_object( $a[$i] ) ?  'https://www.idealista.it'.$a[$i]->getAttribute('href') :'';            
                        
            $price         = $xpath->query("//span[contains(@class, 'item-price')]", $lis[$i] );
            $price         = is_object( $price[$i] ) ? $price[$i]->nodeValue : null;
                        
            $surface        = $xpath->query("//div[contains(@class, 'item-detail-char')]/span[2]", $lis[$i] );
            $surface        = is_object( $surface[$i] ) ? $surface[$i]->nodeValue : null;
            
            $locals         = $xpath->query("//div[contains(@class, 'item-detail-char')]/span[1]", $lis[$i] );
            $locals         = is_object( $locals[$i] ) ? $locals[$i]->nodeValue : null;
            
            $floor          = $xpath->query("//div[contains(@class, 'item-detail-char')]/span[3]", $lis[$i] );
            $floor          = is_object( $floor[$i] ) ? $floor[$i]->nodeValue : null;
            
            
            $results[$i]['name']            = trim( $name );            
            $results[$i]['url']             = $url;
            $results[$i]['locals']          = $locals;
            $results[$i]['price']           = $price;
            $results[$i]['surface']         = $surface;            
            $results[$i]['floor']           = $floor; 
            $results[$i]['bathroom']        = null;
            $results[$i]['src']             = $src;
            
            $x++;
        }
        
        $this->wm->cacheUtility->phpCacheSet( $this->wm->container->getParameter( 'session_memcached_prefix' ).'_curlIdealista', $results, 3600 );
        return $results;
    }
    
}



