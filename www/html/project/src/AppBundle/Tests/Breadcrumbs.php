<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Breadcrumbs extends WebTestCase {
    
    public function __construct( $hostTest ) {
        $this->hostTest = $hostTest;
    }
    
    public function testBreadcrumbs( $route, $crawler ) {
        switch( $route ) {
            case 'allCategoriesProduct':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testAllCategoriesProduct( $crawler );
            break;
            case 'homePage':
                $this->testGlobalBreadcrumbs( $crawler );
            break;
            case 'categoryProduct':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testCategoryProduct( $crawler );
            break;
            case 'subcategoryModelProduct':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testSubcategoryModelProduct( $crawler );
            break;
            case 'typologyModelProduct':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testTypologyModelProduct( $crawler );
            break;
            case 'detailModel':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testDetailModel( $crawler );
            break;
            case 'listModelsTrademark':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testListModelsTrademark( $crawler );
            break;
            case 'productListAbbigliamentoDonna':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testProductListAbbigliamentoDonna( $crawler );
            break;
            case 'productListAbbigliamentoVestitiCortiDonna':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testProductListAbbigliamentoVestitiCortiDonna( $crawler );
            break;
            case 'productsListSearchTermsTypology':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testProductsListSearchTermsTypology( $crawler );
            break;
            case 'productsListSearchTermsSubcategory':
                $this->testGlobalBreadcrumbs( $crawler );
                $this->testProductsListSearchTermsSubcategory( $crawler );
            break;
        }
    }
    
    //Testa i dati della testGlobalBreadcrumbs generali su tutto il sito
    public function testGlobalBreadcrumbs( $crawler ) {             

        //Verifica che i microdati in json del web site siano corretti
        $jsonWebSite = array(
            '@context' => 'http://schema.org',
            '@type' => 'WebSite',
            'name' => 'offerteprezzi.it',
            'alternateName' => 'offerteprezzi.it',
            'url' => $this->hostTest
        );
        $jsonDataWebSite = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(0)->nodeValue, true );
        $this->assertEquals( $jsonWebSite, $jsonDataWebSite );                
        
        //verifica che i microdati in json dell'organizzazione siano corretti
        $jsonOrganization = array(
            "@context" => "http://schema.org",
            "@type" => "Organization",
            "url" => $this->hostTest,
            "logo" => $this->hostTest."/icon/apple-icon-120x120.png"
        );
        $jsonDataOrganization = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(1)->nodeValue, true );
        $this->assertEquals( $jsonOrganization, $jsonDataOrganization );                
        
        //Verifica che i microdati in json del person siano corretti
        $jsonPerson = array(
            '@context' => 'http://schema.org',
            '@type' => 'Person',
            'name' => 'OffertePrezzi',            
            'url' => $this->hostTest,
            'sameAs' => array(
                0 => 'https://www.facebook.com/Offerprezzi.it',
                1 => 'https://twitter.com/Offerteprezzi.it',
                2 => 'https://plus.google.com/+offerteprezzi.it?hl=it'
            )
        );
        $jsonDataPerson = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(2)->nodeValue, true );
        $this->assertEquals( $jsonPerson, $jsonDataPerson );
    }
    
    //Testa i dati della testGlobalBreadcrumbs specifici della sezione
    public function testAllCategoriesProduct( $crawler ) {        
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0 => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/tutte_le_categorie',
                        'name' => 'Tutte le categorie'
                    )
                )
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );
       
    }
    
    //Testa i dati della pagina di categoria specifici della sezione es: http://trunk-offerteprezzi.it/prezzi_informatica
    public function testCategoryProduct( $crawler ) {
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0 => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_telefonia',
                        'name' => 'Telefonia'
                    )
                )
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
    }
    
    //Testa i dati della pagina di categoria specifici della sezione es: http://trunk-offerteprezzi.it/prezzi_cellulari
    public function testSubcategoryModelProduct( $crawler ) {
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0  => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_telefonia',
                        'name' => 'Telefonia'
                    )
                ),
                1 => array(                        
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_cellulari',
                        'name' => 'Smartphone e Cellulari'
                    )
                )
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
    }
    
    //Testa i dati della pagina di categoria specifici della sezione es: http://trunk-offerteprezzi.it/prezzi_notebook
    public function testTypologyModelProduct( $crawler ) {
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0  => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_informatica',
                        'name' => 'Informatica'
                    )
                ),
                1 => array(                        
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_notebook',
                        'name' => 'Notebook'
                    )
                )
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
    }
    
    //Testa i dati della pagina di categoria specifici della sezione es: http://trunk-offerteprezzi.it/prezzi_notebook
    public function testDetailModel( $crawler ) {
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0  => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_telefonia',
                        'name' => 'Telefonia'
                    )
                ),
                1 => array(                        
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_cellulari',
                        'name' => 'Smartphone e Cellulari'
                    )
                ),
                2 => array(                        
                    '@type' => 'ListItem',
                    'position' => 3,
                    'item' => array(
                        '@id' => $this->hostTest.'/cellulari_apple_iphone_x_256gb_prezzo',
                        'name' => 'Apple iPhone X 256GB'
                    )
                )
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );        
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
                
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(4)->nodeValue, true );                
        
        $this->assertEquals( 'http://schema.org', $jsonDataBreadcrumbs['@context'] );      
        $this->assertEquals( 'Product', $jsonDataBreadcrumbs['@type'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['name'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['image'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['description'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['brand']['@type'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['brand']['name'] );      
        $this->assertEquals( 'AggregateOffer', $jsonDataBreadcrumbs['offers']['@type'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['offers']['lowPrice'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['offers']['highPrice'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['offers']['priceCurrency'] );      
        $this->assertNotEmpty( $jsonDataBreadcrumbs['offers']['availability'] );      
        
    }
    
    //Testa i dati della pagina di categoria specifici della sezione es: http://trunk-offerteprezzi.it/prezzi_notebook
    public function testListModelsTrademark( $crawler ) {
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0  => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_telefonia',
                        'name' => 'Telefonia'
                    )
                ),
                1 => array(                        
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_cellulari',
                        'name' => 'Smartphone e Cellulari'
                    )
                ),
                2 => array(                        
                    '@type' => 'ListItem',
                    'position' => 3,
                    'item' => array(
                        '@id' => $this->hostTest.'/offerte_prezzi-cellulari-huawei',
                        'name' => 'Huawei'
                    )
                )
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );        
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
    }
    
    //Testa i dati della pagina di categoria specifici della sezione es: http://trunk-offerteprezzi.it/prezzi_notebook
    public function testProductListAbbigliamentoDonna( $crawler ) {
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0 => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_abbigliamento_moda',
                        'name' => 'Abbigliamento e Moda'
                    )
                ),
                1 => array(                        
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => $this->hostTest.'/vestiti-donna',
                        'name' => 'Vestiti / Donna'
                    )
                )                
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );        
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
    }
    
    //Testa i dati della pagina di categoria specifici della sezione es: http://trunk-offerteprezzi.it/prezzi_notebook
    public function testProductListAbbigliamentoVestitiCortiDonna( $crawler ) {
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0  => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_abbigliamento_moda',
                        'name' => 'Abbigliamento e Moda'
                    )
                ),
                1 => array(                        
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => $this->hostTest.'/vestiti-donna',
                        'name' => 'Vestiti / Donna'
                    )                
                ),
                2 => array(                        
                    '@type' => 'ListItem',
                    'position' => 3,
                    'item' => array(
                        '@id' => $this->hostTest.'/vestiti-in_jeans-donna',
                        'name' => 'In Jeans'
                    )
                )                
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );        
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
    }
    
    //Testa i dati della search terms della tipologie es: http://trunk-offerteprezzi.it/cover_per_cellulari-cover-iphone
    public function testProductsListSearchTermsTypology( $crawler ) {        
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0 => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_telefonia',
                        'name' => 'Telefonia'
                    )
                ),
                1 => array(                        
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => $this->hostTest.'/cover_per_cellulari-cover',
                        'name' => 'Cover'
                    )                
                ),
                2 => array(                        
                    '@type' => 'ListItem',
                    'position' => 3,
                    'item' => array(
                        '@id' => $this->hostTest.'/cover_per_cellulari-cover-iphone',
                        'name' => 'Iphone'
                    )
                )                
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );                
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
    }
    
    //Testa i dati della search terms della tipologie es: http://trunk-offerteprezzi.it/cover_per_cellulari-samsung
    public function testProductsListSearchTermsSubcategory( $crawler ) {        
        $jsonBreadcrumbs = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                0 => array(                        
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => $this->hostTest.'/prezzi_telefonia',
                        'name' => 'Telefonia'
                    )
                ),
                1 => array(                        
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => $this->hostTest.'/telefonia-cover_per_cellulari-samsung',
                        'name' => 'Cover per cellulari samsung'
                    )                
                )                        
            )
        );
        $jsonDataBreadcrumbs = json_decode( $crawler->filterXPath('//script[@type="application/ld+json"]')->getNode(3)->nodeValue, true );                
        $this->assertEquals( $jsonBreadcrumbs, $jsonDataBreadcrumbs );               
    }
    
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first