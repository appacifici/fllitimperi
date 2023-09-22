<?php

namespace AppBundle\Service\WidgetService;

use AppBundle\Service\FormService\FormManager;
use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class CoreAdminEditGroupPermission {

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
        if ( !$this->wm->getPermissionCore('groupPermission', 'edit' ) )
                return array();
        
        $id = $this->wm->getUrlId();
        
        $permission = array(
                            'Nessuno'       => '0-0-0',
                            'Lettura'       => '1-0-0',
                            'Lettura & Modifica'      => '1-1-0',
                            'Lettura & Cancellazione' => '1-0-1',
                            'Tutti' => '1-1-1'
                        );

        $groups = array(
            'Group' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => array( 'id' ),
                'optionsFields' => array( 
                    'article' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Permessi Articoli',
                        'required' => false
                    ),
                    'banner' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Permessi Banner',
                        'required' => false
                    ),
                    'menu' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Permessi Menu',
                        'required' => false
                    ),
                    'category' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Permessi Categorie',
                        'required' => false
                    ),
                    'subcategory' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Permessi Sottocategoria',
                        'required' => false
                    ),
                    'user' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Permessi User',
                        'required' => false
                    ),
                    'extraConfig' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Permessi ExtraConfig',
                        'required' => false
                    ),
                    'groupPermission' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Permessi Gruppi',
                        'required' => false
                    ),
                    'dinamycPage' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Pagine Dinamiche',
                        'required' => false
                    ),
                    'externalUser' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Utenti Esterni',
                        'required' => false
                    ),
                    'affiliation' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Affiliazioni',
                        'required' => false
                    ),
                    'model' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Modelli',
                        'required' => false
                    ),
                    'typology' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Tipologie',
                        'required' => false
                    ),
                    'trademark' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Marchi',
                        'required' => false
                    ),
                    'product' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $permission,
                        'placeholder' => '',
                        'label' => 'Prodotti',
                        'required' => false
                    ),
                )
            ),
        );

        $countEntity = count($groups);

        $buttons = array( 
//            'save' => array(
//                'typeClass' => SubmitType::class,
//                'options' => array( 
//                    'label'=> 'Salva Permessi',
//                    'attr' => array(
//                        'class' => 'pull-left btn-success'
//                        
//                    ))
//            ),   
//            'reset' => array(
//                'typeClass' => ResetType::class,
//                'options' => array( 
//                    'label'=> 'Resetta Permessi',
//                    'attr' => array(
//                        'class' => 'pull-left btn-danger'
//                    )
//                ),
//            ),
        );

        $formGroup = $this->fm->createForm($groups, $countEntity, $buttons);
        $formGroup->handleRequest($this->wm->requestStack->getCurrentRequest());
        
        
        
        if ($formGroup->isSubmitted()) {
            $formGroup = $this->wm->formManager->validateAndSaveForm($formGroup, $groups, $countEntity, false, 'editGroup');
        }
       
        return array(
            'group'              => $formGroup->createView(),
        );
    }
}
