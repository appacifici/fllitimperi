<?php

namespace AppBundle\Service\UserUtility;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Service\UtilityService\GlobalUtility;


//use \AppBundle\Entity\DataArticle;
//use \AppBundle\Entity\ContentArticle;

class UserManager {

    protected $doctrine;
    protected $container;
    protected $groupPermission  = array();

    /**
     * Oggetti che devono essere disponibili su tutti i widget
     * @param \Symfony\Component\Templating\EngineInterface $templating
     */
    public function __construct(
        ObjectManager $doctrine, GlobalUtility $globalUtility, Container $container
    ) {
        $this->doctrine         = $doctrine;
        $this->container        = $container;
        $this->globalUtility    = $globalUtility;
        $this->cacheUtility     = $globalUtility->cacheUtility;
        $this->cacheUtility->initPhpCache();
//        $this->getGroupPermission();
    }
    
    /**
     * Metodo che ritorna il tipo di profilo dell'utente
     * @param type $userId
     * @return UserProfile
     */
    public function getUserPofile( $userId ) {
        $userProfile    = null;
        $user           = $this->doctrine->getRepository('AppBundle:User')->find($userId);
        if( !empty( $user ) )
            $userProfile    = $user->getRole();
        
        return $userProfile;
    }
    
    /**
     * Metodo che gestisce la sessione e la cache al login
     * @param type $userName
     * @param type $password
     * @return boolean
     */
    public function loginUser( $email, $password ) {
        $user = $this->doctrine->getRepository('AppBundle:User')->findByEmailePassword( $email, $password, true );        
        if( !empty( $user ) ) {
            $email = $user->email;
            if(is_object($user->registerAt))
                $RegisterDate = $user->registerAt->date;
            else
                $RegisterDate = $user->registerAt;
            
            $RegisterDate = '';
            
            $code = $this->container->getParameter( 'app.userCode' ); 
            $userCode = $email.$RegisterDate.$code;
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            setcookie("userCode", $userCode, time()+3600, "/", $_SERVER['HTTP_HOST'] );            
            
            $this->cacheUtility->phpCacheSet( $this->container->getParameter( 'session_memcached_prefix' ).'user_'.$userCode , $user, 3600 );

            return true;
        } else {
            return false;
        }
    }
    
    /*
     * Se l'utente è in cache ritorna i dati dell'utente
     */
    public function getDataUser() {
        if( empty( $this->isLogged() ) )
            return false;
        $user = $this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'user_'.$_COOKIE['userCode'] );

        if( !empty( $user ) )
            return $user;
    }
    
    /**
     * Metodo che cotrolla che l'utente sia loggato
     */
    public function isLogged() {
        if( !empty( $_COOKIE['userCode'] ) && !empty($this->cacheUtility->phpCacheGet( $this->container->getParameter( 'session_memcached_prefix' ).'user_'.$_COOKIE['userCode'])) )
            return true;
        else
            return false;
    }
    
    public function getGroupPermission () {
        if(!empty( $this->groupPermission ) )
            return $this->groupPermission;
        // Query che ritorna TUTTI i gruppi
        $listGroupPermissions = $this->doctrine->getRepository( 'AppBundle:Group' )->findGroups();
        //Recupera i campi dell'entita
        $entityColumns = $this->doctrine->getClassMetadata( 'AppBundle:Group' )->getFieldNames();
        $aGroups = array();
        //ciclo le colonne dell'entità e faccio l'explode per ritornare i permessi
        foreach ( $entityColumns as $key1 => $column ) {
            
            $fnGet = 'get'.ucfirst($column);
            $fnSet = 'set'.ucfirst($column);
            
            foreach ( $listGroupPermissions as $key => $group) {
                if( $column != 'id' && $column != 'name' ) {
                       $itemGroups = explode( '-', $group->{$fnGet}() );
                       
                       $newGroups = array('read' => $itemGroups[0],
                                       'edit' =>  ( !empty( $itemGroups[1] ) ?  $itemGroups[1] : 0 ),
                                       'remove' => !empty( $itemGroups[2] ) ?  $itemGroups[2] : 0 ) ;                       
                       
                    $aGroups[$listGroupPermissions[$key]->getId()][$column] = $newGroups;
                } else {
                    $aGroups[$listGroupPermissions[$key]->getId()][$column] = $group->{$fnGet}();
                }                
            }
        }
        $this->groupPermission =  json_decode(json_encode( $aGroups ), FALSE);
    }
    
    public function getPermissionByGroup ( $group = false ) {
        if( empty( $group ) ) {
            $user = $this->getDataUser();
            if( empty( $user ) )
                return false;
            
            $group = $user->role->id;
        }
        if( empty( $this->groupPermission ) ) 
            return false;
        
        return $this->groupPermission->{$group};
    }

}
