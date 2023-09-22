<?php

namespace AppBundle\Service\WidgetService;

use AppBundle\Service\FormService\FormManager;
use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CoreAdminEditDinamycPage {

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager, FormManager $formManager) {
        $this->wm = $widgetManager;
        $this->fm = $formManager;        
    }

    public function processData($options = false) {        
        if( !$this->wm->getPermissionCore( 'dinamycPage', 'read' ) )
            return array();
        
        $id = $this->wm->getUrlId();
        
        $banner = $this->wm->doctrine->getRepository( 'AppBundle:DinamycPage' )->findById( $id );     
        
        if( empty( $id ) )
            $notAllowed = array( 'id' );
        else
            $notAllowed = array( 'id', 'page' );
        
        $banners = array(
            'DinamycPage' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowed,
                'optionsFields' => array(                     
                    'page' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Chi Siamo' => 'aboutUs',
                            'Partner'  => 'partner',
                            'Contatti'  => 'contact',
                            'Pubblicità'  => 'advertising',
                            'Disclaimer'  => 'disclaimer',
                            'Privacy Policy'  => 'privacy-policy',
                            'Credits'  => 'credits',
                            'Redazione'  => 'redazione',
                            'Network'  => 'network',
                        ),
                        'placeholder' => 'Scegli',
                        'label' => 'Pagina',
                        'required' => false
                    ),
                    'body' => array( 
                        'typeClass' => TextareaType::class,
                        'attr' => array(
                            'class' => 'ckeditor form-control',
                            'id'    => 'mustHaveId',
                            'style'   => 'heigth:100px;'
                        ),
                        'label' => 'Testo dell\'articolo'
                    ),
                    
                )
            ),
        );

        $countEntity = count($banners);

        $buttons = array(
            'save' => array(
            'typeClass' => SubmitType::class,
            'options' => array( 'label' => 'Salva Pagina')
        ));

        $formBanner = $this->fm->createForm($banners, $countEntity, $buttons);
        $formBanner->handleRequest($this->wm->requestStack->getCurrentRequest());

        $entityAutoField = array(
            
        );
        
        
        
        if ($formBanner->isSubmitted()) {
            $formBanner = $this->fm->validateAndSaveForm($formBanner, $banners, $countEntity, $entityAutoField, 'editDinamycPage');
        }
        
        return array(
            'data' => $banner,
            'dinamycPage'              => $formBanner->createView(),            
        );
    }
    
 

}
