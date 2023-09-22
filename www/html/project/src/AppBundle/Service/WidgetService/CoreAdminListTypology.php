<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListTypology {
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
        
        $aTypologies = array();
        $subcatId = false;
        $catId = false;
        
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
        
        if ( !empty( $_GET['subcategory'] ) )
            $subcatId = $_GET['subcategory'];
        
        if ( !empty( $_GET['category'] ) )
            $catId = $_GET['category'];
        
        $hasModels = '';
        if ( !empty( $_GET['hasModels'] ) )
            $hasModels = $_GET['hasModels'];
        
        
        $typologies       = $this->wm->doctrine->getRepository('AppBundle:Typology')->findTypologiesWithLimit( $pagination->getLimit(), $catId, $subcatId, $hasModels );
        $countTypologies  = $this->wm->doctrine->getRepository('AppBundle:Typology')->countTypologies( $subcatId, $catId, $hasModels );
        
        foreach ( $typologies as $typology ) {
            $aTypologies[] = $typology;
        }
        
        $pagination->init( $countTypologies['tot'] ); 
        $paginationArt = $pagination->makeList();
        
        return array(
            'typologies' => $aTypologies,
            'pagination' => $paginationArt
        );
    }
}