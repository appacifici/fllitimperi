<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class CatSubcatTypologyController extends TemplateController {
        
    /**
     * Rotta per la lista di tutte le categorie
     * @param Request $request
     * @return Response
     */
    public function allCategoriesProductAction( Request $request ) {        
        return $this->getPageFromHttpCache( $request, 'allCategories.xml', true );
    }
    
    public function catSubcatTypologyProductTwoAction( Request $request ) {
        return $this->catSubcatTypologyProductAction( $request );
    }
    
    
}