<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Image extends WebTestCase
{
    public function __construct( $hostTest ) {
        $this->hostTest = $hostTest;
    }
    
    public function testImages( $route, $crawler  ) {           
        $images =  $crawler->filterXPath('//img' )->count();        
        if( $images == 0 )
            return;
        
        $crawler->filterXPath('//img' )->each( function ( $node, $i ) {
            $this->assertNotEmpty( $node->attr( 'alt' ) );
            $this->assertNotEmpty( $node->attr( 'width' ) );
            $this->assertNotEmpty( $node->attr( 'height' ) );
        });
        
    }
    
    
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first