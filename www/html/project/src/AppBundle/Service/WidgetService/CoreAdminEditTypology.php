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

class CoreAdminEditTypology {

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
//        if ( !$this->wm->getPermissionCore('typology', 'edit' ) )
//                return array();
        
        $id                     = $this->wm->getUrlId();
        $allSubcategories       = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAll();
        $allCategories          = $this->wm->doctrine->getRepository('AppBundle:Category')->findAll();
                
        $notAllowedTypology = array( 'id', 'periodViews', 'numProducts', 'views' );
//        if( $this->wm->container->getParameter( 'admin.subcategoriesType' ) == 'tags' ) {            
//            $notAllowedTypology[] = 'category';
//        }  
        $dataChildrensCategories = array(
                'data-childrens' => json_encode( array(  
                        'subcategory' => array('entity' => 'subcategory', 'find' => 'findSubcategoriesByCategory' ),
                    )
                )
            );
        
        $typologyImage                = $this->wm->doctrine->getRepository('AppBundle:Typology')->findOneById( $id );
        $nameCat = !empty( $typologyImage ) ? $typologyImage->getName() : '';
        
        $typologies = array(
            'Typology' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedTypology,
                'optionsFields' => array(      
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => false,
                        'formats' => array(
                            'default' => array(
                                'width' => $this->wm->container->getParameter( 'app.img_typologies_width' ),
                                'height' => $this->wm->container->getParameter( 'app.img_typologies_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_typologies_write' ),
                                'format' => 'png',
                                'rewriteName' => $this->wm->globalUtility->getNameImageProduct($nameCat)
                            ),                            
                        ),
                        'required' => false,
                        'label' => 'Immagine',
                        'defaultValue' => !empty( $typologyImage ) ? $typologyImage->getImg() : ''  
//                        'queryEntityAutoIncrement' => 'Image'
                    ),
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
                    'isTop' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Top'
                    ),    
                    'hasModels' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Has Model',
                        'empty_data' => 0,
                    ),    
                    'hasProducts' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Has Product',
                        'empty_data' => 0,
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
                    'filterModelCompleted' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Disattivo' => 0,
                            'Attivo' => 1,
                        ),                        
                        'required' => true,
                        'label' => 'Filtra Lista X Completati'
                    ), 
                    'filterSimilarModels' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Disattivo' => 0,
                            'Attivo' => 1,
                        ),                        
                        'required' => true,
                        'label' => 'Filtro Modelli simili'
                    ),
                    'filterAllModelsTrademark' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Disattivo' => 0,
                            'Attivo' => 1,
                        ),                        
                        'required' => true,
                        'label' => 'Link tutti i Modelli Marchio'
                    ), 
                    'category' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Categoria',
                        'attr' => $dataChildrensCategories,
                        'choices' => $allCategories
                    ),
                    'subcategory' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Sottocategoria',
                        'choices' => $allSubcategories
                    ),    
                    'description' => array( 
                        'typeClass' =>  TextareaType::class, 
                        'label'     => 'Descrizione',
                        'attr' => array(
                            'class' => 'ckeditor form-control',
                            'id'    => 'mustHaveId',
                            'style'   => 'heigth:50px;'
                        ),
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
                )
            )
        );

        $countEntity = count($typologies);
        $buttons = array();

        $formTypology = $this->fm->createForm($typologies, $countEntity, $buttons);
        $formTypology->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formTypology->isSubmitted()) {
            $entityAutoField = array(
                'Typology' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formTypology->getData()->getName() )
                )
            );
            
            $formTypology = $this->wm->formManager->validateAndSaveForm($formTypology, $typologies, $countEntity, $entityAutoField, 'editTypology');
        }

        return array(
            'typology' => $formTypology->createView()
        );
    }
    
}
