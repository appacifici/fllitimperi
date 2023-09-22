<?php

namespace AppBundle\Service\MaintenanceService;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Service\UtilityService\GlobalUtility;

class ManageArticle {
    private $container;
    private $doctrine;
    
    /**
     * When creating a new parseRestClient object
     * send array with 'restkey' and 'appid'
     * 
     */
    public function __construct( ObjectManager $doctrine, Container $container, GlobalUtility $globalUtility ) {
        $this->doctrine = $doctrine;
        $this->container = $container; 
        $this->globalUtility = $globalUtility; 
    }

    /**
     * Metodo che elimina le immagini top News quando gli articoli sono stati pubblicati da più di un mese
     */
    public function run( $dbHost, $dbPort, $dbName, $dbUser, $dbPswd, $action, $limit = 5000 ) {
        $this->dbHost      = $dbHost;
        $this->dbPort      = $dbPort;
        $this->dbName      = $dbName;
        $this->dbUser      = $dbUser;
        $this->dbPswd      = $dbPswd;
        $this->mySql = new \PDO('mysql:host='.$dbHost.';port='.$dbPort.';', $dbUser, $dbPswd);
        
        
         switch ( $action ) {
            case 'refactorMetaTagArticleSEO':
                $this->refactorMetaTagArticleSEO( $limit );
            break;
            case 'writePermalink':
                $this->writePermalink( $limit );
            break;
         }
    }
    
    /**
     * 
     */
    private function refactorMetaTagArticleSEO( $limit ) {
        echo $sql = "SELECT * FROM $this->dbName.content_articles "
                . "limit $limit";
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $rows = $sth->fetchAll( \PDO::FETCH_OBJ );
//        print_r($rows);exit;
        foreach ( $rows as $article ) {
            echo $article->body."\n";
            
            echo "########################################################\n";
            echo "########################################################\n";
            echo "########################################################\n";
            echo "########################################################\n";
            echo "########################################################\n";
            
            
            $search = array(
                '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
                '/[^\S ]+\</s',     // strip whitespaces before tags, except space
                '/(\s)+/s',         // shorten multiple whitespace sequences
    //            '/<!--(.|\s)*?-->/' // Remove HTML comments
            );

            $replace = array(
                '>',
                '<',
                '\\1',
                ''
            );
    //        return $html;
            $article->body =  preg_replace($search, $replace, $article->body); 
                        
            //modifica i tag <h4><strong> dentro un li in solo strong
            $article->body =  preg_replace('/<li><h3><strong>(.*?)<\/strong><\/h3>(.*?)<\/li>/s', "<li><strong>$1</strong>$2</li>", $article->body);
                       
            //modifica i tag <h4><strong> dentro un li in solo strong
            $article->body =  preg_replace('/<li><h3>(.*?)<\/h3>(.*?)<\/li>/s', "<li><strong>$1</strong>$2</li>", $article->body);
                                    
            //modifica i tag <h4><strong> dentro un li in solo strong
            $article->body =  preg_replace('/<li><h4><strong>(.*?)<\/strong><\/h4>(.*?)<\/li>/s', "<li><strong>$1</strong>$2</li>", $article->body);
                        
            //modifica i tag <h4> dentro un li in solo strong
            $article->body = preg_replace('/<li><h4>(.*?)<\/h4>(.*?)<\/li>/s', "<li><strong>$1</strong>$2</li>", $article->body );

            //modifica i tag <h4> dentro un li in solo strong
            $article->body =  preg_replace('/<li><h5><strong>(.*?)<\/strong><\/h5>(.*?)<\/li>/s', "<li><strong>$1</strong>$2</li>", $article->body );

            //modifica i tag <h4> dentro un li in solo strong
            $article->body =  preg_replace('/<li><h5>(.*?)<\/h5>(.*?)<\/li>/s', "<li><strong>$1</strong>$2</li>", $article->body );
            
            //modifica i tag <h4> dentro un li in solo strong
            $article->body =  preg_replace('/<li><h6><i>(.*?)<\/i><\/h6>(.*?)<\/li>/s', "<li><strong>$1</strong>$2</li>", $article->body );

            //modifica i tag <h4> dentro un li in solo strong
            $article->body = preg_replace('/<li><h6>(.*?)<\/h6>(.*?)<\/li>/s', "<li><strong>$1</strong>$2</li>", $article->body );          
            
            $article->body = str_replace( array('<h3>','</h3>', '<h4>', '</h4>'), array('<h2>','</h2>', '<h3>', '</h3>'), $article->body );            
            
            //modifica i tag <h4> dentro un li in solo strong
            $article->body = preg_replace('/<h3><strong>(.*?)<\/strong><\/h3>/s', "<h3>$1</h3>", $article->body );
            
            //modifica i tag <h4> dentro un li in solo strong
            $article->body = preg_replace('/<h2><strong (.*?)>(.*?)<\/strong><\/h2>/s', "<h2 $1>$2</h2>", $article->body );
            
            //modifica i tag <h4> dentro un li in solo strong
            $article->body = preg_replace('/<h3><strong>(.*?)<\/strong><\/h3>/s', "<h3>$1</h3>", $article->body );
            
            echo $article->body."\n\n";
            
            $sql = "UPDATE $this->dbName.content_articles SET body =". $this->mySql->quote( $article->body )." WHERE id = ".$article->id;
            $sth = $this->mySql->prepare( $sql );
            $sth->execute();
            
            echo $sql."\n\n";
            
            
        }
    }
    
    /**
     * Metodo che scrive i permalink
     * @param type $limit
     */
    private function writePermalink( $limit ) {
        echo $sql = "SELECT * FROM $this->dbName.content_articles "
                . "WHERE content_articles.permalink = '' limit $limit";
        $sth = $this->mySql->prepare( $sql );
        $sth->execute();
        $rows = $sth->fetchAll( \PDO::FETCH_OBJ );
//        print_r($rows);exit;
        foreach ( $rows as $article ) {
            $permalink =  $this->globalUtility->rewriteUrl( $article->title );
            $sqlUp = "UPDATE $this->dbName.content_articles SET permalink = '$permalink' WHERE id = $article->id";
            $this->mySql->query( $sqlUp );
            echo $sqlUp."\n";
        }
    }
}

//https://gist.github.com/joashp/b2f6c7e24127f2798eb2
//https://developers.google.com/cloud-messaging/http-server-ref


