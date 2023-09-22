<?php

namespace AppBundle\Service\WidgetService;

class CoreGetSearchTerms {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function getSearchTerms( $category, $subcategory = false, $typology = false, $section = false, $name = false, $releatedId = false) {    
        $aSearchTerms = array();
        $searchTerms = $this->wm->doctrine->getRepository('AppBundle:SearchTerm')->findSearchTermsSection( $category, $subcategory, $typology, $section, $name, $releatedId );
        
        foreach ($searchTerms as $searchTerm) {
            if( $searchTerm->getIsTested() && $searchTerm->getIsActive() ) {
                $urls = '';
                $aSearchTerms[$searchTerm->getId()]['id'] = $searchTerm->getId();   
                $aSearchTerms[$searchTerm->getId()]['releatedId'] = $searchTerm->getReleatedId();   
                $aSearchTerms[$searchTerm->getId()]['name'] = $searchTerm->getDisplayLabel();   
                $aSearchTerms[$searchTerm->getId()]['metaTitle'] = $searchTerm->getMetaTitle();
                $aSearchTerms[$searchTerm->getId()]['metaDescription'] = $searchTerm->getMetaDescription();
                $aSearchTerms[$searchTerm->getId()]['title'] = $searchTerm->getTitle();
                $aSearchTerms[$searchTerm->getId()]['description'] = $searchTerm->getDescription();
                $aSearchTerms[$searchTerm->getId()]['routeName'] = $searchTerm->getRouteName();
                $aSearchTerms[$searchTerm->getId()]['img'] = $this->wm->container->getParameter( 'app.folder_img_category' ).$searchTerm->getCategory()->getImg(); 
                
                $sex    = !empty( $searchTerm->getSex() ) ? $searchTerm->getSex() : false;
                $search = !empty( $searchTerm->getName() ) ? $searchTerm->getName() : false;  

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

                $aSearchTerms[$searchTerm->getId()]['url'] = $urls;
            }
        }
         
        
        return $aSearchTerms;
    }
    
    public function getCurrentSearchTerms( $category, $subcategory = false, $typology = false, $section, $name ) {    
        $aSearchTerms = array();
        $searchTerms = $this->wm->doctrine->getRepository('AppBundle:SearchTerm')->findSearchTermsSection( $category, $subcategory, $typology, $section, $name );
            foreach ($searchTerms as $searchTerm) {
                if( $searchTerm->getIsTested() ) {
                    $testUrls = '';
                    $aSearchTerms['id'] = $searchTerm->getId();  
                    $aSearchTerms['releatedId'] = $searchTerm->getReleatedId();   
                    $aSearchTerms['name'] = $searchTerm->getDisplayLabel();
                    $aSearchTerms['metaTitle'] = $searchTerm->getMetaTitle();
                    $aSearchTerms['metaDescription'] = $searchTerm->getMetaDescription();
                    $aSearchTerms['title'] = $searchTerm->getTitle();
                    $aSearchTerms['description'] = $searchTerm->getDescription();
                    $aSearchTerms['body'] = $searchTerm->getBody();
                    $aSearchTerms['routeName'] = $searchTerm->getRouteName();
                    
                    
                    $search = !empty( $searchTerm->getName() ) ? $searchTerm->getName() : false;  
                    
                   if( !empty( $searchTerm->getTypology() ) ) {
                        $urls = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array(
                            'section1' => $searchTerm->getCategory()->getNameUrl(),
                            'section2' => $searchTerm->getSubcategory()->getNameUrl(), 
                            'section3' => $searchTerm->getTypology()->getNameUrl().'-'.$search ) 
                        );
                        
                        $aSearchTerms['img'] = $this->wm->container->getParameter( 'app.folder_img_typologies' ).$searchTerm->getTypology()->getImg(); 
                    } else {
                        $urls = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array(
                            'section1' => $searchTerm->getCategory()->getNameUrl(),
                            'section2' => $searchTerm->getSubcategory()->getNameUrl().'-'.$search, 
                        ));
                        $aSearchTerms['img'] = $this->wm->container->getParameter( 'app.folder_img_subcategories' ).$searchTerm->getSubcategory()->getImg(); 
                    }

                    $aSearchTerms['url'] = $testUrls;
                }
            }
            
        return $aSearchTerms;
    }
    
    
}
