<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminBestDiscountedPrices {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('product', 'read' ) )
                return array();
        
        $subcatId = false;
        $catId = false;
        $typologyId = false;
        $top = false;
        $bestDiscountedModels = array();
        
        $name = !empty( $_GET['name'] ) ? $_GET['name'] : false;
        $isCompleted = isset( $_GET['isCompleted'] ) && ( $_GET['isCompleted'] == '0' || $_GET['isCompleted'] == '1')  ? $_GET['isCompleted'] : false;
        $category = !empty( $_GET['category'] ) ? $_GET['category'] : false;
        $subcategory = !empty( $_GET['subcategory'] ) ? $_GET['subcategory'] : false;
        $typology = !empty( $_GET['typology'] ) ? $_GET['typology'] : false;
        $inShowcase = isset( $_GET['inShowcase'] ) && ( $_GET['inShowcase'] == '0' || $_GET['inShowcase'] == '1' ) ? $_GET['inShowcase'] : false;
        $top = isset( $_GET['top'] ) && ( $_GET['top'] == '0' || $_GET['top'] == '1' ) ? $_GET['top'] : false;
        $revisioned =isset( $_GET['revisioned'] ) && ( $_GET['revisioned'] == '0' || $_GET['revisioned'] == '1' ) ? $_GET['revisioned'] : false;
        $date = !empty( $_GET['date'] ) ? $_GET['date'] : false;
                
        $models = $this->wm->doctrine->getRepository('AppBundle:Model')->findBestDiscountedModels( $name, $isCompleted, $category, $subcategory, $typology, $inShowcase, $revisioned, $date, $top, 50 );        
        foreach ($models as $model) {
//            if( $model->getHasProducts() > 0 ) {
                $bestDiscountedModels[$model->getId()]['id'] = $model->getId();
                $bestDiscountedModels[$model->getId()]['name'] = $model->getName();
                $bestDiscountedModels[$model->getId()]['url'] = $model->getNameUrl();
                $bestDiscountedModels[$model->getId()]['price'] = $model->getPrice();
                $bestDiscountedModels[$model->getId()]['advisedPrice'] = $model->getAdvisedPrice();
                $bestDiscountedModels[$model->getId()]['lastPrice'] = $model->getLastPrice();

                if( empty( $model->getImg() ) ) {
                    $products = $this->wm->doctrine->getRepository('AppBundle:Product')->findOneByModel( $model->getId() );
                    if( !empty( $products ) && !empty( $products->getPriorityImg() ) )
                        $bestDiscountedModels[$model->getId()]['img'] = $products->getPriorityImg()->getImg();
                } else {
                    $bestDiscountedModels[$model->getId()]['img'] = $model->getImg();
                }
                if( !empty( $model->getTypology() ) ) {
                    $urlModel = 'https://www.offerteprezzi.it'.$this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'typology' => $model->getTypology()->getNameUrl(), 'typologySingular' => $model->getTypology()->getSingularNameUrl() ) );
                } else {
                    $urlModel = 'https://www.offerteprezzi.it'.$this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'subcategory' => $model->getSubcategory()->getNameUrl(), 'subcategorySingular' => $model->getSubcategory()->getSingularNameUrl() ) );
                }
                $bestDiscountedModels[$model->getId()]['urlModel'] = $urlModel;

//            }
        }
        
        return array(
            'bestDiscountedModels' => $bestDiscountedModels
        );
    }
}