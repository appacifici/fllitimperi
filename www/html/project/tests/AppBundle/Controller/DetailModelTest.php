<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\W3cValidator;
use AppBundle\Tests\Breadcrumbs;
use AppBundle\Tests\Pagination;
use AppBundle\Tests\Image;
use AppBundle\Tests\Menu;
use AppBundle\Tests\Seo;

class DetailModelControllerTest extends WebTestCase {
    
    public function testDetailModelProduct() {        
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');
        
        $crawler = $client->request('GET', $this->hostTest.'/cellulari_apple_iphone_x_256gb_prezzo');
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'detailModel', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'detailModel', $crawler );         
  
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'detailModel', $crawler );         
                
        //testa la paginazione per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'detailModel', $crawler, '/cellulari_apple_iphone_x_256gb_prezzo' );   
        
        //testa se tutte le immagini sono inserite correttamente
        $utilityImage = new Image( $this->hostTest );
        $utilityImage->testImages( 'detailModel', $crawler ); 
        
        //Verifica se il titolo del modello è corretto
        $resp =  $crawler->filterXPath('//html/body/main/article/div/div/div[1]/header/h1/strong');        
        $this->assertEquals( 'Prezzo Apple iPhone X 256GB Smartphone', trim( $resp->getNode(0)->nodeValue ) );
  
        //Verifica se la description ci sia
        $desc =  $crawler->filterXPath('//html/body/main/article/div/div/div[1]/header/h2')->count();
        $this->assertGreaterThan( 0, $desc );                                               
        
        $boxPrice =  $crawler->filterXPath('//html/body/main/article//table[@class="boxPrice"]')->count();
        $this->assertGreaterThan( 0, $boxPrice );                                               
        
        $btnViewOffered =  $crawler->filterXPath('//html/body/main/article//div[@class="btnViewOffered"]')->count();
        $this->assertGreaterThan( 0, $btnViewOffered );                                               
        
        $btnViewOfferedLgt =  $crawler->filterXPath('//html/body/main/article//div[@class="btnViewOffered"]')->attr( 'data-lgt' );
        $this->assertNotEmpty( $btnViewOfferedLgt );     

        $imgAffiliation =  $crawler->filterXPath('//html/body/main/article//div[@class="boxTable"]//img')->count();
        $this->assertGreaterThan( 0, $imgAffiliation );                                               

        $boxPayments =  $crawler->filterXPath('//html/body/main/article//div[@class="boxTable"]//div[@class="boxPayments"]')->count();
        $this->assertGreaterThan( 0, $boxPayments );                                               

//        $contacts =  $crawler->filterXPath('//html/body/main/article//div[@class="boxTable"]//div[@class="contacts"]')->count();
//        $this->assertGreaterThan( 0, $contacts );                                               

        $sectionh2 =  $crawler->filterXPath('//html/body/main/article//section[@class="widget_DetailComparisonProduct"]/h2')->getNode(0)->nodeValue;
        $this->assertEquals( 'Comparazione Prezzi', $sectionh2 );                                               

        $otherProductsArticle =  $crawler->filterXPath('//html/body/main/article//section[@class="widget_DetailComparisonProduct"]/article')->count();
        $this->assertGreaterThan( 0, $otherProductsArticle );                                               

        $otherProductsArticles =  $crawler->filterXPath('//html/body/main/article//section[@class="widget_DetailComparisonProduct"]/article')->each(function ($node, $i) {
            $node->each(function ($node2, $i) {
                $this->assertNotEmpty( $node2->filterXPath('//h3')->getNode(0)->nodeValue );
//                $this->assertNotEmpty( $node2->filterXPath('//h4')->getNode(0)->nodeValue );
                $this->assertGreaterThan( 0, $node2->filterXPath('//img')->count() );
                $this->assertNotEmpty( $node2->filterXPath('//div[@class="totalPrice"]')->getNode(0)->nodeValue );
                $this->assertNotEmpty( $node2->filterXPath('//div[@class="contacts"]')->getNode(0)->nodeValue );
                $this->assertNotEmpty( $node2->filterXPath('//div[@class="btnViewOtherOffered"]')->attr( 'data-lgt' ) );
                $this->assertGreaterThan( 0, $node2->filterXPath('//div[@class="boxPayments"]')->count() );
            });
        });   
        $productDescriptionH2 =  $crawler->filterXPath('//html/body/main/article/section[@class="widget_ProductDescription"]/h2')->count();
        $this->assertGreaterThan( 0, $productDescriptionH2 ); 
        
        $productDescriptionH3 =  $crawler->filterXPath('//html/body/main/article/section[@class="widget_ProductDescription"]//h3')->count();
        $this->assertGreaterThan( 0, $productDescriptionH3 ); 
        
//        $extraProduct =  $crawler->filterXPath('//html/body/main/article/section[@class="widget_ProductDescription"]//div[@class="extraProduct"]')->count();
//        $this->assertGreaterThan( 0, $extraProduct ); 
//        
        $videoProduct =  $crawler->filterXPath('//html/body/main/article/section[@class="widget_ProductDescription"]//div[@class="videoProduct"]')->count();
        $this->assertGreaterThan( 0, $videoProduct ); 
        
        $aside =  $crawler->filterXPath('//html/body/main/article/section[@class="widget_ProductDescription"]//div[@class="technicalSpecifications"]')->count();
        $this->assertGreaterThan( 0, $aside ); 
        
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/cellulari_apple_iphone_x_256gb_prezzo' );   
        
    }
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first
//https://phpunit.de/manual/6.5/en/appendixes.assertions.html#appendixes.assertions.assertEmpty