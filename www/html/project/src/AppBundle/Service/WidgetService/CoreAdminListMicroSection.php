<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListMicroSection {
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
        
        $aMicroSection = array();
        $typologyId = false;
        $subcatId = false;
        $catId = false;
        
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
        
        if ( !empty( $_GET['typology'] ) )
            $typologyId = $_GET['typology'];
                
        if ( !empty( $_GET['subcategory'] ) )
            $subcatId = $_GET['subcategory'];
        
        if ( !empty( $_GET['category'] ) )
            $catId = $_GET['category'];
        
        $hasModels = '';
        if ( !empty( $_GET['hasModels'] ) )
            $hasModels = $_GET['hasModels'];
        
        
        $microSections       = $this->wm->doctrine->getRepository('AppBundle:MicroSection')->findMicroSectionWithLimit( $pagination->getLimit(), $catId, $subcatId, $typologyId, $hasModels );
        $countMicroSections  = $this->wm->doctrine->getRepository('AppBundle:MicroSection')->countMicroSection( $catId, $subcatId, $typologyId, $hasModels );
        
        foreach ( $microSections as $microSection ) {
            $aMicroSection[] = $microSection;
        }
        
        $pagination->init( $countMicroSections['tot'] ); 
        $paginationArt = $pagination->makeList();
        
        return array(
            'microSections' => $aMicroSection,
            'pagination' => $paginationArt
        );
    }
}