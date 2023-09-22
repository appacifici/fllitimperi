<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Seo extends WebTestCase 
{   
    public function __construct( $hostTest ) {
        $this->hostTest = $hostTest;
    }
    
    public function testSeo( $route, $crawler  ) {
        $this->testGlobal( $crawler );
        switch( $route ) {
            case 'homePage':
                $this->testHomePage( $crawler );
            break;
            case 'allCategoriesProduct':
                $this->testAllCategoriesProduct( $crawler );
            break;
            case 'categoryProduct':
                $this->testCategoryProduct( $crawler );
            break;
            case 'subcategoryModelProduct':
                $this->testSubcategoryModelProduct( $crawler );
            break;
            case 'typologyModelProduct':
                $this->testTypologyModelProduct( $crawler );
            break;
            case 'detailModel':
                $this->testDetailModel( $crawler );
            break;
            case 'listModelsTrademark':
                $this->testListModelsTrademark( $crawler );
            break;
            case 'productListAbbigliamentoDonna':
                $this->productListAbbigliamentoDonna( $crawler );
            break;
            case 'productListAbbigliamentoVestitiCortiDonna':
                $this->productListAbbigliamentoVestitiCortiDonna( $crawler );
            break;
            case 'productsListSearchTermsTypology':
                $this->productsListSearchTermsTypology( $crawler );
            break;
            case 'productsListSearchTermsSubcategory':
                $this->productsListSearchTermsSubcategory( $crawler );
            break;
            case 'productsListSearchCategoryUser':
                $this->productsListSearchCategoryUser( $crawler );
            break;
        }
    }
    
    //effettua i test da eseguire su tutte le pagine
    public function testGlobal( $crawler ) {
        //verifica le info del robotx.txt        
//        $robots = $crawler->filterXpath( "//meta[@name='robots']" )->extract(array('content'));  
//        $this->assertEquals( 'noindex', $robots[0] );
        
        //verifica le info del robotx.txt
        $charset = $crawler->filterXpath( "//meta[@charset]" )->extract(array('charset'));
        $this->assertEquals( 'UTF-8', $charset[0] ); 
        
        //verifica le info del robotx.txt
        $manifest = $crawler->filterXpath( "//link[@rel='manifest']" )->extract(array('href'));
        $this->assertEquals( '/manifest.json', $manifest[0] ); 
        
        //verifica le info del robotx.txt
        $viewport = $crawler->filterXpath( "//meta[@name='viewport']" )->extract(array('content'));
        $this->assertEquals( 'width=device-width, height=device-height', $viewport[0] ); 

//        $robots = file_get_contents( $this->hostTest.'/robots.txt' );
//        $robots = trim( preg_replace("/[\r\n]+/", " ", $robots ) );
//        $this->assertEquals( 'User-agent: * Disallow: /', $robots ); 
    }
    
    /**
     * Testa il seo per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testHomePage( $crawler ) {           
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Il comparatore di offerte per i tuoi acquisti | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );
        
        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( 'Offerte prezzi - Il motore di ricerca per i tuoi acquisti - I migliori prezzi online', trim( $description[0] ) );
        
        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'offerta, offerte, prezzi, prezzo, compara prezzi, miglior prezzo, prezzo più basso, acquisto, acquisti, conveniente, convenienza, risparmia, risparmio, conviene, negozi, negozio, commercio', trim( $keyword[0] ) );
        
        //verifica il canonical
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest, $canonical[0] );
        
    }
    
    /**
     * Testa il seo per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testAllCategoriesProduct( $crawler ) {           
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Confronta prezzi e offerte online - Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( 'Offerte prezzi - Ricerca in tutte le categorie le migliori offerte online', trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'offerta, offerte, prezzi, prezzo, compara prezzi, miglior prezzo, prezzo più basso, acquisto, acquisti, conveniente, convenienza, risparmia, risparmio, conviene, negozi, negozio', trim( $keyword[0] ) );    
        
        //verifica il canonical
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/tutte_le_categorie', $canonical[0] );
    }
    
    /**
     * Testa il seo per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testCategoryProduct( $crawler ) {           
        //Testa il meta title url  http://trunk-offerteprezzi.it/prezzi_telefonia
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'I migliori prezzi e offerte Telefonia | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description http://trunk-offerteprezzi.it/prezzi_telefonia
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( 'Confronta prezzi e offerte Telefonia su Offerteprezzi.it', trim( $description[0] ) );

        //Testa la meta keywords http://trunk-offerteprezzi.it/prezzi_telefonia
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'offerte Telefonia, prezzi Telefonia, promozioni Telefonia', trim( $keyword[0] ) );    
        
        $client = static::createClient();
        $crawler = $client->request('GET', $this->hostTest.'/prezzi_informatica');
        
        //Testa il meta title url  http://trunk-offerteprezzi.it/prezzi_informatica        
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'I migliori prezzi e offerte Informatica | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description http://trunk-offerteprezzi.it/prezzi_informatica
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( 'Confronta prezzi e offerte Informatica su Offerteprezzi.it', trim( $description[0] ) );

        //Testa la meta keywords http://trunk-offerteprezzi.it/prezzi_informatica
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'offerte Informatica, prezzi Informatica, promozioni Informatica', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/prezzi_informatica', $canonical[0] );
    }
        
    /**
     * Testa il seo per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testSubcategoryModelProduct( $crawler ) {           
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Smartphone e Cellulari confronta prezzi e offerte', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "Trova il prezzo più basso per Smartphone e Cellulari, cerca l'offerta migliore ricercando tra tutti i modelli di Smartphone e Cellulari online", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'offerte Smartphone e Cellulari, prezzi Smartphone e Cellulari, promozioni Smartphone e Cellulari', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/prezzi_cellulari', $canonical[0] );
    }
        
    /**
     * Testa il seo per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testTypologyModelProduct( $crawler ) {           
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Modelli Notebook confronta prezzi e offerte | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "Trova il prezzo più basso per Notebook, cerca l'offerta migliore ricercando tra tutti i modelli di Notebook online", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'offerte Notebook, prezzi Notebook, promozioni Notebook', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/prezzi_notebook', $canonical[0] );
    }
        
    /**
     * Testa il seo per la sezione per il dettaglio di un modello
     * @param type $crawler
     */
    public function testDetailModel( $crawler ) {           
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Prezzo Apple iPhone X 256GB e Scheda Tecnica | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "Confronta prezzi e dati tecnici di Smartphone Apple iPhone X 256GB, approfitta degli sconti per acquistare al miglior prezzo più basso online", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'offerte apple iphone x 256gb, scheda tecnica apple iphone x 256gb, prezzo apple iphone x 256gb, costo apple iphone x 256gb, promozioni apple iphone x 256gb', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/cellulari_apple_iphone_x_256gb_prezzo', $canonical[0] );
    }
        
    /**
     * Testa il seo per la sezione lista modelli marchio http://trunk-offerteprezzi.it/offerte_prezzi-cellulari-Apple
     * @param type $crawler
     */
    public function testListModelsTrademark( $crawler ) {           
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Smartphone e Cellulari Huawei modelli e prezzi', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "Huawei Smartphone e Cellulari tutti i modelli con schede tecniche, offerte e prezzi", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'offerte Smartphone e Cellulari huawei, prezzi Smartphone e Cellulari huawei, promozioni Smartphone e Cellulari huawei', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/offerte_prezzi-cellulari-huawei', $canonical[0] );
    }
    
    public function productListAbbigliamentoDonna( $crawler ) {
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Vestiti Donna Collezione '.date('Y').' | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "Moda Vestiti ".date('Y').", Scopri le ultime tendenze di stagione per Donna", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
//        $this->assertEquals( 'Collezione '.date('Y').' Vestiti donna, Moda Vestiti Donna, Tendenze '.date('Y').' Vestiti Donna', trim( $keyword[0] ) );    
        $this->assertEquals( 'Moda Vestiti donna '.date('Y').', promozioni Vestiti donna '.date('Y').', Offerte Vestiti donna '.date('Y').', Collezioni Vestiti donna '.date('Y').', Tendenze Vestiti '.date('Y').'', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/vestiti-donna', $canonical[0] );
    }
    
    public function productListAbbigliamentoVestitiCortiDonna( $crawler ) {
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Vestiti In Jeans Donna Collezione '.date('Y').' | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "Moda Donna Vestiti In Jeans ".date('Y').", Scopri le tendenze e le offerte di stagione", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'Collezione '.date('Y').' Vestiti In Jeans donna, Moda Vestiti In Jeans donna, Tendenze '.date('Y').' Vestiti In Jeans donna', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/vestiti-in_jeans-donna', $canonical[0] );
    }
    
    public function productsListSearchTermsTypology( $crawler ) {
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Cover Iphone offerte | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "I migliori prodotti di Cover Iphone ordinati per prezzo piu basso, scopri tutte le offerte", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'Cover Iphone offerte, prezzi Cover Iphone, miglior prezzo Cover Iphone, promozioni Cover Iphone', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/cover_per_cellulari-cover-iphone', $canonical[0] );
    }    
    
    public function productsListSearchTermsSubcategory( $crawler ) {
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        $this->assertEquals( 'Cover per Cellulari Samsung scopri tutte le promozioni | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "Scopri occasioni e offerte di Cover per Cellulari Samsung al prezzo piu basso", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'Cover per Cellulari Samsung prezzi, occasioni Cover per Cellulari Samsung, promozioni Cover per Cellulari Samsung', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/telefonia-cover_per_cellulari-samsung', $canonical[0] );
    }
    
    public function productsListSearchCategoryUser( $crawler ) {
        $client = static::createClient();
        
        $freeSearchPath = $client->getKernel()->getContainer()->getParameter('app.freeSearchPath');
        
        //Testa il meta title
        $title      = $crawler->filterXpath("//title");        
        //PASSA QUI ANCHE PER LA FREE SEARCH
        $this->assertEquals( 'Prezzi telefonia iphone 7 scopri le offerte | Offerteprezzi.it', trim( $title->getNode(0)->nodeValue ) );

        //Testa la meta description
        $description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));        
        $this->assertEquals( "Scopri le occasioni di telefonia iphone 7 al prezzo piu basso su offerteprezzi", trim( $description[0] ) );

        //Testa la meta keywords
        $keyword    = $crawler->filterXpath("//meta[@name='keyword']")->extract(array('content'));        
        $this->assertEquals( 'telefonia iphone 7 prezzi, occasioni telefonia iphone 7, promozioni telefonia iphone 7', trim( $keyword[0] ) );    
        
        $canonical = $crawler->filterXpath( "//link[@rel='canonical']" )->extract(array('href'));  
        $this->assertEquals( $this->hostTest.'/'.$freeSearchPath.'-telefonia-iphone_7', $canonical[0] );
    }
    
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first