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

class CoreAdminEditMicroSection {

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
        $allTypologies          = $this->wm->doctrine->getRepository('AppBundle:Typology')->findAll();
        $allSubcategories       = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAll();
        $allCategories          = $this->wm->doctrine->getRepository('AppBundle:Category')->findAll();                
        $microSectionImage       = $this->wm->doctrine->getRepository('AppBundle:MicroSection')->findOneById( $id );
        
        $notAllowedMicroSection = array( 'id', 'widthSmall', 'heightSmall' ); 
        $dataChildrensCategories = array(
            'data-childrens' => json_encode( array(  
                    'subcategory' => array('entity' => 'subcategory', 'find' => 'findSubcategoriesByCategory' ),
                )
            )
        );
        $dataChildrensSubcategories = array(
            'data-childrens' => json_encode( array(  
                    'typology' => array('entity' => 'typology', 'find' => 'findTypologiesBySubcategory' ),
                )
            )
        );        
        
        $microsection = array(
            'MicroSection' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedMicroSection,
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
                    'nameUrlTp' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url Sezione TROVAPREZZI.IT'
                    ),
                    'nameUrlPm' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url Sezione PAGOMENO.IT'
                    ),
                    'nameUrlIde' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url Sezione IDEALO.IT'
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
                        'attr' => $dataChildrensSubcategories,
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
                    'description' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Descrizione'
                    ),
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => true,
                        'formats' => array(
                            'default' => array(
                                'width' => $this->wm->container->getParameter( 'app.img_microsection_width' ),
                                'height' => $this->wm->container->getParameter( 'app.img_microsection_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_microsection_write' ),
                                'format' => 'png'
                            ),                            
                        ),
                        'required' => false,
                        'label' => 'Immagine',
                        'defaultValue' => !empty( $microSectionImage ) ? $microSectionImage->getImg() : '',
                        'queryEntityAutoIncrement' => 'MicroSection'
                    ),
                )
            )
        );

        $countEntity = count($microsection);
        $buttons = array();

        $formMicrosection= $this->fm->createForm($microsection, $countEntity, $buttons);
        $formMicrosection->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formMicrosection->isSubmitted()) {
            $entityAutoField = array(
                'Typology' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formTypology->getData()->getName() )
                )
            );
            
            $formMicrosection = $this->wm->formManager->validateAndSaveForm($formMicrosection, $microsection, $countEntity, $entityAutoField, 'editMicroSection');
        }

        return array(
            'microSection' => $formMicrosection->createView()
        );
    }
    
}
