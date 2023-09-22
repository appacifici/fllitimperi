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

class CoreAdminEditSubcategory {

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
        if ( !$this->wm->getPermissionCore('subcategory', 'edit' ) )
                return array();
        
        $id = $this->wm->getUrlId();
        
        $subcategoryImage       = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findOneById( $id );
        $allCategories          = $this->wm->doctrine->getRepository('AppBundle:Category')->findAllCategories();
        
        
        $notAllowedCategory = array( 'id', 'lastDbId', 'lastTermId', 'isTeam');
        if( $this->wm->container->getParameter( 'admin.subcategoriesType' ) == 'tags' ) {            
            $notAllowedCategory[] = 'category';
        }             
        
        $subcategories = array(
            'Subcategory' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedCategory,
                'optionsFields' => array(                    
                    'name' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Nome'
                    ),    
                    'metaTitle' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Title Notizie'
                    ),    
                    'metaKeyword' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Keyword Notizie'
                    ),    
                    'metaDescription' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Description Notizie'
                    ),    
                    'metaTitleTM' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Title Calciomercato'
                    ),    
                    'metaKeywordTM' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Keyword Calciomercato'
                    ),    
                    'metaDescriptionTM' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Description Calciomercato'
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
                    'seeAlso' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Vedi anche'
                    ),
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => false,
                        'formats' => array(
                            'default' => array(
                                'width' => $this->wm->container->getParameter( 'app.img_subcategories_width' ),
                                'height' => $this->wm->container->getParameter( 'app.img_subcategories_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_subcategories_write' ),
                                'format' => 'png'
                            ),                            
                        ),
                        'required' => false,
                        'label' => 'Immagine',
                        'defaultValue' => !empty( $subcategoryImage ) ? $subcategoryImage->getImg() : '',
                        'queryEntityAutoIncrement' => 'Subcategory'
                    ), 
                    'color' => array(
                        'attr' => array(
                            'class' => 'form-control colorpickerColor1',
                            'value' =>  !empty( $subcategoryImage ) && !empty( $subcategoryImage->getColor() ) ? $subcategoryImage->getColor() : "#5a6a87"
                        ),
                        'label' => 'Colore Testo'
                    ), 
                    'bgColor' => array(
                        'attr' => array(
                            'class' => 'form-control colorpickerColor2',
                            'value' =>  !empty( $subcategoryImage ) && !empty( $subcategoryImage->getBgColor() ) ? $subcategoryImage->getBgColor() : "#5a6a87"
                        ),
                        'label' => 'Colore Sfondo'
                    ),
                    'isactive' => array( 
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
                    'isTop' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Top'
                    ),
                    'category' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Categoria',
                        'choices' => $allCategories
                    )
                )
            )
        );

        $countEntity = count($subcategories);

        $buttons = array( 
//            'save' => array(
//                'typeClass' => SubmitType::class,
//                'options' => array( 
//                    'label'=> 'Salva Sottocategoria',
//                    'attr' => array(
//                        'class' => 'pull-left btn-success'
//                        
//                    ))
//            ),   
//            'reset' => array(
//                'typeClass' => ResetType::class,
//                'options' => array( 
//                    'label'=> 'Resetta Sottocategoria',
//                    'attr' => array(
//                        'class' => 'pull-left btn-danger'
//                    )
//                ),
//            ),
        );

        $formTeam = $this->fm->createForm($subcategories, $countEntity, $buttons);
        $formTeam->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formTeam->isSubmitted()) {
            $entityAutoField = array(
                'Subcategory' => array(
                   'lastDbId'    => 1
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formTeam->getData()->getName() )
                )
            );
            
            $formTeam = $this->wm->formManager->validateAndSaveForm($formTeam, $subcategories, $countEntity, $entityAutoField, 'editSubcategory');
        }

        return array(
            'subcategory' => $formTeam->createView(),
            'image' => $subcategoryImage 
        );
    }
    
}
