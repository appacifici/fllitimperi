<?php

namespace AppBundle\Service\WidgetService;
use AppBundle\Service\FormService\FormManager;

class CoreAdminUsers {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager, FormManager $formManager ) {
        $this->wm = $widgetManager;   
        $this->formManager      = $formManager;  
    }
    
    public function processData( $options = false ) {        
        $users             = $this->wm->doctrine->getRepository('AppBundle:User')->findByIsAdmin(1);

        $aRoles = array();
        $roles = $this->wm->doctrine->getRepository('AppBundle:Group')->findGroups();
        foreach ( $roles AS $role ) {
            $aRoles[$role->getid()] = $role;
        }
        
        return array(
            'users'          => $users,
            'roles'           => $aRoles,
            'rolesJson'           => json_encode( $aRoles )
        );
    }
     
}