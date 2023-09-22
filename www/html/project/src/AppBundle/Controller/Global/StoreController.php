<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class StoreController extends TemplateController {
   
    public function storeOpinionsAction( Request $request ) {
       return new Response( 'storeOpinionsAction' ); 
    }
   
    public function storeDatasheetAction( Request $request ) {
       return new Response( 'storeDatasheetAction' ); 
    }
   
    public function storeOffersAction( Request $request ) {
       return new Response( 'storeOffersAction' ); 
    }
    
}
 