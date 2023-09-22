<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WidgetController extends TemplateController {
        
    /**
     * @Route( "/iframe/livematches/{idsMatches}", defaults={"idsMatches" = null}, name="iframeLive" )
     */
    public function indexAction( Request $request, $idsMatches ) {    
        $params = new \stdClass;
        $params->customMatches = $idsMatches;
       
        return new Response( $this->init( "iframeLive.xml", $request, $params ) );        
    }
    
     /**
     * @Route( "/iframe/goals", name="iframeLiveGoals" )
     */
    public function lastGoalsAction( Request $request  ) {    
        $params = new \stdClass;
        return new Response( $this->init( "iframeLastGoals.xml", $request, $params ) );        
    }
    
     /**
     * @Route( "/iframe/odds", name="iframeOdds" )
     */
    public function oddsAction( Request $request  ) {    
        $params = new \stdClass;
        $params->tabLivescore = 'odds';
       
        return new Response( $this->init( "iframeOdds.xml", $request, $params ) );        
    }
    
     /**
     * @Route( "/iframe/livematch/{id}", name="iframeLiveMatch" )
     */
    public function liveMatchAction( Request $request, $id ) {    
        $params = new \stdClass;
        $params->openMatchId = $id;
       
        return new Response( $this->init( "iframeLiveMatch.xml", $request, $params ) );        
    }
   
   
}
