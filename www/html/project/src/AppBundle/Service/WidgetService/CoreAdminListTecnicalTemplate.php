<?php

namespace AppBundle\Service\WidgetService;

class CoreAdminListTecnicalTemplate {

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager) {
        $this->wm = $widgetManager;      
    }
    
        public function getDataToAjax() {
      
        $uri = $this->wm->getUri();
        $this->route = $this->wm->container->get('router')->match( $uri );        
       
        //Avvio la paginazione
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totArticleListCategory' ) );
        $pagination->getLimit();
     
        $tecnicals = $this->wm->doctrine->getRepository( 'AppBundle:TecnicalTemplate' )->findAll();
       

        
        return $this->wm->container->get('twig')->render( $twigT, 
                array( 
                    'polls' => $poll, 
                    'ajax' => true, 
                    'page' => $this->wm->getPage() )
        );
    }
    
    
    public function processData($options = false) {
        $tecnicals = $this->wm->doctrine->getRepository( 'AppBundle:TecnicalTemplate' )->findAll();
        
        
        return array(
            'tecnicals' => $tecnicals
        );
    }

}
