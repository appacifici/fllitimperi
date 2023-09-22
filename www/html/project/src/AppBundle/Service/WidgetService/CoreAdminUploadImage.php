<?php

namespace AppBundle\Service\WidgetService;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\FormService\FormManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CoreAdminUploadImage extends Controller{
    
     public function __construct( WidgetManager $widgetManager, FormManager $formManager ) {
        $this->wm = $widgetManager;
        $this->fm = $formManager;
    }
    
    public function processData( $options = false ) {        
        $images = array(
            'Image' => array(
                'optionsFields' => array(                   
                    'src' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => false,
                        'formats' => array(
                            'small' => array(
                                'width' => $this->wm->container->getParameter( 'app.img_small_width' ),
                                'height' => $this->wm->container->getParameter( 'app.img_small_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_small_write' ),
                            ),
                            'medium' => array(
                                'width' => $this->wm->container->getParameter( 'app.img_medium_width' ),
                                'height' => $this->wm->container->getParameter( 'app.img_medium_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_medium_write' ),
                            ),
                            'big' => array(
                                'width' => $this->wm->container->getParameter( 'app.img_big_width' ),
                                'height' => $this->wm->container->getParameter( 'app.img_big_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_big_write' ),
                            )
                        ),
                        'required' => false,
                        'label' => 'Immagine'                        
//                        'queryEntityAutoIncrement' => 'Image'
                    ),     
                    
                ),
                'notAllowed' => array(
                    'id',
                    'widthSmall',
                    'heightSmall',
                    'widthMedium',
                    'heightMedium',
                    'widthBig',
                    'heightBig', 
                    'dataArticles', 
                    'search', 
                )
            )
        );
        
        $countEntity = count($images);
        
          $buttons = array(
            'save' => array(
            'typeClass' => SubmitType::class,
            'options' => array( 
                'label' => 'Carica Immagini',
                'attr' => array (
                    'class' => 'btn-success'
                ))
        ));
        
        $formImage = $this->fm->createForm($images, $countEntity, $buttons);
        $formImage->handleRequest($this->wm->requestStack->getCurrentRequest());

        $entityAutoField = array(
            'Image' => 
            array( 'search' => 1 )
        );
        
        
        
        if ($formImage->isSubmitted()) {
            $formImage = $this->wm->formManager->validateAndSaveForm($formImage, $images, $countEntity, $entityAutoField, 'adminUploadImages');
        }

        
        $images = $this->wm->doctrine->getRepository('AppBundle:Image')->findBy( array(), array( 'id' => 'desc'), 20 );
        
        return array(
            'image' => $formImage->createView(),
            'images' => $images
        );
    }     
}

//http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html
//http://symfony.com/doc/current/forms.html
//http://api.symfony.com/3.2/Symfony/Component/Form/Extension/Core/Type/UrlType.html
