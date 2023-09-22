<?php

namespace AppBundle\Service\FormService;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Twig_Environment as Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Service\UtilityService\GlobalUtility;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

//use \AppBundle\Entity\DataArticle;
//use \AppBundle\Entity\ContentArticle;

class FormManager {

    protected $twig;
    protected $doctrine;
    protected $memcached;
    protected $requestStack;
    protected $mobileDetector;
    protected $container;
    protected $customOptionsFiels = array(
        'typeClass', 'entityName', 'formats', 'queryEntityAutoIncrement', 'defaultValue', 'children', 'json_encode'
    );
    protected $singularWorld    = array();
    protected $pluralWorld      = array();
    
    const LAYER_NAMESPACE       = '\\AppBundle\\Entity';
    


    /**
     * Oggetti che devono essere disponibili su tutti i widget
     * @param \Symfony\Component\Templating\EngineInterface $templating
     */
    public function __construct(
        Environment $twig, RequestStack $requestStack, ObjectManager $doctrine, GlobalUtility $globalUtility, Container $container
    ) {
        $this->twig             = $twig;
        $this->requestStack     = $requestStack;
        $this->doctrine         = $doctrine;
        $this->container        = $container;
        $this->globalUtility    = $globalUtility;
        $this->browserUtility   = $globalUtility->browserUtility;
        $this->cacheUtility     = $globalUtility->cacheUtility;
        $this->imageUtility     = $globalUtility->imageUtility;
        $this->fileUtility      = $globalUtility->fileUtility;
        $this->memcached        = $this->cacheUtility->initPhpCache();
        
        $this->validator        = $this->container->get( 'validator' );
    }

    /**
     * Metodo che instanzia la classe entita richiesta
     * @param type $entityName
     * @return \AppBundle\Entity\ImageArticle|\AppBundle\Entity\DataArticle|\AppBundle\Entity\ContentArticle
     */
    public function createUse( $entityName ) {
        $className = self::LAYER_NAMESPACE . '\\' . ucfirst( $entityName ) ;
        return new $className();        
    }
    
    /**
     * Genera i nomi al singolare
     * @param type $singularWorld
     */
    public function setSingularWords( $singularWorld ) {
        $this->singularWorld = $singularWorld;
    }
    
    
    /**
     * Recupera il nome al singolare
     */
    public function getSingularWords( $singularWorld ) {
        return !empty( $this->singularWorld[$singularWorld] ) ? $this->singularWorld[$singularWorld] : $singularWorld;
    }
    
    /**
     * Setta i nomi al plurale
     */
    public function setPluralWords( $pluralWorld ) {
        $this->pluralWorld = $pluralWorld;
    }
    
    /**
     * Recupera il nome al plurale
     * @param type $pluralWorld
     * @return type
     */
    public function getPluralWords( $pluralWorld ) {
        return !empty( $this->pluralWorld[$pluralWorld] ) ? $this->pluralWorld[$pluralWorld] : $pluralWorld;
    }
    
    
    /**
     * Metodo che genera il form im maniera dinamica a partire dall'array di configurazione che viene passato dal chiamante
     * @param type $aFormElement
     * @return type
     */
    public function createForm( $aFormElement, $countEntity, $buttons = false ) {
        $aForms = array();
        $columns = array();

        if ( !empty( $aFormElement ) ) {
            
//            $form = $this->container->get('form.factory')->createBuilder(FormType::class, array(
//                $this->doctrine->getRepository('AppBundle:DataArticle')->findOneBy(array('id' => 14)),
//                $this->doctrine->getRepository('AppBundle:ContentArticle')->findOneBy(array('id' => 14)),
//                $this->doctrine->getRepository('AppBundle:Image')->findOneBy(array('id' => 14))
//                    ));
//                    
            //Creazione builder form generico
            $form = $this->container->get( 'form.factory' )->createBuilder( );            
            
            foreach ( $aFormElement as $entityName => $item ) {             
                $lastEntity = false;
                
                //Vede se c'è una query da eseguire in caso di update del record
                if( !empty( $item['query'] ) ) {
                    $lastEntity = $this->doctrine->getRepository('AppBundle:'.$entityName)->findOneBy( $item['query'] );                    
                }
                               
//                echo $entityName;
                //Chiama il metodo che instanzia la classe entita richiesta
                $entity = $this->createUse( $entityName );
                
                //Se l'entità passata nell array di configurazione è una sola mantengo la compatibilita con il sistema nativo
                //dei form di symfony
                if(  $countEntity == 1 ) {
                    //se è riuscito a recuperare l'entita esistente dalla query
                    if( !empty( $lastEntity ) ) {
                        $form = $this->container->get( 'form.factory' )->createBuilder( FormType::class, $lastEntity );
                    } else {
                        //Crea entita nuova per inserimento nel db
                        $form = $this->container->get( 'form.factory' )->createBuilder( FormType::class, $entity );
                        
                    }
                }    
                
                
                //Recupera il path di symfony dell'entita
                $className = $this->doctrine->getClassMetadata(get_class($entity))->getName();
                                
                //Recupera i campi dell'entita
                $entityColumns = $this->doctrine->getClassMetadata( $className )->getFieldNames();
                
                //Recupera i campi associali dell'entita che sono relazioni e li mergia con i campi normali recuperati sotto
                $columns = array_merge($entityColumns, $this->doctrine->getClassMetadata( $className )->getAssociationNames());

                //Cicla tutte le colonne dell'entità
                foreach ( $columns as $column ) {                    
                    if( !empty( $item['notAllowed'] ) &&  in_array( $column, $item['notAllowed'] ) ) {                        
                        continue;
                    }
                    
                    //Se il campo è una relazione, ma NON E' un capo reale del db salta il campo
                    if( !in_array( $column, $entityColumns) && !$this->doctrine->getClassMetadata( $className )->isAssociationWithSingleJoinColumn( $column ) ) {
                        continue;
                    }
                    
                    //Recupera le opzioni da passare alla creazione del campo del form
                    $senderOptions = $this->getSenderOptions( $item, $column );
                    
                    $typeColumns = $this->doctrine->getClassMetadata( get_class( $entity ) )->getTypeOfField( $column );
                    $typeClass = $this->setTypeClass ($typeColumns, $column, $item );

                    //Chiama il metodo per settare le opzioni per igni campo ed in particola modo di quale entità fa parte
                    $option = $this->setOption( $typeClass, $column, $entityColumns, $className, $senderOptions, $lastEntity );
                    
                    //Aggiunge la colonna al form
                    $form->add( $column, $typeClass, $option );
                }
            }                      
            
            //Controlla se sono stati definiti bottoni aggiuntivi nelle cofigurazioni
            if( empty( $buttons ) ) {
                $form->add('save', SubmitType::class, array( 'label'=> 'Salva') );
            } else {
                foreach( $buttons AS $key => $button ) {
                    $form->add($key, $button['typeClass'], $button['options'] );
                }
            }            
                                                            
            return $form->getForm();
        }
    }
    
    /**
     * Metodo che controlla se nell'oggetto di configurazione del form il campo ha delle opzioni aggiuntive di default
     * @param object $item
     * @param stringa $column
     * @return boolean|object
     */
    private function getSenderOptions( $item, $column ) {
        if( empty( $item['optionsFields'] ) ) {
            return false;
        }
         if( empty( $item['optionsFields'][$column] ) ) {
            return false;
        }
         return $item['optionsFields'][$column];
    }

    /**
     * Determina la mappatura del tipo di campo tra doctrine e il formBuilder
     * @param string $typeColumns
     * @param string $column
     * @return string
     */
    public function setTypeClass( $typeColumns, $column, $options ) {
        switch ( $typeColumns ) {
            case 'text':
                $typeClass = TextType::class;
            break;
            case 'integer':
                $typeClass = IntegerType::class;
            break;
            case 'datetime':
                $typeClass = DateTimeType::class;
            break;
            default:
                $typeClass = TextType::class;
            break;
        }

        //Se nell'oggetto di configurazione dell'entita nel form è definita di che genere deve essere il campo
        if( !empty( $options['optionsFields'][$column] ) && !empty( $options['optionsFields'][$column]['typeClass'] ) ) {
            $typeClass = $options['optionsFields'][$column]['typeClass'];
        }
        
        return $typeClass;
    }

    /**
     * Setta le opzioni richieste per ogni campo nel form
     * @param type $typeClass
     * @param string $column
     * @param type $entityName
     * @return type
     */
    public function setOption( $typeClass, $column, $entityColumns, $entityName, $senderOptions, $lastEntity ) {
        $columnEntityName = $column;               
        $options = array();                
                
        //Se è un entita il campo
        if ( strpos($typeClass, 'EntityType', '0') !== false) {            
            //Se nelle configurazioni dell'entita del form c'è settato quale entita lanciare per il campo usa quella specificata 
            if( !empty( $senderOptions['entityName'] ) )
                $columnEntityName = $senderOptions['entityName'];
            
            $options['class'] = 'AppBundle:' . $columnEntityName;     
            $choice_label = $senderOptions['choice_label'];
            
            $options['choice_label'] = $choice_label;
            
            if( !empty( $lastEntity ) ) {
                $fnGet = 'get'.ucfirst( $column );
//                echo $column.' <br>';
                $options['data'] = $lastEntity->$fnGet();
            }
            
        } else if (strpos($typeClass, 'ChoiceType', '0') !== false) {
            $options['choices'] = (array)$senderOptions['choices'];
            if( !empty( $senderOptions['placeholder'] ) )
                $options['placeholder'] = $senderOptions['placeholder'];
        }
        
        //Se è un entita gia esistente setta il valore con quello gia esistente nel db
        if( !empty( $lastEntity ) && in_array( $column, $entityColumns) ) {
            $fnGet = 'get'.ucfirst( $column );
            
            $options['data'] = !is_array( $lastEntity->$fnGet() ) ? $lastEntity->$fnGet() : json_encode( $lastEntity->$fnGet() );
        }
        
        
        if( empty( $senderOptions['attr'] ) ) {
            $options['attr'] = array(
                'class' => $column
            );        
        } else { 
            $options['attr'] = $senderOptions['attr'];
        }   
        
        
        //Imposta le opzioni settate nell'array di configurazione
        if( !empty( $senderOptions ) ) {
            foreach ( $senderOptions AS $key => $value ) {
                //saltiamo la nostra opzione custom
                if( in_array( $key, $this->customOptionsFiels ) )
                    continue;
                
                $options[$key] = $value;
            }
        }
        
        $validationHtml = !empty( $senderOptions['required'] ) ? $senderOptions['required'] : false;
        
        $options['required'] = $validationHtml;

        
        return $options;
    }
    
    /**
     * Metodo che crea un nuovo form di appoggio con i valori cambiati e ne fa la validazione se tutto va a buon fine salva il form originale cambiato
     * @param fotm $form
     * @param array $entitiesForm
     * @param int $countEntity
     * @param array $entitiesAutoFieldValue
     */
    public function validateAndSaveForm( $form, $entitiesForm, $countEntity, $entitiesAutoFieldValue, $redirectToRoute = false ) {                
        $entities = $this->manageEntityForm( $form->getData(), $entitiesForm, $countEntity, $entitiesAutoFieldValue, false, $redirectToRoute );                 
        $errors = $this->validator->validate( $entities );
        
        if( count( $errors ) == 0 ) {
            
            //Salvataggio form            
            $this->manageEntityForm( $form->getData(), $entitiesForm, $countEntity, $entitiesAutoFieldValue, true, $redirectToRoute, $entities );
            
        } else {            
            if( is_object( $entities ) == 1 && !is_null( $entities ) )
                return $form;
                
            foreach( $errors  AS $error ) {
                $property = explode( '.',  $error->getPropertyPath() );
                $field = !empty( $property[1] ) ? $property[1] : $property[0];
     
                $errorForm = new FormError( $error->getMessage() );                    
                $form->get($field)->addError( $errorForm );
            }
        }
        return $form;
    }
    
    /**
     * Metodo che si occupa dell'inserimento dell'entita
     * @param type $form
     * @param type $entitiesForm
     */    
    public function manageEntityForm( $form, $entitiesForm, $countEntity, $entitiesAutoFieldValue, $flush = true, $redirectToRoute = false, $entitiesPersist = false ) {
        $aPersistEntity = array();
        $em = $this->doctrine;
                
        foreach ( $entitiesForm as $entityName => $item ) {
            /******************************************************************************************************************************************************/
            /********************************************** GESTISCE IL NORMALE FUNZIONAMENTO DEI FORM SYMFONY  ***************************************************/
            /******************************************************************************************************************************************************/
            if(  $countEntity == 1 ) {
                $entity = $form;        
                
                //Controlla se dopo aver fatto il set dei campi visibili del form deve settare qualcosa in automatico prendendolo dai 
                //campi settati nel indice setFieldsNotInForm dell'oggetto di configurazione e ne fa il set su doctrine
                if( !empty( $entitiesAutoFieldValue ) && !empty( $entitiesAutoFieldValue[$entityName] ) ) {
                    foreach( $entitiesAutoFieldValue[$entityName] AS $key => $field ) {
                        $value = $this->setAutoFieldValue( $field );                    
                        $fnSet = 'set'. ucfirst( $key );
                        $entity->$fnSet( $value );
                    }                
                }                 
                
                if( empty( $flush ) ) {
                    foreach( $item['optionsFields'] AS $key => $optionField ) {
                        if( !empty( $optionField['typeClass'] ) && $optionField['typeClass'] == FileType::class  ) {   
                                                        
                            $fnGet = 'get'.ucfirst( $key );
                            $fnSet = 'set'.ucfirst( $key );                                                        
                            
                            if( !empty( $form->$fnGet() )  ) {                                
                                
                                $titleImg = method_exists( $form, 'getTitleImg' ) ? $form->getTitleImg() : false;
                                foreach( $optionField['formats'] AS $key => $value ) {
                                    if( empty( $optionField['formats'][$key]['rewriteName'] ) )
                                        $optionField['formats'][$key]['rewriteName'] = $this->globalUtility->rewriteUrl( $titleImg );
                                }                                
                                
                                $resPhotos = $this->uploadFile ( $form->$fnGet(), $optionField, $entityName, $entity, $key );                                     
                                if( empty( $resPhotos ) ) {
                                   
                                    $entity->$fnSet( $optionField['defaultValue'] );
                                    continue;
                                }
                                
                                foreach( $resPhotos AS $resPhoto ) {
                                    $entity->$fnSet( $resPhoto['src'] );
                                }
                                
                                if( empty( $resPhotos ) ) {
                                    $entity->$fnSet( null );
                                }
                                
                                        //Setta dimenzioni se presenti
                                if( !empty( $resPhoto['dim'] ) ) {
                                    foreach( $resPhoto['dim'] AS $key => $photo) {                                
                                        foreach( $photo AS $key2 => $photo2) {                                    
                                            $fnSet = 'set'. ucfirst( $key ).ucfirst( $key2 );
        //                                    echo $fnSet."\n";
                                            if( method_exists( $entity, $fnSet ) )
                                                $entity->$fnSet( $photo2 );
                                        }
                                    }
                                }
//                            } else if( ( is_array( $entity->getImg() ) && empty( $entity->getImg() ) ) || empty( $entity->getImg() ) ) {
                            } else if( ( !empty(  $optionField['defaultValue'] ) ) ) {                                
                                $entity->$fnSet( $optionField['defaultValue'] );                                
                            }
                        }
                    }
                }

                $em = $this->doctrine;
                $em->persist( $entity );
                
                if( $flush ) {     
                    $em->flush();                                
                    if( !empty( $redirectToRoute ) ) {
                        $href = $this->container->get('router')->generate(
                            $redirectToRoute,
                            array('id' => $entity->getId() )
                        );     
                        header('Location: '.$href.'?resp=1'); 
                        exit;
                    }                    
                }
                return $aPersistEntity[$entityName] = $entity;   
            }            
            
            /******************************************************************************************************************************************************/
            /************************************************************ AVVIA LA GESTIONE DI PIU FORM ASSIEME ***************************************************/
            /******************************************************************************************************************************************************/
            
            //Dopo aver fatto la valizazione senza rifar tutto fa il flush
            if( $flush ) {
                $em->flush();

                if( !empty( $redirectToRoute ) ) {  
                    
                    if(is_array( $redirectToRoute ) ) {                        
                        $href = $this->container->get('router')->generate(
                            key( $redirectToRoute ),
                            $redirectToRoute[key( $redirectToRoute )]
                        ); 
                        header('Location: '.$href.'?resp=1'); 
                        exit;
                    } else {
                        $href = $this->container->get('router')->generate(
                            $redirectToRoute,
                            array('id' => $entitiesPersist[key( $entitiesForm )]->getId() )
                        );     
                        header('Location: '.$href.'?resp=1'); 
                        exit;
                    }
                }
            } 
            
            $entity = false;                
            if( !empty( $item['query'] ) ) {
                $entity = $this->doctrine->getRepository('AppBundle:'.$entityName)->findOneBy( $item['query'] );   
                if( empty( $entity ) )
                    $entity = $this->createUse( $entityName );
            } else {
                //Chiama il metodo che instanzia la classe entita richiesta
                $entity = $this->createUse( $entityName );
            }
            
            
            //Recupera il path di symfony dell'entita
            $meta = $this->doctrine->getClassMetadata( get_class( $entity ) );
            $className = $meta->getName();
            $sPrimaryKeyName = $meta->getSingleIdentifierFieldName();
            
            //Recupera i campi dell'entita
            $entityColumns = $this->doctrine->getClassMetadata( $className )->getFieldNames();

            //Recupera i campi associali dell'entita che sono relazioni e li mergia con i campi normali recuperati sotto
            $columns = array_merge($entityColumns, $this->doctrine->getClassMetadata( $className )->getAssociationNames());
                        
            /******************************************************************************************************************************************************/
            /**************************************************************** AVVIA IL SET SULLE ENTITA ***********************************************************/
            /******************************************************************************************************************************************************/
            //si cicla tutte le colonne dell'entita e crea il setter 
            foreach( $columns AS $column ) {                             
                if( !empty( $item['notAllowed'] ) &&  in_array( $column, $item['notAllowed'] ) ) {                        
                    continue;
                }
                               
                //Se il campo che sta ciclando attualmente è la primary key dell'entita ignora il campo
                if( $column == $sPrimaryKeyName )
                    continue;                                                
                
                //Se il campo non è realmente presente nel database e non ha un associazione joinColumn e NON E' un array collection
                if( !in_array( $column, $entityColumns) 
                    && !$this->doctrine->getClassMetadata( $className )->isAssociationWithSingleJoinColumn( $column ) 
                    && !$this->doctrine->getClassMetadata( $className )->isCollectionValuedAssociation(  $column )
                ) {
                    continue;
                }
                
                //Se il tipo e un upload dei file gestisco differentemente, avvio il caricamento delle immagini sul server e salvo i dati delle
                //immagini create nell'entità
                
                if( empty( $flush ) && !empty( $item['optionsFields'][$column] ) && !empty( $item['optionsFields'][$column]['typeClass'] ) && $item['optionsFields'][$column]['typeClass'] == FileType::class ) {                    
                    $resPhotos = $this->uploadFile ( $form[$column], $item['optionsFields'][$column], $entityName, $entity, $column );                                    
                                        
                    if( empty( $resPhotos ) && $entityName == 'Image' ) {
                        $entity = false;
                        continue;
                    }
                    
                    foreach( $resPhotos AS $resPhoto ) {                        
                        //Se gli elementi da inserire sono più di 1 significa che sta lavorando su un entita collezione quindi ogni volta, fa inserito un nuovo record
                        //e quindi ogni iterazione va rigenerata un entita da inserire nel persist per il successivo flus
                        if( count( $resPhotos) > 1 )
                            $entity = $this->createUse( $entityName );
                    
                        $fnSet = 'set'. ucfirst( $column );
                        $entity->$fnSet( $resPhoto['src'] );                       
                        
                        //Setta dimenzioni se presenti
                        if( !empty( $resPhoto['dim'] ) ) {
                            foreach( $resPhoto['dim'] AS $key => $photo) {                                
                                foreach( $photo AS $key2 => $photo2) {                                    
                                    $fnSet = 'set'. ucfirst( $key ).ucfirst( $key2 );
//                                    echo $fnSet."\n";
                                    if( method_exists( $entity, $fnSet ) )
                                        $entity->$fnSet( $photo2 );
                                }
                            }                        
                        }                        
                        
                        //Si ricicla internamente i campi per trovare se ne ha uno in cui salvare le associazioni delle immagini
                        foreach( $columns AS $columnImage ) {                              
                            if(  !empty( $aPersistEntity[ucfirst( $this->getSingularWords( $columnImage ) )] ) ) {                                     
                                $this->getSingularWords( $columnImage );

                                //Setter dell'entita normale quindi salva un intero cioè l'id
                                $fnSet = 'set'. ucfirst( $columnImage );   
                                $fnGet = 'get'. ucfirst( $columnImage );   

                                //Controlla che sia un associazione di Collection
                                if( $this->doctrine->getClassMetadata( get_class( $entity ) )->isCollectionValuedAssociation( $columnImage ) ) {
//                                    $entity->$fnGet()->add( $aPersistEntity[ucfirst( $this->getSingularWords( $columnImage ) )] );
                                    
                                    $getEntityField = 'get'. ucfirst( $this->getPluralWords( lcfirst( $entityName ) ) ) ;      
                                    
                                    //va a fare update solo dei record che sono nell'array di configurazione ignorando le altre associazioni
                                    if( !empty(  $aPersistEntity[ucfirst( $this->getSingularWords( $columnImage ) )]) ) {                                           
                                        $aPersistEntity[ucfirst( $this->getSingularWords( $columnImage ) )]->$getEntityField()->add($entity);
                                    }
                                }
                            }                            
                        }
                        
                        //Controlla se dopo aver fatto il set dei campi visibili del form deve settare qualcosa in automatico prendendolo dai 
                        //campi settati nel indice setFieldsNotInForm dell'oggetto di configurazione e ne fa il set su doctrine
                        if( !empty( $entitiesAutoFieldValue ) && !empty( $entitiesAutoFieldValue[$entityName] ) ) {
                            foreach( $entitiesAutoFieldValue[$entityName] AS $key => $field ) {
                                $value = $this->setAutoFieldValue( $field );                    
                                $fnSet = 'set'. ucfirst( $key );
                                $entity->$fnSet( $value );                                    
                            }                
                        }                         
                        $em->persist( $entity );
                    }                           
                    
                //Gestisce il salvataggio delle relazioni ma che non sono di tipo file    
                } else if( $entity && !empty( $aPersistEntity[ucfirst( $this->getSingularWords( $column ) )] ) ) {                                     
                    $this->getSingularWords( $column );
                    
                    //Setter dell'entita normale quindi salva un intero cioè l'id
                    $fnSet = 'set'. ucfirst( $column );   
                    $fnGet = 'get'. ucfirst( $column );   
                    
                    if( $this->doctrine->getClassMetadata( get_class( $entity ) )->isCollectionValuedAssociation( $column ) ) {
                        $entity->$fnGet()->add( $aPersistEntity[ucfirst( $this->getSingularWords( $column ) )] );
//                        $aPersistEntity[ucfirst( $this->getSingularWords( $column ) )]->getImages()->add($entity);
                    } else {
                        $entity->$fnSet( $aPersistEntity[ucfirst( $column )] );
                    }
                    $em->persist( $entity );
                    
                } else if( $entity ) {
                    //Salvataggio classico sdi symfony con doctrine
                    $fnSet = 'set'. ucfirst( $column );   
                            
                    if( !empty( $item['optionsFields'][$column]['json_encode'] ) ) {
                        $entity->$fnSet( json_decode( $form[$column] ) );                             
                    } else {   
                        $entity->$fnSet( $form[$column] );                                        
                    }
                    
                    $em->persist( $entity );
                }                
                
                
            }
            
            //Controlla se dopo aver fatto il set dei campi visibili del form deve settare qualcosa in automatico prendendolo dai 
            //campi settati nel indice setFieldsNotInForm dell'oggetto di configurazione e ne fa il set su doctrine
            if( !empty( $entitiesAutoFieldValue ) && !empty( $entitiesAutoFieldValue[$entityName] ) ) {
                foreach( $entitiesAutoFieldValue[$entityName] AS $key => $field ) {
                    $value = $this->setAutoFieldValue( $field );                    
                    $fnSet = 'set'. ucfirst( $key );                    
                    $entity->$fnSet( $value );                    
                }                             
            }                                        
           
            if( !empty( $entity ) )
                $aPersistEntity[$entityName] = $entity;                                   
        }    
        return $aPersistEntity;
    }
    
    /**
     * Metodo che gestisce il caricamento di immagini e tutti i tipi di file
     * @param array $files
     * @param array $item
     */
    public function uploadFile( $files, $item, $entityName, $entity, $column ) {
        $formatsImg = array( 'image/gif', 'image/png', 'image/jpeg', 'image/jpeg', 'image/jpg');        
        $photos = array();
        $index = 1;
        
        $lastId = !empty( $entity->getId()  ) ? $entity->getId() : '-1';
        $lastSrc = !empty( $entity->getId()  ) ? array( 0 => true ) : false;        
        
        $queryEntityAutoIncrement = !empty( $item['queryEntityAutoIncrement'] ) ? $item['queryEntityAutoIncrement'] : $entityName;        
        
        if( empty( $item['multiple'] ) ) {
            $files = array( $files );
        }
        
        if( empty( $files ) || empty( $files[0] )  ) {
            return array();
        }
        
        if( !is_object( $files[0] ) ) {
            return array();
        }
        
        
        
        foreach( $files AS $file ) {
            $myFile                 = array();
            $myFile['name'][0]      = $file->getClientOriginalName();
            $myFile['tmp_name'][0]  = $file->getPathName();                         
    
            if( in_array( $file->getClientMimeType(), $formatsImg ) ) {       
                
                $myFile['type'][0]      = $this->imageUtility->myGetTypeImg( $file );                   
                $resPhoto = array();
                //Crea i vari formati richiesti per l'immagine caricata
                
                foreach( $item['formats'] AS $key => $format ) {                    
                    $typeOut = !empty( $format['format'] ) ? $format['format'] : 'jpg';      
//                    if( !empty( $myFile['type'][0] ) ) {
//                        $typeOut = str_replace( 'image/', '', $myFile['type'][0] );
//                    }
                    
                    $rewriteName = !empty( $format['rewriteName'] ) ? $format['rewriteName'] : '';
                    $photo = $this->imageUtility->myUpload( $myFile, $format['pathFileWrite'], '/tmp/', $format['width'], $format['height'], $queryEntityAutoIncrement, $index, $lastId, $lastSrc, $column, $typeOut, $rewriteName ); 
                    $aSrc = explode( '/', $photo['foto'][0] );
                    $newSrc = explode ( '.', $aSrc[count($aSrc)-1] );
                    $newExt = $newSrc[1];
                    $newSrc = $newSrc[0] . $index;                                        
                    $src = str_replace(  $aSrc[count($aSrc)-1], $newSrc, $photo['foto'][0] ) .'.'. $newExt;
                    
                    $src = $photo['foto'][0];
                    
                    $resPhoto['src'] = $src;
                    $resPhoto['dim']['width'][$key]  = $photo['dim'][0]['width'];
                    $resPhoto['dim']['height'][$key] = $photo['dim'][0]['height'];
                }
                
                $photos[] = $resPhoto;
                
            } else {                                
                $myFile['type'][0] = $file->getMimeType() ;    
                //Crea i vari formati richiesti per il file caaricato
                foreach( $item['formats'] AS $key => $format ) {
                    $rewriteName = !empty( $format['rewriteName'] ) ? $format['rewriteName'] : '';
                    $resPhoto = $this->fileUtility->myUploadFiles( $myFile, $format['pathFileWrite'], '/tmp/', $queryEntityAutoIncrement, $index, false, false, $lastId, array(), $rewriteName );
                }
                $photos[0] = array( 'src' => $resPhoto[0] );                
            }
            $index++;
        }
           
        return $photos;
    }
    
    public function uploadImgByRemoteUrl( $files, $item, $entityName ) {
        $formatsImg = array( 'image/gif', 'image/png', 'image/jpeg', 'image/jpeg', 'image/jpeg');        
        $photos = array();
        $index = 1;
          
        $queryEntityAutoIncrement = !empty( $item['queryEntityAutoIncrement'] ) ? $item['queryEntityAutoIncrement'] : $entityName;
        if( empty( $files ) ) 
            return array();
        
        foreach( $files AS $file ) {
            $myFile                 = array();
            $myFile['name'][0]      = $file['src'];
            $myFile['tmp_name'][0]  = $file['src'];
            $imgInfo = getimagesize($file['src']);
            
            //TODO da cambiare come il METODOnormale
            $myFile['type'][0]      = $this->imageUtility->myGetTypeImg( $imgInfo['mime'] );
            //Controlla se i file sono immagini
            if( in_array( $myFile['type'][0], $formatsImg ) ) {                                         
                $resPhoto = array();
                //Crea i vari formati richiesti per l'immagine caricata
                foreach( $item['formats'] AS $key => $format ) {
                    $photo = $this->imageUtility->myUpload( $myFile, $format['pathFileWrite'], '/tmp/', $format['width'], $format['height'], $queryEntityAutoIncrement, $index); 
                    $aSrc = explode( '/', $photo['foto'][0] );
                    $newSrc = explode ( '.', $aSrc[count($aSrc)-1] );
                    $newExt = $newSrc[1];
                    $newSrc = $newSrc[0] + $index;                                        
                    $src = str_replace(  $aSrc[count($aSrc)-1], $newSrc, $photo['foto'][0] ) .'.'. $newExt;
                    
                    $src = $photo['foto'][0];
                    
                    $resPhoto['src'] = $src;
                    $resPhoto['dim']['width'][$key]  = $photo['dim'][0]['width'];
                    $resPhoto['dim']['height'][$key] = $photo['dim'][0]['height'];
                }
                
                $photos[] = $resPhoto;
                
                $resPhoto['title'] = $file['title'];
                
                //INSERIMENTO IMMAGINI NEL DB
                $photo = json_decode(json_encode($resPhoto), FALSE);
                $entity = $this->createUse( $entityName );
                $result = $this->saveEntity($entity, $photo, false);
            }
        }
        return $result;
    }
    
    /**
     * Metodo che valorizza il campo con il dato di default imopstato nelle configurazione dell'array di creazione del form
     * @param type $field
     * @return type
     */
    private function setAutoFieldValue( $field ) {                
        if( !is_array( $field ) )
            return $field;        
                        
        $type = key( (array)$field );                        
        switch( $type ) {
            case 'date': 
                $date = new \DateTime();
                return $date;
            break;            
            case 'entity': 
                return $field[$type];
            break;            
        }
    }
    
    
    public function saveEntity( $entity, $requestQuery, $isRequestUrl = true ) {
        foreach ( $requestQuery AS $key => $request ) {
            if( $key == 'id' || $key == 'action' || $key == 'entity' )
                continue;

            if( $isRequestUrl ) {
                $fnSet = 'set' . ucfirst( $key );
                $entity->$fnSet( $requestQuery->get( $key ) );
            } else {
                if( $key == 'src' || $key == 'title' )
                    $fnSet = 'set' . ucfirst( $key );
                $entity->$fnSet( $requestQuery->src );
                //Setta dimenzioni se presenti
                if( !empty( $requestQuery->dim ) ) {
                    foreach( $requestQuery->dim AS $key => $photo) {
                        foreach( $photo AS $key2 => $photo2) {      
                            $fnSet = 'set'. ucfirst( $key ).ucfirst( $key2 );
                            $entity->$fnSet( $photo2 );
                        }
                    }                        
                }
            }
        }
        
        $errors = $this->validator->validate( $entity );

        $jsonResponse = array();
        $jsonResponse['response'] = 0;
        $jsonResponse['msg'] = 'Modifica avvenuta con successo';
        
        if( count( $errors ) == 1 ) {           
            $jsonResponse['response'] = 1;
            $jsonResponse['errors'] = array();
            $jsonResponse['msg'] = 'Spiacenti si sono verificati degli errori';
            foreach( $errors  AS $error ) {
                $property = explode( '.',  $error->getPropertyPath() );
//                $field = $property[1];
                $jsonResponse['errors'][$error->getPropertyPath()][] = $error->getMessage(); 
                
//                $errorForm = new FormError( $error->getMessage() );                    
//                $form->get($field)->addError( $errorForm );
            }
        } else {
            $this->doctrine->persist( $entity );
            $this->doctrine->flush();
        }
        return json_encode( $jsonResponse );
    }

}
