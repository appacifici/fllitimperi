<?php

namespace AppBundle\Service\WidgetService;

class CoreFollowUs {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData() {    
        $this->extraConfigs = $this->wm->globalConfigManager->getExtraConfigs();
        
        $dataFollowUs = array(
            'facebook' => '',
            'twitter' => '',
            'whatsapp' => ''
        );
        
        switch( $this->wm->globalConfigManager->getCurrentDomain() ) {
            case 'calciomercato.it':
            case '':
                $dataFollowUs = array(
                    'facebook' => $this->extraConfigs['facebookFollowUs']->getValue(),
                    'twitter'  =>  $this->extraConfigs['twitterFollowUs']->getValue(),
                    'whatsapp' => $this->extraConfigs['whatsappShare']->getValue()
                );
            break;
        }

        
        return array(
            'data' => $dataFollowUs
        );
    } 
}