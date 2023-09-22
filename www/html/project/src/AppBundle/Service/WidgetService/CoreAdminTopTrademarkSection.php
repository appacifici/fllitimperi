<?php

namespace AppBundle\Service\WidgetService;

class CoreAdminTopTrademarkSection {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
        
        
    }
    
    public function processData( $options = false ) {
        $subcatId = false;
        $catId = false;
        $typologyId = false;
        $allTrademarksSection   = array();
        $topTrademarksSection   = array();
        $aTopTrademark          = array();
        
        if ( !empty( $_GET['subcategory'] ) )
            $subcatId = $_GET['subcategory'];
        
        if ( !empty( $_GET['category'] ) )
            $catId = $_GET['category'];
        
        if ( !empty( $_GET['typology'] ) )
            $typologyId = $_GET['typology'];
        
        $allTrademarksSection = $this->wm->doctrine->getRepository('AppBundle:Model')->findDistinctIdNameTrademarkModelSubcategoryTypology( $subcatId, $typologyId );
        
        if( !empty( $typologyId ) )
            $topTrademarksSection = $this->wm->doctrine->getRepository('AppBundle:TopTrademarksSection')->findBy(
                array('typologyId' => $typologyId),
                array('position' => 'ASC')
            );
        elseif( !empty( $subcatId ) )
            $topTrademarksSection = $this->wm->doctrine->getRepository('AppBundle:TopTrademarksSection')->findBy(
                    array('subcategoryId' => $subcatId),
                    array('position' => 'ASC')
                
            );
        
        foreach ($topTrademarksSection as $trademark) {
            $trade = $this->wm->doctrine->getRepository('AppBundle:Trademark')->find( $trademark->getTrademarkId() );
            $aTopTrademark[$trademark->getId()]['name'] = $trade->getName();
            $aTopTrademark[$trademark->getId()]['limitModels'] = $trademark->getLimitModels();
            
        }
        
//        print_r( $aTopTrademark );exit;
        
        
        return array(
            'aTopTrademark' => $aTopTrademark,
            'allTrademarksSection' => $allTrademarksSection
        );
    }    
}
