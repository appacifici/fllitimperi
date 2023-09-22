<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DetailArticleController extends TemplateController {
            
    
    public function speakArticleAction( $articleId, Request $request ) {    
        $article = $this->getDoctrine()->getRepository('AppBundle:DataArticle')->findOneById( $articleId );   
        $body =  $article->getContentArticle()->getBody();
        return $this->render('template/widget_SpeakArticle.html.twig', array('body' => $body));
    }       
    
//    
//    /**
//    * @Route( "/blog/{articleId}/{title}.html", name="lastDetailNews", requirements={"articleId": "\d+"}) )     
//    */
//    public function lastIndexAction( $articleId, $title, Request $request ) {     
//        $this->setParameters();
//        $article = $this->getDoctrine()->getRepository('AppBundle:DataArticle')->findOneByLastDbId( $articleId );         
//        if( empty( $article ) ) {            
//                return $this->redirectToRoute( 'homepage', array(
//            )); 
//        }
//        return $this->redirectToRoute( 'detailNews', array(
//            'articleId' => $article->getId(),
//            'title' => $this->globalConfigManager->globalUtility->rewriteUrl( $title )
//        ), 301); 
//    }
//    
    
    
     
    
}