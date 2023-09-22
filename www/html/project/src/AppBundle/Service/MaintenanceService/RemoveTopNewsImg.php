<?php

namespace AppBundle\Service\MaintenanceService;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class RemoveTopNewsImg {
    private $container;
    private $doctrine;
    
    /**
     * When creating a new parseRestClient object
     * send array with 'restkey' and 'appid'
     * 
     */
    public function __construct( ObjectManager $doctrine, Container $container ) {
        $this->doctrine = $doctrine;
        $this->container = $container; 
    }

    /**
     * Metodo che elimina le immagini top News quando gli articoli sono stati pubblicati da più di un mese
     */
    public function deleteTopNewsImg() {
        $folderTopNewsImg = $this->container->getParameter('app.folder_imgTopNews_default_write');
        $results = $this->doctrine->getRepository('AppBundle:DataArticle')->deleteAllTopNewsImg();
        
        foreach ( $results as $article ) {
            $img = $article->getTopNewsImg();
            @unlink( $folderTopNewsImg.$img );
            
            $article->setTopNewsImg( null );
            $this->doctrine->persist( $article );
            $this->doctrine->flush();
        }
    }
}

//https://gist.github.com/joashp/b2f6c7e24127f2798eb2
//https://developers.google.com/cloud-messaging/http-server-ref
