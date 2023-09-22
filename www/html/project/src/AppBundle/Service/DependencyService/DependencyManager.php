<?php

namespace AppBundle\Service\DependencyService;
use AppBundle\Service\UtilityService\GlobalUtility;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class DependencyManager {
    
    protected $paramaters;
    
    public $dependenciesCSSHead = array();
    public $dependenciesCSSBody = array();
    public $dependenciesJSHead = array();
    public $dependenciesJSBody = array();
    public $jqueryVersion         = 'min';  
    public $jqueryValidateVersion = 'min'; 
    public $forceVersion = false;
    public $isMobileOrApp = false;
    /**
     * Metodo costruttore della classe che instanzia anche la classe padre
     */
    public function __construct( $paramaters, GlobalUtility $globalUtility )  {                
        $this->parameters = json_decode( json_encode( $paramaters ), FALSE );
        $this->globalUtility    = $globalUtility;        
        $this->browserUtility   = $globalUtility->browserUtility;  

//        $this->setForceVersion( 'm_template' ); 
            
        $this->getSpecificVersion();
        $this->loaderFiles();
        $this->globalDependencies();
    }
    
    public function setForceVersion( $version ) {        
        $this->forceVersion = $version;
       
        $this->isMobileOrApp = false;
        if( $this->browserUtility->mobileDetector->isMobile() || 
            $this->forceVersion == 'm_template' || $this->forceVersion == 'm_direttagoal' 
            || $this->forceVersion == 'm_chediretta'  || $this->forceVersion == 'm_diretta365'
            || $this->forceVersion == 'm_youscore' || $this->forceVersion == 'm_resultados365'
            || $this->forceVersion == 'm_africagol' || $this->forceVersion == 'm_livegoal'
            || $this->forceVersion == 'app_livescore24' || $this->forceVersion == 'app_direttagoal'
        ) {
            $this->isMobileOrApp = true;
        }
        
    }
    
    /**
     * Metodo che cambia i plugin da caricare in base alle versioni specifiche dei prowser dell'utente
     */
    public function getSpecificVersion() {
        if( !empty( $this->config->isIeVersion ) && $this->config->isIeVersion < 9  ) {
            $this->jqueryVersion         = 'min.1.7.0';
            $this->jqueryValidateVersion = '1.9.0';
        }
    }
            
    /**
     * Metodo che include le librerire globali del sito
     */
    public function globalDependencies() {              
        $this->addDependencyJSHead( $this->parameters->commonPath.'library/jquery/jquery.'.$this->jqueryVersion.'.js' );                        
//        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'jqueryExtends.js' );
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'modules.init.js' );        
        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'managerLinks.js' );
//        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'main.js' );
//        $this->addDependencyJSBody( $this->parameters->extensionsJsPath.'chat.js' );
    }

    /**
     * Metodo che aggiunge all'array delle dipendenze i file da caricare per il widget passato
     * @param string $fileName
     */
    public function addTplDependencies( $widget ) {        
        $this->getDependency( $widget );        
    }
    
    public function getDependency( $widget ) {
        
    }
        

    /**
     * Metodo che setta a TRUE nell'array relativo al head e quindi include la dipenendenza
     * @param string $dependency
     */
    public function addDependencyJSHead( $dependency ) {
        $this->dependenciesJSHead[$dependency] = true;
    }

    /**
     * Metodo che setta a TRUE nell'array relativo al body e quindi include la dipenendenza
     * @param string $dependency
     */
    public function addDependencyJSBody( $dependency ) {
        $this->dependenciesJSBody[$dependency] = true;
        
    }
    
    /**
     * Metodo che setta a TRUE nell'array relativo al head e quindi include la dipenendenza
     * @param string $dependency
     */
    public function addDependencyCSSHead( $dependency ) {
        $this->dependenciesCSSHead[$dependency] = true;
    }

    /**
     * Metodo che setta a TRUE nell'array relativo al body e quindi include la dipenendenza
     * @param string $dependency
     */
    public function addDependencyCSSBody( $dependency ) {
        $this->dependenciesCSSBody[$dependency] = true;
    }

    /**
     * Metodo che ritorna l'array contenente le dipendenze sta inserire dentro il tag head
     * @return array
     */
    public function getJSHead() {
        return array_filter( $this->dependenciesJSHead );
    }

    /**
     * Metodo che ritorna l'array contenente le dipendenze sta inserire dentro il tag body
     * @return array
     */
    public function getJSBody() {
        return array_filter( $this->dependenciesJSBody );
        
    }

    /**
     * Metodo che ritorna l'array contenente le dipendenze sta inserire dentro il tag head
     * @return array
     */
    public function getCSSHead() {
        return array_filter( $this->dependenciesCSSHead );
    }

    /**
     * Metodo che ritorna l'array contenente le dipendenze sta inserire dentro il tag body
     * @return array
     */
    public function getCSSBody() {
        return array_filter( $this->dependenciesCSSBody );
    }
    
    public function restoreDependency() {        
//        $this->dependenciesJSBody = array_fill_keys( array_keys($this->dependenciesJSBody), 'false');
        $this->loaderFiles();
        $this->globalDependencies();
        
    }

    /**
     * Metodo che valorizza gli array con i path delle dipendenze css e js sia quelli della sezione head
     * che quelli della sezione body
     */
    public function loaderFiles() {
        
        $this->dependenciesCSSHead = array(
            $this->parameters->commonPath.'library/bootstrap/css/bootstrap.min.css'                                  => false,
            $this->parameters->commonPath.'library/bootstrap/css/bootstrap.min.css'                                  => false,
            //'assets/library/icons/fontawesome/assets/css/font-awesome.min.css',                                           => false,
//            'assets/library/icons/glyphicons/assets/css/glyphicons_filetypes.css',                                        => false,
//            'assets/library/icons/glyphicons/assets/css/glyphicons_regular.css',                                          => false,
//            'assets/library/icons/glyphicons/assets/css/glyphicons_social.css',                                           => false,   
            //'assets/library/icons/pictoicons/css/picto.css',                                                              => false,
            $this->parameters->commonPath.'library/jquery-ui/css/jquery-ui.min.css'                                  => false,
            $this->parameters->commonPath.'library/jquery-mobile/jquery.mobile.min.css'                              => false,
            $this->parameters->commonPath.'library/animate/animate.min.css'                                          => false,
            $this->parameters->commonPath.'plugins/calendar_fullcalendar/css/fullcalendar.css'                       => false,
            $this->parameters->commonPath.'plugins/charts_easy_pie/css/jquery.easy-pie-chart.css'                    => false,
            $this->parameters->commonPath.'plugins/core_prettyprint/css/prettify.css'                                => false,
            $this->parameters->commonPath.'plugins/forms_editors_wysihtml5/css/bootstrap-wysihtml5-0.0.2.css'        => false,
            $this->parameters->commonPath.'plugins/forms_elements_bootstrap-datepicker/css/bootstrap-datepicker.css' => false,
            $this->parameters->commonPath.'plugins/forms_elements_bootstrap-select/css/bootstrap-select.css'         => false,
            $this->parameters->commonPath.'plugins/forms_elements_bootstrap-switch/css/bootstrap-switch.css'         => false,
            $this->parameters->commonPath.'plugins/forms_elements_bootstrap-timepicker/css/bootstrap-timepicker.css' => false,
            $this->parameters->commonPath.'plugins/forms_elements_colorpicker-farbtastic/css/farbtastic.css'         => false,
            $this->parameters->commonPath.'plugins/forms_elements_jasny-fileupload/css/fileupload.css'               => false,
            $this->parameters->commonPath.'plugins/forms_elements_multiselect/css/multi-select.css'                  => false,
            $this->parameters->commonPath.'plugins/forms_elements_select2/css/select2.css'                           => false,
            $this->parameters->commonPath.'plugins/forms_file_dropzone/css/dropzone.css'                             => false,
            $this->parameters->commonPath.'plugins/forms_file_plupload/jquery.plupload.queue/css/jquery.plupload.queue.css' => false,
            $this->parameters->commonPath.'plugins/maps_vector/css/elements.css'                                     => false,
            $this->parameters->commonPath.'plugins/maps_vector/css/jquery-jvectormap-1.1.1.css'                      => false,
            $this->parameters->commonPath.'plugins/maps_vector/css/jquery-jvectormap-1.2.2.css'                      => false,
            $this->parameters->commonPath.'plugins/media_blueimp/css/blueimp-gallery.min.css'                        => false,
            $this->parameters->commonPath.'plugins/media_image-crop/css/jquery.Jcrop.css'                            => false,
            $this->parameters->commonPath.'plugins/media_owl-carousel/owl.carousel.css'                              => false,
            $this->parameters->commonPath.'plugins/media_owl-carousel/owl.theme.css'                                 => false,
            $this->parameters->commonPath.'plugins/media_prettyphoto/css/prettyPhoto.css'                            => false,
            $this->parameters->commonPath.'plugins/notifications_gritter/css/jquery.gritter.css'                     => false,
            $this->parameters->commonPath.'plugins/notifications_notyfy/css/jquery.notyfy.css'                       => false,
            $this->parameters->commonPath.'plugins/notifications_notyfy/css/notyfy.theme.default.css'                => false,
            $this->parameters->commonPath.'plugins/other_page-tour/css/pageguide.css'                                => false,
            $this->parameters->commonPath.'plugins/tables_datatables/extras/ColReorder/media/css/ColReorder.css'     => false,
            $this->parameters->commonPath.'plugins/tables_datatables/extras/ColVis/media/css/ColVis.css'             => false,
            $this->parameters->commonPath.'plugins/tables_datatables/extras/TableTools/media/css/TableTools.css'     => false,
            $this->parameters->commonPath.'plugins/tables_responsive/css/footable.core.min.css'                      => false,
            $this->parameters->commonPath.'plugins/ui_sliders_range_jqrangeslider/css/iThing.css'                    => false,
            $this->parameters->commonPath.'plugins/cube/css/cubeportfolio.css'                                       => false
        );
        
        $this->dependenciesCSSBody = array(
        );
        
        $this->dependenciesJSHead = array(
            $this->parameters->commonPath.'library/jquery/jquery.min.js'                                                        => false,
            $this->parameters->commonPath.'library/jquery/jquery.min.1.7.0.js'                                                  => false,
            $this->parameters->commonPath.'library/jquery/jquery-migrate.min.js'                                                => false,
            $this->parameters->commonPath.'library/jquery-mobile/jquery.mobile.min.js'                                          => false,
            $this->parameters->commonPath.'library/modernizr/modernizr.js'                                                      => false,
            $this->parameters->commonPath.'plugins/core_less-js/less.min.js'                                                    => false,
            $this->parameters->commonPath.'plugins/charts_flot/excanvas.js'                                                     => false,
            $this->parameters->commonPath.'plugins/core_browser/ie/ie.prototype.polyfill.js'                                    => false,
            $this->parameters->commonPath.'library/jquery-ui/js/jquery-ui.min.js'                                               => false,
            $this->parameters->commonPath.'plugins/core_jquery-ui-touch-punch/jquery.ui.touch-punch.min.js'                     => false,
        );

        $this->dependenciesJSBody = array(
            $this->parameters->extensionsJsPath.'lazy.js'                                                                       => false,
            $this->parameters->commonPath.'library/bootstrap/js/bootstrap.min.js'                                               => false,
            $this->parameters->commonPath.'plugins/core_nicescroll/jquery.nicescroll.min.js'                                    => false,
            $this->parameters->commonPath.'plugins/core_breakpoints/breakpoints.js'                                             => false,
            $this->parameters->commonPath.'plugins/core_preload/pace.min.js'                                                    => false,
            $this->parameters->commonPath.'components/core_preload/preload.pace.init.js'                                        => false,
            $this->parameters->commonPath.'plugins/menu_sidr/jquery.sidr.js'                                                    => false,
            $this->parameters->commonPath.'components/core/core.init.js'                                                        => false,
            $this->parameters->commonPath.'components/widget_twitter/twitter.init.js'                                           => false,
            $this->parameters->commonPath.'plugins/media_holder/holder.js'                                                      => false,
            $this->parameters->commonPath.'plugins/media_gridalicious/jquery.gridalicious.min.js'                               => false,
            $this->parameters->commonPath.'components/media_gridalicious/gridalicious.init.js'                                  => false,
            $this->parameters->commonPath.'components/media_gridalicious/gridaliciousSearchUsers.init.js'                       => false,
            $this->parameters->commonPath.'components/maps_google/maps-google.init.js'                                          => false,
            $this->parameters->extensionsJsPath.'userMapPosition.init.js'                                                       => false,
            'http://maps.googleapis.com/maps/api/js?v=3&sensor=false&callback=initGoogleMaps'                                   => false,            
            $this->parameters->commonPath.'plugins/ui_modals/bootbox.min.js'                                                    => false,
            $this->parameters->commonPath.'components/menus/sidebar.main.init.js'                                               => false,
            $this->parameters->commonPath.'components/menus/sidebar.collapse.init.js'                                           => false,
            $this->parameters->commonPath.'components/menus/menus.sidebar.chat.init.js'                                         => false,
            $this->parameters->commonPath.'plugins/other_mixitup/jquery.mixitup.min.js'                                         => false,
            $this->parameters->commonPath.'plugins/other_mixitup/mixitup.init.js'                                               => false,
            $this->parameters->commonPath.'plugins/media_blueimp/js/blueimp-gallery.min.js'                                     => false,
            $this->parameters->commonPath.'plugins/media_blueimp/js/jquery.blueimp-gallery.min.js'                              => false,
            $this->parameters->commonPath.'plugins/media_prettyphoto/js/jquery.prettyPhoto.js'                                  => false,
            $this->parameters->commonPath.'components/media_prettyphoto/prettyphoto.init.js'                                    => false,
            $this->parameters->commonPath.'plugins/cube/jquery.cubeportfolio.min.js'                                            => false,
            $this->parameters->commonPath.'components/cube/cubeportfolio.init.js'                                               => false,
            $this->parameters->commonPath.'components/admin_messages/messages.init.js'                                          => false,
            $this->parameters->commonPath.'components/admin_email/email.init.js'                                                => false,
            $this->parameters->commonPath.'components/ui_modals/modals.init.js'                                                 => false,
            $this->parameters->commonPath.'plugins/notifications_gritter/js/jquery.gritter.min.js'                              => false,
            $this->parameters->commonPath.'components/admin_notifications_gritter/gritter.init.js'                              => false,
            $this->parameters->commonPath.'plugins/forms_elements_bootstrap-select/js/bootstrap-select.js'                      => false,
            $this->parameters->commonPath.'components/forms_elements_bootstrap-select/bootstrap-select.init.js'                 => false,
            $this->parameters->commonPath.'plugins/media_owl-carousel/owl.carousel.min.js'                                      => false,
            $this->parameters->commonPath.'components/admin_events/events-carousel.init.js'                                     => false,
            $this->parameters->commonPath.'components/admin_events/events-speakers.init.js'                                     => false,
            $this->parameters->commonPath.'plugins/forms_elements_uniform/js/jquery.uniform.min.js'                             => false,
            $this->parameters->commonPath.'components/forms_elements_uniform/uniform.init.js'                                   => false,
            $this->parameters->commonPath.'components/tables/tables-classic.init.js'                                            => false,
            $this->parameters->commonPath.'plugins/forms_editors_wysihtml5/js/wysihtml5-0.3.0_rc2.min.js'                       => false,
            $this->parameters->commonPath.'plugins/forms_editors_wysihtml5/js/bootstrap-wysihtml5-0.0.2.js'                     => false,
            $this->parameters->commonPath.'components/forms_editors_wysihtml5/wysihtml5.init.js'                                => false,
            $this->parameters->commonPath.'plugins/ui_pagination/jquery.bootpag.js'                                             => false,
            $this->parameters->commonPath.'components/ui_pagination/jquery.bootpag.init.js'                                     => false,
            $this->parameters->commonPath.'plugins/calendar_fullcalendar/js/fullcalendar.min.js'                                => false,
            $this->parameters->commonPath.'components/calendar/calendar.init.js'                                                => false,
            $this->parameters->commonPath.'plugins/tables_datatables/js/jquery.dataTables.min.js'                               => false,
            $this->parameters->commonPath.'plugins/tables_datatables/extras/TableTools/media/js/TableTools.min.js'              => false,
            $this->parameters->commonPath.'plugins/tables_datatables/extras/ColVis/media/js/ColVis.min.js'                      => false,
            $this->parameters->commonPath.'components/tables_datatables/js/DT_bootstrap.js'                                     => false,
            $this->parameters->commonPath.'components/tables_datatables/js/datatables.init.js'                                  => false,
            $this->parameters->commonPath.'components/forms_elements_fuelux-checkbox/fuelux-checkbox.init.js'                   => false,
            $this->parameters->commonPath.'plugins/tables_datatables/extras/ColReorder/media/js/ColReorder.min.js'              => false,
            $this->parameters->commonPath.'plugins/tables_responsive/js/footable.min.js'                                        => false,
            $this->parameters->commonPath.'components/tables_responsive/tables-responsive-footable.init.js'                     => false,
            $this->parameters->commonPath.'plugins/forms_wizards/jquery.bootstrap.wizard.js'                                    => false,
            $this->parameters->commonPath.'components/forms_wizards/form-wizards.init.js'                                       => false,
            $this->parameters->commonPath.'plugins/forms_elements_bootstrap-switch/js/bootstrap-switch.js'                      => false,
            $this->parameters->commonPath.'components/forms_elements_bootstrap-switch/bootstrap-switch.init.js'                 => false,
            $this->parameters->commonPath.'components/forms_elements_fuelux-radio/fuelux-radio.init.js'                         => false,
            $this->parameters->commonPath.'plugins/forms_elements_jasny-fileupload/js/bootstrap-fileupload.js'                  => false,
            $this->parameters->commonPath.'components/forms_elements_button-states/button-loading.init.js'                      => false,
            $this->parameters->commonPath.'plugins/forms_elements_select2/js/select2.js'                                        => false,
            $this->parameters->commonPath.'components/forms_elements_select2/select2.init.js'                                   => false,
            $this->parameters->commonPath.'plugins/forms_elements_multiselect/js/jquery.multi-select.js'                        => false,
            $this->parameters->commonPath.'components/forms_elements_multiselect/multiselect.init.js'                           => false,
            $this->parameters->commonPath.'plugins/forms_elements_inputmask/jquery.inputmask.bundle.min.js'                     => false,
            $this->parameters->commonPath.'components/forms_elements_inputmask/inputmask.init.js'                               => false,
            $this->parameters->commonPath.'plugins/forms_elements_bootstrap-datepicker/js/bootstrap-datepicker.js'              => false,
            $this->parameters->commonPath.'components/forms_elements_bootstrap-datepicker/bootstrap-datepicker.init.js'         => false,
            $this->parameters->commonPath.'components/plugins/forms_elements_bootstrap-timepicker/js/bootstrap-timepicker.js'   => false,
            $this->parameters->commonPath.'components/forms_elements_bootstrap-timepicker/bootstrap-timepicker.init.js'         => false,
            $this->parameters->commonPath.'plugins/forms_elements_colorpicker-farbtastic/js/farbtastic.min.js'                  => false,
            $this->parameters->commonPath.'components/forms_elements_colorpicker-farbtastic/colorpicker-farbtastic.init.js'     => false,
            $this->parameters->commonPath.'plugins/forms_validator/jquery-validation/dist/jquery.validate.min.1.13.js'          => false,
            $this->parameters->commonPath.'plugins/forms_validator/jquery-validation/dist/jquery.validate.1.9.0.js'             => false,
            $this->parameters->commonPath.'plugins/forms_validator/jquery-validation/dist/jquery.validate.min.js'               => false,
            $this->parameters->extensionsJsPath.'tooltipster.init.js'                                                           => false,
            $this->parameters->commonPath.'components/forms_validator/form-validator.signup.js'                                 => false,
            $this->parameters->commonPath.'components/forms_validator/form-validator.signup.landing.js'                         => false,
            $this->parameters->commonPath.'components/forms_validator/form-validator.login.js'                                  => false,
            $this->parameters->commonPath.'components/forms_validator/form-validator.login.landing.js'                          => false,
            $this->parameters->commonPath.'components/forms_validator/form-validator.modifyAccount.js'                          => false,            
            $this->parameters->commonPath.'plugins/forms_file_dropzone/js/dropzone.min.js'                                      => false,
            $this->parameters->commonPath.'components/forms_file_dropzone/dropzone.init.js'                                     => false,
            $this->parameters->commonPath.'plugins/forms_file_plupload/plupload.full.js'                                        => false,
            $this->parameters->commonPath.'plugins/forms_file_plupload/jquery.plupload.queue/jquery.plupload.queue.js'          => false,
            $this->parameters->commonPath.'components/forms_file_plupload/plupload.init.js'                                     => false,
            $this->parameters->commonPath.'plugins/ui_sliders_range_mousewheel/jquery.mousewheel.min.js'                        => false,
            $this->parameters->commonPath.'plugins/ui_sliders_range_jqrangeslider/js/jQAllRangeSliders-withRuler-min.js'        => false,
            $this->parameters->commonPath.'components/ui_sliders_range/range-sliders.init.js'                                   => false,
            $this->parameters->commonPath.'components/ui_sliders_range/range-slidersSearchUsers.init.js'                        => false,
            $this->parameters->commonPath.'components/ui_sliders_jqueryui/jqueryui-sliders.init.js'                             => false,
            $this->parameters->commonPath.'plugins/charts_flot/jquery.flot.js'                                                  => false,
            $this->parameters->commonPath.'plugins/charts_flot/jquery.flot.resize.js'                                           => false,
            $this->parameters->commonPath.'plugins/charts_flot/plugins/jquery.flot.tooltip.min.js'                              => false,
            $this->parameters->commonPath.'components/charts_flot/flotcharts.common.js'                                         => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-simple.init.js'                                     => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-mixed-1.init.js'                                    => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-line-2.init.js'                                     => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-line.init.js'                                       => false,
            $this->parameters->commonPath.'plugins/charts_flot/plugins/jquery.flot.orderBars.js'                                => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-bars-ordered.init.js'                               => false,
            $this->parameters->commonPath.'plugins/charts_flot/jquery.flot.pie.js'                                              => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-donut.init.js'                                      => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-bars-stacked.init.js'                               => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-pie.init.js'                                        => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-bars-horizontal.init.js'                            => false,
            $this->parameters->commonPath.'components/charts_flot/flotchart-autoupdating.init.js'                               => false,
            $this->parameters->commonPath.'plugins/notifications_notyfy/js/jquery.notyfy.js'                                    => false,
            $this->parameters->commonPath.'components/admin_notifications_notyfy/notyfy.init.js'                                => false,
            $this->parameters->commonPath.'plugins/media_image-crop/js/jquery.Jcrop.js'                                         => false,
            $this->parameters->commonPath.'components/media_image-crop/image-crop.init.js'                                      => false,
            $this->parameters->commonPath.'plugins/other_infinite-scroll/jquery.jscroll.js'                                     => false,
            $this->parameters->commonPath.'components/other_infinite-scroll/infinite-scroll.init.js'                            => false,
            $this->parameters->commonPath.'plugins/maps_vector/jquery-jvectormap-1.2.2.min.js'                                  => false,
            $this->parameters->commonPath.'plugins/maps_vector/data/gdp-data.js'                                                => false,
            $this->parameters->commonPath.'plugins/maps_vector/maps/jquery-jvectormap-world-mill-en.js'                         => false,
            $this->parameters->commonPath.'plugins/maps_vector/maps/jquery-jvectormap-us-aea-en.js'                             => false,
            $this->parameters->commonPath.'plugins/maps_vector/maps/jquery-jvectormap-de-merc-en.js'                            => false,
            $this->parameters->commonPath.'plugins/maps_vector/maps/jquery-jvectormap-fr-merc-en.js'                            => false,
            $this->parameters->commonPath.'plugins/maps_vector/maps/jquery-jvectormap-es-merc-en.js'                            => false,
            $this->parameters->commonPath.'plugins/maps_vector/maps/jquery-jvectormap-us-lcc-en.js'                             => false,
            $this->parameters->commonPath.'plugins/maps_vector/maps/mall-map.js'                                                => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.france-elections.init.js'                         => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.mall-map.init.js'                                 => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.projection-map.init.js'                           => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.random-colors.init.js'                            => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.region-selection.init.js'                         => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.usa-unemployment.init.js'                         => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.world-map-gdp.init.js'                            => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.world-map-markers.init.js'                        => false,
            $this->parameters->commonPath.'components/maps_vector/maps-vector.tabs.js'                                          => false,
            $this->parameters->commonPath.'components/admin_employees/employees.init.js'                                        => false,
            $this->parameters->commonPath.'plugins/charts_easy_pie/js/jquery.easy-pie-chart.js'                                 => false,
            $this->parameters->commonPath.'components/charts_easy_pie/easy-pie.init.js'                                         => false,
            $this->parameters->commonPath.'components/core_medical/medical.init.js'                                             => false,
            $this->parameters->commonPath.'plugins/charts_flot/plugins/jquery.flot.growraf.js'                                  => false,
            $this->parameters->commonPath.'plugins/core_prettyprint/js/prettify.js'                                             => false,
            $this->parameters->commonPath.'components/admin_news/news-featured-2.init.js'                                       => false,
            $this->parameters->commonPath.'components/admin_news/news-featured-1.init.js'                                       => false,
            $this->parameters->commonPath.'components/admin_news/news-featured-3.init.js'                                       => false,
            $this->parameters->commonPath.'components/admin_invoice/invoice.init.js'                                            => false,
            $this->parameters->commonPath.'plugins/charts_sparkline/jquery.sparkline.min.js'                                    => false,
            $this->parameters->commonPath.'components/charts_sparkline/sparkline.init.js'                                       => false,            
            $this->parameters->commonPath.'plugins/media_holder/holder.js'                                                      => false,            
            $this->parameters->extensionsJsPath.'jqueryExtends.js'                                                              => false,
            $this->parameters->extensionsJsPath.'managerLinks.js'                                                               => false,
//            $this->parameters->extensionsJsPath.'main.js'                                                                       => false,
                        
        );
                
    }
}//End Class
