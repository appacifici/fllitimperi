<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\Breadcrumbs;
use AppBundle\Tests\Menu;
use AppBundle\Tests\Seo;

class ModelsListProductControllerTest extends WebTestCase {
    
    public function testSubcategoryModelProduct() {
        $client = static::createClient();

        $crawler = $client->request('GET', 'http://trunk-offerteprezzi.it/prezzi_cellulari');
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo();
        $utilitySeo->testSeo( 'subcategoryModelProduct', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu();
        $utilityMenu->testMenu( 'subcategoryModelProduct', $crawler );         
//        
//        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs();
        $utilityBeadcrumbs->testBreadcrumbs( 'subcategoryModelProduct', $crawler );         
//        
//        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/section/h1');        
        $this->assertEquals( 'Modelli delle migliori Marche di Cellulari', trim( $resp->getNode(0)->nodeValue ) );
//        
//         //Verifica se ci sono tutte le sezione dei bestseller in home
        $categories =  $crawler->filterXPath('//html/body/main/section/div/section')->count();
        $this->assertGreaterThan( 3, $categories );                                               
//        
//       //Controlla che sia presente almeno un modello nel sotto menu delle sottocategoria 
        $doc = new \DOMDocument();        
        libxml_use_internal_errors( true );
        libxml_clear_errors();
        $xpath = new \DOMXpath( $doc );
        $elements =  $crawler->filterXPath('//html/body/main/section/div/section[not(@class="otherModelsList")]' )->each( function ( $node, $i ) {
            $node->each( function ( $node2, $i ) {
                $tot = $node2->filterXPath('//div/a/h3')->count();
                $this->assertGreaterThan( 0, $tot );
                
                $tot2 = $node2->filterXPath('//nav/ul/li')->count();
                $this->assertGreaterThan( 0, $tot2 );
                
                //Verifica che non sia linkata la sottocategoria in questa sezione
                $this->assertEquals( 0, $node2->filterXPath('//h2/a')->count() );                
            });
        });
        
        $elements =  $crawler->filterXPath('//html/body/main/section/div/section[@class="otherModelsList"]' )->each( function ( $node, $i ) {
            $node->each( function ( $node2, $i ) {
                $tot = $node2->filterXPath('//nav/ul/li')->count();
                //Verifica che non sia stampati i modelli in altri marchi
                $this->assertEquals( 0, $tot );
                
                //Verifica che  sia linkato il marchio
                $this->assertGreaterThan( 0, $node2->filterXPath('//h3/a')->count() );                
            });
        });
    }
    
    
    public function testTypologyModelProduct() {
        $client = static::createClient();

        $crawler = $client->request('GET', 'http://trunk-offerteprezzi.it/prezzi_notebook');
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo();
        $utilitySeo->testSeo( 'typologyModelProduct', $crawler );         
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu();
        $utilityMenu->testMenu( 'typologyModelProduct', $crawler );         
//        
//        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs();
        $utilityBeadcrumbs->testBreadcrumbs( 'typologyModelProduct', $crawler );         
//        
//        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/section/h1');        
        $this->assertEquals( 'Modelli delle migliori Marche di Notebook', trim( $resp->getNode(0)->nodeValue ) );
//        
//         //Verifica se ci sono tutte le sezione dei bestseller in home
        $categories =  $crawler->filterXPath('//html/body/main/section/div/section')->count();
        $this->assertGreaterThan( 3, $categories );                                               
//        
//       //Controlla che sia presente almeno un modello nel sotto menu delle sottocategoria 
        $doc = new \DOMDocument();        
        libxml_use_internal_errors( true );
        libxml_clear_errors();
        $xpath = new \DOMXpath( $doc );
        $elements =  $crawler->filterXPath('//html/body/main/section/div/section[not(@class="otherModelsList")]' )->each( function ( $node, $i ) {
            $node->each( function ( $node2, $i ) {
                $tot = $node2->filterXPath('//div/a/h3')->count();
                $this->assertGreaterThan( 0, $tot );
                
                $tot2 = $node2->filterXPath('//nav/ul/li')->count();
                $this->assertGreaterThan( 0, $tot2 );
                
                //Verifica che non sia linkata la sottocategoria in questa sezione
                $this->assertEquals( 0, $node2->filterXPath('//h2/a')->count() );                
            });
        });
        
        $elements =  $crawler->filterXPath('//html/body/main/section/div/section[@class="otherModelsList"]' )->each( function ( $node, $i ) {
            $node->each( function ( $node2, $i ) {
                $tot = $node2->filterXPath('//nav/ul/li')->count();
                //Verifica che non sia stampati i modelli in altri marchi
                $this->assertEquals( 0, $tot );
                
                //Verifica che  sia linkato il marchio
                $this->assertGreaterThan( 0, $node2->filterXPath('//h3/a')->count() );                
            });
        });
    }
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first