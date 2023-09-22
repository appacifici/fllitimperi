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


class CoreAdminEditTecnicalTemplate {

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
//        if ( !$this->wm->getPermissionCore('trademark', 'edit' ) )
//                return array();
        
        $id       = $this->wm->getUrlId();
        $tecnicalTemplate = $this->wm->doctrine->getRepository('AppBundle:TecnicalTemplate')->findOneById( $id );
        
        $notAllowedTecnical = array( 'id' );
//        if( $this->wm->container->getParameter( 'admin.subcategoriesType' ) == 'tags' ) {            
//            $notAllowedTrademark[] = 'category';
//        }  
        
        $tecnical = array(
            'TecnicalTemplate' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedTecnical,
                'optionsFields' => array(                    
                    'name' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Nome'
                    ),    
                    'nameUrl' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url'
                    ),    
                    'template' => array( 
                        'typeClass' =>  TextareaType::class,
                        'required' => false, 
                        'label' => 'Template'
                    ),                    
                    'vocabulary' => array( 
                        'typeClass' =>  TextareaType::class,
                        'required' => false, 
                        'label' => 'Vocabolario termini'
                    ),                    
                    'bulletPoints' => array( 
                        'typeClass' =>  TextareaType::class,
                        'required' => false, 
                        'label' => 'Bullet Points'
                    )                    
                )
            )
        );

        $countEntity = count($tecnical);

        $buttons = array();

        $formTecnical = $this->fm->createForm($tecnical, $countEntity, $buttons);
        $formTecnical->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formTecnical->isSubmitted()) {
            $entityAutoField = array(
                'TecnicalTemplate' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formTrademark->getData()->getName() )
                )
            );
            
            $formTecnical = $this->wm->formManager->validateAndSaveForm($formTecnical, $tecnical, $countEntity, $entityAutoField, 'editTecnicalTemplate');
        }

        return array(
            'tecnical' => $formTecnical->createView()
        );
    }

}
