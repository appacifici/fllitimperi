<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListModels {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('model', 'read' ) )
                return array();
        
        $aModels = array();
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
        
        $name = !empty( $_GET['name'] ) ? $_GET['name'] : false;
        $isCompleted = isset( $_GET['isCompleted'] ) && ( $_GET['isCompleted'] == '0' || $_GET['isCompleted'] == '1')  ? $_GET['isCompleted'] : false;
        $category = !empty( $_GET['category'] ) ? $_GET['category'] : false;
        $subcategory = !empty( $_GET['subcategory'] ) ? $_GET['subcategory'] : false;
        $typology = !empty( $_GET['typology'] ) ? $_GET['typology'] : false;
        $inShowcase = isset( $_GET['inShowcase'] ) && ( $_GET['inShowcase'] == '0' || $_GET['inShowcase'] == '1' ) ? $_GET['inShowcase'] : false;
        $top = isset( $_GET['top'] ) && ( $_GET['top'] == '0' || $_GET['top'] == '1' ) ? $_GET['top'] : false;
        $revisioned =isset( $_GET['revisioned'] ) && ( $_GET['revisioned'] == '0' || $_GET['revisioned'] == '1' ) ? $_GET['revisioned'] : false;
        $date = !empty( $_GET['date'] ) ? $_GET['date'] : false;
        
        $models = $this->wm->doctrine->getRepository('AppBundle:Model')->findModelsWithLimit( $pagination->getLimit(), $name, $isCompleted, $category, $subcategory, $typology, $inShowcase, $revisioned, $date, $top );
        $countModels = $this->wm->doctrine->getRepository('AppBundle:Model')->countModels( $name, $isCompleted, $category, $subcategory, $typology, $inShowcase, $revisioned, $date, $top );
        
        foreach ( $models as $model ) {
            $aModels[] = $model;
        }
        
        $pagination->init( $countModels['tot'] ); 
        $paginationArt = $pagination->makeList();

        return array(
            'models' => $aModels,
            'pagination' => $paginationArt
        );
    }
}