<?php

namespace AppBundle\Service\DependencyService;
use AppBundle\Service\UtilityService\GlobalUtility;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class DependencyManagerTemplate extends DependencyManager {
    
    public function __construct( $paramaters, GlobalUtility $globalUtility ) {
        parent::__construct( $paramaters, $globalUtility );        
    }
    
    public function globalDependencies() {    
        parent::globalDependencies();  
        
        $this->isMobile =  $this->browserUtility->mobileDetector->isMobile();
        $this->addDependencyJSHead( $this->parameters->commonPath.'library/jquery/jquery.'.$this->jqueryVersion.'.js' );
    }
    
    public function loaderFiles() {
        parent::loaderFiles();     
        unset( $this->dependenciesJSBody[$this->parameters->commonPath.'components/ui_modals/modals.init.js'] );
        unset( $this->dependenciesJSBody[$this->parameters->commonPath.'plugins/notifications_notyfy/js/jquery.notyfy.js'] );
        unset( $this->dependenciesJSBody[$this->parameters->commonPath.'components/admin_notifications_notyfy/notyfy.init.js'] );
       
        //Parte per compatibilità cmsadmin
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'main.js']                            = false;
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widgetInfiniteScrollNews.js']        = false;
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widget/template/widgetScrollTop.js'] = false;
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widget/template/widgetArticle.js']   = false;
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widget/template/widgetUser.js']      = false;        
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widget/template/widgetComment.js']   = false;
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widget/template/skin.js']            = false;
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'mobileSlider.js']                    = false;        
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widgetDictionary.js']                    = false;        
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widgetSearchFilterProduct.js']                    = false;        
        $this->dependenciesJSBody['https://www.gstatic.com/charts/loader.js']                               = false;        
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'widgetTrendChart.js']                = false;        
        $this->dependenciesJSBody[$this->parameters->commonPath.'plugins/notifications_notyfy/js/jquery.notyfy.js']     = false;
        $this->dependenciesJSBody[$this->parameters->commonPath.'components/admin_notifications_notyfy/notyfy.init.js'] = false;
        $this->dependenciesJSBody[$this->parameters->commonPath.'plugins/ui_modals/bootbox.min.js'] = false;
        $this->dependenciesJSBody[$this->parameters->extensionsJsPath.'coockie.js']                         = false;
    }
    
    public function getDependency( $widget ) {                
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widgetSearchFilterProduct.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'main.js' );          
        
//        $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/notifications_notyfy/js/jquery.notyfy.js' );
//        $this->addDependencyJSBody( $this->parameters->commonPath.'components/admin_notifications_notyfy/notyfy.init.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widget/template/widgetMenu.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widgetUser.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'coockie.js' );
//        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'facebook.init.js' );
//        $this->addDependencyJSBody( 'https://apis.google.com/js/api:client.js' );
//        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'google.init.js' );
        
        switch( $widget ) {                 
            case 'widget_ProductListInfiniteScroll':            
//                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widgetInfiniteScrollNews.js' ); 
            break;
            case 'widget_DetailNews':
            case 'widget_CardCarousel':
//                $this->addDependencyJSBody( $this->parameters->extensionsTemplates.'assetsAlchimist/vendor/slick/slick.min.js' );
//                $this->addDependencyJSBody( $this->parameters->extensionsTemplates.'assetsAlchimist/vendor/custom-select/selectFx.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widget/template/widgetArticle.js' );                
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'mobileSlider.js' );
            break;
            case 'widget_Comments':
                $this->addDependencyJSBody( 'https://apis.google.com/js/api:client.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'facebook.init.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'google.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/ui_modals/modals.init.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widget/template/modals_bootstrap.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/notifications_notyfy/js/jquery.notyfy.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/admin_notifications_notyfy/notyfy.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/ui_modals/bootbox.min.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widget/template/widgetComment.js' );
            break;
            case 'widget_SpeakArticle':
                $this->addDependencyJSBody($this->parameters->extensionsJsPath.'widget/template/widgetArticle.js');
            break;           
            case 'widget_ScrollTop':    
                $this->addDependencyJSBody($this->parameters->extensionsJsPath.'widget/template/widgetScrollTop.js');
            break;
//            case 'widget_Poll':                    
//                $this->addDependencyJSBody($this->parameters->extensionsJsPath.'widget/template/widgetPoll.js');
//            break;
//            case 'widget_PollsGrid':    
//                $this->addDependencyJSBody($this->parameters->extensionsJsPath.'widget/template/widgetPoll.js');
//                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widget/template/widgetInfiniteScrollPolls.js' );  
//                
//            break;
            case 'banner_Skin':    
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widget/template/skin.js' );       
            break;
            case 'widget_SearchFilterProduct':    
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widgetSearchFilterProduct.js' );       
            break;            
            case 'widget_ModelsComparison':    
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widgetDictionary.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'mobileSlider.js' );
            break;
            case 'widget_CatSubcatTypologyProductListAcquistiGiusti':    
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widgetDictionary.js' );
            break;
            case 'widget_DetailProduct':    
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widget/template/widgetModel.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'mobileSlider.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widgetDictionary.js' );
//                $this->addDependencyJSBody( 'https://www.gstatic.com/charts/loader.js' );       
//                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'widgetTrendChart.js' );       
//                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/charts_flot/jquery.flot.js' );
//                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/charts_flot/jquery.flot.resize.js' );
//                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/charts_flot/plugins/jquery.flot.tooltip.min.js' );
//                $this->addDependencyJSBody( $this->parameters->commonPath.'components/charts_flot/flotcharts.common.js' );
//                $this->addDependencyJSBody( $this->parameters->commonPath.'components/charts_flot/flotchart-line-2.init.js' );
            break;
        }        
    }    
}
