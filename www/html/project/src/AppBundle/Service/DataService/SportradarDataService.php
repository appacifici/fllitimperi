<?php namespace AppBundle\Service\SportradarDataService;

use AppBundle\Service\SportradarDataService\Entity\Layer\SportradarDataLayer;
use AppBundle\Service\SportradarDataService\ArrayElement\ArrayElementHandler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Monolog\Logger;

class SportradarDataService {

    /**
     * The injected entitiesHandler service
     * @var EntitiesHandler
     */
    protected $arrayElementHandler;

    /**
     * The injected Monolog service
     * @var Logger
     */
    protected $logger;

    /**
     * The injected Parser service
     * @var Parser
     */
    protected $parser;

    public function __construct(Parser $parser, Logger $logger) {
        $this->logger = $logger;
        $this->parser = $parser;
    }

    /**
     * Get the last periodic feed parsed (the last feed is given by the Id)
     * @return SportradarData
     */
    public function getLatestPeriodicFeedParsed() {
        return $this->arrayElementHandler
            ->getDoctrine()
            ->getRepository('AppBundle:SportradarData')
            ->findOneBy([
                'updateType'    => 'periodic'
            ], [
                'id'            => 'DESC'
            ]);
    }

    /**
     * Get the last periodic parsed feed with the most updated data
     * @return SportradarData
     */
    public function getMostRecentPeriodicFeedParsed() {
        return $this->arrayElementHandler
            ->getDoctrine()
            ->getRepository('AppBundle:SportradarData')
            ->findOneBy([
                'updateType'    => 'periodic'
            ], [
                'generatedAt'   => 'DESC'
            ]);
    }

    /**
     * Parse the given feed
     * @param string $feed The path of the feed to parse
     * @param string $origin The origin of the file
     *                       - socket: the file comes from the NodeJS socket
     *                       - ftp: the file comes from the FTP
     *                       - NULL: the default value
     * @return Object The object with the data fetched from the XML feeds
     */
    public function parse( $feed, $folder, $feedType =  null ) {
        if( empty( $feedType ) )
            $feedType = 'from_socket_to_entity_json';
//            $feedType = 'from_socket_to_client';        
        
        // Transform the given XML feed to an Object        

        $this->parser->parse($feed, $folder, $feedType);        
    }
    
}
