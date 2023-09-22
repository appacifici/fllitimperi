<?php

namespace AppBundle\Service\WidgetService;

use AppBundle\Service\FormService\FormManager;
use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class CoreAdminEditExtraConfig {

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager, FormManager $formManager) {
        $this->wm = $widgetManager;
        $this->fm = $formManager;
    }

    public function processData($options = false) {
        //controllo se l'utente abbia i permessi di lettura
        if ( !$this->wm->getPermissionCore('category', 'edit' ) )
                return array();
        
        $id = $this->wm->getUrlId();
                
        $extraConfig = array(
            'ExtraConfig' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => array('id'),
                'optionsFields' => array(
                    'keyName' => array( 
                        'typeClass' =>  TextType::class,
                        'label'     => 'Nome',
                        'required'  => false
                    ),
                    'value' => array( 
                        'typeClass' =>  TextType::class,
                        'label'     => 'Contenuto configurazione extra',
                        'required'  => false
                    )
               ),
            )
        );

        $countEntity = count($extraConfig);

        $buttons = array( 
            
        );

        $formExtraConfig = $this->fm->createForm($extraConfig, $countEntity, $buttons);
        $formExtraConfig->handleRequest($this->wm->requestStack->getCurrentRequest());
        
        if ($formExtraConfig->isSubmitted()) {
            $entityAutoField = array(
                'ExtraConfig' => array()      
                );            
            $formExtraConfig = $this->wm->formManager->validateAndSaveForm($formExtraConfig, $extraConfig, $countEntity, $entityAutoField, 'editExtraConfig');
        }

        return array(
            'extraConfig'  => $formExtraConfig->createView(),
        );
    }

}
