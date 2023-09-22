<?
include("./proxyConnector.class.php");

$proxyConnector = proxyConnector::getIstance();

for($x = 1; $x < 10; $x++ ) {
	$data = $proxyConnector->getContentPage( "http://www.groupednews.com/remoteIp.php" );
	echo $proxyConnector->getRemoteIp( $data ).'<br>';
  $proxyConnector->newIdentity();
}
