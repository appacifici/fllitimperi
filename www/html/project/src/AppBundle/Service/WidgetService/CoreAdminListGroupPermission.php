<?php

namespace AppBundle\Service\WidgetService;

class CoreAdminListGroupPermission {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {      
        //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('groupPermission', 'read' ) )
                return array();
        //query repository group
        $listGroupPermissions = $this->wm->doctrine->getRepository( 'AppBundle:Group' )->findGroups();
        
        $agroups = array();
        //ciclo tutti i gruppi e formatto l'oggetto per stamparlo sul twig
        foreach ($listGroupPermissions as $groupPermission) {
            $agroups[$groupPermission->getId()] = $this->wm->userManager->getPermissionByGroup( $groupPermission->getId() );
        }
        
        return array( 'groups' => $agroups );
    }
     
}
