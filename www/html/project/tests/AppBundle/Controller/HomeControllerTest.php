<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\W3cValidator;
use AppBundle\Tests\Breadcrumbs;
use AppBundle\Tests\Pagination;
use AppBundle\Tests\Image;
use AppBundle\Tests\Menu;
use AppBundle\Tests\Seo;

class PostControllerTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();
        $this->hostTest =  $client->getKernel()->getContainer()->getParameter('app.hostTest');

        $crawler = $client->request('GET', $this->hostTest );
        
        //testa il Seo per la sezione specificata
        $utilitySeo = new Seo( $this->hostTest );
        $utilitySeo->testSeo( 'homePage', $crawler );                  
        
        //testa il Menu per la sezione specificata
        $utilityMenu = new Menu( $this->hostTest );
        $utilityMenu->testMenu( 'homePage', $crawler );         
        
        //testa il Breadcrumbs per la sezione specificata
        $utilityBeadcrumbs = new Breadcrumbs($this->hostTest);
        $utilityBeadcrumbs->testBreadcrumbs( 'homePage', $crawler );   
        
        //testa la paginazione per la sezione specificata
        $testPagination = new Pagination( $this->hostTest );
        $testPagination->testPagination( 'homePage', $crawler, '/' );   
        
        //testa se tutte le immagini sono inserite correttamente
        $utilityImage = new Image( $this->hostTest );
        $utilityImage->testImages( 'homePage', $crawler );         
        
        //Verifica se il titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h1');        
        $this->assertEquals( 'Confronta le offerte e scopri i migliori prezzi online!', $resp->getNode(0)->nodeValue );
        
        //Verifica se il sotto titolo della home è corretto
        $resp =  $crawler->filterXPath('//html/body/main/h2/em');        
        $this->assertEquals( 'Un mondo di infiniti risparmi', $resp->getNode(0)->nodeValue );
        
        //Verifica se ci sono tutte le sezione dei bestseller in home
        $bestsellers =  $crawler->filterXPath('//html/body/main/section/h2[@class="productTitle"]'); 
        $aBest = array( 
            'Bestseller Smartphone e Cellulari',
            'Bestseller Elettrodomestici da Cucina',
            'Bestseller Tablet',
            'Bestseller Orologi Sportivi e Cardiofrequenzimetri',
            'Bestseller Sneakers',  
            'Bestseller Televisori LCD, LED e Plasma'            
        );
        
        $aBestResult = array();
        foreach( $bestsellers as $bestseller ) {
            $aBestResult[] = $bestseller->nodeValue;
        }
        $this->assertEquals( $aBest, $aBestResult );
        
        //Testa la homne page
        $seoText =  $crawler->filterXPath('//html/body/main/section[8]');         
        $text       = "Risparmia con Offerteprezzi.it  Il motore di comparazione Offerteprezzi.it, ti aiuto nella ricerca per il prodotto desiderato al miglior prezzo online.  Ricerca i prodotti che desideri tra i principali fornitori, confronta i prezzi e le caratteristiche, e scegli l'offerta migliore.     Ti promoniamo i prodotti ordinati per prezzo e costo di spedizione, per garantirti un effettivo risparmio, e garantiamo trasparenza su metodi di acquisto e tempi di spedizione.  Approffitta delle promozioni sui: Cellulari, Notebook, Fotocamere Digitali, Attrezzature sportive, Arredamento casa e tutto su abbigliamento e moda.";
        $this->assertEquals( $text, trim( $seoText->getNode(0)->nodeValue) );                 
        
        //Controlla se il numero di articoli sia corretto
        $totArtSection1 =  $crawler->filterXPath('//html/body/main/section[1]/article' )->count();
        $this->assertEquals( 6, $totArtSection1 );
        
        $totArtSection2 =  $crawler->filterXPath('//html/body/main/section[2]/article' )->count();
        $this->assertEquals( 3, $totArtSection2 );
        
        $totArtSection3 =  $crawler->filterXPath('//html/body/main/section[3]/article' )->count();
        $this->assertEquals( 6, $totArtSection3 );
        
        $totArtSection4 =  $crawler->filterXPath('//html/body/main/section[4]/article' )->count();
        $this->assertEquals( 3, $totArtSection4 );
        
        $totArtSection5 =  $crawler->filterXPath('//html/body/main/section[5]/article' )->count();
        $this->assertEquals( 6, $totArtSection5 );
         
        //testa la paginazione per la sezione specificata
//        $w3cValidator = new W3cValidator( $this->hostTest );
//        $w3cValidator->testValidationPage( $this->hostTest );   
    }
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first