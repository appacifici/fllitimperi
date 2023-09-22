<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListSubcategories {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('subcategory', 'read' ) )
                return array();
        
        $aSubcategories = array();
        $subcategories             = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAll();
        
        foreach ( $subcategories as $item ) {
            $aSubcategories[] = $item;
        }
        
        
        return array(
            'subcategories'             => $aSubcategories
        );
    }
}