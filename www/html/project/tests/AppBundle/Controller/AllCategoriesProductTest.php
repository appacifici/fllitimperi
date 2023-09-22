<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\W3cValidator;
use AppBundle\Tests\Breadcrumbs;
use AppBundle\Tests\Pagination;
use AppBundle\Tests\Image;
use AppBundle\Tests\Menu;
use AppBundle\Tests\Seo;

class AllCategoriesProductControllerTest extends WebTestCase
{
    public function testAllCategories()
    {
        echo 'si';
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');
//        echo $this->hostTest.'/tutte_le_categorie';
        $crawler = $client->request('GET', $this->hostTest.'/tutte_le_categorie');
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'allCategoriesProduct', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'allCategoriesProduct', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs( $this->hostTest );
        $utilityBeadcrumbs->testBreadcrumbs( 'allCategoriesProduct', $crawler );        
        
        //testa la paginazione per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'allCategoriesProduct', $crawler, '/tutte_le_categorie' );   
        
        //testa se tutte le immagini sono inserite correttamente
        $utilityImage = new Image( $this->hostTest );
        $utilityImage->testImages( 'allCategoriesProduct', $crawler ); 
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h1');        
        $this->assertEquals( 'Sitemap Categorie', $resp->getNode(0)->nodeValue );
        
        //Verifica se ci sono tutte le sezione dei bestseller in home
        $categories =  $crawler->filterXPath('//html/body/main/div/section')->count();
//        $this->assertEquals( 16, $categories );                                                
        
        //Controlla che sia presente almeno un elemento nel sotto menu delle categorie
        $doc = new \DOMDocument();        
        libxml_use_internal_errors( true );
        libxml_clear_errors();
        $xpath = new \DOMXpath( $doc );
        $elements =  $crawler->filterXPath('//html/body/main/div/section' )->each(function ($node, $i) {
            $node->each(function ($node2, $i) {
                $tot = $node2->filterXPath('//nav/ul/li')->count();
                $this->assertGreaterThan( 0, $tot );
            });
        });
        
        //testa la paginazione per la sezione specificata
        $w3cValidator = new W3cValidator( $this->hostTest );
        $w3cValidator->testValidationPage( $this->hostTest.'/tutte_le_categorie' );   
        
    }        
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first