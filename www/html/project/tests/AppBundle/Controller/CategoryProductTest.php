<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\W3cValidator;
use AppBundle\Tests\Breadcrumbs;
use AppBundle\Tests\Pagination;
use AppBundle\Tests\Image;
use AppBundle\Tests\Menu;
use AppBundle\Tests\Seo;

class CategoryProductControllerTest extends WebTestCase {
    
    public function testCategoryProduct() {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');
        
        $crawler = $client->request('GET', $this->hostTest.'/prezzi_telefonia');
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'categoryProduct', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'categoryProduct', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'categoryProduct', $crawler );         
        
        //testa la paginazione per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'allCategoriesProduct', $crawler, '/prezzi_telefonia' );   
        
        //testa se tutte le immagini sono inserite correttamente
        $utilityImage = new Image( $this->hostTest );
        $utilityImage->testImages( 'categoryProduct', $crawler ); 
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/section/h1');        
        $this->assertEquals( 'Telefonia', trim( $resp->getNode(0)->nodeValue ) );
        
         //Verifica se ci sono tutte le sezione dei bestseller in home
        $categories =  $crawler->filterXPath('//html/body/main/section/div/section')->count();
        $this->assertGreaterThan( 3, $categories );                                               
        
        //Controlla che sia presente almeno un elemento nel sotto menu delle categorie in caso contrario che sia lincata la sottocategoria
        $doc = new \DOMDocument();        
        libxml_use_internal_errors( true );
        libxml_clear_errors();
        $xpath = new \DOMXpath( $doc );
        $elements =  $crawler->filterXPath('//html/body/main/section/div/section' )->each( function ( $node, $i ) {
            $node->each( function ( $node2, $i ) {
                $tot = $node2->filterXPath('//nav/ul/li')->count();
                if( $tot != 0 ) {
                    //Se ha le tipologia verifica che non sia lincata la sottocategoria
                    $this->assertEquals( 0, $node2->filterXPath('//h2/a')->count() );
                } else {
                    //Se non ha le tipologie verifica che sia lincata la sottocategoria
                    $tot = $node2->filterXPath('//a')->count();
                    $this->assertGreaterThan( 0, $tot );
                }
            });
        });
        
        
        echo $this->hostTest.'/prezzi_telefonia';
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/prezzi_telefonia' );   
    }
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first