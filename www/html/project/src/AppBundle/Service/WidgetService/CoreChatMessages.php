<?php

namespace AppBundle\Service\WidgetService;

class CoreChatMessages {

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager) {
        $this->wm = $widgetManager;      
    }

    public function processData($options = false) {
        $superUserMsg = array();
        $msg =  $this->wm->doctrine->getRepository( 'AppBundle:ChatMessage' )->findAll();
        
        $superUsers = array_map( 'trim', explode( ',', $this->wm->container->getParameter( 'app.superUserChat' ) ) );
        
        foreach ( $msg as $item ) {
            if( in_array( trim( $item->getUser() ), $superUsers ) ) {
                array_push($superUserMsg, $item);
            }
        }
        
        return array(
            'chatMessages' => $msg,
            'superUserMessages' => $superUserMsg
        );
    }

}
