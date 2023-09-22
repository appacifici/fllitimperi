<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class W3cValidator extends WebTestCase
{
    public function __construct( $hostTest ) {
        $this->hostTest = $hostTest;
    }
    
    public function testValidationPage( $link  ) {              
//        echo 'https://validator.w3.org/nu/?doc='.urlencode($link)."\n";
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, 'https://validator.w3.org/nu/?doc='.urlencode($link) ); 
        curl_setopt($ch, CURLOPT_USERAGENT, "Googlebot/2.1 (+http://www.google.com/bot.html)");
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        $headers = array( 
                 "Cache-Control: no-cache", 
                ); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $output = curl_exec($ch); 
        curl_close($ch);  
        
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $output );
        libxml_clear_errors();       
        $xpath = new \DOMXpath( $doc );
        
        $success = $xpath->query( '//html/body/div[@id="results"]/p[@class="success"]')->length;      
        $this->assertEquals( 1, $success );
        
        $warning = $xpath->query( '//html/body/div[@id="results"]//li[@class="info warning"]')->length;      
        $this->assertEquals( 'SENZA WARNING', ( $warning == 0 ? 'SENZA WARNING' : 'CON WARNING' ) );
        
    }
    
    
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first