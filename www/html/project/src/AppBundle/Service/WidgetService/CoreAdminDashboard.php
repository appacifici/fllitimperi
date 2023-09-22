<?php

namespace AppBundle\Service\WidgetService;
use AppBundle\Service\UserUtility\UserManager;

class CoreAdminDashboard {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager, UserManager $userManager ) {
        $this->wm = $widgetManager;
        $this->um = $userManager;
    }
    
    public function processData( $options = false ) {
                      
                //controllo se l'utente abbia i permessi di lettura
//        if ( !$this->wm->getPermissionCore('article', 'read' ) )
//                return array();
                
        $models = $this->wm->doctrine->getRepository('AppBundle:Model')->getEmptyProductsModel();          
                
        $checkArticles = array();
        $articles = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->getAllArticles('0,500');
        foreach( $articles AS $article ) {
            $longDesc =  $article->getContentArticle()->getBody();
            
            $checkArticles[$article->getId()]['articleName']        = $article->getContentArticle()->getTitle();
            $checkArticles[$article->getId()]['articleId']          = $article->getId();            
            
            $ids = $this->wm->getInternalProductAmazonCode( $longDesc  );                        
            foreach( $ids AS $id ) {
                $product = $this->wm->doctrine->getRepository( 'AppBundle:Product' )->findOneById( $id );
                
                if( empty( $product ) ) {                    
                    $checkArticles[$article->getId()]['productsNotExist'][]       = $id;
                } else {
                    if( !empty( $product->getIsActive() ) ) {
                        $checkArticles[$article->getId()]['productsActive'][]       = $product;
                    } else {
                        $checkArticles[$article->getId()]['productsDisabled'][]     = $product;
                    }
                }
            }
            
            $coreModelByIds = $this->wm->container->get('app.coreModelByIds');
            $ids = explode( ';', $article->getModelsRank() );
            $amodels = $coreModelByIds->getByIds( $ids ); 

            $maxProduct = 0;
            
            for( $x = 0; $x < count( $ids ); $x++ ) {
                foreach( $amodels AS $item ) {
                    if( $item['model']->getHasProducts() > 0  ) {
                        $checkArticles[$article->getId()]['modelsActive'][] = $item['model'];                                
                    } else {
                        $checkArticles[$article->getId()]['modelsDisabled'][]   = $item['model'];                                
                    }
                    
                    $x++;
                    $maxProduct = count( $item['product'] ) > $maxProduct ? count( $item['product'] ) : $maxProduct;
                }
            }
            
        }
        
        
        
        return array(
              'models' => $models,         
              'checkArticles' => $checkArticles
        );
    }
     
}