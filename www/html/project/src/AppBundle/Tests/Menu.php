<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Menu extends WebTestCase
{
    public function __construct( $hostTest ) {
        $this->hostTest = $hostTest;
    }
    
    public function testMenu( $route, $crawler  ) {
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
            case 'productListAbbigliamentoVestitiCortiDonna':
                $this->testProductListAbbigliamentoDonna( $crawler );
            break;
            case 'productsListSearchTermsTypology':
            case 'productsListSearchTermsSubcategory':
                $this->productsListSearchTerms( $crawler );
            break;
        }
    }
    
    /**
     * Testa la breadcrumbs per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testHomePage( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );        
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );
    }
    
    /**
     * Testa la breadcrumbs per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testAllCategoriesProduct( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );  
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );
    }
    
    /**
     * Testa la breadcrumbs per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testCategoryProduct( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );  
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );
    }
    
    /**
     * Testa la breadcrumbs per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testSubcategoryModelProduct( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );  
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );
    }
    
    /**
     * Testa la breadcrumbs per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testTypologyModelProduct( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );        
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );
    }
    
    /**
     * Testa la breadcrumbs per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testDetailModel( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );    
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );        
    }
    
    /**
     * Testa la breadcrumbs per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testListModelsTrademark( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );    
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );        
    }
    
    /**
     * Testa la breadcrumbs per la sezione tutte le categorie
     * @param type $crawler
     */
    public function testProductListAbbigliamentoDonna( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );    
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );        
    }
    
    /**
     * Testa la breadcrumbs per la sezione search terms della tipologia
     * @param type $crawler
     */
    public function productsListSearchTerms( $crawler ) {           
        //Verifica che non sia presente il menu
        $menu =  $crawler->filterXPath('//html/body/header/nav/ul' )->count();
        $this->assertGreaterThan( 0, $menu );    
        
        //Verifica che non sia presente bottone categorie sulla destra
        $buttonCategory =  $crawler->filterXPath('//html/body/header//div[@class="widget_ButtonCategory"]' )->count();
        $this->assertEquals( 1, $buttonCategory );        
    }
    
}

//https://symfony.com/doc/3.4/testing.html
//http://api.symfony.com/3.4/Symfony/Component/DomCrawler/Crawler.html#method_first