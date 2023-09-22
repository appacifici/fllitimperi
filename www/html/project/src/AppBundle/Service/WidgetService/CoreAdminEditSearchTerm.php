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

class CoreAdminEditSearchTerm {

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
        
        $routes = $this->wm->routerManager->getAllRoutes();
        
        // Creare metodi che ritornino solo id e name
        $allCategories      = $this->wm->doctrine->getRepository('AppBundle:Category')->findAll();
        $allSubcategories   = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAll();
        $allTypologies      = $this->wm->doctrine->getRepository('AppBundle:Typology')->findAll();
        
        
        $id = $this->wm->getUrlId();        
        $notAllowedSearchTerm = array( 'id' );

        $searchTerm = array(
            'SearchTerm' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedSearchTerm,
                'optionsFields' => array(                    
                    'name' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Nome'
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
                    'displayLabel' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Label'
                    ),
                    'section' => array( 
                        'typeClass' =>  ChoiceType::class,
                        'label' => 'Sezione',
                        'choices' => array(
                            'List Product' => 'listProduct',
                            'Cat Subcat Typology' => 'catSubcatTypologyProduct',
                        )
                    ),
                    'routeName' => array( 
                        'typeClass' =>  ChoiceType::class,
                        'label' => 'Rotta',
                        'choices' => $routes
                    ),
                    'category' => array( 
                        'typeClass' =>  EntityType::class,
                        'choices' => $allCategories,
                        'choice_label' => 'name',
                        'label' => 'Categoria',
                        'attr' => array(
                            'data-childrens' => '{"subcategory":{"entity":"subcategory","find":"findSubcategoriesByCategory"}}'
                        )
                    ),
                    'subcategory' => array( 
                        'typeClass' =>  EntityType::class,
                        'choices' => $allSubcategories,
                        'choice_label' => 'name',
                        'label' => 'Sottocategoria',
                        'attr' => array(
                            'data-childrens' => '{"typology":{"entity":"typology","find":"findTypologiesBySubcategory"}}'
                        ),
                    ),
                    'typology' => array( 
                        'typeClass' =>  EntityType::class,
                        'choices' => $allTypologies,
                        'choice_label' => 'name',
                        'label' => 'Tipologia'
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
                    'isTested' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
                        'required' => true,
                        'label' => 'Testata'                                  
                    ),
                    'sex' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Scegli' => Null,
                            'Uomo' => 'uomo',
                            'Donna' => 'donna',
                        ),
                        'required' => true,
                        'label' => 'Sesso'
                    )                                   
                )
            )
        );

        $countEntity = count($searchTerm);

        $buttons = array();

        $formSearchTerm = $this->fm->createForm($searchTerm, $countEntity, $buttons);
        $formSearchTerm->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formSearchTerm->isSubmitted()) {
            $entityAutoField = array(
                'SearchTerm' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formModel->getData()->getName() )
                )
            );
            
            $formSearchTerm = $this->wm->formManager->validateAndSaveForm($formSearchTerm, $searchTerm, $countEntity, $entityAutoField, 'editSearchTerm');
        }

        return array(
            'searchTerm' => $formSearchTerm->createView(),
        );
    }
    
}
