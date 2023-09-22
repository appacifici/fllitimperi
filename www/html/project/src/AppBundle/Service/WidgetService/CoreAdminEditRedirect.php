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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoreAdminEditRedirect {

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
//        if ( !$this->wm->getPermissionCore('model', 'edit' ) )
//                return array();
        
        $id = $this->wm->getUrlId();        
        
        $notAllowedModel = array( 'id' );

        $redirect = array(
            'Redirect' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedModel,
                'optionsFields' => array(                    
                    'originalUrl' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url Originale'
                    ),    
                    
                    'newUrl' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Nuova Url'
                    ),                            
                )
            )
        );

        $countEntity = count($redirect);

        $buttons = array();

        $formRedirect = $this->fm->createForm($redirect, $countEntity, $buttons);
        $formRedirect->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formRedirect->isSubmitted()) {
            $entityAutoField = array(
                'Redirect' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formModel->getData()->getName() )
                )
            );
            
            $formRedirect = $this->wm->formManager->validateAndSaveForm($formRedirect, $redirect, $countEntity, $entityAutoField, 'editRedirect');
        }

        return array(
            'redirect' => $formRedirect->createView()            
        );
    }
    
}
