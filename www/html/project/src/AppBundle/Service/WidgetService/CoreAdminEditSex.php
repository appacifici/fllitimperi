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

class CoreAdminEditSex {

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

        $sex = array(
            'Sex' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedModel,
                'optionsFields' => array(                    
                    'name' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Nome'
                    ),    
                    
                    'synonym' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Description'
                    ),
                    
                    'isActive' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Disattivo' => 0,
                            'Attivo' => 1,
                        ),
                        'required' => true,
                        'label' => 'Stato'
                    ),
                    'nameUrl' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url'
                    ),                                       
                )
            )
        );

        $countEntity = count($sex);

        $buttons = array();

        $formSex = $this->fm->createForm($sex, $countEntity, $buttons);
        $formSex->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formSex->isSubmitted()) {
            $entityAutoField = array(
                'Sex' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formModel->getData()->getName() )
                )
            );
            
            $formSex = $this->wm->formManager->validateAndSaveForm($formSex, $sex, $countEntity, $entityAutoField, 'editSex');
        }

        return array(
            'sex' => $formSex->createView(),
        );
    }
    
}
