<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\W3cValidator;
use AppBundle\Tests\Breadcrumbs;
use AppBundle\Tests\Pagination;
use AppBundle\Tests\Image;
use AppBundle\Tests\Menu;
use AppBundle\Tests\Seo;

class ProductsListControllerTest extends WebTestCase {
    
    //Testa la sezione abbigliamento vestiti donna
    public function testProductsListAbbigliamentoVestitiDonna() {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');

        $crawler = $client->request('GET', $this->hostTest.'/vestiti-donna');
        $this->productsListItem( $crawler );
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h1');        
        $this->assertEquals( 'Offerte Vestiti Donna', trim( $resp->getNode(0)->nodeValue ) );
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'productListAbbigliamentoDonna', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'productListAbbigliamentoDonna', $crawler );         
     
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'productListAbbigliamentoDonna', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'productListAbbigliamentoDonna', $crawler, '/vestiti-donna' );   
        
        $this->globalTestAbbigliamento( $crawler );
        
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/vestiti-donna' );           
    }

    
    //Testa la sezione abbigliamento donna generica
    public function testProductsListAbbigliamentoVestitiCortiDonna() {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');

        $crawler = $client->request('GET', $this->hostTest.'/vestiti-in_jeans-donna');
        $this->productsListItem( $crawler );
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h1');        
        $this->assertEquals( 'Offerte In Jeans Donna', trim( $resp->getNode(0)->nodeValue ) );
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'productListAbbigliamentoVestitiCortiDonna', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'productListAbbigliamentoVestitiCortiDonna', $crawler );         
     
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'productListAbbigliamentoVestitiCortiDonna', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'productListAbbigliamentoVestitiCortiDonna', $crawler, '/vestiti-in_jeans-donna' );
        
        $this->globalTestAbbigliamento( $crawler );
        
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/vestiti-corti-donna' );           
    }
    
    //Testa la sezione abbigliamento donna generica
    public function testProductsListAbbigliamentoVestitiCortiDonnaFilters() {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');

        $crawler = $client->request('GET', $this->hostTest.'/vestiti-in_jeans-donna?sizes[]=L&colors[]=blu&minPrice=10&maxPrice=90&');
        $this->productsListItem( $crawler );
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h1');        
        $this->assertEquals( 'Offerte In Jeans Donna', trim( $resp->getNode(0)->nodeValue ) );
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'productListAbbigliamentoVestitiCortiDonna', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'productListAbbigliamentoVestitiCortiDonna', $crawler );         
     
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'productListAbbigliamentoVestitiCortiDonna', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
//        $testPagination = new Pagination( $this->hostTest );
//        $testPagination->testPagination( 'productListAbbigliamentoVestitiCortiDonna', $crawler, '/vestiti-corti-donna' );   
        
//        $this->globalTestAbbigliamento( $crawler );
        
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/vestiti-corti-donna?minPrice=90&maxPrice=200&' );    
    }
    
    //Testa la sezione abbigliamento donna generica
    public function testProductsListSearchTermsSubcategory() {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');

        $crawler = $client->request('GET', $this->hostTest.'/telefonia-cover_per_cellulari-samsung');
        $this->productsListItem( $crawler );
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h1');        
        $this->assertEquals( 'Offerte Cover Per Cellulari Samsung', trim( $resp->getNode(0)->nodeValue ) );
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'productsListSearchTermsSubcategory', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'productsListSearchTermsSubcategory', $crawler );         
     
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'productsListSearchTermsSubcategory', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'productsListSearchTermsSubcategory', $crawler, '/telefonia-cover_per_cellulari-samsung' );   
                
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/telefonia-cover_per_cellulari-samsung' );    
    }
        
    //Testa la sezione abbigliamento donna generica
    public function testProductsListSearchTermsTypology() {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');

        $crawler = $client->request('GET', $this->hostTest.'/cover_per_cellulari-cover-iphone');
        $this->productsListItem( $crawler, false );
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h1');        
        $this->assertEquals( 'Offerte Cover Iphone', trim( $resp->getNode(0)->nodeValue ) );
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'productsListSearchTermsTypology', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'productsListSearchTermsTypology', $crawler );         
     
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'productsListSearchTermsTypology', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'productsListSearchTermsTypology', $crawler, '/cover_per_cellulari-cover-iphone' );   
                
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/cover_per_cellulari-cover-iphone' );    
    }
        
    //Testa la sezione abbigliamento donna generica
    public function testProductsListSearchCategoryUser() {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');
        
        $freeSearchPath = $client->getKernel()->getContainer()->getParameter('app.freeSearchPath');
        
        $crawler = $client->request('GET', $this->hostTest.'/'.$freeSearchPath.'-telefonia-iphone_7');
        $this->productsListItem( $crawler, false );
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h1');        
        $this->assertEquals( 'Offerte Telefonia Iphone 7', trim( $resp->getNode(0)->nodeValue ) );
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'productsListSearchCategoryUser', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'productsListSearchCategoryUser', $crawler );         
     
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'productsListSearchCategoryUser', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'productsListSearchCategoryUser', $crawler, '/'.$freeSearchPath.'-telefonia-iphone_7' );   
                
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/'.$freeSearchPath.'-telefonia-iphone_7' );    
    }
    
    //testa le parti della pagina della list product comuni a tutte le sezioni
    private function globalTest( $crawler, $checkTypologies = true ) {
        
        //testa se tutte le immagini sono inserite correttamente
        $utilityImage = new Image( $this->hostTest );
        $utilityImage->testImages( 'productListAbbigliamentoVestitiCortiDonna', $crawler );    
        
        $resp =  $crawler->filterXPath('//html/body/main//div[@class="boxOrderProductList"]/h2');        
        $this->assertEquals( 'Elenco Prodotti', trim( $resp->getNode(0)->nodeValue ) );
        
        $select =  $crawler->filterXPath('//html/body/main//div[@class="boxOrderProductList"]/select');        
        $this->assertNotEmpty( $select );
        
        $select =  $crawler->filterXPath('//html/body/main//div[@class="widget_SearchFilterProduct"]');        
        $this->assertNotEmpty( $select );
        
        $h2 =  $crawler->filterXPath('//html/body/main//div[@class="widget_SearchFilterProduct"]/h2');        
        $this->assertNotEmpty( $h2 );
        
        $inputPrices =  $crawler->filterXPath('//html/body/main//div[@class="searchPrice"]/input')->count();
        $this->assertEquals( 2, $inputPrices );
        
        if( $checkTypologies ) {
            $tipologies =  $crawler->filterXPath('//html/body/main//ul[@class="boxTypologies"]/li')->count();
            $this->assertGreaterThan( 0, $tipologies );
        }
        
        
    }
    
    //testa le parti della pagina della list product comuni a tutte le sezioni di abbigliamento
    private function globalTestAbbigliamento( $crawler ) {
        $sizes =  $crawler->filterXPath('//html/body/main//ul[@class="boxSizes filtersSizes"]/li')->count();
        $this->assertGreaterThan( 1, $sizes );
        
        $colors =  $crawler->filterXPath('//html/body/main//ul[@class="boxColor"]/li')->count();
        $this->assertGreaterThan( 1, $colors );
        
        $filterSex =  $crawler->filterXPath('//html/body/main//div[@class="sex filterSex"]');        
        $this->assertNotEmpty( $filterSex );
    }        
    
    /**
     * Testa i dati della sezione abbigliamento
     * @param type $crawler
     */
    private function productsListItem( $crawler, $checkTypologies = true ) {                                              
        
        //Verifica se il titolo della home è corretto
        $products =  $crawler->filterXPath('//html/body/main/section//article')->count();        
        $this->assertGreaterThan( 0, $products );
        
        $products =  $crawler->filterXPath('//html/body/main/section//article')->each( function ( $node, $i ) {
            $href = $node->filterXPath( '//header/a')->attr( 'href' );
            $this->assertNotEmpty( $href );     
            
            $hrefRel = $node->filterXPath( '//header/a')->attr( 'rel' );
            $this->assertEquals( 'nofollow', trim( $hrefRel ) );
            
            $h2 = $node->filterXPath( '//header/a/h3');
            $this->assertNotEmpty( $h2->getNode(0)->nodeValue );
            
            $price = $node->filterXPath( '//span[@class="totalPrice"]');
            $this->assertNotEmpty( $price->getNode(0)->nodeValue );
        });
        
        $this->globalTest( $crawler, $checkTypologies );        
    }
    
   
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first