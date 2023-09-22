<?php

namespace AppBundle\Service\WidgetService;

use AppBundle\Service\FormService\FormManager;
use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoreAdminEditProduct {

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
        if ( !$this->wm->getPermissionCore('product', 'edit' ) )
                return array();
        
        $id = $this->wm->getUrlId();
        
//        $allAffiliations    = $this->wm->doctrine->getRepository('AppBundle:Affiliation')->findAll();
//        $allCategories      = $this->wm->doctrine->getRepository('AppBundle:Category')->findAll();
//        $allSubcategories   = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAll();
//        $allTrademarks      = $this->wm->doctrine->getRepository('AppBundle:Trademark')->findAll();
//        $allTypologies      = $this->wm->doctrine->getRepository('AppBundle:Typology')->findAll();
//        $allModels          = $this->wm->doctrine->getRepository('AppBundle:Model')->findAll();
        
        
        $notAllowedModel = array( 'id', 'fkSubcatAffiliation',
                                'dataImport', 'lastRead', 'lastModify', 'dataDisabled', 'views', 
                                'periodViews', 'disabledViews', 'stockAmount',
            'productExtra', 'affiliation', 'trademark', 'subcategory', 'model','category','typology','images');
        
        
        $products = array(
            'Product' => array(
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
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => false,
                        'formats' => array(
                            'small' => array(
                                'width' => $this->wm->container->getParameter( 'app.imgProducts_width' ),
                                'height' => $this->wm->container->getParameter( 'app.imgProducts_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_imgProductsSmall_write' ),
//                                'format' => 'png'
                            ),                            
                        ),
                        'required' => false,
                        'label' => 'Immagine',
                        'defaultValue' => !empty( $modelImage ) ? $modelImage->getImg() : '',
                        'queryEntityAutoIncrement' => 'Product'
                    ),
                    'price' => array( 
                        'typeClass' =>  MoneyType::class,
                        'required' => false,
                        'label' => 'Prezzo'
                    ),
                    'lastprice' => array( 
                        'typeClass' =>  MoneyType::class,
                        'required' => false,
                        'label' => 'Ultimo Prezzo'
                    ),
                    'prices' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Ultimo Prezzi'
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
                    'manualOff' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),                        
                        'required' => true,
                        'label' => 'Disabiitazione Manuale'
                    ), 
//                    'affiliation' => array( 
//                        'placeholder' => '',
//                        'typeClass' => EntityType::class,
//                        'choice_label' => 'name',
//                        'required' => false, 
//                        'label' => 'Affiliato',
//                        'choices' => $allAffiliations
//                    ), 
//                    'category' => array( 
//                        'placeholder' => '',
//                        'typeClass' => EntityType::class,
//                        'choice_label' => 'name',
//                        'required' => false, 
//                        'label' => 'Categoria',
//                        'choices' => $allCategories
//                    ),
//                    'subcategory' => array( 
//                        'placeholder' => '',
//                        'typeClass' => EntityType::class,
//                        'choice_label' => 'name',
//                        'required' => false, 
//                        'label' => 'Sottocategoria',
//                        'choices' => $allSubcategories
//                    ),
//                    'trademark' => array( 
//                        'placeholder' => '',
//                        'typeClass' => EntityType::class,
//                        'choice_label' => 'name',
//                        'required' => false, 
//                        'label' => 'Marchio',
//                        'choices' => $allTrademarks
//                    ),
//                    'typology' => array( 
//                        'placeholder' => '',
//                        'typeClass' => EntityType::class,
//                        'choice_label' => 'name',
//                        'required' => false, 
//                        'label' => 'Tipologia',
//                        'choices' => $allTypologies
//                    ),
//                    'model' => array( 
//                        'placeholder' => '',
//                        'typeClass' => EntityType::class,
//                        'choice_label' => 'name',
//                        'required' => false, 
//                        'label' => 'Modello',
//                        'choices' => $allModels
//                    )
                )
            )
        );

        $countEntity = count($products);
        $countEntity = 2;

        $buttons = array();

        $formProduct = $this->fm->createForm($products, $countEntity, $buttons);
        $formProduct->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formProduct->isSubmitted()) {
            $entityAutoField = array(
                'Product' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formProduct->getData()->getName() )
                )
            );
            
            $formProduct = $this->wm->formManager->validateAndSaveForm($formProduct, $products, $countEntity, $entityAutoField, 'editProduct');
        }

        return array(
            'product' => $formProduct->createView()
        );
    }
    
}
