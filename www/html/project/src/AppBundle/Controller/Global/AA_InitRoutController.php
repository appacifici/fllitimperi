<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class AA_InitRoutController extends TemplateController {
            
    
    /**
     * @Route( "/info/{page}", name="dinamycPage" )     
     */
    public function indexAction( Request $request ) {          
        $params = new \stdClass;
                
        return new Response( $this->init( "dinamycPage.xml", $request, $params ) );  
    }   
}

//abase_host (direttagol.cgjtz1nav4zs.eu-west-1.rds.amazonaws.com): localhost
//database_port (3306): 
//database_name (direttagol): livescoreServices
//database_user (dgol_user): root
//database_password (dgol_0e830984): R9UXOvtK
//mailer_transport (smtp): 
