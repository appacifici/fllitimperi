<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListAffiliations {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
//        if ( !$this->wm->getPermissionCore('affiliate', 'read' ) )
//                return array();
        $aAffiliations = array();
        $affiliations = $this->wm->doctrine->getRepository('AppBundle:Affiliation')->findAll();
        
        foreach ( $affiliations as $affiliate ) {
            $aAffiliations[] = $affiliate;
        }
        
        return array(
            'affiliations' => $aAffiliations
        );
    }
}