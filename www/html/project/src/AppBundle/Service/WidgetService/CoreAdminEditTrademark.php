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

class CoreAdminEditTrademark {

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
        if ( !$this->wm->getPermissionCore('trademark', 'edit' ) )
                return array();
        
        $id                     = $this->wm->getUrlId();
        $trademarkImage         = $this->wm->doctrine->getRepository('AppBundle:Trademark')->findOneById( $id );
        
        $notAllowedTrademark = array( 'id', 'ip', 'periodviews', 'numproducts', 'views', 'follows', 'periodfollows' );
//        if( $this->wm->container->getParameter( 'admin.subcategoriesType' ) == 'tags' ) {            
//            $notAllowedTrademark[] = 'category';
//        }  
        
        $trademarks = array(
            'Trademark' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => $notAllowedTrademark,
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
                    'isactive' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Disattivo' => 0,
                            'Attivo' => 1,
                        ),
                        'required' => true,
                        'label' => 'Stato'
                    ),
                    'initletter' => array( 
                        'typeClass' =>  TextType::class,
                        'required' => false,
                        'label' => 'Iniziale'
                    ),
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => true,
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
                        'defaultValue' => !empty( $trademarkImage ) ? $trademarkImage->getImg() : '',
                        'queryEntityAutoIncrement' => 'Trademark'
                    )
                )
            )
        );

        $countEntity = count($trademarks);

        $buttons = array();

        $formTrademark = $this->fm->createForm($trademarks, $countEntity, $buttons);
        $formTrademark->handleRequest($this->wm->requestStack->getCurrentRequest());

        if ($formTrademark->isSubmitted()) {
            $entityAutoField = array(
                'Trademark' => array(
//                   'lastDbId'    => 1,
//                   'nameUrl'     => $this->wm->globalUtility->rewriteUrl_v1( $formTrademark->getData()->getName() )
                )
            );
            
            $formTrademark = $this->wm->formManager->validateAndSaveForm($formTrademark, $trademarks, $countEntity, $entityAutoField, 'editTrademark');
        }

        return array(
            'trademark' => $formTrademark->createView()
        );
    }
    
}
