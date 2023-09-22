<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminLookupSubcategories {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
//        if ( !$this->wm->getPermissionCore('affiliate', 'read' ) )
//                return array();
        
        if( empty( $_GET['affiliationId'] ) || !isset( $_GET['isActive'] ) ) {
            return array();
        }
        
        
//        $aSubcatAff = $this->wm->doctrine->getRepository('AppBundle:SubcategorySiteAffiliation')->findBy(
//            array( 'isActive' => $_GET['isActive'], 'affiliation' => $_GET['affiliationId'] ) 
//        );
//        
//        $subcatActive = $this->wm->doctrine->getRepository('AppBundle:Subcategory')->findSubcategorySiteAffiliation(
//             $_GET['isActive'],  $_GET['affiliationId'], true
//        );
//        
        
        $dbHost = $this->wm->container->getParameter('database_host');
        $dbName = $this->wm->container->getParameter('database_name');
        $dbUser = $this->wm->container->getParameter('database_user');
        $dbPswd = $this->wm->container->getParameter('database_password');        
        $dbPort = $this->wm->container->getParameter('database_port');        
        $this->mySql = new \PDO('mysql:host='.$dbHost.';port='.$dbPort.';', $dbUser, $dbPswd);
        
        $whereName = !empty( $_GET['name'] ) ? " AND subcategorySiteAffiliations.name LIKE '%".$_GET['name']."%'" : '';
        $limit = !empty( $_GET['limit'] )  ? $_GET['limit'] :  10;
        
        
        $sql = "SELECT categories.id as categoryId,subcategories.id as subcatId, subcategorySiteAffiliations.id as subcatAffId, subcategorySiteAffiliations.name as subcatName
                ,lookup_subcategories.typology_id,lookup_subcategories.micro_section_id, subcategorySiteAffiliations.label
                FROM $dbName.subcategorySiteAffiliations                
                left JOIN $dbName.lookup_subcategories ON subcategorySiteAffiliations.id = lookup_subcategories.subcategorySiteAffiliation_id                 
                    left JOIN $dbName.subcategories ON subcategories.id = lookup_subcategories.subcategory_id 
                left JOIN $dbName.categories ON subcategories.category_id = categories.id 
                WHERE subcategorySiteAffiliations.is_active = ".$_GET['isActive']." AND subcategorySiteAffiliations.affiliation_id = ".$_GET['affiliationId']." $whereName ORDER BY subcategorySiteAffiliations.id asc
                    LIMIT $limit 
        ";
        
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $subcatActive = $sth->fetchAll( \PDO::FETCH_OBJ );     
        
        
        
        $aItemActive = array();
        foreach( $subcatActive As $item ) {
                $aItemActive[$item->subcatAffId]['name'] = $item->subcatName;
                $aItemActive[$item->subcatAffId]['label'] = $item->label;
                $aItemActive[$item->subcatAffId]['subcatId'] = $item->subcatId;
                $aItemActive[$item->subcatAffId]['catId'] = $item->categoryId;
                $aItemActive[$item->subcatAffId]['typologyId'] = $item->typology_id;
                $aItemActive[$item->subcatAffId]['microSectionId'] = $item->micro_section_id;
        }
        
//        print_r($aItemActive);exit;
        
        return array(
            'aSubcatAff'  => $subcatActive,
            'aItemActive' => $aItemActive
        );
    }
}