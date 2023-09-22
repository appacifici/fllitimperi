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

class CoreAdminEditAffiliation {

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
        if ( !$this->wm->getPermissionCore('affiliation', 'edit' ) )
                return array();
        
        $id                     = $this->wm->getUrlId();
        $affiliationImage         = $this->wm->doctrine->getRepository('AppBundle:Affiliation')->findOneById( $id );
        
        $notAllowedAffiliation = array( 'id', 'lastread', 'numproducts', 'views', 'periodviews', 'widthSmall', 'heightSmall', 'widthBig', 'heightBig' );
//        if( $this->wm->container->getParameter( 'admin.subcategoriesType' ) == 'tags' ) {            
//            $notAllowedTrademark[] = 'category';
//        }  
        
        $affiliations = array(
            'Affiliation' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedAffiliation,
                'optionsFields' => array(                    
                    'name' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Nome'
                    ),    
                    'url' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Url'
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
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => true,
                        'formats' => array(
                            'small' => array(
                                'width' => $this->wm->container->getParameter( 'app.imgAffiliations_small_width' ),
                                'height' => $this->wm->container->getParameter( 'app.imgAffiliations_small_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_imgAffiliations_small_write' ),
                                'format' => 'png'
                            ),    
                            'big' => array(
                                'width' => $this->wm->container->getParameter( 'app.imgAffiliations_big_width' ),
                                'height' => $this->wm->container->getParameter( 'app.imgAffiliations_big_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_imgAffiliations_big_write' ),
                                'format' => 'png'
                            )
                        ),
                        'required' => false,
                        'label' => 'Immagine',
                        'defaultValue' => !empty( $affiliationImage ) ? $affiliationImage->getImg() : '',
                        'queryEntityAutoIncrement' => 'Affiliation'
                    )
                )
            )
        );

        $countEntity = count($affiliations);

        $buttons = array();

        $formAffiliation = $this->fm->createForm($affiliations, $countEntity, $buttons);
        $formAffiliation->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formAffiliation->isSubmitted()) {
            $entityAutoField = array(
                'Affiliation' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formAffiliation->getData()->getName() )
                )
            );
            
            $formAffiliation = $this->wm->formManager->validateAndSaveForm($formAffiliation, $affiliations, $countEntity, $entityAutoField, 'editAffiliation');
        }

        return array(
            'affiliation' => $formAffiliation->createView()
        );
    }
    
}
