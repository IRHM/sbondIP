<?php
  require_once("geoip/geoip2.phar");

  use GeoIp2\Database\Reader;

  //
  //    Get Real IP
  //

  if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
  }

  $client  = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote  = $_SERVER['REMOTE_ADDR'];

  if(filter_var($client, FILTER_VALIDATE_IP)){
    $publicIP = $client;
  }
  elseif(filter_var($forward, FILTER_VALIDATE_IP)){
    $publicIP = $forward;
  }
  else{
    $publicIP = $remote;
  }

  $ua = $_SERVER['HTTP_USER_AGENT'];

  //
  //    Geo IP
  //    DB...: https://dev.maxmind.com/geoip/geoip2/geolite2/
  //    API..: https://github.com/maxmind/GeoIP2-php/releases
  //

  if($publicIP == "192.168.0.1" || $publicIP == "127.0.0.1" || $publicIP == "::1"){
		// If checking from localhost use external service
    $publicIP = file_get_contents('https://api.ipify.org');
  }
  
	try {
		$reader = new Reader('geoip/GeoLite2-City.mmdb');
		$record = $reader->city($publicIP);
		
		$countryCode = $record->country->isoCode; // 2 letter country code
		$countryName = $record->country->name; // Full country name
	}
	catch(Exception $ex) {}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="https://ul.sbond.co/i/hive/Hiv2.png" />
    <link rel="stylesheet" href="styles.css?v=1">
    <title>My IP</title>
  </head>
  <body class="">
    <span id="themeSwitch"></span>

    <div class="myInfo">
      <span class="myCountry" title="Country Associated With IP"><?php if(isset($countryName)){echo $countryName;} ?></span>
      <span class="myPublicIP" title="Your Public IP"><?php echo $publicIP; ?></span>
    </div>

    <script type="application/javascript" src="main.js"></script>
  </body>
</html>
