<?php

namespace AppBundle\Service\DependencyService;
use AppBundle\Service\UtilityService\GlobalUtility;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class DependencyManagerAdmin extends DependencyManager {
    
    public function __construct( $paramaters, GlobalUtility $globalUtility ) {
        parent::__construct( $paramaters, $globalUtility );        
    }
    
    public function globalDependencies() {      
        parent::globalDependencies();
        
        $this->addDependencyCSSHead( $this->parameters->commonPath.'library/bootstrap/css/bootstrap.min.css' );                                         
        $this->addDependencyCSSHead( $this->parameters->commonPath.'plugins/forms_elements_bootstrap-datepicker/css/bootstrap-datepicker.css' );  
        $this->addDependencyCSSHead( $this->parameters->commonPath.'plugins/notifications_notyfy/css/jquery.notyfy.css' );  

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
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'users.js'] = false;        
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'templateManager.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsPath.'main.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/mainAdmin.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/widgetLogin.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/widgetManagerInlineForm.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/widgetManagerMenus.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/widgetEditArticle.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/widgetEditPoll.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/widgetTestBanner.js'] = false;
        $this->dependeciesJSBody[$this->parameters->extensionsJsAdminPath.'/widgetExtraConfigs.js'] = false;
    }
    
    public function getDependency( $widget ) {
        $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/ui_modals/bootbox.min.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/mainAdmin.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetManagerInlineForm.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetLogin.js' );        
        
        switch( $widget ) {            
            case 'widget_EditArticle':
            case 'widget_EditDinamycPage':
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/ckeditor/ckeditor.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetEditArticle.js' );

            break;
            case 'widget_EditModel':   
            case 'widget_EditComparison':   
            case 'widget_EditSearchTerm':   
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/ckeditor/ckeditor.js' );
            break;
            case 'widget_Login':   
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetLogin.js' );
            break;
            case 'widget_ListArticles':
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_responsive/js/footable.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables_responsive/tables-responsive-footable.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/forms_elements_bootstrap-datepicker/bootstrap-datepicker.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/forms_elements_bootstrap-datepicker/js/bootstrap-datepicker.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetListArticles.js' );                
            break;    
            case 'widget_ListProducts':
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_responsive/js/footable.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables_responsive/tables-responsive-footable.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/forms_elements_bootstrap-datepicker/bootstrap-datepicker.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/forms_elements_bootstrap-datepicker/js/bootstrap-datepicker.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetListProducts.js' );                
            break;    
            case 'widget_ManagerMenus':
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables/tables-classic.init.js');
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetManagerMenus.js' );
            break; 
            case 'widget_EditBanner':
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetTestBanner.js' );
            break;    
            case 'widget_ListBanners':
            case 'widget_ListCategories':
            case 'widget_ListSubcategories':
            case 'widget_ListTypology':
            case 'widget_ListProducts':
            case 'widget_ListTrademarks':
            case 'widget_ListAffiliations':
            case 'widget_ListGroupPermission':
            case 'widget_ListPoll':
            case 'widget_ListTecnicalTemplate':
            case 'widget_ListDinamycPage':
            case 'widget_Users':
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_responsive/js/footable.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables_responsive/tables-responsive-footable.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_datatables/js/jquery.dataTables.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_datatables/extras/TableTools/media/js/TableTools.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_datatables/extras/ColVis/media/js/ColVis.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables_datatables/js/DT_bootstrap.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables_datatables/js/datatables.init.js' );                
            break;
            
            
            case 'widget_ImageArticle':
//                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/media_gridalicious/jquery.gridalicious.min.js' );
//                $this->addDependencyJSBody( $this->parameters->commonPath.'components/media_gridalicious/gridalicious.init.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetImageArticle.js' );
            break;
            case 'widget_ImageArticleGetty':
//                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/media_gridalicious/jquery.gridalicious.min.js' );
//                $this->addDependencyJSBody( $this->parameters->commonPath.'components/media_gridalicious/gridalicious.init.js' );
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetImageGetty.js' );
            break;
            case 'widget_EditSubcategory':
            case 'widget_EditCategory':
            case 'widget_EditTypology':
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/forms_elements_colorpicker-farbtastic/js/farbtastic.min.js');
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/forms_elements_colorpicker-farbtastic/colorpicker-farbtastic.init.js' );                
                $this->addDependencyCSSHead( $this->parameters->commonPath.'plugins/forms_elements_colorpicker-farbtastic/css/farbtastic.css' ); 
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/ckeditor/ckeditor.js' );
            break;
            case 'widget_EditPoll' :
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetEditPoll.js' );
            break;
            case 'widget_LookupSubcategories' :
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetLookupSubcategories.js' );
            break;
            case 'widget_TopTrademarkSection' :
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables/tables-classic.init.js');
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetTopTrademarksSection.js' );
            break;
            case 'widget_ExtraConfigs' :
                $this->addDependencyJSBody( $this->parameters->extensionsJsAdminPath.'/widgetExtraConfigs.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_responsive/js/footable.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables_responsive/tables-responsive-footable.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_datatables/js/jquery.dataTables.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_datatables/extras/TableTools/media/js/TableTools.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/tables_datatables/extras/ColVis/media/js/ColVis.min.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables_datatables/js/DT_bootstrap.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/tables_datatables/js/datatables.init.js' );                
            break;
            case 'widget_ListModels':
            case 'widget_ListDisabledModels':
                $this->addDependencyJSBody( $this->parameters->commonPath.'components/forms_elements_bootstrap-datepicker/bootstrap-datepicker.init.js' );
                $this->addDependencyJSBody( $this->parameters->commonPath.'plugins/forms_elements_bootstrap-datepicker/js/bootstrap-datepicker.js' );
            break;
        }
    }
    
}//End Class
