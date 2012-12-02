<?php  
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $request);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_USERAGENT, "NCSU Libraries Mobilib2 Test");
  $response = curl_exec($ch);
  $_SESSION['xml'] = $response;
  curl_close($ch);
  $xml = simplexml_load_string($response);
  $_SESSION['xml'] = $response;
  return $xml;
?>