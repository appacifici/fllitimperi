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

class CoreAdminEditDictionary {

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
        if ( !$this->wm->getPermissionCore('category', 'edit' ) )
                return array();
        
        $id = $this->wm->getUrlId();
        
        $categoryImage                = $this->wm->doctrine->getRepository('AppBundle:Dictionary')->findOneById( $id );
        $allSubcategories    = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAll();
        $allTypologies       = $this->wm->doctrine->getRepository('AppBundle:Typology')->findAll();
        
        $nameCat = !empty( $categoryImage ) ? $categoryImage->getName() : '';
        
        $categories = array(
            'Dictionary' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => array( 'id' ),
                'optionsFields' => array(
                    
                    'name' => array( 
                        'typeClass' =>  TextType::class,
                        'label'     => 'Nome',
                        'required'  => false
                    ),
                    'nameUrl' => array( 
                        'typeClass' =>  TextType::class,
                        'label'     => 'Name Url',
                        'required'  => false
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
                    'subcategory' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Sottocategoria',
                        'choices' => $allSubcategories
                    ),
                    'typology' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Tipologia',
                        'choices' => $allTypologies
                    ),
               ),
            )
        );

        $countEntity = count($categories);

        $buttons = array( 
//            'save' => array(
//                'typeClass' => SubmitType::class,
//                'options' => array( 
//                    'label'=> 'Salva Categoria',
//                    'attr' => array(
//                        'class' => 'pull-left btn-success'
//                        
//                    ))
//            ),   
//            'reset' => array(
//                'typeClass' => ResetType::class,
//                'options' => array( 
//                    'label'=> 'Resetta Categoria',
//                    'attr' => array(
//                        'class' => 'pull-left btn-danger'
//                    )
//                ),
//            ),
        );

        $formCategory = $this->fm->createForm($categories, $countEntity, $buttons);
        $formCategory->handleRequest($this->wm->requestStack->getCurrentRequest());
        
        if ($formCategory->isSubmitted()) {
            $entityAutoField = array(
                'Category' => array(
//                    'lastDbId'    => 1,
//                    'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formCategory->getData()->getName() )
                )
            );            
            $formCategory = $this->wm->formManager->validateAndSaveForm($formCategory, $categories, $countEntity, $entityAutoField, 'editDictionary');
        }

        return array(
            'category'  => $formCategory->createView(),
            'image'     => $categoryImage
        );
    }

}
