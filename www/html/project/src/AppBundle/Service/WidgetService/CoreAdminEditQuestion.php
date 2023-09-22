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

class CoreAdminEditQuestion {

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
        
        $allArticles       = $this->wm->doctrine->getRepository('AppBundle:DataArticle')->findBy(array(),array('labelReleated' => 'ASC'));

        $question = array(
            'Question' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedModel,
                'optionsFields' => array(                    
                    'dataArticle' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'labelReleated',
                        'required' => false, 
                        'label' => 'Guida',
                        'choices' => $allArticles
                    )                                                
                )
            )
        );

        $countEntity = count($question);

        $buttons = array();

        $formQuestion = $this->fm->createForm($question, $countEntity, $buttons);
        $formQuestion->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formQuestion->isSubmitted()) {
            $entityAutoField = array(
                'Question' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formModel->getData()->getName() )
                )
            );
            
            $formQuestion = $this->wm->formManager->validateAndSaveForm($formQuestion, $question, $countEntity, $entityAutoField, 'editQuestion');
        }

        return array(
            'form' => $formQuestion->createView()            
        );
    }
    
}
