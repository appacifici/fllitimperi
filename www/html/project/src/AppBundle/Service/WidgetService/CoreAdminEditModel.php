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
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoreAdminEditModel {

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
        if ( !$this->wm->getPermissionCore('model', 'edit' ) )
                return array();
        
        $id = $this->wm->getUrlId();
        
        $modelImage          = $this->wm->doctrine->getRepository('AppBundle:Model')->findOneById( $id );
        $allCategories       = $this->wm->doctrine->getRepository('AppBundle:Category')->findAll();
        $allSubcategories    = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAll();
        $allTypologies       = $this->wm->doctrine->getRepository('AppBundle:Typology')->findAll();
        $allTrademarks       = $this->wm->doctrine->getRepository('AppBundle:Trademark')->findBy( array(), array('name' => 'ASC') );                
        $allTecnicalTemplate = $this->wm->doctrine->getRepository('AppBundle:TecnicalTemplate')->findAll();                
        
        $notAllowedModel = array( 'id', 'hasProducts', 'widthSmall', 'heightSmall', 'dateImport', 'externalTecnicalId', 'externalTecnicalTemplate','lastReadPrice' );
//        if( $this->wm->container->getParameter( 'admin.subcategoriesType' ) == 'tags' ) {            
//            $notAllowedModel[] = 'category';
//        }     
        
        $tecnicalTemplate = array();
        $tecnicalTemplate['Scegli'] = 0;
        foreach( $allTecnicalTemplate AS $item ) {
            $tecnicalTemplate[$item->getName()] = $item->getId();
        }
        
        $modelImg = !empty( $modelImage ) ? $modelImage->getName() : '';
        
        $models = array(
            'Model' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedModel,
                'optionsFields' => array(                    
                    'name' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Nome'
                    ),    
                    'metaTitle' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Title'
                    ),  
                    'metaDescription' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Meta Description'
                    ),
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => false,
                        'formats' => array(
                            'small' => array(
                                'width' => $this->wm->container->getParameter( 'app.img_models_width' ),
                                'height' => $this->wm->container->getParameter( 'app.img_models_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_models_write' ),
//                                'format' => 'png'
                                'rewriteName' => $this->wm->globalUtility->getNameImageProduct($modelImg)
                            ),                            
                        ),
                        'required' => false,
                        'label' => 'Immagine',
                        'defaultValue' => !empty( $modelImage ) ? $modelImage->getImg() : '',
                        'queryEntityAutoIncrement' => 'Model'
                    ),
                    'tecnicalTemplate' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false,
                        'label' => 'Scegli Template Scheda Tecnica',
                        'choices' => $allTecnicalTemplate
                    ),
                    'manualUrl' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => false,
                        'formats' => array(
                            'small' => array(
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_manuals_write' ),
                                'rewriteName' => $this->wm->globalUtility->getNameImageProduct($modelImg).'_istruzioni'
                            ),                            
                        ),
                        'required' => false,
                        'label' => 'Manuale',
                        'defaultValue' => !empty( $modelImage ) ? $modelImage->getManualUrl() : '',
                        'queryEntityAutoIncrement' => 'Model'
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
                    'isCompleted' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
                        'required' => true,
                        'label' => 'Dati Completi'
                    ),
                    'isCompleted' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
                        'required' => true,
                        'label' => 'Dati Completi'
                    ),                    
                    'nameUrl' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url'
                    ),
                    'nameUrlPm' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url Scheda PAGOMENO.it'
                    ),
                    'nameUrlIde' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url Scheda IDEALO.IT'
                    ),
                    'nameUrlProductIde' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url Prodotti IDEALO.IT'
                    ),
                    'advisedPrice' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Prezzo Consigliato'
                    ),
                    'bulletPoints' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Bullet Points'
                    ),
                    'technicalSpecifications' => array( 
                        'typeClass' =>  TextareaType::class,
                        'required' => false,
                        'label' => 'Specifiche Tecniche'
                    ),
                    'longDescription' => array( 
                        'typeClass' => TextareaType::class,
                        'attr' => array(
                            'class' => 'ckeditor form-control',
                            'id'    => 'mustHaveId',
                            'style'   => 'heigth:100px;'
                        ),
                        'label' => 'Descrizione Lunga'
                    ),
                    'shortDescription' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false, 
                        'label' => 'Descrizione Corta'
                    ),
                    'revisioned' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
                        'required' => true,
                        'label' => 'Revisionato'
                    ),
                    'isTop' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
                        'required' => true,
                        'label' => 'Top'
                    ),
                    'inShowcase' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
                        'required' => true,
                        'label' => 'In Vetrina'
                    ),                    
                    'category' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Categoria',
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
                    'typology' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Tipologia',
                        'choices' => $allTypologies
                    ),
                    'trademark' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Marchio',
                        'choices' => $allTrademarks
                    ),
                    'groupingProduct' => array( 
                        'typeClass' => TextareaType::class,
                        'attr' => array(
                            'class' => '',
                            'id'    => 'mustHaveId',
                            'style'   => 'heigth:100px;'
                        ),
                        'label' => 'RAGGRUPAMENTO PRODOTI'
                    ),
                    'alphaCheckModel' => array( 
                        'typeClass' => TextareaType::class,
                        'attr' => array(
                            'class' => '',
                            'id'    => 'mustHaveId',
                            'style'   => 'heigth:100px;'
                        ),
                        'label' => 'Alpha ceck'
                    ),
                    'synonyms' => array( 
                        'typeClass' => TextareaType::class,
                        'attr' => array(
                            'class' => '',
                            'id'    => 'mustHaveId',
                            'style'   => 'heigth:100px;'
                        ),
                        'label' => 'Sinonimi'
                    ),
                    'dateRelease' => array( 
                        'typeClass' => DateTimeType::class,
                        'placeholder' => [
                            'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                            'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                        ],
                        'date_widget' => 'single_text',
                        'time_widget' => 'choice',
                        'label' => 'Data Uscita'
                    ),
                )
            )
        );

        $countEntity = count($models);

        $buttons = array();

        $formModel = $this->fm->createForm($models, $countEntity, $buttons);
        $formModel->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formModel->isSubmitted()) {
            $entityAutoField = array(
                'Model' => array(
                    'lastModify' => array( 'date' => 'Y-m-d H:i:s' )
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formModel->getData()->getName() )
                )                
            );
            
            $formModel = $this->wm->formManager->validateAndSaveForm($formModel, $models, $countEntity, $entityAutoField, 'editModel');
        }
        
        $urlModel = '';
        if( !empty( $modelImage ) ) {                        
            if( !empty( $modelImage->getTypology() ) ) {
                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $modelImage->getNameUrl(), 'section1' => $modelImage->getCategory()->getNameUrl(),'section2' => $modelImage->getSubcategory()->getNameUrl(), 'section3' => $modelImage->getTypology()->getNameUrl() ) );
            } else if( !empty( $modelImage->getSubcategory() ) ) {
                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $modelImage->getNameUrl(), 'section1' => $modelImage->getCategory()->getNameUrl(), 'section2' => $modelImage->getSubcategory()->getNameUrl() ) );
            }
            
        }
        
        if( !empty( $modelImage ) ) {
            return array(
                'model' => $formModel->createView(),
                'image' => $modelImage,
                'urlModel' => $urlModel,
                'nameUrlTp' => $modelImage->getNameUrlTp(),
                'nameUrlPm' => $modelImage->getNameUrlPm(),
                'amazonAsinReview' => $modelImage->getAmazonAsinReview(),
                'modelName' => $modelImage->getName(),
                'modelId' => $modelImage->getId(),
            );
        } else {
            return array(
                'model' => $formModel->createView(),
                'image' => $modelImage,
                'urlModel' => $urlModel,
                'nameUrlTp' => '',
                'nameUrlPm' => '',
                'amazonAsinReview' => '',
                'modelName' => '',
                'modelId' => ''
            );
        }                
    }
    
}
