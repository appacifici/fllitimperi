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

class CoreAdminEditSize {

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
        $modelImage         = $this->wm->doctrine->getRepository('AppBundle:Size')->find( $id );
        
        $notAllowedModel = array( 'id' );

        $size = array(
            'Size' => array(
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

        $countEntity = count($size);

        $buttons = array();

        $formSize = $this->fm->createForm($size, $countEntity, $buttons);
        $formSize->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formSize->isSubmitted()) {
            $entityAutoField = array(
                'Size' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formModel->getData()->getName() )
                )
            );
            
            $formSize = $this->wm->formManager->validateAndSaveForm($formSize, $size, $countEntity, $entityAutoField, 'editSize');
        }

        return array(
            'form' => $formSize->createView(),
            'pathRoute' => 'listSizes',
            'label' => 'Taglie'
        );
    }
    
}
