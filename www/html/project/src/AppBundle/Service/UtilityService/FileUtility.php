<?php

namespace AppBundle\Service\UtilityService;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class FileUtility {    
    
    protected $doctrine;
    protected $container;
    
    public function __construct( Container $container, ObjectManager $doctrine )  {                
        $this->container        = $container;        
        $this->doctrine = $doctrine;
    }
    
    //$pdo, $myFile, $pathDirectoryWrite, $tempDir, dbName, $table, $sessioneId, $idFile = -1, $oldVideo = array(), $nameFormat = ''
//    public function myUploadFiles( $myFile, $pathDirectoryWrite, $tempDir, $entityName, $indexId = false, $width = false, $height = false, $idTipo = -1, $oldVideo = array(), $nameFormat = '')  {
    public function myUploadFiles( $myFile, $pathDirectoryWrite, $tempDir, $entityName, $indexId = false, $width = false, $height = false, $idTipo = -1, $oldVideo = array(), $nameFormat = '')  {
        $goUpload = true;		
		$myFiles = null;
        $totFile = 1;	
        $formatsVideo = array( 'video/mp4', 'video/mov', 'video/quicktime', 'video/avi' );
        
        for ( $i = 0; $i < count( $myFile ); $i++ ) {                           
//            if ( empty( $myFile['type'][$i] ) || !in_array( $myFile['type'][$i], $formatsVideo ) )
//                continue;
            
            
            $filePathTmp    = $myFile['tmp_name'][$i];
			$fileType       = $myFile['type'][$i];
			
            if ( empty( $oldVideo ) || empty( $oldVideo[$i] ) ) {
                if ($idTipo == -1) {         
                    
                   $qb = $this->doctrine->createQueryBuilder();                                    
                            $result = $qb->select('e')
                            ->from('AppBundle:'.$entityName, 'e')
                            ->orderBy('e.id', 'DESC')
                            ->setMaxResults(1)
                            ->getQuery()
                            ->getSingleResult();
                            $indexId = !empty( $indexId ) ? $indexId : 1;
                            $fileId = !empty( $result ) ? $result->getId() + $indexId : 1;
                } else {
                    $fileId = $idTipo;
                }
                                
                $indexFile = $totFile > 1 ? "_" . $i : '_';
                
                
                if( in_array( $myFile["type"][$i], $formatsVideo ) ) {
                    $ext = 'mp4';
                } else {
                    $ext = explode( '.', $myFile['name'][$i] );
                    $ext = $ext[1];
                }                               
                
                if (!empty( $nameFormat ) ) {
                    $newFilePath = $fileId . $indexFile . $nameFormat . ".".$ext;
                } else {
                    $newFilePath = $fileId . $indexFile . ".".$ext;
                }

                $hashImg = md5( $newFilePath . $i );
                $dir = "";
                
                for ( $o = 0; $o < 3; $o++ ) {
                    $dir .= $hashImg[$o] . "/";
                }
                
                $myPath = $pathDirectoryWrite . $dir . $newFilePath;
                if ( !file_exists( dirname( $myPath ) ) ) {
                    mkdir(dirname($myPath), 0777, 1);
                }
                $myFiles[$i] = $dir . $newFilePath;
                
            } else {
                $fileId = $fileId;
                $myPath = $pathDirectoryWrite . $oldVideo[$i];

                if ( !file_exists( dirname( $myPath ) ) ) {
                    mkdir( dirname( $myPath ), 0777, 1 );
                }
                $myFiles[$i] = $oldVideo[$i];
            }			
            
            if( in_array( $myFile["type"][$i], $formatsVideo ) ) {
                rename( $filePathTmp, $myPath );
                
                //AAC/H.264
                rename( $filePathTmp, $myPath.'_avconv' );                
                //exec( 'avconv -i '.$myPath.'_avconv'.' -codec copy  "'.$myPath.'"' );
                exec( "avconv -i '{$myPath}_avconv' -vcodec libx264 -preset ultrafast -vprofile baseline -acodec aac -strict experimental -r 24 -b 255k -ar 44100 -ab 59k '{$myPath}'" );
                //exec( 'ffmpeg -i '.$myPath.'_avconv'.' -vcodec libx264 -vprofile high -preset slow -b:v 500k -maxrate 500k -bufsize 1000k -vf scale=-1:480 -threads 0 -acodec libvo_aacenc -b:a 128k -pix_fmt yuv420p "'.$myPath.'"' );
                //avconv -i infile.mp4 -c:a copy -c:v copy outfile.avi
                //avconv -i 3.mp4 -s 100x100 -strict experimental "4.mp4"
                
            } else {
                
                rename( $filePathTmp, $myPath );
            }
            return $myFiles;
        }
    }
    
}//End Class