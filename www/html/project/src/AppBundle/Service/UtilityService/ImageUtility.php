<?php

namespace AppBundle\Service\UtilityService;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class ImageUtility {    
    
    protected $doctrine;
    protected $container;
    
    public function __construct( Container $container, ObjectManager $doctrine )  {                
        $this->container        = $container;        
        $this->doctrine = $doctrine;
    }
    
    public function resizeImg($maxWidth, $maxHeight, $widthFoto, $heightFoto, $style = 4) {
        
		// horizontale
		//echo $widthFoto.' '.$heightFoto.'<===<br>';
		if ($widthFoto >= $heightFoto && $widthFoto > $maxWidth) {
			$ratio = $maxWidth / $widthFoto;
			$newWidth = round($widthFoto * $ratio);
			$newHeight = round($heightFoto * $ratio);
			$ratio = 1;
			// dopo resize, altezza + grande del maxHeight
			if ($newHeight > $maxHeight) {
				$ratio = $maxHeight / $newHeight;
			}
			// verticale
		} else if ($heightFoto >= $widthFoto && $heightFoto > $maxHeight) {
			$ratio = $maxHeight / $heightFoto;
			$newWidth = round($widthFoto * $ratio);
			$newHeight = round($heightFoto * $ratio);
			$ratio = 1;
			// dopo resize, larghezza + grande del maxWidth

			if ($newWidth > $maxWidth) {
				$ratio = $maxWidth / $newWidth;
			}
		} else {
			$ratio = 1;
			$newWidth = $widthFoto;
			$newHeight = $heightFoto;
		}

		$newWidth = round($newWidth * $ratio);
		$newHeight = round($newHeight * $ratio);

		$margin = round($maxHeight - $newHeight);
		$margin = round($margin / 2);

		$marginLeft = round($maxWidth - $newWidth);
		$marginLeft = round($marginLeft / 2);

		if ($style == 1) {
			return "width:" . $newWidth . "px; height:" . $newHeight . "px";
		} else if ($style == 2) {
			return "width:" . $newWidth . "px; height:" . $newHeight . "px; margin-top:" . $margin . "px";
		} else if ($style == 3) {
			return "width:" . $newWidth . "px; height:" . $newHeight . "px; margin-left:" . $marginLeft . "px";
		} else if ($style == 4) {
			return "width:" . $newWidth . "px; height:" . $newHeight . "px;margin-top:" . $margin . "px; margin-left:" . $marginLeft . "px";
		} else if ($style == 5) {
            $params = new \stdClass();
			$params->width = $newWidth;
			$params->height = $newHeight;
			$params->marginTop = $margin;
			$params->marginLeft = $marginLeft;
			$params->maxWidth = $maxWidth;
			$params->maxHeight = $maxHeight;
			return $params;
		} else {
			return array($newWidth, $newHeight);
		}
	}
    
    /**
     * Metodo che genera i campi per la stampa a dimesioni delle immagini
     * @param array$article
     * @param array $types
     */
    public function formatPath ( &$images, $types, $style ) {
        if( empty( $images ) )
            return false;
        
        foreach( $types AS $type ) {            
            $fnGetWidth = 'getWidth'.ucfirst( $type );
            $fnGetHeigth = 'getHeight'.ucfirst( $type );
            $imgStyle = $this->resizeImg( 
                $this->container->getParameter( "app.img_{$type}_width" ), 
                $this->container->getParameter( "app.img_{$type}_height" ), 
                $images->$fnGetWidth(), 
                $images->$fnGetHeigth(), 
                $style
            );                                  
            
            
            $src = 'src'. ucfirst( $type );
            $styleImg = 'style'.ucfirst( $type );
            
            $images->{$src} = $this->container->getParameter( 'app.folder_img_'.$type ).$images->getSrc();
            $images->{$styleImg} = $imgStyle;  
        }        
    }
    
    /*	 * **********************************************************************************************************************************
	 * * FUNZIONE PER L'UPLOAD DELLE IMMAGINI SUL SITO
	 * * PARAMETRI:
	 * *              $myFile(ARRAY) = ARRAY CONTENENTE I FILE DA CARICARE
	 * *              $totFile(INT) = MASSIMO FILE DA CARICARE MASSIMO 5 CONTEMPORANEI
	 * *              $pathDirectoryWrite(STRING) = PATH CARTELLA DI SCRITTURA PER I FILE
	 * *              $tempDir(STRING) =PATH CARTELLA TEMPORANEA DI SCRITTURA PER I FILE
	 * *              $width(INT) = LARGHEZZA MASSIMA CONSENTITA
	 * *              $height(INT) = ALTEZZA MASSIMA CONSENTITA
	 * *              $db(STRING) = DATABASE ATTUALE
	 * *              $entityName(STRING) = Entita DI LAVORO PER RECUPER NEXT ID DA ASSEGNARE ALLA FOTO
	 * *              $sessioneId(STRING) = SESSION ID PER NOME FOTO TEMPORANEA
	 * *              $idTipo(INT) = SE -1 SI TRATTA DI UN NUOVO FILE, SE > -1 SI TRATTA DI UNA SOSTITUZIONE DI FOTO
	 * *********************************************************************************************************************************** */

	function myUpload($myFile, $pathDirectoryWrite, $tempDir, $width, $height, $entityName, $indexId = false,  $idTipo = -1, $oldFoto = array(), $columnImg = false, $ext = 'jpg', $nameFormat = '', $noDir = false) {		
		$goUpload = true;
		$totFile = 1;
		$arrayFormati = array('image/gif', 'image/png', 'image/jpeg', 'image/jpeg', 'image/jpeg');
		$aDimension = array('small', 'medium', 'large');
		$myFoto = null;
		$dim = null;
		
		for ($x = 0; $x < $totFile; $x++) {
//			if ($myFile["name"][$x] !='' && in_array($myFile["type"][$x],$arrayFormati)) {
			$fileFoto['name'][$x] = $myFile["name"][$x];
			$fileFoto['tmp_name'][$x] = $myFile["tmp_name"][$x];
			$fileFoto['type'][$x] = $myFile["type"][$x];
			//}
		}
        
		for ($i = 0; $i < $totFile; $i++) {
//            echo 'si';
			//foreach ($fileFoto["name"] AS $foto) {
			$imagepath = $fileFoto['tmp_name'][$i];
			$imageType = $fileFoto['type'][$i];
			if ($imagepath) {                
				$myTempImgName = $tempDir . rand() . ".".$ext;
				if ( $dim[$i] = $this->resizeConvertImage($imagepath, $imageType, $width, $height, $ext, $myTempImgName, $pathDirectoryWrite)) {                    
					if( empty( $dim[$i] ) )
						return false;
					     
					if (empty($oldFoto) || !$oldFoto[$i]) {                                     
						if ($idTipo == -1) {                            
                            $qb = $this->doctrine->createQueryBuilder();                                    
                            $result = $qb->select('e')
                            ->from('AppBundle:'.$entityName, 'e')
                            ->orderBy('e.id', 'DESC')
                            ->setMaxResults(1)
                            ->getQuery()
                            ->getOneOrNullResult();
                            
                            $indexId = !empty( $indexId ) ? $indexId : 1;
                            $immagineId = !empty( $result ) ? $result->getId() + $indexId : 1;
                            
						} else {            
							$immagineId = $idTipo;
						}
						$okIdArticolo = true;
						$indice_foto = $totFile > 1 ? "_" . $i : '';                        
                        
						if (!empty($nameFormat))
							$newImagePath = $nameFormat. $indice_foto . ".".$ext;
						else
							$newImagePath = $immagineId . $indice_foto . ".".$ext;

						$hashImg = md5( $newImagePath . $i);
						$dir = "";
                        if( !$noDir ) {
                            for ($o = 0; $o < 4; $o++) {
                                $dir .= $hashImg[$o] . "/";
                            }
                        }
						$myPath = $pathDirectoryWrite . $dir . $newImagePath;
						if ( !file_exists( dirname( $myPath ) ) ) {
//                            $old = umask(0);
							mkdir( dirname( $myPath ), 0777, 1 );
//                            umask( $old );
						}
						$myFoto[$i] = $dir . $newImagePath;
//                        exit;
					} else {                                
                        $qb = $this->doctrine->createQueryBuilder();                                    
                            $result = $qb->select('e')
                            ->from('AppBundle:'.$entityName, 'e')
                            ->where( 'e.id = '.$idTipo )
                            ->orderBy('e.id', 'DESC')
                            ->setMaxResults(1)
                            ->getQuery()
                            ->getOneOrNullResult();                            
                            
                        $immagineId =  $result->getId();
                        $okIdArticolo = true;                        
                        $indice_foto = $totFile > 1 ? $indexId."_"  : $indexId."_" ;
//                        echo $indice_foto;
                        if ( !empty( $nameFormat ) ) {
                            $newImagePath =  $indice_foto . $nameFormat . ".".$ext;
//                            echo 'uno';
                        } else {
                            $newImagePath = $immagineId . $indice_foto . ".".$ext;
//                            echo 'due';
                        }

                        $hashImg = md5( $newImagePath . $i);
                        $dir = "";
                        for ($o = 0; $o < 4; $o++) {
                            $dir .= $hashImg[$o] . "/";
                        }
                        $myPath = $pathDirectoryWrite . $dir . $newImagePath;
                        if (!file_exists(dirname($myPath))) {
                            mkdir(dirname($myPath), 0777, 1);
                        }
                        $myFoto[$i] = $dir . $newImagePath;                            
                        
					}                    

                    @rename($myTempImgName, $myPath);                                        
                    $command1 = 'jpegoptim '.$myPath.' -p -o -m100 --strip-all';
                    
                    try {
                        if( $ext == 'jpg' ) {
                            exec( $command1 );
                        }                        
                                                
                    } catch ( Exception $e ) {
                        ;
                    }
				}
			}
		}
        
		return array("foto" => $myFoto, "dim" => $dim);
	}

	public function setTransparency($new_image, $image_source) {
		$transparencyIndex = @imagecolortransparent($image_source);
		$transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
		if ($transparencyIndex >= 0) {
			$transparencyColor = @imagecolorsforindex($image_source, $transparencyIndex);
		}
		$transparencyIndex = @imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
		@imagefill($new_image, 0, 0, $transparencyIndex);
		@imagecolortransparent($new_image, $transparencyIndex);
	}

	public function resizeConvertImage2($path, $typeIn, $maxWidth, $maxHeight, $typeOut = "gif", $pathToOutput, $percorsoTrim = '', $fileLocale = true) {
        
        $width = 30;
        $height = 48;
        $scale = 1;
        $image = $path;
        
        $size = getimagesize($path);        
        
        $dst_w = $maxWidth; $dst_h = $maxHeight;
        
        $src_image = @imagecreatefrompng($path);
        
        list($imagewidth, $imageheight, $imageType) = getimagesize($path);
        $imageType = image_type_to_mime_type($imageType);
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        
        
        $dst_x=0;
        $dst_y=0;
        if( $size[0]>$maxWidth or $size[1]>$maxHeight )
        {
        $centerX = $size[0]/2;
        $centerY = $size[1]/2;
        if( $size[0] > $size[1] ){
        $src_y = 0;
        $src_x = $centerX-$centerY;
        $src_h = $size[1];
        $src_w = $size[1];
        }
        else{
        $src_x = 0;
        $src_y = $centerY-$centerX;
        $src_w = $size[0];
        $src_h = $size[0];
        }
        }
        
        $dst_image = imagecreatetruecolor($newImageWidth,$newImageHeight);

        imagealphablending($dst_image, false);
        imagesavealpha($dst_image,true);
        $transparent = imagecolorallocatealpha($dst_image, 255, 255, 255, 127);
        imagefilledrectangle($dst_image, 0, 0, $dst_w, $dst_h, $transparent);
        
        imagecopyresampled ( $dst_image , $src_image , $dst_x , $dst_y , $src_x , $src_y , $dst_w , $dst_h , $src_w , $src_h );
     
        echo $path;
        
         @imagepng($dst_image,$pathToOutput);
        
        
        exit;
        chmod($image, 0777);
        return $image;
        
        exit;
        
    }
    
	public function resizeConvertImage($path, $typeIn, $maxWidth, $maxHeight, $typeOut = "gif", $pathToOutput, $percorsoTrim = '', $fileLocale = true) {
		$arrayFormati = array('gif' => 'image/gif', 'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg');
		$sessionId = substr(session_id(), 1, 10);
		
		$pathToOutput = $pathToOutput == "" ? $default->fileTMP . "/temp.jpg" : $pathToOutput;
		
        switch ( $typeIn ) {
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/pjpeg':
				$im = @imagecreatefromjpeg( $path );
				break;
			case 'image/gif':
				$im = @imagecreatefromgif( $path );
				break;
			case 'image/png':
			case 'image/x-png':
				$im = @imagecreatefrompng( $path );
				break;
			default:
				return false;
		}
		
		if( empty( $im ) ) {
            $dimensioni['width'] = 0;
            $dimensioni['height'] = 0;
            return $dimensioni;
			echo "Utility.class.php error cropImage non valid image im for: ".$path;
			return false;
		}
		
		$imgw = imagesx( $im );
		$imgh = imagesy( $im );
		
//		$minW = $imgw;
//		$minH = $imgh;
//		$maxW = $maxH = 0;
//		
//		// Find the size of the borders
//        $top = 0;
//        $bottom = 0;
//        $left = 0;
//        $right = 0;
//        $bgcolor = 0xFFFFFF; // Use this if you only want to crop out white space
////        $bgcolor = imagecolorat( $im, $top, $left ); // This works with any color, including transparent backgrounds
//
//        
//        //top
//        for(; $top < $imgh; ++$top) {
//          for($x = 0; $x < $imgw; ++$x) {
//            if(imagecolorat($im, $x, $top) != $bgcolor) {
//               break 2; //out of the 'top' loop
//            }
//          }
//        }
//        //bottom
//        for(; $bottom < $imgh; ++$bottom) {
//          for($x = 0; $x < $imgw; ++$x) {
//            if(imagecolorat($im, $x, $imgh - $bottom-1) != $bgcolor) {
//               break 2; //out of the 'bottom' loop
//            }
//          }
//        }
//        //left
//        for(; $left < $imgw; ++$left) {
//          for($y = 0; $y < $imgh; ++$y) {
//            if(imagecolorat($im, $left, $y) != $bgcolor) {
//               break 2; //out of the 'left' loop
//            }
//          }
//        }
//        //right
//        for(; $right < $imgw; ++$right) {
//          for($y = 0; $y < $imgh; ++$y) {
//            if(imagecolorat($im, $imgw - $right-1, $y) != $bgcolor) {
//               break 2; //out of the 'right' loop
//            }
//          }
//        }

        
        if( $typeOut == 'png' ) {
            $dst_w = $imgw;
            $dst_h = $imgh;
        } else {
//            $dst_w = $imgw-($left+$right);
//            $dst_h = $imgh-($top+$bottom);
            
            $dst_w = $imgw;
            $dst_h = $imgh;
        }
        
//        
        
        if ($dst_w >= $dst_h && $dst_w > $maxWidth) {
			$ratio = $maxWidth / $dst_w;
			// verticale
		} else if ($dst_h >= $dst_w && $dst_h > $maxHeight) {
			$ratio = $maxHeight / $dst_h;
		} else {
			$ratio = 1;
		}
		$dst_h = $dst_h * $ratio;
		$dst_w = $dst_w * $ratio;
        

        $dst_image = imagecreatetruecolor($dst_w,$dst_h);
        
        if( $typeOut == 'png' ) {
//            exit;
            imagealphablending($dst_image, false);
            imagesavealpha($dst_image,true);
            $transparent = imagecolorallocatealpha($dst_image, 255, 255, 255, 127);
            imagefilledrectangle($dst_image, 0, 0, $dst_w, $dst_h, $transparent);        
            imagecopyresampled ( $dst_image , $im , 0 , 0 , 0, 0, $dst_w , $dst_h , $imgw , $imgh );
        } else {            
//            imagecopy($dst_image, $im, 0, 0, $left, $top, imagesx($dst_image), imagesy($dst_image));
            imagecopyresampled ( $dst_image , $im , 0 , 0 , 0, 0, $dst_w , $dst_h , $imgw , $imgh );
        }
        
        switch($typeOut) {
            case 'jpg':
                    @imagejpeg($dst_image,$pathToOutput);
                    break;
            case 'gif':
                    @imagegif($dst_image,$pathToOutput);
                    break;
            case 'png':
                    @imagepng($dst_image,$pathToOutput);
                    break;
            default:
                    return false;
        }		             
        
        $dimensioni['width'] = $dst_w;
        $dimensioni['height'] = $dst_h;
        return $dimensioni;
    }
    
    function exifImagetype($img) {        
        
		switch( @exif_imagetype( $img ) ) {
            case IMAGETYPE_GIF:
                return 'image/gif';
            break;
            case IMAGETYPE_JPEG:
                return 'image/jpeg';
            break;
            case IMAGETYPE_PNG:
                return 'image/png';
            break;
            case IMAGETYPE_BMP:
                return 'image/bmp';
            break;
        }
        
	}
    function myGetTypeImgBack($img) {
		$formati = array(
			'gif' => 'image/gif',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'png' => 'image/png',
			'bmp' => 'image/bmp'
		);
		foreach ($formati AS $key => $formato) {
			if (preg_match_all("/\b" . $key . "\b/i", $img, $matches))
				return $formato;
		}        
	}
    
    function myGetTypeImg($img) { 
        $type = false;
        try {
            $type =  @$this->exifImagetype( $img );
            if( empty( $type ) ) {
                if( is_object( $img ) )
                    $type =  @$this->myGetTypeImgBack( $img->getMimeType() );
            }
            return $type;
        } catch (\Exception $e) {
            return false;
        } catch (\Symfony\Component\Debug\Exception\FatalThrowableError $e) {
            return false;
        }         
		
	}
    
    /**
	 * 
	 * @param type $source_file
	 * @return boolean
	 */
	static function cropImage( $source_file, $typeIn, $pathToOutput, $typeOut='jpg' ) {
		//$im = ImageCreateFromJpeg( $source_file );	
		
		switch ( $typeIn ) {
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/pjpeg':
				$im = @imagecreatefromjpeg( $source_file );
				break;
			case 'image/gif':
				$im = @imagecreatefromgif( $source_file );
				break;
			case 'image/png':
			case 'image/x-png':
				$im = @imagecreatefrompng( $source_file );
				break;
			default:
				return false;
		}
		
		if( empty( $im ) ) {
			echo "Utility.class.php error cropImage non valid image im for: ".$source_file;
			return false;
		}
		
		$imgw = imagesx( $im );
		$imgh = imagesy( $im );
		
		$minW = $imgw;
		$minH = $imgh;
		$maxW = $maxH = 0;
		
		for ($i = 0; $i < $imgw; $i++) {
			for ($j = 0; $j < $imgh; $j++) {

				// get the rgb value for current pixel
				$rgb = ImageColorAt( $im, $i, $j );
				// extract each value for r, g, b
				$r = ( $rgb >> 16 ) & 0xFF;
				$g = ( $rgb >> 8 ) & 0xFF;
				$b = $rgb & 0xFF;
				
				if ( ( $r + $g + $b ) < 730 ) {
					$maxW = max( $maxW, $i);
					$maxH = max( $maxH, $j);
					$minW = min( $minW, $i);
					$minH = min( $minH, $j);
					continue;
				}
			}
		}
		
		$destW = $maxW - $minW;
		$destH = $maxH - $minH;
		
		$image_resized = imagecreatetruecolor($destW, $destH);
		imagecopy( $image_resized, $im, 0, 0, $minW, $minH, $destW, $destH );
		
		//imagejpeg( $image_resized, $pathToOutput ); 
		
		
		
		return array( 'width' => $destW, 'height' => $destH, 'image' => $image_resized );
	}
	
	static function RGBHistogram( $source_file ) {
		$im = ImageCreateFromJpeg( $source_file );

		$imgw = imagesx( $im );
		$imgh = imagesy( $im );

		// n = total number or pixels

		$n = $imgw * $imgh;

		$histo = array();

		for ($i = 0; $i < $imgw; $i++) {
			for ($j = 0; $j < $imgh; $j++) {

				// prendo il valore rgb del pixel
				$rgb = ImageColorAt( $im, $i, $j );

				// estraggo i colori di r, g, b
				$r = ( $rgb >> 16 ) & 0xFF;
				$g = ( $rgb >> 8 ) & 0xFF;
				$b = $rgb & 0xFF;
				
				// approssimo il colore.
				$r = round( $r / 10 ) * 10;
				$g = round( $g / 10 ) * 10;
				$b = round( $b / 10 ) * 10;
				
				// get the Value from the RGB value
				$V = round( ( $r + $g + $b ) / 3 );
				
				// tolgo tutti i valori vicini al bianco.
				if ( $V >= 240 )
					continue;
				
				// add the point to the histogram
				$color = "{$r},{$g},{$b}";
				$histo[$color] += $V / $n;
			}
		}
		asort($histo);
		return $histo;
	}
	
	static function drawRGBHistogram( $histo ) {
		// histogram options
		$maxheight = 300;
		$barwidth = 5;
		
		// find the maximum in the histogram in order to display a normated graph
		$max = 0;
		$min = 100000000000;
		foreach( $histo as $value ) {
			$max = max( $max, $value );
			$min = min( $min, $value );
		}
		$mean = ( $max - $min ) / 2;
		$html = "<div style='border: 1px solid'>";
		foreach( $histo as $color => $value ) {
			$h = ( $value / $max ) * $maxheight;
			if ( $h > ( $maxheight * 0.1 ) )
				$html .= "<div style=\"width:{$barwidth}px; height:{$h}px; float: left; background: rgb({$color}); margin-left: 2px; border: 1px solid #000; \">&nbsp;</div>";
		}
		$html .= "<div style='clear:both;'></div>";
		$html .= "</div>";
		
		return $html;
	}
    
    
}//End Class