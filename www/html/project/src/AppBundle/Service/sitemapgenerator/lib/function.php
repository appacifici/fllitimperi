<?php

function specialStripTags($stringa,$consentiti= array(),$arrayProtocol=array(),$tipoPermessi=0){
	require_once('Safe.php');
	require_once('SafeExtend.php');
	$safe = new ControllaHaking($tipoPermessi);
	$eliminaQuot = false;
        $tagConsentiti = '';
	if($consentiti){
		$safe->setAllowTags($consentiti);
		foreach($consentiti AS $myConsentiti){
			$tagConsentiti .= '<'.$myConsentiti.'>';
		}
	}
	//controlla se tra i protoccolli consentiti c'è (href) in caso positivo imposta la valiabile eliminaQuot a true
	// in modo tale che per quel campo saranno eliminati tutti i &quot;
	foreach($arrayProtocol AS $controlloProtocollo){
			if($controlloProtocollo == 'href'){
				 $eliminaQuot = true;
			}
	}
	$arrayProtocol = $arrayProtocol ? $arrayProtocol :  $safe->protocolAttributes;

	$safe->consentiProtocolAttributes($arrayProtocol);
	$nuovaStringa = $safe->parse($stringa);
	$stringaIniziale = $stringa;

	/*Imposta il sistema safe in modo da chiudere solamentente i tag non chiusi all'interno di essa e lascia invece
		tutti i tag ritenuti dannosi ed eliminati nel parse precedente che sarà quello che poi andra inserito nel database
		in modo da poter poi confrontare le due stringe e verificare se è stato eliminato quelche tag rdannoso
	*/
	$ctrHaking = new ControllaHaking($tipoPermessi);
	$ctrHaking->modificaDeleteTagsContent();
	$ctrHaking->setAllowTags($ctrHaking->deleteTags);
	$ctrHaking->consentiProtocolAttributes(array('href'));
	$stringaIniziale = $ctrHaking->parse($stringaIniziale);

	$ctrHaking->controllaStringheHaking($stringaIniziale,$nuovaStringa);


	$caratteri = '<br><a><i><b><strong>'.$tagConsentiti.'';
	$nuovaStringa = strip_tags($nuovaStringa,$caratteri);
	if($eliminaQuot){
   	$nuovaStringa = str_replace('&quot;',"",$nuovaStringa);
	}
	return trim($nuovaStringa);
}

function ricercaAle($datiSelect,$nomeIdBox,$VisualTagsEsist,$cambia,$submitOnClick,$visSelezionato,$aggiungiTags,$tagsEsistenti,$minCarRic,$limitRicerca,$width,$height,$widthIcon=23,$heightIcon=23){
	global $default;
	$boxRicerca = '
	<script type="text/javascript">
		settaConf(\''.$datiSelect.'\',\''.$nomeIdBox.'\','.$cambia.','.$submitOnClick.','.$visSelezionato.','.$aggiungiTags.','.$minCarRic.','.$limitRicerca.','.$width.','.$height.',escape(",'.$tagsEsistenti.',"));
	</script>';
	$boxRicerca .= '<table><tr><td>';
	if($VisualTagsEsist){
		 $boxRicerca .= '<textarea name="tagsVis_'.$nomeIdBox.'"  id="tagsVis_'.$nomeIdBox.'" style="width:'.$width.'px;height:70px" rows="5"  disabled="disabled">'.$tagsEsistenti.'</textarea>';	
	 }
	$boxRicerca .= '<input type="hidden" id="tags_'.$nomeIdBox.'" name="tags_'.$nomeIdBox.'" value=",'.$tagsEsistenti.',"/>
		</td><td></td></tr><tr><td>
		<input autocomplete="off" type="text" onclick="azzeraIndice();" class="tagsRic"  name="tagsRic_'.$nomeIdBox.'" id="tagsRic_'.$nomeIdBox.'" style="width:'.($width+4).'px; height:'.$height.'px"  onkeyup="ricercaConta(event.keyCode,\''.$nomeIdBox.'\')"/><td>';
	if($submitOnClick == 'true' || $visSelezionato == 'true'){
		$boxRicerca .= '<img onclick="cercaDaPulsante()"; src="/img/search.png" class="iconaCerca" style="cursor:pointer;width:'.$widthIcon.'px; height:'.$heightIcon.'px" title="Cerca nel sito" alt="Cerca nel sito">';
	}
	$boxRicerca .= '</td><div id="visualizzatore_'.$nomeIdBox.'">	</div>
	  <input type="hidden" id="tagScelto_'.$nomeIdBox.'" name="tagScelto_'.$nomeIdBox.'" value="" onKeyPress="return false"/>
	  </td></tr></table>';
	return $boxRicerca;
}

function arrangiaUrl ($string) {
			 $string = trim($string);
       $string = html_entity_decode($string);
       $string = strtolower($string);
       $string = strip_tags($string);
       //$string = strtr($string, "çâãàáäåéèêëíìîïñóòôõöøðúùûüýÇÂÃÀÁÄÅÉÈÊËÍÌÎÏÑÓÒÔÕÖØÐÚÙÛÜÝ", "caaaaaaeeeeiiiinooooooouuuuyCAAAAAAEEEEIIIINOOOO0OOUUUUY");
       $string = str_replace( array('à','á','é','è','í','ì','ó','ò','ú','ù'),array('a','a','e','e','i','i','o','o','u','u'),$string ); 
       $string = str_replace( array('À','Á','É','È','Í','Ì','Ó','Ò','Ú','Ù'),array('A','A','E','E','I','I','O','O','U','U'),$string ); 
       $string = preg_replace("|[^A-Za-z0-9àáéèíìóòúù/]|", "-", $string);
       $string = str_replace('/',"-",$string);
       $string = preg_replace('/-+/',"-",$string);
       $string = preg_replace('/-$/',"",$string);
       $string = str_replace('-'," ",$string);
       $string = str_replace(' ',"-",$string);
       return $string;
}

/**
 * Metodo per la scritture delle url
 */
function rewriteUrl ( $string ) {
	$string = trim( $string );
	$string = strip_tags( $string );
	$string = utf8_decode( $string );
    $string = strtr($string, "çâãàáäåéèêëíìîïñóòôõöøðúùûüýÇÂÃÀÁÄÅÉÈÊËÍÌÎÏÑÓÒÔÕÖØÐÚÙÛÜÝ", "caaaaaaeeeeiiiinooooooouuuuyCAAAAAAEEEEIIIINOOOO0OOUUUUY");
	$string = str_replace( array('à','á','é','è','í','ì','ó','ò','ú','ù'),array('a','a','e','e','i','i','o','o','u','u'),$string ); 
	$string = str_replace( array('À','Á','É','È','Í','Ì','Ó','Ò','Ú','Ù'),array('A','A','E','E','I','I','O','O','U','U'),$string );
	$string = strtolower( $string );
	$string = preg_replace( "#[^A-Za-z0-9àáéèíìóòúù/]#", "-", $string );
	$string = str_replace( '/',"-",$string );
	$string = preg_replace( '/-+/',"_",$string );
	$string = preg_replace( '/-$/',"",$string );
	$string = str_replace( '-'," ",$string );
	$string = str_replace( ' ',"-",$string );
	return $string;
}

function formatDescription( $desc ) {
	return $desc;
    $init =  array(
        '...','.','|'
    );
    $final =  array(
        '.','.<br /><br />','<br />'
    );
    $desc = str_replace( $init, $final, $desc );
    return utf8_encode( $desc );
}

function toItalianDate( $date , $readTime=false ){
   $time = '';
   if($readTime){
      $token = explode(' ',$date);
      $date = trim($token[0]);
      $time = ' '.trim($token[1]);
      unset($token);
   }
   $token = explode('-', $date);  
   return $token[2].'-'.$token[1].'-'.$token[0].$time;
}


function tagExplodeAndOrder( $str, $limit=5 ){
   $token = explode(',', $str);
   $token = shuffle_assoc( $token );
   /*
   for( $i=0; $i<count($token)-1; $i++){
      if( strlen($token[$i]) < strlen($token[$i+1]) ){
         $temp = $token[$i];
         $token[$i] = $token[$i+1];
         $token[$i+1] = $temp;
      }
   } 
   */ 
   if( count($token) > $limit){
      $toCut = $token;
      $token = array();
      for($i=0; $i<$limit; $i++){
         $token[] = $toCut[$i];
      }
   }
   
   for( $i=0; $i<count($token); $i++){
      $token[$i] = array( 'tag' => str_replace('-', ' ', utf8_decode($token[$i])), 'tagUrl' => arrangiaUrl(utf8_decode($token[$i])) );
   }
   $token = shuffle_assoc( $token );
   return $token;
}

function shuffle_assoc($list) { 
  if ( !is_array( $list ) ) 
  	return $list; 

  $keys = array_keys( $list ); 
  shuffle( $keys ); 
  $random = array(); 
  foreach ( $keys as $key ) 
    $random[$key] = $list[$key]; 
    
  return $random; 
} 


function resizeImg ($maxWidth, $maxHeight, $widthFoto, $heightFoto, $style=4) {
		// horizontale
		//echo $widthFoto.' '.$heightFoto.'<===<br>';
		if ($widthFoto >= $heightFoto && $widthFoto > $maxWidth) {
			$ratio = $maxWidth / $widthFoto;
			$newWidth = round($widthFoto * $ratio);
			$newHeight = round($heightFoto * $ratio);
			$ratio = 1;
			// dopo resize, altezza + grande del maxHeight
			if($newHeight > $maxHeight) {
				$ratio = $maxHeight / $newHeight;
			}
		// verticale
		} else if ($heightFoto >= $widthFoto && $heightFoto > $maxHeight) {
			$ratio = $maxHeight / $heightFoto;
			$newWidth = round($widthFoto * $ratio);
			$newHeight = round($heightFoto * $ratio);
			$ratio = 1;
			// dopo resize, larghezza + grande del maxWidth
			
			if($newWidth > $maxWidth) {
				$ratio = $maxWidth / $newWidth;
			}
		} else {
			$ratio = 1;
			$newWidth = $widthFoto;
			$newHeight = $heightFoto;
		}
		
		$newWidth = round($newWidth * $ratio);
		$newHeight = round($newHeight * $ratio);
		
		$margin = round($maxHeight-$newHeight);
		$margin = round($margin/2);
		
		$marginLeft = round($maxWidth-$newWidth);
		$marginLeft = round($marginLeft/2);
				
		if ($style == 1) {
			return "width:".$newWidth."px; height:".$newHeight."px";
		} else if ($style == 2){
			return "width:".$newWidth."px; height:".$newHeight."px; margin-top:".$margin."px";
		} else if ($style == 3){
			return "width:".$newWidth."px; height:".$newHeight."px; margin-left:".$marginLeft."px";
		} else if ($style == 4){	
			return "width:".$newWidth."px; height:".$newHeight."px;margin-top:".$margin."px; margin-left:".$marginLeft."px";	
		} else if ($style == 5){
			return array(
				'width' => $newWidth,
				'height' => $newHeight,
				'marginTop' => $margin,
				'marginLeft' =>$marginLeft
			);
		}
	}

function tagliaStringa($stringa,$carattere,$max_char,$puntini=true) {
    $ptz = '';
    $car = '';
    if ($carattere == ". ") {
            $ptz = 1;
            $car = ".";
    }
    $strLen = strlen($stringa);
    if ($strLen > $max_char) {
        $stringa_tagliata = substr($stringa, 0,$max_char);
        $last_space	= strrpos($stringa_tagliata,$carattere);
        if ($last_space == 0 || $last_space == "") {
					$last_space	= strrpos($stringa_tagliata,".</p>");
        }
        $stringa_ok	= substr($stringa_tagliata, 0,$last_space);
        $finalString	= substr($stringa,$last_space+$ptz,$strLen);
        $finalStringLen	= $strLen - $last_space;
        $testoT = stripslashes($stringa_ok).$car.( $puntini ? ' ...' : '' );
    } else {
        $testoT = stripslashes($stringa);
    }
    return $testoT;
}

    function object_to_array($data)     {
        if ((!is_array($data)) and (!is_object($data))) return 'xxx'; //$data;

        $result = array();

        $data = (array) $data;
        foreach ($data as $key => $value) {
            if (is_object($value)) $value = (array) $value;
            if (is_array($value)) 
                $result[$key] = object_to_array($value);
            else
                $result[$key] = $value;
        }

        return $result;
    }
    
    function arrayToObject($array) {
        if(!is_array($array)) {
            return $array;
        }

        $object = new stdClass();
        if (is_array($array) && count($array) > 0) {
          foreach ($array as $name=>$value) {
             $name = trim($name);
             if (!empty($name)) {
                $object->$name = arrayToObject($value);
             }
          }
          return $object; 
        }
        else {
          return false;
        }
    }
    
	function php_multisort( $data, $keys ) {
        $sort = '';        
        $data = object_to_array( $data );
        // List As Columns
        foreach ( $data as $key => $row ) {
            foreach ( $keys as $k ){
                $cols[$k['key']][$key] = $row[$k['key']];
            }
        }
        // List original keys
        $idkeys = array_keys( $data );
        // Sort Expression
        $i=0;
        foreach ( $keys as $k ) {
            if( $i > 0 )
                $sort.= ',';
            $sort.= '$cols['.$k['key'].']';
            if( !empty( $k['sort'] ) )
                $sort.= ',SORT_'.strtoupper( $k['sort'] );
            
            if( !empty( $k['type'] ) ) 
                $sort.= ',SORT_'.strtoupper( $k['type'] );
            $i++;
        }
        $sort.= ',$idkeys';
        // Sort Funct
        $sort='array_multisort('.$sort.');';
        @eval( $sort );
        // Rebuild Full Array
        foreach( $idkeys as $idkey ) {
          $result[$idkey]=$data[$idkey];
        }
        $result = arrayToObject( $result );
        return $result;
	}
    
// costruisce un combo box
function getSelectBox($ValBox,$nomeBox,$query,$addNA=0,$disabled=false,$style="inline",$functionJS="",$classe="",$action="",$size="1",$multiple=0,$edit=1) {
    $result = "";
    if ($edit == 1) {
        $nomeIdBox = $nomeBox;
        if (strpos($nomeBox,"[") > 0) {
                $posizione = strpos($nomeBox,"[") > 0 ? (strpos($nomeBox,"[") + 1) : 0;
            $nomeIdBox = substr($nomeBox,$posizione);
            $nomeIdBox = str_replace("]","",$nomeIdBox);
        }
        if (is_array($nomeBox)) {
                $nomeIdBox = key($nomeBox);
        }
        // inizia select box
        $multiplo = $multiple == 1 ? "multiple='true'" : "";
        $myClass = $classe ? "class=\"$classe\"" : "";
        $disabled = $disabled ? 'disabled="disabled"' : "";
        $nomeBox = $multiple == 1 ? $nomeBox.'[]' : $nomeBox;
        $result .= "
        <select id=\"$nomeIdBox\" name=\"$nomeBox\" $disabled $functionJS $myClass $action $style size=\"$size\" $multiplo>\n";
        // aggiunge N/A se richiesto (default = 0)
        if ($addNA==1) {
                $result .= "<option value=\"0\">N/A</option>\n";
        } else 	if ($addNA==2) {
                $result .= '<option value="" class="noselect">Scegli</option>';
        } else 	if ($addNA==3) {
                $result .= '<option value="" class="noselect">Seleziona</option>';
        } else if ($addNA <> '' && $addNA <> '0') {
                $result .= "<option value=\"0\">$addNA</option>\n";
        }
        //print_r($query);
        # i dati provengono da una array
        $i = 0;
        if (is_array($query)) {
            foreach($query as $myKey => $myValue) {
                $i++;
                //$tds = explode("|",$query);
                $selected = ( $ValBox == $myKey ) ? " selected=\"selected\"" : "";
                $result .= "<option value=\"" . $myKey . "\"$selected>" . $myValue . "</option>\n";
            }
        # i dati provengono da una query mysql
        } else {
            foreach( $row AS $myRow ) {
                $i++;
                $selected = ( $ValBox == $myRow['id'] ) ? " selected" : "";
                $result .= "<option value=\"" . $myRow['id'] . "\"$selected>" . trim($myRow['name']) . "</option>";
            }
        }
        $result .= "</select>\n";
        // edit = 0 : display value
    } else {
        if ( !is_array( $query ) ) {
                $query = $this->valArray( $query );
        }
        $result = $query[$ValBox];
    }
    return $result;
}

    
    
    function articoliTags($pdo,$db, $articoloId, $tagsArray,$tagString) {
        /*$sQuery = "UPDATE $db.ArticoliTags SET isActive=0 WHERE articoloId=".$articoloId;
        echo $sQuery . "<br>\n";
        $stn = $pdo->prepare($sQuery);
        $stn->execute();
        */
        $myString = '';
        foreach ($tagsArray AS $tag) {
            if ( isset($tag) && trim($tag) != "" && strlen($tag) > 3 ) {
                $sQuery = "INSERT INTO $db.Tags (tag) VALUES (\"".trim($tag)."\")	ON DUPLICATE KEY UPDATE	tagId=LAST_INSERT_ID(tagId)";
                $stn = $pdo->prepare($sQuery);
                $resp = $stn->execute();
                $tagId = $pdo->lastInsertId();
                //echo $sQuery . "<br>\n";

                $sQuery = "INSERT INTO $db.ArticoliTags (articoloId,tagId,isActive) VALUES (".$articoloId.",".$tagId.",1)
                ON DUPLICATE KEY UPDATE
                isActive=1";
                $stn = $pdo->prepare($sQuery);
                $stn->execute();
                //echo $sQuery . "<br>\n";
                $myString .= $tag.',';
            }
        }
        $sQuery = "UPDATE $db.Articoli SET tags= '".substr($myString,0,-1)."' WHERE articoloId = ".$articoloId."";
        $stn = $pdo->prepare($sQuery);
        $stn->execute();

        /*
        $sQuery = "DELETE FROM $db.ArticoliTags WHERE isActive=0 AND articoloId=".$articoloId;
        $stn = $pdo->prepare($sQuery);
        $stn->execute();
        echo $sQuery . "<br>\n";
        */
    }

    
/************************************************************************************************************************************
    ** FUNZIONE PER L'UPLOAD DELLE IMMAGINI SUL SITO
    ** PARAMETRI:
    **              $myFile(ARRAY) = ARRAY CONTENENTE I FILE DA CARICARE
    **              $totFile(INT) = MASSIMO FILE DA CARICARE MASSIMO 5 CONTEMPORANEI
    **              $pathDirectoryWrite(STRING) = PATH CARTELLA DI SCRITTURA PER I FILE
    **              $tempDir(STRING) =PATH CARTELLA TEMPORANEA DI SCRITTURA PER I FILE
    **              $width(INT) = LARGHEZZA MASSIMA CONSENTITA
    **              $height(INT) = ALTEZZA MASSIMA CONSENTITA
    **              $db(STRING) = DATABASE ATTUALE
    **              $table(STRING) = TABELLA DI LAVORO PER RECUPER NEXT ID DA ASSEGNARE ALLA FOTO
    **              $sessioneId(STRING) = SESSION ID PER NOME FOTO TEMPORANEA
    **              $idTipo(INT) = SE -1 SI TRATTA DI UN NUOVO FILE, SE > -1 SI TRATTA DI UNA SOSTITUZIONE DI FOTO
    *************************************************************************************************************************************/
function myUpload($pdo,$myFile,$pathDirectoryWrite,$tempDir,$width,$height,$db,$table,$sessioneId,$idTipo=-1,$oldFoto=array(), $nameFormat = '' ) {
        $goUpload = true;
        $totFile = 1;
        $arrayFormati = array ('image/gif','image/png', 'image/jpeg','image/jpeg', 'image/jpeg' );
 		$aDimension = array( 'small', 'medium', 'large' );
        
        for($x = 0; $x < $totFile; $x++){
            //if ($myFile["name"][$x] !='' && in_array($myFile["type"][$x],$arrayFormati)) {
              $fileFoto['name'][$x] = $myFile["name"][$x];
              $fileFoto['tmp_name'][$x] = $myFile["tmp_name"][$x];
              $fileFoto['type'][$x] = $myFile["type"][$x];
            //}
        }
        
        for($i=0; $i< $totFile;$i++){
            //foreach ($fileFoto["name"] AS $foto) {
            $fileFoto['tmp_name'][$i];
            $imagepath = $fileFoto['tmp_name'][$i];
            $imageType = $fileFoto['type'][$i];
            if ($imagepath) {
					$myTempImgName = $tempDir.$sessioneId.rand().".jpg";
					if ($dim[$i] = resizeConvertImage ($imagepath, $imageType, $width, $height, "jpg", $myTempImgName,$pathDirectoryWrite)) {
						if ( empty( $oldFoto ) || !$oldFoto[$i] ) {
							if ($idTipo == -1) {
								$sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='".$db."' AND TABLE_NAME='".$table."'";
								$statement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
								$e = $statement->execute();
								if( !$e ) 
									return false;	
								$row = $statement->fetch( PDO::FETCH_ASSOC );
								$immagineId = $row["AUTO_INCREMENT"];
							}  else {
								$immagineId = $idTipo;
							}
							$okIdArticolo = true;
							$indice_foto = $totFile > 1 ? "_".$i : '';
                            if ( !empty( $nameFormat ) )
                                $newImagePath = $immagineId.$indice_foto.$nameFormat.".jpg";
                            else
                                $newImagePath = $immagineId.$indice_foto.".jpg";
                                
							$hashImg = md5($sessioneId.$newImagePath.$i);
							$dir = "";
							for ($o = 0; $o < 10; $o++) {
								$dir .= $hashImg[$o]."/";
							}
							$myPath = $pathDirectoryWrite.$dir.$newImagePath;
							if (!file_exists(dirname($myPath))) {
								mkdir(dirname($myPath),0777,1);
							}
							$myFoto[$i] = $dir.$newImagePath;

					} else {
						$immagineId = $idTipo;
                        if ( !empty( $nameFormat ) ) {
                            foreach( $aDimension AS $dimension )
                                $oldFoto[$i] = str_replace ( '_'.$dimension, '', $oldFoto[$i] );
                            $oldFoto[$i] = str_replace( '.jpg', '_'.$nameFormat.'.jpg', $oldFoto[$i] );
                        }
                        $myPath = $pathDirectoryWrite.$oldFoto[$i];
                        
						if (!file_exists(dirname($myPath))) {
							mkdir(dirname($myPath),0777,1);
						}
                        $myFoto[$i] = $oldFoto[$i];
					}
                    echo "\n$myTempImgName, $myPath\n";
					rename($myTempImgName, $myPath); 
					/*
					$command = 'jpegoptim '.$myPath.' -p -o -m100 --strip-all';
					try {
						system( $command );
					} catch ( Exception $e ) {
						echo 'ATTENZIONE: Ottimizzazione Immagine Fallita!!! '.$e;
					}
					*/
                }
            }    
        }
        return array("foto" => $myFoto,"dim" => $dim);
    }

    
    function setTransparency($new_image,$image_source){
        $transparencyIndex = @imagecolortransparent($image_source);
        $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
        if ($transparencyIndex >= 0) {
            $transparencyColor = @imagecolorsforindex($image_source, $transparencyIndex);
        }
        $transparencyIndex    = @imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
        @imagefill($new_image, 0, 0, $transparencyIndex);
        @imagecolortransparent($new_image, $transparencyIndex);
    }

    function resizeConvertImage ($path, $typeIn, $maxWidth, $maxHeight, $typeOut="gif", $pathToOutput,$percorsoTrim='',$fileLocale=true) {
        $arrayFormati = array ('gif' => 'image/gif','png' => 'image/png','jpg' => 'image/jpeg','jpeg' => 'image/jpeg','bmp' => 'image/bmp');
        $sessionId = substr(session_id(),1,10);

        switch($typeIn) {
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/pjpeg':
                    $image = @imagecreatefromjpeg($path);
            break;
            case 'image/gif':
                    $image = @imagecreatefromgif($path);
            break;
            case 'image/png':
            case 'image/x-png':
                    $image = @imagecreatefrompng($path);
            break;
            default:
                return false;
        }
        //echo $pathToOutput;
        $pathToOutput = $pathToOutput == "" ? $default->fileTMP."/temp.jpg" : $pathToOutput;

        // Get original width and height
        $width = @imagesx($image);
        $height = @imagesy($image);

        // horizontale
        if ($width >= $height && $width > $maxWidth) {
            $ratio = $maxWidth / $width;
        // verticale
        } else if ($height >= $width && $height > $maxHeight) {
            $ratio = $maxHeight / $height;
        } else {
            $ratio = 1;
        }
        $newHeight = $height * $ratio;
        $newWidth = $width * $ratio;

        $image_resized = @imagecreatetruecolor($newWidth, $newHeight);
        setTransparency($image_resized , $image);
        @imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        switch($typeOut) {
            case 'jpg':
                    @imagejpeg($image_resized,$pathToOutput);
                    break;
            case 'gif':
                    @imagegif($image_resized,$pathToOutput);
                    break;
            case 'png':
                    @imagepng($image_resized,$pathToOutput);
                    break;
            default:
                    return false;
        }
        $dimensioni['width'] = $newWidth;
        $dimensioni['height'] = $newHeight;
        return $dimensioni;
    }
    
    
     function getTypeImg( $type ) {
		$typeImg = array( IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP );
		$formato = array ( 
			IMAGETYPE_GIF => 'image/gif', 
			IMAGETYPE_JPEG => 'image/jpeg',
			IMAGETYPE_PNG => 'image/png',
			IMAGETYPE_BMP=> 'image/bmp');
		if (in_array( $type, $typeImg) ) {
			return $formato[$type];
		} else {
			return 'image/jpeg';
		}
	}
    
    function myGetTypeImg( $img ) {
		 $formati = array ( 
			'gif' => 'image/gif', 
			'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
			'png' => 'image/png',
			'bmp' => 'image/bmp'
         );
         foreach ( $formati AS $key => $formato ) {
            if ( preg_match_all( "/\b".$key."\b/i", $img, $matches ) ) 
                return $formato;
         }
	}
	 
    function alertResponse($msg) {
        $alert = '
        <script tyle="text/javascript">
            alert("'.$msg.'");
        </script>';
        return $alert; 
    }
    
     /**
     * Funzione che effettua la ricerca full text in sphinx
     * @params string $index ( Indice su cui effettuare la ricerca )
     * @params string $stringa( Parole ricercare )
     * @params boolean $ricercaStretta( Se true effettuerà una ricerca in "AND" delle parole ricercare, se false la effettua in "OR" )
     * @params boolean $jolly ( Se è true toglie l'ultimo carattere dalle stringhe e lo sostituisce con il carattere jolly, false noo sost.  )
     * @params int $minCar ( Numero minimo di caratteri affinchè la parola possa essere inserita nella query di ricerca )
     * @params int $maxMatches( Numero massimo di risultati che sphinx recupererà )
     * @params boolean $repeatNoMatches( Se true è la e la ricerca è stretta == "AND", e non trova risultati proverà a fare una nuova ricerca on "OR" )
     */
    function getSphinxQuery( $index, $stringa, $ricercaStretta = true, $jolly = true, $minCar = 4 ,$maxMatches = 100, $repeatNoMatches = true ) {
 				require_once ( PATH."lib/Sphinxapi.php" );
        $search = '';        
        $searchOr = explode(' ',trim($stringa));
        $quanteParole = count($searchOr);
       
        foreach($searchOr AS $mySearchOr) {
        	if ( strlen( trim( $mySearchOr ) ) >= $minCar ) {
          	$search .= !$ricercaStretta ? " ( " : " ";
          		$search .= $jolly ? substr($mySearchOr,0,-1)."*" : $mySearchOr;
          	$search .= !$ricercaStretta ? " ) | " : " ";
        	}
        }
        
        if ( !$ricercaStretta )
					$search = substr( trim($search),0,-1);

        $q = "(".$search.")";
            
        $cl = new SphinxClient ();
        $cl->_mode = SPH_MATCH_EXTENDED;
        $cl->mySetup();
        if ( isset( $canaliSearchNews ) ) {
            $searchInIds = $canaliSearchNews;
            if ($index == "calcioM") {
                $fakeSearch = $tipoChannelRic;
            }	 
            foreach(explode(",",$searchInIds) AS $canaleSearch) {
                $whereCanali .= " | (".$fakeSearch.$canaleSearch.")";
            }
            $whereCanali = " (".substr($whereCanali,2).") ";
            $q .= " & " . $whereCanali.$whereIdSite;
        }

        $cl->SetSortMode(SPH_SORT_RELEVANCE);
				$cl->SetFieldWeights( array( 'title' => 100,'tags' => 60,'abstract' => 20,'articolo' => 10 ) );
        $cl->SetLimits ( 0, $maxMatches, 0, 0 );
        $cl->SetRankingMode(SPH_RANK_WORDCOUNT);

        //echo "---".$q . "--- in  $index<br>\n";
        $res = $cl->Query ( $q, $index );
        $cl->Close();

    //	print_r($res);
    //	echo "<pre>";
    //	print_r($res["matches"]);
    //	echo "</pre>";
    //	die();
    
        if ( $res===false ) {
            //echo "ERRORRE " . $cl->GetLastError() . ".\n";
            return array();
        } else {
            $minDocWeight = $quanteParole == 1 ? 10 : 20;
            $resultArray = array();
            if ( isset( $res["matches"] ) && is_array($res["matches"])) {
                $n = 1;
                $x = 0;
                foreach ($res["matches"] as $docinfo) {
                    //echo "$n. doc_id=$docinfo[id], weight=$docinfo[weight]". "<br>\n";
                    if ($docinfo['weight'] < $minDocWeight) {
                        break;
                    }
                    $resultArray[$x]['id'] = $docinfo['id'];
                    $resultArray[$x]['weight'] = $docinfo['weight'];
                    $x++;
                }
            }
        }
        
        //Se la ricerca precedenti non ha trovato risultati 
        if ( !$resultArray && $ricercaStretta && $repeatNoMatches ) 
            	$resultArray = getSphinxQuery( $index, $stringa, false, true, $minCar ,$maxMatches, false);
        
        return $resultArray;
    }
    
    
    function getArticoliSearch($tids,$limit,$orderWeight,$idNot=""){
			$x=0;
	        $where = "";
	        $whereNOT = "";
	        $orderByFields = "";
	        $giaPresente[] = array();
			foreach($tids AS $tid) {
	            $where .= "'".$tid['id']."',";
	            $whereNOT .= " AND articoloId<>".$tid['id'];
	            $orderByFields .= ",".$tid['id'];
				$x++;
			}
			$where = substr($where,0,-1);
	        
			$whereNotCorrelato = $idNot != '' ? 'Articoli.articoloId !='.$idNot.' AND' : '' ;
			$whereTids = " articoloId IN (".$where.")";

        $sql = "
        SELECT Articoli.articoloId,Articoli.channelId,Articoli.title,LEFT(Articoli.abstract,150) as abstract,Articoli.fonte,Articoli.foto1,
        Articoli.widthFoto1,Articoli.heightFoto1,Articoli.tags,Articoli.stato,Articoli.ORA 
            FROM ".DB_NAME.".Articoli
                JOIN ".DB_NAME.".ChannelsSites ON ChannelsSites.channelId= Articoli.channelId
            WHERE ".$whereNotCorrelato.$whereTids;
        if ( $orderWeight )
            $sql .= " ORDER BY FIELD(articoloId".$orderByFields.") LIMIT ".$limit;
        else
            $sql .= " ORDER BY articoloId DESC LIMIT ".$limit;
    	
			return $sql;
    }
    
    function isSpider( $agent ) {
        if ( preg_match( "#googlebot#", strtolower( $agent ) ) ) 
                return true;
        if ( preg_match( "#bingbot#", strtolower( $agent ) ) ) 
                return true;
        if ( preg_match( "#ahrefsbot#", strtolower( $agent ) ) ) 
                return true;
        if ( preg_match( "#msnbot#", strtolower( $agent ) ) ) 
                return true;
        if ( preg_match( "#surveybot#", strtolower( $agent ) ) ) 
                return true;
        if ( preg_match( "#yandexbot#", strtolower( $agent ) ) ) 
                return true;
		if ( preg_match( "#facebookexternalhit#", strtolower( $agent ) ) ) 
                return true;
    }
  
function internalReferer( $referal ) {
	if ( empty( $referal ) || preg_match( "#http://(www.|dev.|staging.|)soshopping.it#", strtolower( $referal ) ) ) 
		return true;
	return false;
}	
	
function getImageGoogle( $query, $proxyConnector = array(), $newIdentity = false, $start = 0 ) {
    $url = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&imgsz=medium&rsz=8&start=".$start."&q=".specialReplace( utf8_encode( str_replace( ' ', '%20', $query ) ) )."%20logo";
    //echo utf8_encode( $url ) ."<==<br>\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    /*
	if (  $newIdentity )
		$proxyConnector->newIdentity();
	$json = $proxyConnector->getContentPage( $url );
	*/
    
	$json = curl_exec($ch);
    $jset = json_decode( $json, true );
    //echo "<img src='{$jset["responseData"]["results"][0]["url"]}'><br>";
    //return $jset["responseData"]["results"][0]["url"];
	return $jset["responseData"]["results"];
}


function specialReplace( $query ) {
    $kwd1 = array( ' ', 'd&g' );
    $kwd2 = array( '%20', 'dolce%20e%20gabbana' );
    $query = str_replace( $kwd1, $kwd2, $query );
    return strtolower( $query );
}


function insertLogoTradermark( $pdo, $urlImage, $idTrademark, $ip, $img ) { 
	$sessionId = session_id();
	$myFile['name'][0] = $urlImage;
    $myFile['tmp_name'][0] = $urlImage;
    $myFile['type'][0] = getTypeImg( exif_imagetype( $urlImage ) );

	$file = myUpload($pdo,$myFile,IMAGES_MARCHI_WRITE,FILE_TMP,100,100,DB_NAME,"Trademarks",$sessionId,$idTrademark, array( $img ));
	$width =  isset( $file['dim'][0]['width'] ) ? $file['dim'][0]['width'] : 0;
	$height = isset( $file['dim'][0]['height'] ) ? $file['dim'][0]['height'] : 0;
	$img = isset( $file['foto'][0] ) ? $file['foto'][0] : '';
	$sql = "UPDATE ".DB_NAME.".Trademarks 
		SET img = '".$img."',width = '".$width."', height = '".$height."', ip = '".$ip."' WHERE idTrademark = ".$idTrademark;
	$stn = $pdo->prepare( $sql );
	$e = $stn->execute();
	if( !$e ) {
		echo "query fallita:\n";	
	}
	return $img;
}

function compressHtml( $html ) {
	$html = preg_replace( "/\n ?+/", " ", $html );
	$html = preg_replace( "/\n+/", " ", $html );
	$html = preg_replace( "/\r ?+/", " ", $html );
	$html = preg_replace( "/\r+/", " ", $html );
	$html = preg_replace( "/\t ?+/", " ", $html );
	$html = preg_replace( "/\t+/", " ", $html );
	$html = preg_replace( "/ +/", " ", $html );
	$html = trim($html);
	return $html;
}

?>