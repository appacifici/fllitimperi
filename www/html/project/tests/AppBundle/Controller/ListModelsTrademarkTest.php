<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\W3cValidator;
use AppBundle\Tests\Breadcrumbs;
use AppBundle\Tests\Pagination;
use AppBundle\Tests\Image;
use AppBundle\Tests\Menu;
use AppBundle\Tests\Seo;

class ListModelsTrademark extends WebTestCase {
    
    public function testSubcategoryModelProduct() {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');
        
        $crawler = $client->request('GET', $this->hostTest.'/offerte_prezzi-cellulari-huawei');
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'listModelsTrademark', $crawler );         
        
//        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'listModelsTrademark', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'listModelsTrademark', $crawler );         
        
        //testa se tutte le immagini sono inserite correttamente
        $utilityImage = new Image( $this->hostTest );
        $utilityImage->testImages( 'listModelsTrademark', $crawler );      
        
        //testa il Breadcrumbs per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'listModelsTrademark', $crawler, '/offerte_prezzi-cellulari-huawei' );  
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/section/h1');        
        $this->assertEquals( 'Le offerte di Smartphone e Cellulari Huawei', trim( $resp->getNode(0)->nodeValue ) );
                                         
        
       //Controlla che sia presente almeno un modello nel sotto menu delle sottocategoria 
        $doc = new \DOMDocument();        
        libxml_use_internal_errors( true );
        libxml_clear_errors();
        $xpath = new \DOMXpath( $doc );
        $elements =  $crawler->filterXPath('//html/body/main/section/div/section' )->each( function ( $node, $i ) {
            $node->each( function ( $node2, $i ) {
                $tot = $node2->filterXPath('//h2')->count();
                $this->assertGreaterThan( 0, $tot );
                
                $name = $node2->filterXPath('//h2')->getNode(0)->nodeValue;
                $this->assertEquals( 'Huawei', trim( $name ));
                
                $tot2 = $node2->filterXPath('//nav/ul/li')->count();
                $this->assertGreaterThan( 0, $tot2 );
                
                $link = $node2->filterXPath('//nav/ul/li/a')->attr( 'href' );
                $this->assertNotEmpty( $link );     
            });
        });
        
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/offerte_prezzi-cellulari-huawei' );   
        
    }   
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first