<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListPolls {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('article', 'read' ) )
                return array();
        
        $poll = null;
        $polls = $this->wm->doctrine->getRepository('AppBundle:Poll')->findAllPolls();
        
        if ( !empty( $polls ) ) {
         
            foreach ($polls as $item) {
                $poll[$item->getId()]['answers'] = json_decode($item->getJsonAnswers());
                $poll[$item->getId()]['question'] = $item->getQuestion();
                $poll[$item->getId()]['dataArticleId'] = $item->getDataArticleId();
            }
        }
        
        return array(
            'polls'     => $poll,
        );
    }
}