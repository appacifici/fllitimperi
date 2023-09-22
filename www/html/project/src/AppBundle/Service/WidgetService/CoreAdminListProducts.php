<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListProducts {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
//        if ( !$this->wm->getPermissionCore('category', 'read' ) )
//                return array();
        $aProducts = array();
        $affiliations = $this->wm->doctrine->getRepository('AppBundle:Affiliation')->findAll();
        
        if( !isset( $_GET['name'] ) ) {
            return  array(
                'products' => $aProducts,
                'pagination' => false,
                'affiliations' => $affiliations
            );
        }        
        
        $name = !empty( $_GET['name'] ) ? $_GET['name'] : false;
        $number = !empty( $_GET['number'] ) ? $_GET['number'] : false;
        $isCompleted = isset( $_GET['isCompleted'] ) && ( $_GET['isCompleted'] == '0' || $_GET['isCompleted'] == '1')  ? $_GET['isCompleted'] : false;
        $category = !empty( $_GET['category'] ) ? $_GET['category'] : false;
        $subcategory = !empty( $_GET['subcategory'] ) ? $_GET['subcategory'] : false;
        $typology = !empty( $_GET['typology'] ) ? $_GET['typology'] : false;        
        $date = !empty( $_GET['date'] ) ? $_GET['date'] : false;
        
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
        
        $products       = $this->wm->doctrine->getRepository('AppBundle:Product')->findProductsWithLimit( $pagination->getLimit(), $name, $isCompleted, $category, $subcategory, $typology, $date, $number );
        $countProducts  = $this->wm->doctrine->getRepository('AppBundle:Product')->countProducts( $name, $isCompleted, $category, $subcategory, $typology, $date, $number );
        
        foreach ( $products as $product ) {
            $aProducts[] = $product;
        }
        
        $pagination->init( $countProducts['tot'] ); 
        $paginationArt = $pagination->makeList();
        
        

        
        return array(
            'products' => $aProducts,
            'pagination' => $paginationArt,
            'affiliations' => $affiliations
        );
    }
}