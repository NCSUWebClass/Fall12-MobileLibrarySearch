<?php

require_once('../lib/query-functions.php');
// Retrieves items based on search terms
function search($query, $ntk, $n, $offset, $count, $id) {
  if(isset($_SESSION['response'])){
    $xml = simplexml_load_string($_SESSION['response']);
    unset($_SESSION['response']);
    return $xml;
  }
  $request = 'http://www.lib.ncsu.edu/catalogws/?view=full&service=search&live=true';
  if($query) {
    $clear_query = sanitize_query($query);
    $request .= '&query=' . $clear_query['url_encoded'];
  }
  if($ntk) {
    $request .= '&Ntk=' . $ntk;
  }
  if($n) {
    $request .= '&N=' . $n;
  }
  if($offset) {
    $request .= '&offset=' . $offset;
  }
  if($count == '') {
    $request .= '&count=30';
  }
  elseif($count) {
    $request .= '&count=' . $count;
  }
  if($id != '') {
    $request = 'http://www.lib.ncsu.edu/catalogws/?service=search&live=true&Ntk=UniqueId&Ntt=' . $id;
  }
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
}

// Retrieves single item based on ID
function search_detail($id) {
  $request = 'http://www.lib.ncsu.edu/catalogws/?service=search&live=true&Ntk=UniqueId&Ntt=' . $id;
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $request);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_USERAGENT, "NCSU Libraries Mobilib2 Test");
  $response = curl_exec($ch);
  curl_close($ch);
  $xml = simplexml_load_string($response);
  return $xml;
}
?>
