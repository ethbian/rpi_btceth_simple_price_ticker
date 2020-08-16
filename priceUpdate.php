<?php

function callProcedure($coin="bitcoin") {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 10,      // timeout on connect
        CURLOPT_TIMEOUT        => 50,      // timeout on response
        CURLOPT_MAXREDIRS      => 2,       // stop after 2 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );
    
    $endpoint = "https://api.coingecko.com/api/v3/simple/price";
    $params = array(
        'ids' => $coin,
        'vs_currencies' => 'USD',
        'include_24hr_change' => 'true'
    );
    $url = $endpoint . '?' . http_build_query($params);
    $ch      = curl_init();
    curl_setopt_array($ch, $options);
    curl_setopt($ch, CURLOPT_URL, $url);
    $content = curl_exec($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $header  = curl_getinfo($ch);
    curl_close($ch);

    return $content;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   if ($_POST['type'] == 1) {
      echo callProcedure('bitcoin');
   } elseif ($_POST['type'] == 2) {
      echo callProcedure('ethereum');
   }
}

?>
