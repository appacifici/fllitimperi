<?php

namespace AppBundle\Service\WidgetService;

class CorePoll {

    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct(WidgetManager $widgetManager) {
        $this->wm = $widgetManager;      
    }

    public function processData($options = false) {        
        if( !empty( $_GET['idPoll'] ) ) {
            
            $poll = $this->wm->doctrine->getRepository( 'AppBundle:Poll' )->findOneBy( array( 'id' =>  $_GET['idPoll'] ) );
            $metaTitle =  $fbMetaTitle = $twitterMetaTitle = $poll->getQuestion();
            
            $desc = '';
            $ans = json_decode($poll->getJsonAnswers() );
            foreach( $ans AS $a ) {
                $desc .= $a->answer.' - ';
            }
            $desc = trim( $desc, '- ');
            
            $metaDesc = $fbMetaDescription = $twitterMetaDescription = $desc;
            
            $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', html_entity_decode( $metaTitle ) );

            if (!empty( $fbMetaTitle ) )
                $this->wm->container->get( 'twig' )->addGlobal( 'fbTitle', html_entity_decode( $fbMetaTitle ) );
            if (!empty( $twitterMetaTitle ) )
                $this->wm->container->get( 'twig' )->addGlobal( 'twitterTitle', html_entity_decode( $twitterMetaTitle ) );
            if (!empty( $fbMetaDescription ) )
                $this->wm->container->get( 'twig' )->addGlobal( 'facebookDescription', html_entity_decode( $fbMetaDescription ) );
            if (!empty( $twitterMetaDescription ) )
                $this->wm->container->get( 'twig' )->addGlobal( 'twitterDescription', html_entity_decode( $twitterMetaDescription ) );
        
            $this->wm->container->get( 'twig' )->addGlobal( 'pageDesc', html_entity_decode( $metaDesc ) );                
            $this->wm->container->get( 'twig' )->addGlobal( 'pagekwds', '' );                
            $this->wm->container->get( 'twig' )->addGlobal( 'ogUrl', 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );        
            return array();
        }
        
        $articleId = $this->wm->getUrlArticleId();        
        $item = array();
        $answers = null;
        
        if( empty( $articleId ) )
            $poll = $this->wm->doctrine->getRepository( 'AppBundle:Poll' )->findPoll( 1 );
        else
            $poll = $this->wm->doctrine->getRepository( 'AppBundle:Poll' )->findOneBy( 
                array( 'dataArticleId' => $articleId )
            );
        
        
        if ( !empty( $poll ) ) {
            $item['id'] = $poll->getId();
            $item['answers'] = json_decode($poll->getJsonAnswers());
            $item['question'] = $poll->getQuestion();
            $item['dataArticleId'] = $poll->getDataArticleId();
        }

        return array(
            'poll' => $item
        );
    }

}
