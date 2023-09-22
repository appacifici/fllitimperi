<?php
// myapplication/src/sandboxBundle/Command/SocketCommand.php
// Change the namespace according to your bundle
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

// Include ratchet libs
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Change the namespace according to your bundle
use AppBundle\Sockets\Chat;

class SocketCommand extends Command
{
    protected function configure()
    {
        $this->setName('sockets:start-chat')
            // the short description shown while running "php bin/console list"
            ->setHelp("Starts the chat socket demo")
            // the full command description shown when running the command with
            ->setDescription('Starts the chat socket demo')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();             
        $output->writeln([
            'Chat socket',// A line
            '============'
        ]);
        
        $dbHost = $this->getApplication()->getKernel()->getContainer()->getParameter('database_host');
        $dbName = $this->getApplication()->getKernel()->getContainer()->getParameter('database_name');
        $dbUser = $this->getApplication()->getKernel()->getContainer()->getParameter('database_user');
        $dbPswd = $this->getApplication()->getKernel()->getContainer()->getParameter('database_password');
        $host = $this->getApplication()->getKernel()->getContainer()->getParameter('socketChatHostServer');
        $port = $this->getApplication()->getKernel()->getContainer()->getParameter('socketChatPort');
        
        try{                         
            if (!$socket = @fsockopen($host, $port, $errno, $errstr, 3)) {
                echo "Socket server offline... Inizializzo";                     
                $server = IoServer::factory(
                    new HttpServer( 
                        new WsServer(
                            new Chat( $dbHost, $dbName, $dbUser, $dbPswd )
                        )
                    ),
                    $port
                );

                $server->run();
            } else {
               echo "Socket server gia avviato!"; 
            }            
        } catch (React\Socket\ConnectionException $e) {
            echo 'sui';
            ;
        }
    }
}