<?php

namespace AppBundle\Service\WidgetService;

use AppBundle\Service\FormService\FormManager;
use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class CoreAdminEditBanner {

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager, FormManager $formManager) {
        $this->wm = $widgetManager;
        $this->fm = $formManager; 
    }

    public function processData($options = false) {        
        if( !$this->wm->getPermissionCore( 'banner', 'read' ) )
            return array();
        
        $id = $this->wm->getUrlId();
        
        $banner = $this->wm->doctrine->getRepository( 'AppBundle:Banner' )->find( $id );     
                
        $banners = array(
            'Banner' => array(
                'query' => array(
                    'id' => $id
                ),
                'notAllowed' => array( 'id' ),
                'optionsFields' => array(                     
                    'site' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            
                            'calciomercato.it'  => 'calciomercato.it',
                            'chedonna.it'  => 'chedonna.it',
                        ),
                        'placeholder' => '',
                        'label' => 'Sito',
                        'required' => false
                        
                    ),
                    'screen' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Desktop' => 'desktop',
                            'Mobile'  => 'mobile',
                            'App'  => 'app',
                            'Amp'  => 'amp',
                        ),
                        'placeholder' => '',
                        'label' => 'Versione',
                        'required' => false
                    ),
                    'position' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $this->getPositionsBanner() ,
                        'label' => 'Posizione',
                        'required' => false
                    ),
                    'route' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Home Page' => 'homepage',
                            'Lista Articoli'  => 'listArticles',
                            'Dettaglio Articolo'  => 'detailNews',
                        ),
                        'placeholder' => '',
                        'label' => 'Sezione',
                        'required' => false
                    ),
                    'code' => array(
                        'typeClass' => TextareaType::class,
                        'label' => 'Codice',
                        'required' => false
                    ),
                    'callsCode' => array(
                        'typeClass' => TextareaType::class,
                        'label' => 'Codice Chiamate Librerie',
                        'required' => false
                    ),
                    'codeAmp' => array(
                        'typeClass' => TextareaType::class,
                        'label' => 'Codice AMP',
                        'required' => false,
                        'attr' => array(
                            'height' => '300'
                        )
                    ),
                    'headerCode' => array(
                        'typeClass' => TextareaType::class,
                        'label' => 'Codice Header',
                        'required' => false
                    ),
                    'url' => array(
                        'typeClass' => TextType::class,
                        'label' => 'Url',
                        'required' => false
                    ),
                    'img' => array( 
                        'typeClass' =>  FileType::class,
                        'data_class' => null,
                        'multiple' => true,
                        'formats' => array(
                            'default' => array(
                                'width' => 2000,
                                'height' => 2000,
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_img_banners_write' ),
                            ),                            
                        ),
                        'required' => false,
                        'label' => 'Immagine',
                        'defaultValue' =>  !empty( $banner ) ? $banner->getImg() : '',
//                        'queryEntityAutoIncrement' => 'Image'
                    ),  
                    'isactive' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Non attivo' => 0,
                            'Attivo' => 1,
                            'Test' => 2
                        ),
                        'placeholder' => '',
                        'label' => 'Stato',
                        'required' => false
                    ),
                    'text' => array(
                        'typeClass' => TextareaType::class,
                        'label' => 'Testo'
                    )
                )
            ),
        );
        
        
        $countEntity = count($banners);

        $buttons = array( 
//            'save' => array(
//                'typeClass' => SubmitType::class,
//                'options' => array( 
//                    'label'=> 'Salva Banner',
//                    'attr' => array(
//                        'class' => 'pull-left btn-success'
//                        
//                    ))
//            ),   
//            'reset' => array(
//                'typeClass' => ResetType::class,
//                'options' => array( 
//                    'label'=> 'Resetta Banner',
//                    'attr' => array(
//                        'class' => 'pull-left btn-danger'
//                    )
//                ),
//            ),
        );

        $formBanner = $this->fm->createForm($banners, $countEntity, $buttons);
        $formBanner->handleRequest($this->wm->requestStack->getCurrentRequest());

        $entityAutoField = array(
//            'site' => $this->wm->globalConfigManager->getCurrentDomain()
        );
//        
        
        if ($formBanner->isSubmitted()) {
            $formBanner = $this->fm->validateAndSaveForm($formBanner, $banners, $countEntity, $entityAutoField, 'editBanner');
        }

        $lastArticle = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->getIdLastArticle();
        if (!empty($lastArticle->getCategory()) && $lastArticle->getCategory() != null ) {
            $category       = $this->wm->globalUtility->rewriteUrl( $lastArticle->getCategory()->getName() );
            $titleArticle   = $this->wm->globalUtility->rewriteUrl($lastArticle->getContentArticle()->getTitle());
            $articleId      = $lastArticle->getId();
        }
                
        $urlArticle = $this->wm->container->get('router')->generate('detailNews', array( 
                'articleId'     => $lastArticle->getId(),
                'title'         => $titleArticle,
            ));
        
        
        return array(
            'data'                => $banner,
            'banner'              => $formBanner->createView(),
            'bannersPosition'     => $this->getPositionsBanner(),
            'image'               => $banner,
            'lastArticle'         => $lastArticle,
            'category'            => $category,
            'urlArticle'          => $urlArticle
            );
    }
    
    private function getPositionsBanner() {
        $folder = $this->wm->container->getParameter( 'app.folder_banners' ).'template';
        $aBannerPosition = array();
        $files = scandir($folder);
        
        foreach ( $files as $file ) {
            if( strpos($file, 'banner_', '0' ) !== false ) {
                $position = str_replace( array('banner_','.html.twig'), '', strtolower( $file ) ) ;
                $aBannerPosition[$position] = ucwords(strtolower($position));
            }
        }
        
        return $aBannerPosition;
    }

}
