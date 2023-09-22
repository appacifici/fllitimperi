<?php

namespace AppBundle\Service\WidgetService;

use AppBundle\Service\FormService\FormManager;
use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoreAdminEditUser {

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
        if ( !$this->wm->getPermissionCore('user', 'edit' ) )
                return array();
        
        $id = $this->wm->getUrlId();
        
        $notAllowed = array( 'id', 'canc', 'close', 'lastDbId', 'isAdmin', 'registerAt' );
        if( !empty( $id ) )
            $notAllowed[] = 'password';

        $users = array(
            'User' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowed,
                'optionsFields' => array(
                    'title' => array( 
                        'typeClass' => TextType::class,
                        'required' => false
                    ),                    
                    'role' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'entityName' => 'Group', 
                        'label' => 'Gruppo Ruoli', 
                        'query_builder' => $this->wm->doctrine->createQueryBuilder()->select('g')->from('AppBundle:Group', 'g')->where('g.id != :identifier')->setParameter('identifier', 1),
                    ),   
                    'name' => array(
                        'typeClass' => TextType::class,
                        'label' => 'Nome',
                        'required' => false,
                        'attr'  => array(
                            'class' => 'pull-left'
                        ),
                    ),
                    'surname' => array(
                        'typeClass' => TextType::class,
                        'required' => false,
                        'label' => 'Cognome'
                    ),
                    'username' => array(
                        'typeClass' => TextType::class,
                        'required' => false,
                        'label' => 'Username'
                    ),
                    'email' => array(
                        'typeClass' => TextType::class,
                        'required' => false
                    ),
                    'password' => array(
                        'typeClass' => TextType::class,
                        'required' => false,
                        'data' => '',
                        'attr' => array(
                            'placeholder' => '* * *',
                        )
                    )
                )
            ),
        );

        $countEntity = count($users);

        $buttons = array( 
//            'save' => array(
//                'typeClass' => SubmitType::class,
//                'options' => array( 
//                    'label'=> 'Salva Utente',
//                    'attr' => array(
//                        'class' => 'pull-left btn-success'
//                        
//                    ))
//            ),   
//            'reset' => array(
//                'typeClass' => ResetType::class,
//                'options' => array( 
//                    'label'=> 'Resetta Utente',
//                    'attr' => array(
//                        'class' => 'pull-left btn-danger'
//                    )
//                ),
//            ),
        );

        $formUser = $this->fm->createForm($users, $countEntity, $buttons);
        $formUser->handleRequest($this->wm->requestStack->getCurrentRequest());

        $entityAutoField = array( 'User' => array(
            'isAdmin' => 1, 'registerAt' => array( 'date' => 'Y-m-d H:i:s' )
        ));
        
        
        
        if ($formUser->isSubmitted()) {
            $formUser = $this->fm->validateAndSaveForm($formUser, $users, $countEntity, $entityAutoField, 'editUser');
        }

        return array(
            'user' => $formUser->createView()
        );
    }

}
