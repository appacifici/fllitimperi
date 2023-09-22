<?php

namespace AppBundle\Service\WidgetService;

class CoreListPolls {

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
     
        $polls = $this->wm->doctrine->getRepository( 'AppBundle:Poll' )->getAllPollsAndPagination( $pagination->getLimit() );
        
        if ( !empty( $polls ) ) {
         
            foreach ($polls as $item) {
                $poll[$item->getId()]['id'] = $item->getId();
                $poll[$item->getId()]['answers'] = json_decode($item->getJsonAnswers());
                $poll[$item->getId()]['question'] = $item->getQuestion();
                $poll[$item->getId()]['dataArticleId'] = $item->getDataArticleId();
            }
        }
        
        $twigT = $this->wm->getVersionSite().'/widget_InfiniteScrollPollsGlobal.html.twig';

        
        return $this->wm->container->get('twig')->render( $twigT, 
                array( 
                    'polls' => $poll, 
                    'ajax' => true, 
                    'page' => $this->wm->getPage() )
        );
    }
    
    
    public function processData($options = false) {
        $poll = false;
        $answers = null;
        
        $pagination    = $this->wm->container->get( 'app.paginationUtility' );
        $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totPolls' ) );
        $pagination->getLimit();
        
        $polls = $this->wm->doctrine->getRepository( 'AppBundle:Poll' )->getAllPollsAndPagination( $pagination->getLimit() );
        
        if ( !empty( $polls ) ) {
         
            foreach ($polls as $item) {
                $poll[$item->getId()]['id'] = $item->getId();
                $poll[$item->getId()]['answers'] = json_decode($item->getJsonAnswers());
                $poll[$item->getId()]['question'] = $item->getQuestion();
                $poll[$item->getId()]['dataArticleId'] = $item->getDataArticleId();
            }
        }
        
        
        
        return array(
            'polls' => $poll,
            'page' => $this->wm->getPage()
        );
    }

}
