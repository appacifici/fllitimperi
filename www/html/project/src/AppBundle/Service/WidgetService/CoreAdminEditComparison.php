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

class CoreAdminEditComparison {

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
        
        $allModels       = $this->wm->doctrine->getRepository('AppBundle:Model')->findBy( array(), array('name' => 'ASC') );          
        
        $notAllowedModel = array( 'id', 'createDate');

        $comparison = array(
            'Comparison' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedModel,
                'optionsFields' => array(                    
                    'modelOne' => array( 
                        'typeClass' => EntityType::class,
                        'entityName' => 'Model',
                        'choice_label' => 'name',
                        'required' => false,
                        'label' => 'Modello 1',
                        'choices' => $allModels
                    ),    
                    'modelTwo' => array( 
                        'typeClass' => EntityType::class,
                        'entityName' => 'Model',
                        'choice_label' => 'name',
                        'required' => false,
                        'label' => 'Modello 2',
                        'choices' => $allModels
                    ),    
                    'isTop' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
                        'required' => true,
                        'label' => 'Top'
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
                    'body' => array( 
                        'typeClass' => TextareaType::class,
                        'attr' => array(
                            'class' => 'ckeditor form-control',
                            'id'    => 'mustHaveId',
                            'style'   => 'heigth:100px;'
                        ),
                        'label' => 'Descrizione Lunga'
                    ),                                       
                )
            )
        );

        $countEntity = count($comparison);

        $buttons = array();

        $formComparison = $this->fm->createForm($comparison, $countEntity, $buttons);
        $formComparison->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formComparison->isSubmitted()) {
            $entityAutoField = array( 'Comparison' => array( ) );
            
            if( empty( $id ) ) {
                $entityAutoField = array(
                    'Comparison' => array(
                        'createDate' => array( 'date' => 'Y-m-d H:i:s' )
                    )
                );
            }
            
            $formComparison = $this->wm->formManager->validateAndSaveForm($formComparison, $comparison, $countEntity, $entityAutoField, 'editComparison');
        }

        return array(
            'comparison' => $formComparison->createView(),
            'pathRoute' => 'listColors',
            'label' => 'Colori'
        );
    }
    
}
