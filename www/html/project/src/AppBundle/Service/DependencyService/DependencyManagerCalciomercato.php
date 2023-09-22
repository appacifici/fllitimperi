<?php

namespace AppBundle\Service\DependencyService;
use AppBundle\Service\UtilityService\GlobalUtility;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class DependencyManagerCalciomercato extends DependencyManager {
    
    public function __construct( $paramaters, GlobalUtility $globalUtility ) {
        parent::__construct( $paramaters, $globalUtility );        
    }
    
    public function globalDependencies() {      
        parent::globalDependencies();
        
        $this->addDependencyCSSHead( $this->parameters->commonPath.'library/bootstrap/css/bootstrap.min.css' );                                         
        $this->addDependencyCSSHead( $this->parameters->commonPath.'plugins/forms_elements_bootstrap-datepicker/css/bootstrap-datepicker.css' );  
        $this->addDependencyCSSHead( $this->parameters->commonPath.'plugins/notifications_notyfy/css/jquery.notyfy.css' );  
        $this->addDependencyCSSHead( $this->parameters->commonPath.'library/icons/glyphicons/assets/css/glyphicons_social.css' );  
        $this->addDependencyCSSHead( 'http://fonts.googleapis.com/css?family=Roboto+Slab&#038;ver=4.6.1' );  

        $this->addDependencyJSHead( $this->parameters->commonPath.'library/jquery/jquery.'.$this->jqueryVersion.'.js' );
        if( $this->forceVersion != 'app_direttagoal' && !$this->isMobileOrApp ) {
            $this->addDependencyJSHead( $this->parameters->commonPath.'library/jquery-ui/js/jquery-ui.min.js' );
            $this->addDependencyJSHead( $this->parameters->commonPath.'library/jquery/jquery-migrate.min.js' );        
        }
        $this->addDependencyJSHead( $this->parameters->commonPath.'library/modernizr/modernizr.js' );

        $this->addDependencyJSBody( $this->parameters->commonPath.'library/bootstrap/js/bootstrap.min.js' );        

        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'jqueryExtends.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'main.js' );
        $this->addDependencyJSBody( $this->parameters->commonPath.'components/ui_modals/modals.init.js' );
        $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/notifications_notyfy/js/jquery.notyfy.js' );
        $this->addDependencyJSBody( $this->parameters->commonPath.'components/admin_notifications_notyfy/notyfy.init.js' );
        
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'modules.init.js' );

    }
    
    public function loaderFiles() {
        parent::loaderFiles();                
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'/widget/calciomercato/widgetBreakingNews.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'audio.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'users.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'social.js']= false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'templateManager.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'main.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/widgetLogin.js'] = false;
    }
    
    public function getDependency( $widget ) {
        switch( $widget ) {            
            case 'widget_BreakingNews':                                          
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'/widget/calciomercato/widgetBreakingNews.js' );                
            break;            
            case 'widget_Slideshow':                                          
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'/widget/calciomercato/widgetSlideshow.js' );                
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'owl.carousel.min.js' );                
                $this->addDependencyCSSHead( $this->parameters->extensionCssPath.'owl.carousel.css' );
            break;            
            case 'widget_MenuMobile':                                          
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'/widget/calciomercato/widgetMenuMobile.js' );
            break;            
            case 'widget_VerticalListNews':                                          
                
            break;            
            case 'widget_ListCategoryNews':                                          
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'/widget/calciomercato/widgetListCategoryNews.js' );
            break;            
            case 'widget_DetailNews':                                          
                $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'/widget/calciomercato/widgetDetailNews.js' );
            break;
        }      
    }
    
}//End Class
