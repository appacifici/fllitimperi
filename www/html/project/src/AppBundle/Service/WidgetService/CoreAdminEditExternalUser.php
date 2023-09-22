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

class CoreAdminEditExternalUser {

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
        if ( !$this->wm->getPermissionCore('externalUser', 'edit' ) )
                return array();
        
        $id = $this->wm->getUrlId();
        
        $notAllowed = array( 'id', 'team', 'profileImg', 'accessToken', 'extUserCode', 'registerAt', 'city', 'age', 'password', 'username' );
        if( !empty( $id ) )
            $notAllowed[] = 'password';

        $users = array(
            'ExternalUser' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowed,
                'optionsFields' => array(
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
                        'label' => 'Cognome',
                    ),
                    'email' => array(
                        'typeClass' => TextType::class,
                        'required' => false
                    ),
                    'isTopUser' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Sì' => 1,
                        ),
                        'required' => true,
                        'label' => 'Top User'
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
            $formUser = $this->fm->validateAndSaveForm($formUser, $users, $countEntity, $entityAutoField, 'editExternalUser');
        }

        return array(
            'user' => $formUser->createView()
        );
    }

}
