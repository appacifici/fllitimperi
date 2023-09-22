<?php

namespace AppBundle\Service\WidgetService;

class CoreCatSubcatTypologyListAcquistiGiusti {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData( $options = false ) {        
        $parmas = $this->wm->getCatSubcatTypology();        
        $aSearchTerms               = array();
        $enabledSearchTerms         = false;        
        
        $sectionItems = false;
        $paginationProd = false;
                
        $catSubcatTypology = $parmas['catSubcatTypology'];        
        $this->globalQueryUtility = $this->wm->container->get( 'app.globalQueryUtility' );
        $response = $this->globalQueryUtility->getCatSubcatTypology( $catSubcatTypology, false, $parmas['typeSection'] );        
        
        $category       = $response->category;
        $subcategory    = $response->subcategory;
        $typology       = $response->typology;
        $microSection   = $response->microSection;
        
        $categoryId         = false;
        $subcategoryId      = false;
        $typologyId         = false;
        $microSectionId     = false;
        
        if( empty( $category ) &&  empty( $subcategory ) && empty( $typology )  && empty( $microSection ) ) {            
            return array( 'errorPage' => 404 );
        }
        
        $limitModels =  false;
        //Se è la url di una categoria ES: /elettrodomestici
        if( !empty( $category ) ) {
            $sectionItems = array();
            $i = 0;
            foreach ( $category->getSubcategories() as $subcat ) {
                if( $subcat->getIsActive() ) {
                    $sectionItems[$i]['img']            = $this->wm->container->getParameter( 'app.folder_img_subcategories' ).$subcat->getImg();
                    $sectionItems[$i]['name']           = $subcat->getName();
                    $sectionItems[$i]['hasProduct']     = $subcat->getHasProducts();
                    $sectionItems[$i]['url']            = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $subcat->getCategory()->getNameUrl(), 'section2' => $subcat->getNameUrl() ) 
                    );
                    $i++;
                }                
            }
            $label              = new \stdClass;
            $label->name        = $category->getName();
            $label->nameUrl     = $category->getNameUrl();
            $label->description = $category->getDescription(); 
            $label->img         = $this->wm->container->getParameter( 'app.folder_img_category' ).$category->getImg(); 
            $label->body        = $category->getBody(); 
            $label->bg          = $category->getBgColor(); 
            $categoryId         = $category->getId();   
            $limitModels        = true;
        }
        
        //Se è la url di una sottocategoria ES: /elettrodomestici/piccoli_elettrodomestici
        if( !empty( $subcategory ) ) {
            $sectionItems = array();
            $i = 0;
            foreach ( $subcategory->getTypology() as $typo ) {
                if( $typo->getIsActive() ) {
                    $sectionItems[$i]['img']            = $this->wm->container->getParameter( 'app.folder_img_typologies' ).$typo->getImg();
                    $sectionItems[$i]['name']           = $typo->getName();
                    $sectionItems[$i]['hasProduct']     = $typo->getHasProducts();
                    $sectionItems[$i]['url']            = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
                        'section1' => $typo->getCategory()->getNameUrl(),  'section2' => $typo->getSubcategory()->getNameUrl(), 'section3' => $typo->getNameUrl() ) 
                    );
                    $i++;
                }                
            }
//            print_r($sectionItems);
            $label = new \stdClass;
            $label->name = !empty( $subcategory->getLabel() ) ? $subcategory->getLabel()  : $subcategory->getName();
            $label->nameUrl = $subcategory->getNameUrl();
            $label->description = $subcategory->getDescription(); 
            $label->body = $subcategory->getBody(); 
            $label->img =  $this->wm->container->getParameter( 'app.folder_img_subcategories' ).$subcategory->getImg(); 
            $label->bg          = $subcategory->getCategory()->getBgColor(); 
            
            $categoryId         = $subcategory->getCategory()->getId();
            $subcategoryId      = $subcategory->getId();            
            
            $limitModels =  count( $subcategory->getTypology() ) > 0  ? true : false;            
            $enabledSearchTerms = count( $subcategory->getTypology() ) > 0  ? false : true;            
        }
        
        //Se è la url di una sottocategoria ES: /elettrodomestici/piccoli_elettrodomestici
        if( !empty( $typology ) ) {
            $sectionItems = array();
            $i = 0;
            
            //TODO: DA SCOMMENTARE SE SI VOGLIONO RIATTIVARE LE MICRO SEZIONI
//            foreach ( $typology->getMicroSection() as $micro ) {
//                if( $micro->getIsActive() ) {
//                    $sectionItems[$i]['img']            = $this->wm->container->getParameter( 'app.folder_img_microsection' ).$micro->getImg();
//                    $sectionItems[$i]['name']           = $micro->getName();
//                    $sectionItems[$i]['hasProduct']     = $micro->getHasProducts();
//                    $sectionItems[$i]['url']            = $this->wm->routerManager->generate( 'catSubcatTypologyProduct', array( 
//                        'section1' => $micro->getCategory()->getNameUrl(),  'section2' => $micro->getSubcategory()->getNameUrl(), 'section3' => $micro->getTypology()->getNameUrl(), 'section4' => $micro->getNameUrl() ) 
//                    );
//                    $i++;
//                }                
//            }
            $label = new \stdClass;
            $label->name = $typology->getName();
            $label->nameUrl = $typology->getNameUrl(); 
            $label->description = $typology->getDescription(); 
            $label->img =  $this->wm->container->getParameter( 'app.folder_img_typologies' ).$typology->getImg(); 
            $label->body = $typology->getBody(); 
            $label->bg          = $typology->getCategory()->getBgColor(); 
            
            $categoryId         = $typology->getCategory()->getId();
            $subcategoryId      = $typology->getSubcategory()->getId();        
            $typologyId         = $typology->getId();        
            
//            $limitModels =  count( $typology->getMicroSection() ) ? true : false;
//            $enabledSearchTerms = count( $typology->getMicroSection() ) > 0  ? false : true;            
            
            $limitModels =   false;
            $enabledSearchTerms = true;            
        }
        
        if( !empty( $microSection ) ) {
            $label = new \stdClass;
            $label->name = $microSection->getName();
            $label->nameUrl = $microSection->getNameUrl();
            $label->description = $microSection->getDescription(); 
            $label->img =  $this->wm->container->getParameter( 'app.folder_img_typologies' ).$microSection->getImg(); 
            $label->body = $microSection->getBody(); 
            $label->bg          = $microSection->getCategory()->getBgColor(); 
            
            $categoryId         = $microSection->getCategory()->getId();
            $subcategoryId      = $microSection->getSubcategory()->getId();        
            $typologyId         = $microSection->getTypology()->getId();        
            $microSectionId     = $microSection->getId();        
            $enabledSearchTerms = true;
        }
        
        
        if( empty( $limitModels ) ) {
            $pagination    = $this->wm->container->get( 'app.paginationUtility' );
            $pagination->getParamsPage( $this->wm->container->getParameter( 'app.totListModels' ) );
            
            $count = $this->wm->doctrine->getRepository( 'AppBundle:Model' )->getCountModelsList( false, $categoryId, $subcategoryId, $typologyId, $microSectionId );        
            $models = $this->wm->doctrine->getRepository('AppBundle:Model')->getModelsList( $pagination->getLimit(), false, $categoryId, $subcategoryId, $typologyId, $microSectionId );

            $pagination->init( $count['tot'], $this->wm->container->getParameter( 'app.toLinksPagination' ), false, false, true );
            $paginationProd = $pagination->makeList();                    
            $this->wm->container->get( 'twig' )->addGlobal( 'lastPagePagination', $pagination->lastPage() );
            
//            $lastModels = $this->wm->doctrine->getRepository('AppBundle:Model')->getModelsList( 5, false, $categoryId, $subcategoryId, $typologyId, $microSectionId, 'm.dateImport DESC' );
        } else {
            $models = $this->wm->doctrine->getRepository('AppBundle:Model')->getModelsList( 10, 1, $categoryId, $subcategoryId, $typologyId, $microSectionId );
            $lastModels = $this->wm->doctrine->getRepository('AppBundle:Model')->getModelsList( 5, false, $categoryId, $subcategoryId, $typologyId, $microSectionId, 'm.dateImport DESC' );
        }
        
        
        $x = 0;
        $allModels = array();
        foreach ( $models as $model ) {       
            if( !empty( $model->getTypology() ) ) {
                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(),'section2' => $model->getSubcategory()->getNameUrl(), 'section3' => $model->getTypology()->getNameUrl() ) );
            } else {
                $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl() ) );
            }
            
            
            $allModels[$x]['id']              = $model->getId();
            $allModels[$x]['name']            = utf8_decode( $model->getName() );
            $allModels[$x]['nameUrl']         = $urlModel;
            $allModels[$x]['hasProduct']      = $model->getHasProducts();
            $allModels[$x]['isTop']           = $model->getIsTop();         
            $allModels[$x]['widthSmall']      = $model->getWidthSmall();  
            $allModels[$x]['heightSmall']     = $model->getHeightSmall();  
//            $allModels[$x]['bulletPoints']    = preg_split( "/;/", $model->getBulletPoints(), -1, PREG_SPLIT_NO_EMPTY );
            $allModels[$x]['bulletPoint']     = trim( trim( str_replace( ";", ", ", $model->getBulletPoints() ) ), ',' );
            $allModels[$x]['hasProducts']     = $model->getHasProducts();  
            $allModels[$x]['advisedPrice']    = $model->getAdvisedPrice();  
            $allModels[$x]['price']           = $this->wm->setPrice( $model->getPrice() );
            $allModels[$x]['lastPrice']       = $model->getLastPrice();  
            $allModels[$x]['img']             = $model->getImg();  
            $allModels[$x]['category']        = $model->getCategory();  
            $allModels[$x]['subcategory']     = $model->getSubcategory();  
            $allModels[$x]['typology']        = $model->getTypology();  
            $allModels[$x]['saving']          = (int)$model->getAdvisedPrice() - (int)$model->getPrice();
            $x++;
        }
        
        
//        $x = 0;
        $allLastModels = array();
        if( !empty( $lastModels ) ) {
            foreach ( $lastModels as $model ) {       
                if( !empty( $model->getTypology() ) ) {
                    $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(),'section2' => $model->getSubcategory()->getNameUrl(), 'section3' => $model->getTypology()->getNameUrl() ) );
                } else {
                    $urlModel = $this->wm->routerManager->generate( 'detailProduct', array( 'name' => $model->getNameUrl(), 'section1' => $model->getCategory()->getNameUrl(), 'section2' => $model->getSubcategory()->getNameUrl() ) );
                }
                $allLastModels[$x]['id']              = $model->getId();
                $allLastModels[$x]['name']            = utf8_decode( $model->getName() );
                $allLastModels[$x]['nameUrl']         = $urlModel;
                $allLastModels[$x]['hasProduct']      = $model->getHasProducts();
                $allLastModels[$x]['isTop']           = $model->getIsTop();         
                $allLastModels[$x]['widthSmall']      = $model->getWidthSmall();  
                $allLastModels[$x]['heightSmall']     = $model->getHeightSmall();  
//                $allLastModels[$x]['bulletPoints']    = preg_split( "/;/", $model->getBulletPoints(), -1, PREG_SPLIT_NO_EMPTY );
                $allLastModels[$x]['bulletPoint']     = trim( trim( str_replace( ";", ", ", $model->getBulletPoints() ) ), ',' );
                $allLastModels[$x]['hasProducts']     = $model->getHasProducts();  
                $allLastModels[$x]['advisedPrice']    = $model->getAdvisedPrice();  
                $allLastModels[$x]['price']           = $model->getPrice();  
                $allLastModels[$x]['lastPrice']       = $model->getLastPrice();  
                $allLastModels[$x]['img']             = $model->getImg();  
                $allLastModels[$x]['category']        = $model->getCategory();  
                $allLastModels[$x]['subcategory']     = $model->getSubcategory();  
                $allLastModels[$x]['typology']        = $model->getTypology();  
                $allLastModels[$x]['saving']          = (int)$model->getAdvisedPrice() - (int)$model->getPrice();
                $x++;
            }
        }
        
        if( $enabledSearchTerms ) {          
            $aSearchTerms = $this->wm->container->get('app.coreGetSearchTerms')->getSearchTerms( $categoryId, $subcategoryId, $typologyId, 'catSubcatTypologyProduct', false );        
        }
        
        return array(
            'models' => $allModels,
            'lastModels' => $allLastModels,
            'sectionItems' => $sectionItems,
            'aSearchTerms' => $aSearchTerms,
            'label' => $label,
            'pagination'                => $paginationProd,
            'countArticles'             => !empty( $count ) ? $count['tot'] : 0,
            'page'                      => $this->wm->getPage()
        );
    } 
}