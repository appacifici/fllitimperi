<?php

namespace AppBundle\Service\WidgetService;

use \AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoreAdminListSearchTerms {
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager; 
    }
    
    public function processData( $options = false ) {
        //controllo se l'utente abbia i permessi di lettura
//        if ( !$this->wm->getPermissionCore('trademark', 'read' ) )
//                return array();
        
        $searchTerms = $this->wm->doctrine->getRepository('AppBundle:SearchTerm')->findAll();
        $testUrls = array();
        
        
        foreach ($searchTerms as $searchTerm) {
            $testUrls[$searchTerm->getId()] = '';
            
            $sex    = !empty( $searchTerm->getSex() ) ? $searchTerm->getSex() : false;
            $search = !empty( $searchTerm->getName() ) ? $searchTerm->getName() : false;  
            
            
//            if( !empty( $searchTerm->getSubcategory() ) ) {                                                                                                                     
//                $categoryname = $searchTerm->getCategory()->getId() != 8 ? $searchTerm->getCategory()->getNameUrl().'-' : '';
//                $urls = $this->wm->routerManager->generate( $searchTerm->getRouteName(), array( 
//                    'subcategory' => $categoryname.$searchTerm->getSubcategory()->getNameUrl(), 
//                    'search' => $search ), true
//                );
//            }
//
//            if( !empty( $searchTerm->getTypology() ) ) {
//                $urls = $this->wm->routerManager->generate( $searchTerm->getRouteName(), array( 
//                    'subcategory' => $searchTerm->getSubcategory()->getNameUrl(), 
//                    'typology' => $searchTerm->getTypology()->getNameUrl(), 
//                    'sex' => $sex,  
//                    'search' => $search ), true
//                );
//            }
            
            
            if( !empty( $searchTerm->getTypology() ) ) {
                $urls = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array(
                    'section1' => $searchTerm->getCategory()->getNameUrl(),
                    'section2' => $searchTerm->getSubcategory()->getNameUrl(), 
                    'section3' => $searchTerm->getTypology()->getNameUrl().'-'.$search ) 
                );
            } else {
                $urls = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array(
                    'section1' => $searchTerm->getCategory()->getNameUrl(),
                    'section2' => $searchTerm->getSubcategory()->getNameUrl().'-'.$search, 
                ));
            }
            
            if(!empty( $urls ))
                $testUrls[$searchTerm->getId()] = $urls;
            
//            if( !empty( $searchTerm->getSubcategory() ) )
//                $testUrls[$searchTerm->getId()] .= $searchTerm->getSubcategory()->getNameUrl().'-';
//            
//            if( !empty( $searchTerm->getTypology() ) )
//                $testUrls[$searchTerm->getId()] .= $searchTerm->getTypology()->getNameUrl().'-';
//            
//            if( !empty( $searchTerm->getSex() ) )
//                $testUrls[$searchTerm->getId()] .= $searchTerm->getSex().'-';
//            
//            if( !empty( $searchTerm->getName() ) )
//                $testUrls[$searchTerm->getId()] .= $searchTerm->getName();
        }
        
        return array(
            'searchTerms' => $searchTerms,
            'testUrls' => $testUrls,
           
        );
    }
}