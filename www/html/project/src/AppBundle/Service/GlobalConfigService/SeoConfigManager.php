<?php

namespace AppBundle\Service\GlobalConfigService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Environment as Environment;
use AppBundle\Menu\Menu;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;
use Symfony\Component\HttpFoundation\Session\Session; 

/**
 * @author alessandro pacifici
 */
class SeoConfigManager {
    
    protected $twig;    
    protected $container;    
    protected $requestStack;    
    protected $request;
    protected $versionSite;
    
    
    /**
     * Metodo costruttore della classe che instanzia anche la classe padre
     */
    public function __construct( 
            Environment $twig,
            RequestStack $requestStack,
            Container $container
    ) {
        
        $this->twig             = $twig;
        $this->requestStack     = $requestStack;
        $this->container        = $container;        
        $this->request          = $this->requestStack->getCurrentRequest();  
        $this->versionSite      = 'livescore24';
    }
    
    /**
     * Metodo che avvia il settaggio dei meta 
     * @param type $versionSite
     */
    public function setMetaPage( $versionSite ) {        
        $this->versionSite = $versionSite;
        $matchUri = explode( '?', $this->request->server->get( 'REQUEST_URI' ) );
        $this->route = $this->container->get('router')->match( $matchUri[0] );    
        $this->getMeta();
    }
    
     
    /**
     * Metodo che assegna il valore dei meta
     */
    public function getMeta( $route ) {
        switch( $route ) {
            case 'homepage':
                    default:
                $this->setMetaHomePage();
            break;            
            case 'allCategoriesProduct':
                $this->setMetaAllCategoriesProduct();
            break;            
        }        
    }
    
    /**
     * Metodo che assegna il valore per i meta title per la home page
     */
    public function setMetaHomePage() {
        $host = strtolower( str_replace( array('m.','www.'), '', $this->request->server->get( 'HTTP_HOST' ) ) );               
        $this->container->get( 'twig' )->addGlobal( 'pageTitle','Onoranze Funebri F.lli Timperi Guidonia' );
        $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Le onornze oronzo cana ti manda alla poubblicità'   );                        
        $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
    }        
    
    /**
     * Metodo che assegna il valore per i meta title per la home page
     */
    public function setMetaAllCategoriesProduct() {        
        $this->container->get( 'twig' )->addGlobal( 'pageTitle','AcquistiGiusti.it - Sitemaps Categorie' );
        $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'AcquistiGiusti.it - Ottieni tutte le informazioni, cerca tra tutte le categorie i prodotti che fanno per te' );                        
        $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
    }        
    /**
     * Metodo che assegna il valore per i meta title per la home page
     */
    public function setMetaListModelComparison() {        
        $page = !empty( $_GET['page'] ) ? ' - Pag. '. $_GET['page'] : '';
        $this->container->get( 'twig' )->addGlobal( 'pageTitle', 'Comparatore di prezzi e caratteristiche '.$page.' - AcquistiGiusti.it' );
        $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Confronta TV, elettrodomestici e prodotti per casa e cucina: compara le offerte su Amazon, Monclick e Ebay e fai l\'acquisto giusto al miglior prezzo online.' );
        $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
    }        
    
    public function seoDinamycPage( $page ) {
        switch( $page ) {
            case 'chi-siamo':
                $this->container->get( 'twig' )->addGlobal( 'pageTitle', 'Chi Siamo | Acquistigiusti.it' );
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Non solo confronto prezzi, la nostra missione è quella di fornire informazioni esatte su prezzi e caratteristiche dei prodotti. Scopri chi siamo!' );                    
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
            break;
            case 'coockie':
                $this->container->get( 'twig' )->addGlobal( 'pageTitle', 'Informativa Coockie | Acquistigiusti.it' );
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Informazioni sull\'utilizzo dei coockie su Acquistigiusti.it' );                    
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
            break;
        }
    }
    
    /**
     * Metodo che assegna il valore per i meta title per la home page
     */
    public function setCatSubcatTypologyProduct( $section, $category = false, $subcategory = false, $typology = false, $search = false ) {      
        $page = !empty( $_GET['page'] )  && $_GET['page'] != 1 ? ' - Pag. ' .$_GET['page'] : '';      
        switch( $section ) {
            case 'category':
                $congiunzione = $category->getName() == 'Audio & Video' ? '' : 'per la ';
                $this->container->get( 'twig' )->addGlobal( 'pageTitle', 'Prodotti '.$category->getName().' - Info e Offerte - AcquistiGiusti.it' );
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Leggi le descrizioni compara i prezzi dei prodotti '.$congiunzione.$category->getName().', e fai il giusto acquisto' );                    
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
            break;
            case 'subcategory':
                $seoTitle = 'Prodotti '.$subcategory->getCategory()->getName().', '.$subcategory->getName().$page.' - Info e Offerte - AcquistiGiusti.it';
                if( strlen( $seoTitle ) > 70  ) {
                    $seoTitle = 'Prodotti '.$subcategory->getName().$page.' - Info e Offerte';
                }
                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoTitle );
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', $subcategory->getCategory()->getName().', '.$subcategory->getName().': Leggi le descrizioni compara i prezzi dei prodotti, e fai il giusto acquisto' );                    
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
                
                if( !empty( trim( $subcategory->getMetaTitle() ) ) )
                    $this->container->get( 'twig' )->addGlobal( 'pageTitle', trim( $subcategory->getMetaTitle() ) ); 

                if( !empty( trim( $subcategory->getMetaDescription() ) ) )
                    $this->container->get( 'twig' )->addGlobal( 'pageDesc', trim( $subcategory->getMetaDescription() ) );       
                
            break;
            case 'typology':                
                $seoTitle = $typology->getName().' Prezzi'.$page.' - Scopri le offerte su AcquistiGiusti.it';
                if( strlen( $seoTitle ) > 70  ) {
                    $seoTitle = $typology->getName().' Prezzi'.$page.' - Scopri le offerte';
                }
                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoTitle );
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Ottieni informazioni su prezzi ed offerte '.$typology->getName().', e leggi le caratteristiche tecniche dei modelli su AcquistiGiusti.it' );                    
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
                
                if( !empty( trim( $typology->getMetaTitle() ) ) )
                    $this->container->get( 'twig' )->addGlobal( 'pageTitle', trim( $typology->getMetaTitle() ) ); 

                if( !empty( trim( $typology->getMetaDescription() ) ) )
                    $this->container->get( 'twig' )->addGlobal( 'pageDesc', trim( $typology->getMetaDescription() ) );  
                
            break;
            case 'typologySearch':
                $searchReplace = ucwords( str_replace( '_', ' ', $search ) );
                $seoTitle = $typology->getName().' '.$searchReplace.' Prezzi'.$page.' - Scopri le offerte su AcquistiGiusti.it';
                if( strlen( $seoTitle ) > 70  ) {
                    $seoTitle = $typology->getName().' '.$searchReplace.' Prezzi'.$page.' - Scopri le offerte';
                }
                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoTitle );
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Informazioni prezzi ed offerte '.$typology->getName().' '.$searchReplace.', leggi le caratteristiche tecniche dei modelli su AcquistiGiusti.it' );                    
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
            break;
            //ricerca libera
            case 'search':
                $searchReplace = ucwords( str_replace( '_', ' ', $search ) );
                $this->container->get( 'twig' )->addGlobal( 'pageTitle', 'Prezzi modelli '.$searchReplace.' vedi le offerte su AcquistiGiusti.it' );
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Tutti le offerte migliori di '.$searchReplace. ', scopri i prezzi e caratteristiche tecniche' );
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
            break;            
        }        
    }  

    /**
     * gestisce il seo per la pagina con tutti i modelli di un marchio paginati
     * @param type $trademark
     * @param type $nameSection
     */
    public function setListModelsTrademark( $trademark, $nameSection ) {
        echo 'setListModelsTrademark';
        exit;
        $seoTitle = $nameSection.' '.ucfirst( $trademark ).' Confronta modelli e prezzi | AcquistiGiusti.it';
        if( strlen( $seoTitle ) > 70  ) {
            $seoTitle = $nameSection.' '.ucfirst( $trademark ).' modelli e prezzi';
        }
        if( strlen( $seoTitle ) > 70  ) {
            $seoTitle = $nameSection.' '.ucfirst( $trademark ).' prezzi';
        }
        $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoTitle );
        $this->container->get( 'twig' )->addGlobal( 'pageDesc', "".ucfirst( $trademark )." $nameSection tutti i modelli con schede tecniche, offerte e prezzi" );                            
        $this->container->get( 'twig' )->addGlobal( 'pagekwds', 'offerte '.$nameSection.' '.$trademark.', prezzi '.$nameSection.' '.$trademark.', promozioni '.$nameSection.' '.$trademark.'' );
    }
    
    /**
     * Metodo che assegna il valore per i meta title per la home page
     */
//    public function setListProduct( $section, $category = false, $subcategory = false, $typology = false, $search = false, $sex = false ) {         
//        $page = !empty( $_GET['page'] ) && $_GET['page'] != 1 ? ' - Pag. ' .$_GET['page'] : ' ';
//        switch( $section ) {
//            case 'free_search':                
//                $this->container->get( 'twig' )->addGlobal( 'pageTitle', 'Prezzi '.$subcategory.$search.' scopri le offerte | AcquistiGiusti.it' );
//                $this->container->get( 'twig' )->addGlobal( 'pageDesc', "Scopri le occasioni di $subcategory$search al prezzo piu basso su offerteprezzi");  
//                $this->container->get( 'twig' )->addGlobal( 'pagekwds', $subcategory.$search.' prezzi, occasioni ' .$subcategory.$search.", promozioni ".$subcategory.$search ); 
//            break;            
//            case 'category_search_user':
//                $searchReplace = ucwords( str_replace( '_', ' ', $search ) );                                
//                $seoName = $category->getName() .' '.$searchReplace;
//                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoName.' scopri le promozioni | AcquistiGiusti.it' );
//                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Tutte le occasioni di '. $seoName );  
//                $this->container->get( 'twig' )->addGlobal( 'pagekwds', $seoName.' prezzi, occasioni ' .$seoName.", promozioni ".$seoName ); 
//            break;
//            case 'subcategory':
//                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $subcategory->getName().' Collezione '.date("Y").''.$page.' | AcquistiGiusti.it' );
//                $this->container->get( 'twig' )->addGlobal( 'pageDesc', "Moda ".$subcategory->getName()." ".date("Y").", Scopri le ultime tendenze di stagione");  
//                $this->container->get( 'twig' )->addGlobal( 'pagekwds', 'Moda '.$subcategory->getName().' '.date("Y").', promozioni '.$subcategory->getName().' '.date("Y").', Offerte '.$subcategory->getName().' '.date("Y").', Collezioni '.$subcategory->getName().' '.date("Y").', Tendenze '.$subcategory->getName().' '.date("Y").'' );
//            break;
//            case 'subcategory_sex':
//                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $subcategory->getName().' '. ucfirst($sex).' Collezione '.date("Y").''.$page.' | AcquistiGiusti.it' );
//                $this->container->get( 'twig' )->addGlobal( 'pageDesc', "Moda ".$subcategory->getName()." ".date("Y").", Scopri le ultime tendenze di stagione per ".ucfirst($sex) );  
//                $this->container->get( 'twig' )->addGlobal( 'pagekwds', 'Moda '.$subcategory->getName().' '.$sex.' '.date("Y").', promozioni '.$subcategory->getName().' '.$sex.' '.date("Y").', Offerte '.$subcategory->getName().' '.$sex.' '.date("Y").', Collezioni '.$subcategory->getName().' '.$sex.' '.date("Y").', Tendenze '.$subcategory->getName().' '.date("Y").'' );
//            break;
//            case 'subcategory_search_user':
//                $searchReplace = ucwords( str_replace( '_', ' ', $search ) );                                
//                $seoName = !empty( $subcategory ) ? $subcategory->getName() .' '.$searchReplace : $category->getName() .' '.$searchReplace;
//                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoName.' scopri tutte le promozioni | AcquistiGiusti.it' );
//                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'Scopri occasioni e offerte di '. $seoName.' al prezzo piu basso' );  
//                $this->container->get( 'twig' )->addGlobal( 'pagekwds', $seoName.' prezzi, occasioni ' .$seoName.", promozioni ".$seoName ); 
//            break;
//            case 'typology':
//                $category = !empty( $typology->getCategory() ) ? $typology->getCategory()->getName() : '';
//                $seoTitle = 'Prezzi e offerte '.$typology->getName().' '.ucfirst( $category ).''.$page.' | AcquistiGiusti.it';
//                if( strlen( $seoTitle ) > 70  ) {
//                    $seoTitle = 'Prezzi e offerte '.$typology->getName().' '.ucfirst( $category ).$page;
//                }
//                if( strlen( $seoTitle ) > 70  ) {
//                    $seoTitle = 'Offerte '.$typology->getName().' '.ucfirst( $category ).$page;
//                }                
//                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoTitle );
//                $this->container->get( 'twig' )->addGlobal( 'pageDesc', "Le offerte di ".$typology->getName().' '.ucfirst( $category ).", Risparmia comparando prezzi, cogli la miglior occasione per acquistare ".$typology->getName());  
//                $this->container->get( 'twig' )->addGlobal( 'pagekwds', 'Moda '.$typology->getName().' '.ucfirst( $category ).', promozioni '.$typology->getName().' '.ucfirst( $category ).', Offerte '.$typology->getName().' '.ucfirst( $category ).'' );
//            break;           
//            case 'typology_search':
//                $seoName = $typology->getName() .''.$sex.''.$search;
//                
//                $seoTitle =  $seoName.' offerte | AcquistiGiusti.it ';
//                if( strlen( $seoTitle ) > 70  ) {
//                    $seoTitle =  $seoName.' le offerte ';
//                }
//                
//                $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoTitle );
//                $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'I migliori prodotti di '.$seoName.' ordinati per prezzo piu basso, scopri tutte le offerte' );
//                $this->container->get( 'twig' )->addGlobal( 'pagekwds', $seoName.' offerte, prezzi '.$seoName.', miglior prezzo '.$seoName.', promozioni '.$seoName.' ' );
//            break;            
//        }                
//    }        
    
    /**
    * Metodo che assegna il valore per i meta title per il dettaglio prodotto
    */
    public function setDetailProduct( $section, $model, $subcategory = false, $typology = false ) {        
        $modelName       = trim( str_replace( array(' - ','"'), array(' ', '',''), utf8_decode( $model->getName() ) ) );
        $modelNameKwds   = trim( str_replace( array(' - ','"'), array(' ', '',''), strtolower( utf8_decode( $model->getName() ) ) ) );       
        
        switch( $section ) {           
            case 'subcategory':
                $singolarName    = !empty( $subcategory->getSingularName() ) ? ' '.trim( $subcategory->getSingularName() ) : '';
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', "Confronta prezzi e dati tecnici di".$singolarName." ".$modelName." con le altre migliori ".$subcategory->getName(). " su AcquistiGiusti.it"  );
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', "");
            break;
            case 'typology':         
                $singolarName    = !empty( $typology->getSingularName() ) ? ''.trim( $typology->getSingularName() ) : '';                
                $this->container->get( 'twig' )->addGlobal( 'pageDesc', "Confronta prezzi e dati tecnici di".$singolarName." ".$modelName." con le altre migliori ".$typology->getName(). " su AcquistiGiusti.it"  );
                $this->container->get( 'twig' )->addGlobal( 'pagekwds', "");
            break;           
        }        
        
        $seoTitle = $modelName.', prezzo e caratteristiche - AcquistiGiusti.it';
        if( strlen( $seoTitle ) > 70  )            
            $seoTitle = $modelName.', prezzo e caratteristiche';
        if( strlen( $seoTitle ) > 70  )
            $seoTitle = $modelName.', prezzo';        

        $this->container->get( 'twig' )->addGlobal( 'pageTitle', $seoTitle );       
        
        if( !empty( trim( $model->getMetaTitle() ) ) )
            $this->container->get( 'twig' )->addGlobal( 'pageTitle', trim( $model->getMetaTitle() ) ); 
        
        if( !empty( trim( $model->getMetaDescription() ) ) )
            $this->container->get( 'twig' )->addGlobal( 'pageDesc', trim( $model->getMetaDescription() ) );                 
    }
    
    
    /**
     * Seo per la parte della lista articoli
     * @param type $catSubcatTypology
     */
    public function seoListArticles( $catSubcatTypology = false ) {
        $host = strtolower( str_replace( array('m.','www.'), '', $this->request->server->get( 'HTTP_HOST' ) ) );       
        $page = !empty( $_GET['page'] ) ? ' - Pag. '. $_GET['page'] : '';
        if( empty( $catSubcatTypology ) ) {
            $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
            $this->container->get( 'twig' )->addGlobal( 'pageTitle',' Curiosità e approfondimenti per guidarti nel tuo shopping online | AcquistiGiusti.it Magazine' );
            $this->container->get( 'twig' )->addGlobal( 'pageDesc', 'AcquistiGiusti.it Magazine ti consiglia, indicandoti trend di mercato, informazioni sui prodotti, per farti fare il giusto acquisto online per le tue esigenze al miglior prezzo' );
        } else {
            $catSubcatTypology = $catSubcatTypology == 'Guida acquisto' ? 'Guide acquisto' : 'Recensioni';
            $this->container->get( 'twig' )->addGlobal( 'pagekwds', '' );
            $this->container->get( 'twig' )->addGlobal( 'pageTitle', 'Leggi le '.$catSubcatTypology.' e scegli bene '.$page.' - AcquistiGiusti.it ' );
            $this->container->get( 'twig' )->addGlobal( 'pageDesc',  'Scegli bene ciò che compri, non sprecare i tuoi soldi, leggi le nostre '.$catSubcatTypology.' ed informati sul prodotto giusto per te!' );
        }
    }
    
    public function setModelsComparison( $models, $comparison ) {
        if( !empty( $models[0]->getTypology() )  )
            $catName = $models[0]->getTypology()->getName();
        else 
            $catName = $models[0]->getSubcategory()->getName();
        
        $title =  'Comparazione '.$catName.', ';
        foreach( $models AS $model ) {
            $title .= $model->getName(). ' vs ';
        }
        $title = trim( $title, 'vs ' );                
        
        $this->container->get( 'twig' )->addGlobal( 'pageTitle', $title );
        
        $desc =  '';
        foreach( $models AS $model ) {
            $desc .= $model->getName(). ' e ';
        }
        $desc = trim( $desc, 'e ' );
        
        $key =  '';
        foreach( $models AS $model ) {
            $key .= $model->getName(). ' e ';
        }
        $key = trim( $key, 'e ' );
        
        $this->container->get( 'twig' )->addGlobal( 'pageDesc', "Confronto prezzi e dati tecnici dei $catName, ".$desc );
        $this->container->get( 'twig' )->addGlobal( 'pagekwds', "");
        
        if( !is_array( $comparison ) && !empty( trim( $comparison->getMetaTitle() ) ) )
            $this->container->get( 'twig' )->addGlobal( 'pageTitle', $comparison->getMetaTitle() );
        
        if( !is_array( $comparison ) && !empty( trim($comparison->getMetaDescription() ) ) )
            $this->container->get( 'twig' )->addGlobal( 'pageDesc', $comparison->getMetaDescription() );
    }
    
}//End Class
