<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Pagination extends WebTestCase
{
    public function __construct( $hostTest ) {
        $this->hostTest = $hostTest;
    }
    
    public function testpagination( $route, $crawler, $link  ) {           
        $pagination =  $crawler->filterXPath('//html/body/main//ul[@id="pagination"]' )->count();        
        if( $pagination == 0 )
            return;
        
        $pagination =  $crawler->filterXPath('//html/body/main//ul[@id="pagination"]/li' )->count();
        $this->assertGreaterThan( 2, $pagination );   
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.$link, $canonical[0] );            
        
        $this->testPage1( $crawler, $link );
        $this->testPage2( $crawler, $link );
        $this->testPage3( $crawler, $link );
    }
    
    private function testPage1( $crawler, $link ) {
        $prev = $crawler->filterXpath( "//link[@rel='prev']" )->count();
        $this->assertEquals( 0, $prev );    
        
        $next = $crawler->filterXpath( "//link[@rel='next']" )->extract(array('href'));  
        $this->assertEquals( $link.'?page=2', $next[0] );                     
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.$link, $canonical[0] );    
    }
    
    private function testPage2( $crawler, $link ) {
        $client = static::createClient();
        $crawler = $client->request('GET', $this->hostTest.$link.'?page=2');
        
        $prev = $crawler->filterXpath( "//link[@rel='prev']" )->extract(array('href')); 
        $this->assertEquals( $link, $prev[0] );                     
        
        $next = $crawler->filterXpath( "//link[@rel='next']" )->extract(array('href'));  
        $this->assertEquals( $link.'?page=3', $next[0] );      
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.$link, $canonical[0] );    
    }
        
    private function testPage3( $crawler, $link ) {
        $client = static::createClient();
        $crawler = $client->request('GET', $this->hostTest.$link.'?page=3');
        
        $prev = $crawler->filterXpath( "//link[@rel='prev']" )->extract(array('href')); 
        $this->assertEquals( $link.'?page=2', $prev[0] );                     
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.$link, $canonical[0] );    
    }
    
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first