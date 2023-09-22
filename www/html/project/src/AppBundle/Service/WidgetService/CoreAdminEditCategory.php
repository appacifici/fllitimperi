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

class CoreAdminEditCategory {

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
        
        $categoryImage                = $this->wm->doctrine->getRepository('AppBundle:Category')->findOneById( $id );
        
        $nameCat = !empty( $categoryImage ) ? $categoryImage->getName() : '';
        
        $categories = array(
            'Category' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => array( 'id', 'lastDbId', 'lastTermId', 'hasModels', 'hasProducts' ),
                'optionsFields' => array(
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => false,
                        'formats' => array(
                            'default' => array(
                                'width' => $this->wm->container->getParameter( 'app.img_category_width' ),
                                'height' => $this->wm->container->getParameter( 'app.img_category_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_category_write' ),
                                'format' => 'png',
                                'rewriteName' => $this->wm->globalUtility->getNameImageProduct($nameCat)
                            ),                            
                        ),
                        'required' => false,
                        'label' => 'Immagine',
                        'defaultValue' => !empty( $categoryImage ) ? $categoryImage->getImg() : ''  
//                        'queryEntityAutoIncrement' => 'Image'
                    ),  
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
                    'metaTitle' => array( 
                        'typeClass' =>  TextType::class,
                        'label'     => 'Meta Title',
                        'required'  => false
                    ),
                    'metaDescription' => array( 
                        'typeClass' =>  TextType::class,
                        'label'     => 'Meta Description',
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
                    'metaKeyword' => array( 
                        'typeClass' =>  TextType::class,
                        'label'     => 'Meta Keyword',
                        'required'  => false
                    ),
                    
                    'color' => array(
                        'attr' => array(
                            'class' => 'form-control colorpickerColor1',
                            'value' =>  !empty( $categoryImage ) && !empty( $categoryImage->getColor() ) ? $categoryImage->getColor() : "#5a6a87"
                        ),
                        'label' => 'Colore Testo'
                    ), 
                    'bgColor' => array(
                        'attr' => array(
                            'class' => 'form-control colorpickerColor2',
                            'value' =>  !empty( $categoryImage ) && !empty( $categoryImage->getBgColor() ) ? $categoryImage->getBgColor() : "#5a6a87"
                        ),
                        'label' => 'Colore Sfondo'
                    ),
                    'isactive' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Disattivo' => 0,
                            'Attivo' => 1,
                        ),
                        
//                        'placeholder' => 'Scegli',
                        'required' => true,
                        'label' => 'Stato'
                    ),
                    'isTop' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Top'
                    ),
                    'isReserved' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Sì' => 1,
                        ),
                        
//                        'placeholder' => 'Scegli',
                        'required' => true,
                        'label' => 'Riservata'
                    ),
                    'isTopUserReserved' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Sì' => 1,
                        ),
                        'required' => true,
                        'label' => 'Riservata Top User'
                    )
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
            $formCategory = $this->wm->formManager->validateAndSaveForm($formCategory, $categories, $countEntity, $entityAutoField, 'editCategory');
        }

        return array(
            'category'  => $formCategory->createView(),
            'image'     => $categoryImage
        );
    }

}
