<?php

namespace AppBundle\Service\WidgetService;
use Symfony\Component\HttpFoundation\Response;

class CoreDetailArticle {
    
    /**
     * Viene inniettato il servizio WidgetManager che contiene
     * @param \AppBundle\Service\WidgetService\WidgetManager $widgetManager
     */
    public function __construct( WidgetManager $widgetManager ) {
        $this->wm = $widgetManager;
    }
    
    public function processData() {             
        $titleNews                   = $this->wm->getUrlTitleNews();            
        $setLike                     = $this->wm->getSetLikeArticle();            
        $em = $this->wm->doctrine;
//        
//        if( empty( $id ) ) {
//            $this->wm->container->get( 'twig' )->addGlobal( 'ampHtmlUrl', false );  
//            return array( 'errorPage' => 404 );
//        }
        
        $megazineSection    = $this->wm->getMegazineSection( 'megazineSection' );        
        $megazineSection = 'recensioni';
        
        
        $parseUrl = explode( '/', trim( $this->wm->getRequestUri(),' /' ) );
        $megazineSection = $parseUrl[0] != 'amp' ? $parseUrl[0] : $parseUrl[1];       
        
        
        $megazineSection    = $this->wm->doctrine->getRepository( 'AppBundle:MegazineSection' )->findByNameUrl( $megazineSection );
        $megazineSectionId  =  !empty( $megazineSection ) ? $megazineSection->getId() : false;
        if( empty( $megazineSectionId ) ) {  
            $this->wm->container->get( 'twig' )->addGlobal( 'ampHtmlUrl', false );  
            return array( 'errorPage' => 404 );
        }

        $article               = $this->wm->doctrine->getRepository('AppBundle:DataArticle')->getArticleDetail( $megazineSectionId, $titleNews, true );        
        
        if( empty( $article ) ) {  
            $this->wm->container->get( 'twig' )->addGlobal( 'ampHtmlUrl', false );  
            return array( 'errorPage' => 404 );
        }
        
        if( !empty( $article->getArticleId() ) && empty( $parseUrl[2] ) ) {
            $this->wm->container->get( 'twig' )->addGlobal( 'ampHtmlUrl', false );  
            return array( 'errorPage' => 404 );
        }
                
                        
        if( !empty( $setLike ) )
            $this->addLike( $article );
        
//        if ( !empty( $article->getViews() ) ) {
//            $views = $article->getViews();
//            $article->setViews( $views+1 );
//            $em->persist( $article );
//            $em->flush(); 
//        } else {
//            $article->setViews( 1 );
//            $em->persist( $article );
//            $em->flush();
//        }
        
        
        //Cicla e finalizza l'arrey degli articoli
        
        if( !empty( $article->getPriorityImg() ) ) {
            $image = $article->getPriorityImg();
            $this->wm->imageUtility->formatPath( $image, array('small','medium','big'), 1 );
            $image->styleMedium = "width:360px; height:165px";
        }                                

        
        
        $views = !empty( $article->getViews() ) ? $article->getViews() : null;
          
        $metaTitle                  = !empty( $article->getContentArticle()->getMetaTitle() ) ? $article->getContentArticle()->getMetaTitle() : $article->getContentArticle()->getTitle();
        $metaDesc                   = !empty( $article->getContentArticle()->getMetaDescription() ) ? $article->getContentArticle()->getMetaDescription()  : $article->getContentArticle()->getSubHeading();
        $fbMetaTitle                = !empty( $article->getContentArticle()->getFbMetaTitle() ) ? $article->getContentArticle()->getFbMetaTitle() : $metaTitle;
        $twitterMetaTitle           = !empty( $article->getContentArticle()->getTwitterMetaTitle() ) ? $article->getContentArticle()->getTwitterMetaTitle() : $metaTitle;
        $fbMetaDescription          = !empty( $article->getContentArticle()->getfbMetaDescription() ) ? $article->getContentArticle()->getfbMetaDescription() : $metaDesc;
        $twitterMetaDescription     = !empty( $article->getContentArticle()->getTwitterMetaDescription() ) ? $article->getContentArticle()->getTwitterMetaDescription() : $metaDesc;
        
        $isVideoCategory =  !empty( $article->getCategory() ) && !empty( $article->getCategory()->getName() ) && strtolower( $article->getCategory()->getName() ) == 'video' ? true : false;     
        
        $this->wm->container->get( 'twig' )->addGlobal( 'pageTitle', html_entity_decode( $metaTitle ) );
        $this->wm->container->get( 'twig' )->addGlobal( 'idNews', $article->getId() );
        
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
        $this->wm->container->get( 'twig' )->addGlobal( 'ogType', 'article' );        
        
        if( !empty( $article->getImages()[0] ) ) {            
            $this->wm->container->get( 'twig' )->addGlobal( 'ogImage', 'https://'.$_SERVER['HTTP_HOST'].$this->wm->container->getParameter( 'app.folder_img_big' ).$article->getImages()[0]->getSrc() );
        }
        
        $article->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $article->getContentArticle()->getPermalink() );
        
        $currentDomain = $this->wm->globalConfigManager->getCurrentDomain();
        
        
        $newBody = str_replace( 
                array( 'http://www.'.$currentDomain, 'http://'.$currentDomain ), 
                array( 'https://www.'.$currentDomain, 'https://www.'.$currentDomain ), 
                $article->getContentArticle()->getBody() 
        );
        
       
        $article->getContentArticle()->setBody( $newBody );
        
        
        //Ricava la url del video per al compatibilitià amp
        $aSrc = array();
        preg_match( '/src="([^"]*)"/i', $article->getContentArticle()->getVideo(), $aSrc ) ;
        if( empty( $aSrc ) )
            preg_match( '/src=\'([^\']*)\'/i', $article->getContentArticle()->getVideo(), $aSrc ) ;                
        
        $src = !empty( $aSrc[1] ) ? $aSrc[1] : false;
        $src = strpos( ' '.$src, 'https' ) !== FALSE ? $src : false;  
        $srcYoutube = false;                              
        
                      
        
        if (!empty($article->getImages())) {
            foreach ($article->getImages() as &$image) {
                if( !empty( $image ) ) {                    
                    $this->wm->imageUtility->formatPath( $image, array('small','medium'), 1 );
                }                                                
            }
        }
        
        $article->getContentArticle()->setBody( $this->replaceBody( $article->getContentArticle()->getBody(), $article->getContentArticle()->getVideo() ) );
        
        
        $likes = !empty( $article->getLikes() ) ? $article->getLikes() : null;        
        
                
        $this->wm->container->get( 'twig' )->addGlobal( 'isVideoCategory', $isVideoCategory );                
                
        $coreModelByIds = $this->wm->container->get('app.coreModelByIds');
        $ids = explode( ';', $article->getModelsRank() );
        $models = $coreModelByIds->getByIds( $ids ); 
        
        $maxProduct = 0;
        $rankingModels = array();
        for( $x = 0; $x < count( $ids ); $x++ ) {
            foreach( $models AS $item ) {
//                echo $item['model']->getBulletPointsGuide();Exit;
                $rankingModels[$x]['modelsName']   = $item['model']->getName();            
                $rankingModels[$x]['modelsId']   = $item['model']->getId();            
                $rankingModels[$x]['modelsPrice']   = $item['model']->getPrice();            
                $rankingModels[$x]['modelsImages']   = $item['model']->getImg();            
                $rankingModels[$x]['linkCategoryAmazon']   = $item['model']->getLinkCategoryAmazon();            
                $rankingModels[$x]['label']   = $item['label'];
                $rankingModels[$x]['images']['src']         = $item['model']->getImg();            
                $rankingModels[$x]['images']['widthSmall']         = $item['model']->getWidthSmall();            
                $rankingModels[$x]['images']['heightSmall']         = $item['model']->getHeightSmall();            
                $rankingModels[$x]['images']['name']         = $item['model']->getName();            
                $rankingModels[$x]['products']         = $item['product'];            
                $rankingModels[$x]['disabledProduct']         = $item['disabledProduct'];            
                $rankingModels[$x]['bulletsPoints']         = !empty( $item['model']->getBulletPointsGuide() )  ? $item['model']->getBulletPointsGuide() : false;                           
//                echo $rankingModels[$x]['bulletsPoints'] .'<=';
                $x++;
                $maxProduct = count( $item['product'] ) > $maxProduct ? count( $item['product'] ) : $maxProduct;
            }
        }
        
//        exit;
        
        $this->getDataNewsArticleRichSnippet( $article );        
        $this->getDataGuideRichSnippet( $article, $rankingModels );        
        $this->getQuestion( $article );        
        
        $totItem = 0;
        foreach( $ids AS $id ) {
            if( !empty( $id ) )
                $totItem++;
        }
//        print_r($rankingModels);
//        echo $totItem;
        $widthTD = !empty( $rankingModels ) ? 100 / count($rankingModels) : 25;
        $heightItem = $maxProduct * 42;
        $extraStyle = '';
//        if( $totItem < 5 ) {
            $extraStyle = '.widget-news .ranking .prices img { max-width: 200px; height: auto;     max-height: 32px; } .widget-news .ranking .product div.prices { height:'.$heightItem.'px }';            
//        }
        
        $anchors = explode( '[#]', $article->getAnchors() );
        foreach( $anchors AS &$anchor ) {
            $anchor = str_replace( ' ' , '-', trim($anchor) ); 
        }
                
        $releateds = explode( '[#]', $article->getReleatedArticles() );
        $releatedArticles = $this->wm->doctrine->getRepository('AppBundle:DataArticle')->findRelatedByIds( $releateds );  
        $aReleated = array();
        $x = 0;
        foreach( $releatedArticles AS $a ) {
            $a->getContentArticle()->urlArticle = $this->wm->globalUtility->rewriteUrl( $a->getContentArticle()->getPermalink() );            
            $aReleated[$x]['title'] = !empty( $a->getLabelReleated() ) ? $a->getLabelReleated() : $a->getContentArticle()->getTitle(); 
            
            //Gestione delle url per gli articoli di primo livello e di secondo livello 
            //ES: /passeggini/inglesina <== detailNews2
            $baseArticle = '';
            if( !empty( $a->getArticleId() ) ) {
                $baseArticle = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findOneById( $a->getArticleId() );
                $baseArticle =  $baseArticle->getContentArticle()->getPermalink();

                $aReleated[$x]['href']  = $this->wm->routerManager->generate( 'detailNews2', array(                         
                    'baseArticle' => $baseArticle,
                    'title' => $a->getContentArticle()->urlArticle
                )); 

            } else {                                                                               
                $aReleated[$x]['href'] =  $this->wm->routerManager->generate( 'detailNews'.$a->getMegazineSection()->getId(), array(                         
                    'title' => $a->getContentArticle()->urlArticle
                ));     
            }                       
            $x++;
        }
                                
        $href = $this->wm->routerManager->generate( 'detailNews'.$article->getMegazineSection()->getId() , array(                         
            'title' => $article->getContentArticle()->urlArticle
        ));                
        
        $h2 = !empty( $article->getTypology() ) ? $article->getTypology()->getName() : ( !empty( $article->getSubcategoryOne() ) ? $article->getSubcategoryOne()->getName() : '' );
        
        //abilito inserimento script di google
        $this->wm->container->get( 'twig' )->addGlobal('googleScript', true);
        $this->wm->container->get( 'twig' )->addGlobal('widthTD', $widthTD);
        $this->wm->container->get( 'twig' )->addGlobal('extraStyle', $extraStyle);
        
        
        return array( 
            'widthTD'            => $widthTD,
            'extraStyle'            => $extraStyle,
            'rankingModels'            => $rankingModels,
            'models'            => $models,
            'article'           => $article,
            'aReleated'           => $aReleated,
            'anchors'           => $anchors,
            'srcYoutube'        => $srcYoutube,
            'isVideoCategory'   => $isVideoCategory,
            'likes'             => $likes,
            'views'             => $views,
            'articleHref'       => $href,
            'h2'       => $h2
        );
    } 
    
    private function replaceVideoYouTube( $body, $code ) {                        
        preg_match("/\[\#\#\[([A-Za-z0-9;\_\- ]+?)\]\#\#\]/", $body, $match);
        if( empty( $match ) || empty( $match[1] ) ) {
            return $body;
        }
        
        $strRep = "[##[$match[1]]##]";
        
        if( $this->wm->globalConfigManager->getAmpActive() ) {
            $html = '<amp-youtube data-videoid="'.$match[1].'"
                                     layout="responsive"
                                     width="480" height="270">
                            <amp-img layout="fill" src="{{articles.images[0].srcMedium}}" placeholder></amp-img>
                        </amp-youtube>';
            
        } else {            
            $html = '<iframe src="https://www.youtube.com/embed/'.$match[1].'"></iframe>';
        }
        
        $body = str_replace( $strRep, $html, $body );
        $this->wm->container->get( 'twig' )->addGlobal( 'srcYoutube', true );
        return $body;
        
    }
    
    private function replaceCodes( $longDesc ) {
        preg_match("/\[\#\#\[([A-Za-z0-9;\_\- ]+?)\]\#\#\]/", $body, $match);
        if( empty( $match ) || empty( $match[1] ) ) {
            return $body;
        }
    }
    
    /**
     * Effettua il replace dei modelli che devono essere linkati nel testo
     * @param type $longDesc
     * @return type
     */
    private function replaceBody( $longDesc, $video ) { 
        
        $longDesc = str_replace( '<p>[[ADSGOOGLE]]</p>', '<ins class="adsbygoogle" style="display:block; text-align:center;" data-ad-layout="in-article" data-ad-format="fluid"
     data-ad-client="ca-pub-2895778574087441" data-ad-slot="7201696469"></ins>', $longDesc  );
        
        
        $longDesc = $this->replaceVideoYouTube( $longDesc, $video );  
        
        $longDesc = $this->wm->replaceInternalProductAmazonCode( $longDesc  );
        
        
        if( !empty( $this->wm->globalConfigManager->getAmpActive() ) ) {  
            $longDesc =  $this->wm->globalUtility->html5toampImage( $longDesc, 'responsive' );                
        }
        
                
        $longDesc =  $this->wm->replacePlaceholderInternalLink( $longDesc );                
        
        
        $longDesc = str_replace( '<p></p>', '', $longDesc );
        return html_entity_decode( $longDesc );
    }
    
    /**
     * 
     */
    public function getQuestion( $article ) {
        
        $questions    = $this->wm->doctrine->getRepository( 'AppBundle:Question' )->findByDataArticle( $article->getId() );    
        if( empty( $questions ) ) {
            $this->wm->container->get( 'twig' )->addGlobal('jsonDataQuestionRichSnippet', '' );
            return;
        }
        
        $jsonDataRichSnippet = '{
            "@context":"https://schema.org",
            "@type":"FAQPage",
            "mainEntity":[';
        
            foreach( $questions AS $question ) {
                $jsonDataRichSnippet .= '
                {
                    "@type":"Question",
                    "name":"'.$question->getQuestion().'",
                    "acceptedAnswer":{
                        "@type":"Answer",
                        "text":"'.$question->getAnwser().'"
                    }
                },';
            }
                
        $jsonDataRichSnippet = trim( $jsonDataRichSnippet, ',' );       
        $jsonDataRichSnippet .= ']}';
        
        $this->wm->container->get( 'twig' )->addGlobal('jsonDataQuestionRichSnippet', $jsonDataRichSnippet);
        
    }
    
    /**
     * Genera il rich snippet per la guida
     * @param type $article
     * @return string
     */
    public function getDataGuideRichSnippet( $article, $rankingModels ) {        
        $jsonDataRichSnippet = false;
        
        $base = 'https://'.str_replace( 'app.', 'www.',$_SERVER['HTTP_HOST']);             
        
        $baseArticle = '';
        if( !empty( $article->getArticleId() ) ) {
            $baseArticle = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findOneById( $article->getArticleId() );
            $baseArticle =  $baseArticle->getContentArticle()->getPermalink();

            $href = $this->wm->routerManager->generate( 'detailNews2', array(                         
                'baseArticle' => $baseArticle,
                'title' => $article->getContentArticle()->urlArticle
            )); 

        } else {                                                                               
            $href = $this->wm->routerManager->generate( 'detailNews'.$article->getMegazineSection()->getId(), array(                         
                'title' => $article->getContentArticle()->urlArticle
            ));     
        }
        
        //https://developers.google.com/search/docs/data-types/social-profile-links
        //https://developers.google.com/search/docs/data-types/articles
        //https://developers.google.com/search/docs/data-types/articles#type_definitions
        $logo = $base.'/images/logo_richsnippet.png';
        $img = $base.$this->wm->container->getParameter( 'app.folder_img_big' ).$article->getPriorityImg()->getSrc();
        $publishAt = date("Y-m-d\TH:i:sP", strtotime($article->getPublishAt()->format('Y-m-d H:i:s')));
        $lastModify = date("Y-m-d\TH:i:sP", strtotime($article->getLastModify()->format('Y-m-d H:i:s')));
        $domain = $this->wm->globalConfigManager->getCurrentDomain();
        $widthImg = $article->getPriorityImg()->getWidthBig() >= 696 ? $article->getPriorityImg()->getWidthBig() : 696;
        
        $userPublish = !empty( $article->getUserPublish() ) ? $article->getUserPublish()->getUsername() : 'Redazione';
        
        $richProducts = '';
        
        
        for( $x = 0; $x < count( $rankingModels );   $x++) {
            
            //prende i dati direttamente dal prodotto
            if( !empty( $rankingModels[$x]['products'][0] ) ) {                 
                $link = $this->wm->routerManager->generate( 'impressionLink', array(                         
                    'impressionLink' => $rankingModels[$x]['products'][0]->getImpressionLink(),
                    'deepLink' => $rankingModels[$x]['products'][0]->getDeepLink(),
                )); 

                $richProducts .= '{
                    "@type": "Recommendation",
                    "position": '.($x+1).',
                    "name": "'.$rankingModels[$x]['modelsName'].'",                         
                    "itemReviewed": {
                        "@type": "Product",
                        "name": "'.$rankingModels[$x]['products'][0]->getName().'",
                        "image": [
                            "'.$base.$this->wm->container->getParameter( 'app.folder_imgProductsSmall' ).$rankingModels[$x]['products'][0]->getImg().'"
                        ],                        
                        "offers": {
                            "@type": "Offer",
                            "price": "'.str_replace(',','.',$rankingModels[$x]['products'][0]->getPrice() ).'",
                            "priceCurrency": "EUR",
                            "availability": "http://schema.org/InStock",
                            "url": "'.$link.'"
                        }                   
                    },
                    "author": {
                        "@type": "Person",
                        "name": "'.$userPublish.'"
                    }
                },';
                
            //Prende i dati dal modello in mancanza dei prodotti 
            } else {
                $richProducts .= '{
                    "@type": "Recommendation",
                    "position": '.($x+1).',
                    "name": "'.$rankingModels[$x]['modelsName'].'",                         
                    "itemReviewed": {
                        "@type": "Product",
                        "name": "'.$rankingModels[$x]['modelsName'].'",
                        "image": [
                             "'.$base.$this->wm->container->getParameter( 'app.folder_img_models' ).$rankingModels[$x]['modelsImages'].'"
                        ],
                        "offers": {
                            "@type": "Offer",
                            "price": "'.str_replace(',','.',$rankingModels[$x]['modelsPrice'] ).'",
                            "priceCurrency": "EUR",
                            "availability": "http://schema.org/SoldOut"
                        }                   
                    },
                    "author": {
                        "@type": "Person",
                        "name": "'.$userPublish.'"
                    }
                },';
            }
            
           
        }
        $richProducts = trim( $richProducts,',');
        
        $jsonDataRichSnippet = '
        {
            "@context": "schema.org",
            "@type": "Guide",
            "name": "'.$article->getContentArticle()->getTitle().'",
            "hasPart": 
            [
                 '.$richProducts.'              
            ],
            "datePublished": "'.$publishAt.'",
            "dateModified": "'.$lastModify.'",            
            "publisher": {
              "@type": "Organization",
              "name": "'.ucfirst($domain).'",
              "logo": {
                "@type": "ImageObject",
                "url": "'.$logo.'",
                "height": 60,
                "width": 357
                }
            }
        }';        
        
        $this->wm->container->get( 'twig' )->addGlobal('jsonDataGuideRichSnippet', $jsonDataRichSnippet);
    }
    
    /**
     * Genera il rich snippet per l'articolo
     * @param type $article
     * @return string
     */
    public function getDataNewsArticleRichSnippet( $article ) {
        $jsonDataRichSnippet = false;
        
        $base = 'https://'.str_replace( 'app.', 'www.',$_SERVER['HTTP_HOST']);
             
        
        $baseArticle = '';
        if( !empty( $article->getArticleId() ) ) {
            $baseArticle = $this->wm->doctrine->getRepository( 'AppBundle:DataArticle' )->findOneById( $article->getArticleId() );
            $baseArticle =  $baseArticle->getContentArticle()->getPermalink();

            $href = $this->wm->routerManager->generate( 'detailNews2', array(                         
                'baseArticle' => $baseArticle,
                'title' => $article->getContentArticle()->urlArticle
            )); 

        } else {                                                                               
            $href = $this->wm->routerManager->generate( 'detailNews'.$article->getMegazineSection()->getId(), array(                         
                'title' => $article->getContentArticle()->urlArticle
            ));     
        }
        
                 
        
        //https://developers.google.com/search/docs/data-types/social-profile-links
//        https://developers.google.com/search/docs/data-types/articles
        //https://developers.google.com/search/docs/data-types/articles#type_definitions
        $logo = $base.'/images/logo_richsnippet.png';
        $img = $base.$this->wm->container->getParameter( 'app.folder_img_big' ).$article->getPriorityImg()->getSrc();
        $publishAt = date("Y-m-d\TH:i:sP", strtotime($article->getPublishAt()->format('Y-m-d H:i:s')));
        $lastModify = date("Y-m-d\TH:i:sP", strtotime($article->getLastModify()->format('Y-m-d H:i:s')));
        $domain = $this->wm->globalConfigManager->getCurrentDomain();
        $widthImg = $article->getPriorityImg()->getWidthBig() >= 696 ? $article->getPriorityImg()->getWidthBig() : 696;
        
        $userPublish = !empty( $article->getUserPublish() ) ? $article->getUserPublish()->getUsername() : 'Redazione';
        
        $jsonDataRichSnippet = '                    
        {
            "@context": "http://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage": {
               "@type": "WebPage",
               "@id": "'.str_replace('_','-',$href).'"
            },
            "headline": "'.substr( str_replace( '"', '', $article->getContentArticle()->getTitle() ), 0, 100 ).'",
            "datePublished": "'.$publishAt.'",
            "dateModified": "'.$lastModify.'",
            "author": {
              "@type": "Person",
              "name": "'.$userPublish.'"
            },

            "publisher": {
              "@type": "Organization",
              "name": "'.ucfirst($domain).'",
              "logo": {
                "@type": "ImageObject",
                "url": "'.$logo.'",
                "height": 60,
                "width": 357
                }
            },
            "image": {
              "@type": "ImageObject",
              "url": "'.$img.'",
              "height": '.$article->getPriorityImg()->getHeightBig().',
              "width": '.$widthImg.'
            },
            "description": "'.str_replace( '"', '', $article->getContentArticle()->getSubHeading() ).'"
        }';        
        
        $this->wm->container->get( 'twig' )->addGlobal('jsonDataNewsArticleRichSnippet', $jsonDataRichSnippet);
    }
    
     /**
     * Genera il rich snippet per lla breadcrumbsarticolo
     * @param type $article
     * @return string
     */
    public function getDataRichSnippetBreadcrumbs( $article ) {               
        $domain = $this->wm->globalConfigManager->getCurrentDomain();
        $base = 'https://www.'.$domain;
        
        $i = 1;
        $code = '';
        $categoryUrl = false;
        if( !empty( $article->getCategory() ) ) {
            
            
            $href = $this->wm->container->get('router')->generate(
                'listArticles',
                array( 'category' => $article->getCategory()->getNameUrl() )

            );  
            
            $code .= '{
                "@type": "ListItem",
                "position": '.($i).',
                "item": {
                  "@id": "'.$base.$href.'",
                  "name": "'.ucfirst($article->getCategory()->getName()).'"
                }
              },';
            $categoryUrl = $article->getCategory()->getNameUrl();
            $i++;
        }
        
        if( !empty( $article->getSubcategoryOne() ) ) {
            $href = $this->wm->container->get('router')->generate(
                'listArticles',
                array( 'category' => $categoryUrl, 'subcategory' => $article->getSubcategoryOne()->getNameUrl() )

            );  
            
            $code .= '{
                "@type": "ListItem",
                "position": '.($i).',
                "item": {
                  "@id": "'.$base.$href.'",
                  "name": "'.ucfirst($article->getSubcategoryOne()->getName()).'"
                }
              },';
            $i++;
        }
        
        if( !empty( $article->getSubcategoryTwo() ) ) {
            $href = $this->wm->container->get('router')->generate(
                'listArticles',
                array( 'category' => $categoryUrl, 'subcategory' => $article->getSubcategoryTwo()->getNameUrl() )

            );  
            $code .= '{
                "@type": "ListItem",
                "position": '.($i).',
                "item": {
                  "@id": "'.$base.$href.'",
                  "name": "'.ucfirst($article->getSubcategoryTwo()->getName()).'"
                }
              },';
            $i++;
        }
        
        
        $json = '
        {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
                '.trim( $code, ',' ).'
               
            ]
        }';        
        $this->wm->container->get( 'twig' )->addGlobal('jsonDataRichSnippetBreadcrumbs', $json);
    }
    
    public function addLike ( $article ) {                        
        $article->setLikes( $article->getLikes() + 1 );       
        $em = $this->wm->doctrine;
        $em->persist($article);
        $em->flush();
    }
    
}