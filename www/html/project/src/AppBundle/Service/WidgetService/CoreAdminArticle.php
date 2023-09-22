<?php

namespace AppBundle\Service\WidgetService;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\FormService\FormManager;
use AppBundle\Service\UserUtility\UserManager;
use \AppBundle\Entity\DataArticle;
use \AppBundle\Entity\ContentArticle;
use \AppBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CoreAdminArticle extends Controller{
    
     public function __construct( WidgetManager $widgetManager, FormManager $formManager, UserManager $userManager ) {
        $this->wm = $widgetManager;
        $this->fm = $formManager;
        $this->um = $userManager;
    }
    
    public function processData( $options = false ) {
        if( !$this->wm->getPermissionCore( 'article', 'read' ) )
            return array();
        
        $articleId = $this->wm->getUrlId(); 
        $validator        = $this->wm->container->get( 'validator' );
        
        $extraConfigEditorMaster = new \stdClass();
        $user = $this->um->getDataUser();

        if( $user->role->name == 'Direttore' || $user->role->name == 'Admin' || $user->role->name == 'Super Admin') {
            $allUsers               = $this->wm->doctrine->getRepository('AppBundle:User')->findAllUsers();
            $extraConfigEditorMaster->notAllowed = '';
            $extraConfigEditorMaster->autoField = '';
            $extraConfigEditorMaster->field = array(
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'entityName' => 'User',
                        'choice_label' => 'surname',
                        'required' => false, 
                        'label' => 'Utente',
                        'choices' => $allUsers
                );

        } else {
            $extraConfigEditorMaster->notAllowed = 'userPublish';
            $extraConfigEditorMaster->autoField = $this->wm->doctrine->getRepository('AppBundle:User')->find($user->id);
            $extraConfigEditorMaster->field = '';
        }
        
        
        $queryDataArticle = $queryContentArticle = $notAllowedDataArticle = false;             
        
        $notAllowedDataArticle = array(
            'id',
            'lastDbId',
            'lastModify',
            'createAt',
            'images',
            'userCreate',
            'priorityImg',
            'views',
            'likes',
            'lastUriWp',
            $extraConfigEditorMaster->notAllowed
        );
        
        $entitiesAutoFieldValue = array(
            'DataArticle' => array(
                'createAt'    => array( 'date' => 'Y-m-d H:i:s' ),
                'lastModify'    => array( 'date' => 'Y-m-d H:i:s' ),
                'publishAt'    => array( 'date' => 'Y-m-d H:i:s' ),             
                'userCreate'    => $this->wm->doctrine->getRepository('AppBundle:User')->find($user->id)
            )
        );
        
        if( !empty( $extraConfigEditorMaster->autoField ) )
            $entitiesAutoFieldValue['DataArticle']['userPublish']   = $extraConfigEditorMaster->autoField;
        
        //entra se è un update da eseguire                
        if( !empty( $articleId ) ) {
            $queryDataArticle    = array( 'id' => $articleId  ); 
            $queryContentArticle = array( 'dataArticle' => $articleId  );            
            
            $entitiesAutoFieldValue = array(
                'DataArticle' => array(
                    'lastModify'    => array( 'date' => 'Y-m-d H:i:s' ),
                ),
            );            
            if( !empty( $extraConfigEditorMaster->autoField ) )
                $entitiesAutoFieldValue['DataArticle']['userPublish']   = $extraConfigEditorMaster->autoField;
        }
        
        $allCategories              = $this->wm->doctrine->getRepository('AppBundle:Category')->findAllCategories();          
        $lastSubcategories          = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findAllSubcategories();    
        $lastTypologies             = $this->wm->doctrine->getRepository('AppBundle:Typology')->findAllTypologies();    
        $lastMegazineSection        = $this->wm->doctrine->getRepository('AppBundle:MegazineSection')->findAll();    
                
        for( $x = 0; $x < 100; $x++ ) {
            $choisesPositions[$x] = $x; 
        }
        
        //Gestisce le due differenti versioni si sottocategorie o per relazione per categoria o a tag libero
        $dataChildrensCategories = array();
        if( $this->wm->container->getParameter( 'admin.subcategoriesType' ) == 'relationship' ) {
            $dataChildrensCategories = array(
                'data-childrens' => json_encode( array(  
                        'subcategoryOne' => array('entity' => 'subcategory', 'find' => 'findSubcategoriesByCategory' ),
                    )
                )
            );
            $dataChildrensSubcategories = array(
                'data-childrens' => json_encode( array(  
                        'typology' => array('entity' => 'typology', 'find' => 'findTypologiesBySubcategory' ),
                    )
                )
            );
            $notAllowedDataArticle[] = 'subcategoryTwo';
        }        
        
        
        $entitiesForm = array(
            'DataArticle' => array(
                'query' => $queryDataArticle,
                'optionsFields' => array(
                    'contentArticle' => array( 
                        'attr' => array(
                            'class' => 'form-control contentArticle',
                            'data_id' => 4                            
                        )
                    ),
                    'megazineSection' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'required' => false, 
                        'label' => 'Megazine Sezione',
                        'choices' => $lastMegazineSection                       
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
                    'subcategoryOne' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'entityName' => 'Subcategory',
                        'required' => false,
                        'label' => 'Sottocategoria',
                        'attr' => $dataChildrensSubcategories,
                        'choices' => $lastSubcategories
                    ),
                    'subcategoryTwo' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'entityName' => 'Subcategory', 
//                        'query_builder' => $this->wm->doctrine->createQueryBuilder()->select('u')->from('AppBundle:Subcategory', 'u')->where('u.id = :identifier')->orderBy('u.name', 'ASC')->setParameter('identifier', 1),
                        'required' => false,
                        'label' => 'Sottocategoria 2',
                        'choices' => $lastSubcategories
                   ),                                                                         
                    'typology' => array( 
                        'placeholder' => '',
                        'typeClass' => EntityType::class,
                        'choice_label' => 'name',
                        'entityName' => 'Typology', 
//                        'query_builder' => $this->wm->doctrine->createQueryBuilder()->select('u')->from('AppBundle:Subcategory', 'u')->where('u.id = :identifier')->orderBy('u.name', 'ASC')->setParameter('identifier', 1),
                        'required' => false,
                        'label' => 'Typologia',
                        'choices' => $lastTypologies
                   ),                                                                         
                    'breakingNews' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
                        
//                        'placeholder' => 'Scegli',
                        'required' => true,
                        'label' => 'Breaking News'
                    ),
                     'exclusive' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
//                        'placeholder' => 'Scegli',
                        'required' => true,
                        'label' => 'Esclusiva'                            
                    ),
                     'isCategoryGuide' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
//                        'placeholder' => 'Scegli',
                        'required' => true,
                        'label' => 'E una guida di categoria?'                        
                    ),     
                    'topNews' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'No' => 0,
                            'Si' => 1,
                        ),
//                        'placeholder' => 'Scegli',
                        'required' => true,
                        'label' => 'Primo Piano'                        
                    ),               
                     'publishAt' => array(
                         'typeClass' => DateTimeType::class,
                        'label' => 'Data di pubblicazione',
                         'attr' => array(
                            'class' => 'form-control',
                        ),
                        'placeholder' => array(
                            'year' => 'Anno', 'month' => 'Mese', 'day' => 'Giorno',
                            'hour' => 'Ora', 'minute' => 'Minuto',
                        ),
                     ),
                     'status' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Disattivo' => 0,
                            'Pubblicato' => 1,
                            'Bozza' => 2,
                        ),
                        'placeholder' => '',
                        'label' => 'Stato'                        
                    ),
                     'topNewsImg' => array( 
                        'typeClass' => FileType::class,
                        'data_class' => null,
                        'label' => 'Immagine Primo Piano',
                         'formats' => array(
                            'default' => array(
                                'width'         => $this->wm->container->getParameter( 'app.imgTopNews_default_width' ),
                                'height'        => $this->wm->container->getParameter( 'app.imgTopNews_default_height' ),
                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_imgTopNews_default_write' ),
                            ),
                        ),
                        'required' => false,                       
                    ),
                    'positionTopNewsImg' => array(
                        'typeClass' => ChoiceType::class,
                        'choices' => $choisesPositions,
                        'placeholder' => '',
                        'label' => 'Posizione Foto Top News'                        
                    ),
                    'negotiationStatus' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Trattativa appena iniziata' => 0,
                            'Trattativa in corso' => 1,
                            'Trattativa vicina alla chiusura' => 2,
                        ),
                        'placeholder' => '',
                        'label' => 'Stato della trattativa'                        
                    ),
                    'opinionCm' => array( 
                        'typeClass' => ChoiceType::class,
                        'choices' => array(
                            'Operazione molto difficile' => 0,
                            'Operazione possibile' => 1,
                        ),
                        'placeholder' => '',
                        'label' => 'Fattibilità dell\'operazione'                        
                    ),
                    'userPublish' => $extraConfigEditorMaster->field
                ),                
                'notAllowed' => $notAllowedDataArticle
            ),
            'ContentArticle' => array(
                'query' => $queryContentArticle,
                'optionsFields' => array(                              
                    'body' => array( 
                        'typeClass' => TextareaType::class,
                        'attr' => array(
                            'class' => 'ckeditor form-control',
                            'id'    => 'mustHaveId',
                            'style'   => 'heigth:100px;'
                        ),
                        'label' => 'Testo dell\'articolo'
                    ),
                    'dataArticle' => array( 
                        'typeClass' => HiddenType::class,//trick per bipassare il settagio del valore in quanto satà settato con l'entita padre in automatico                       
                    ),
                    'title' => array( 
                        'label' => 'Titolo'                        
                    ),
                    'subHeading' => array( 
                        'typeClass' => TextType::class,
                        'required' => false,
                        'label' => 'Sottotitolo'                        
                    ),
                    'metaTitle' => array( 
                        'typeClass' => TextType::class,
                        'label' => 'Meta Title'                        
                    ),
                    'metaDescription' => array( 
                        'typeClass' => TextType::class,
                        'label' => 'Meta Description'                        
                    ),
                    'fbMetaTitle' => array( 
                        'typeClass' => TextType::class,
                        'label' => 'Titolo Facebook'                        
                    ),
                    'twitterMetaTitle' => array( 
                        'typeClass' => TextType::class,
                        'label' => 'Titolo Twitter'                        
                    ),
                    'fbMetaDescription' => array( 
                        'typeClass' => TextType::class,
                        'label' => 'Descrizione Facebook'                        
                    ),
                    'twitterMetaDescription' => array( 
                        'typeClass' => TextType::class,
                        'label' => 'Descrizione Twitter'                        
                    ),
                    'signature' => array( 
                        'typeClass' => TextType::class,
                        'label' => 'Autore'                        
                    ),
                    'source' => array( 
                        'typeClass' => TextType::class,
                        'label' => 'Fonte'                        
                    ),
                    'topScripts' => array( 
                        'typeClass' => TextareaType::class,
                        'label' => 'Top Scripts'                        
                    ),
                    'scripts' => array( 
                        'typeClass' => TextareaType::class,
                        'label' => 'Scripts'                        
                    ),                    
                ),
//                    'videoFile' => array( 
//                        'typeClass' =>  FileType::class,
//                        'data_class' => null,
//                        'multiple' => true,
////                        'queryEntityAutoIncrement' => 'ContentArticle',
//                        'formats' => array(
//                            'default' => array(
//                                'width'         => $this->wm->container->getParameter( 'app.video_default_width' ),
//                                'height'        => $this->wm->container->getParameter( 'app.video_default_height' ),
//                                'pathFileWrite' => $this->wm->container->getParameter( 'app.folder_video_default_write' ),
//                            ),
//                        ),
//                        'required' => false,
//                        'label' => 'File Video'                        
//                    ),
                'notAllowed' => array(
                    'contentArticle',
                    'id',
                    'lastDbId',
                    'lastModify',
                    'images',                    
                    'createAt',
                    'images',
                    'userCreate',
                    'videoFile',
                    'status'
                )
            ),
            
        );        
        
        

        $buttons = array( 
            'save' => array(
                'typeClass' => SubmitType::class,
                'options' => array( 
                    'label'=> 'Salva Articolo',
                    'attr' => array(
                        'class' => 'pull-left btn-success hide'
                        
                    ))
            )          
        ); 
        
        
        $article = $this->wm->doctrine->getRepository( 'AppBundle:ContentArticle' )->findOneByDataArticle( $articleId );
        
        if( !empty( $article ) )
        $articleUrl = $article->getPermalink();
                        
        $countEntity = count( $entitiesForm );
        
        //Creazione HTML form
        $this->fm->setSingularWords( array( 'dataArticles' => 'dataArticle' ) );                
        $this->fm->setPluralWords( array( 'dataArticle' => 'dataArticles', 'contentArticle' => 'contentArticles', 'image' => 'images' ) );        
        
        $form = $this->fm->createForm( $entitiesForm, $countEntity, $buttons, false );                
        $form->handleRequest( $this->wm->requestStack->getCurrentRequest() );
        
        $errors = '';
        if ( $form->isSubmitted() ) {   
            $dataForm = $form->getData();
            
            if( empty( $articleId ) && !empty( $dataForm['title'] ) ) {                
                $permalink = $this->wm->globalUtility->rewriteUrl( $dataForm['title'] );
                $entitiesAutoFieldValue['ContentArticle']['permalink'] = $permalink;
            }
            
            if( empty( $dataForm['publishAt'] ) ) {
                $entitiesAutoFieldValue['DataArticle']['publishAt'] = array( 'date' => 'Y-m-d H:i:s' );                
            }
            
            $form   = $this->fm->validateAndSaveForm( $form, $entitiesForm, $countEntity, $entitiesAutoFieldValue, 'manageArticle' );      
            
        }
                
       if( !empty( $article ))
                $article->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getPermalink() );
        return array( 
            'form' => $form->createView(),
            'article' => $article,
            'articleUrl' => ( !empty( $articleUrl ) ? $articleUrl : null )) ;
    }     
}

//http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html
//http://symfony.com/doc/current/forms.html
//http://api.symfony.com/3.2/Symfony/Component/Form/Extension/Core/Type/UrlType.html
                    
