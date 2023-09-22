<?php

namespace AppBundle\Service\WidgetService;

class CoreAdminEditPoll {

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager) {
        $this->wm = $widgetManager;      
    }

    public function processData($options = false) {        
        if( !$this->wm->getPermissionCore( 'article', 'read' ) )
            return array();
        
        $id = $this->wm->getUrlId();
        $answers = null;
        $poll = $this->wm->doctrine->getRepository( 'AppBundle:Poll' )->find( $id );
        
        if( !empty( $poll ) )
            $answers = json_decode($poll->getJsonAnswers());
        
        
        return array(
            'data' => $poll,
            'answers' => $answers
        );
    }

}
