<?php
// myapp\src\yourBundle\Sockets\Chat.php;

// Change the namespace according to your bundle, and that's all !
namespace AppBundle\Sockets;
use AppBundle\Entity\ChatMessage;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;    

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct( $dbHost, $dbName, $dbUser, $dbPswd ) {
        $this->clients = new \SplObjectStorage;
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPswd = $dbPswd;
        
        $this->cmsDb = new \PDO('mysql:host='.$this->dbHost.';', $this->dbUser, $this->dbPswd);
        
        $query = "SELECT COUNT(1) AS tot  FROM $this->dbName.chat_messages";
        $sth = $this->cmsDb->prepare( $query );
        $sth->execute();
        $tot = $sth->fetch( \PDO::FETCH_OBJ );
        
        if( $tot->tot < 100 ) {
            for( $x = 0; $x < ( 100 - $tot->tot ); $x++ ) {
                $query = 'INSERT INTO '.$this->dbName.'.chat_messages ( text, create_at, user )
                        VALUES (
                            '.$this->cmsDb->quote( strip_tags( '') ).',
                            '.$this->cmsDb->quote( date( 'Y-m-d h:i:s') ).',
                            '.$this->cmsDb->quote( trim( '' ) ).'
                        )
                ';
                echo $query."\n";
                $this->cmsDb->query( $query );
            }
            
        }                
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {        
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        
        $aMsg = json_decode( $msg );           
        
        $this->cmsDb = new \PDO('mysql:host='.$this->dbHost.';', $this->dbUser, $this->dbPswd);
        
        $query = 'INSERT INTO '.$this->dbName.'.chat_messages ( text, create_at, user )
                    VALUES (
                        '.$this->cmsDb->quote( strip_tags( $aMsg->message ) ).',
                        '.$this->cmsDb->quote( date( 'Y-m-d h:i:s') ).',
                        '.$this->cmsDb->quote( trim( $aMsg->username ) ).'
                    )
            ';
//        echo $query."\n";
        $this->cmsDb->query( $query );
        
        $query = 'DELETE FROM '.$this->dbName.'.chat_messages ORDER BY id ASC limit 1';
        $this->cmsDb->query( $query );
//        echo $query."\n";   
        
        echo sprintf('insert mex in db');
        
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
    
    
}