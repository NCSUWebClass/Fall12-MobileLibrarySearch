<?php

// Search User Query Sanitizer

function sanitize_query($user_query) {

  // Raw Version
  // Store the raw version of the query
  $query['raw'] = $user_query;

  // Display Version 
  // Used for HTML display back to user
  $query['display'] = htmlentities($query['raw']);

  // Sanitized Version 
  // Here we go through multiple steps...

  // Start with the raw query
  $query['sanitized'] = $query['raw'];

  // Remove these special characters:  ( ) ? * [ ] ` ! # $ % { } < > ^ ~ | + & 
  $query['sanitized'] = preg_replace("/\(|\)|\?|\*|\[|\]|`|!|#|\$|%|{|}|<|>|\^|~|\||\+|&/", "", $query['sanitized']);

  // Replace these special characters with a single space:  . : ; , - _ / = @
  $query['sanitized'] = preg_replace("/\.|:|;|,|-|_|\/|=|@/", " ", $query['sanitized']);

  // Escape any shell command strings
  $query['sanitized'] = escapeshellcmd($query['sanitized']);

  // Replace 1 or more whitespace charaters with a single space
  $query['sanitized'] = preg_replace("/[ \t\n\r]+/", " ", $query['sanitized']);

  // Trim leading and trailing spaces from the search string
  $query['sanitized'] = trim($query['sanitized']);

  // URL Encoded version
  // For passing the query to an external search service via GET URL
  // Note:  the encoded version is also "Sanitized"
  $query['url_encoded'] = urlencode($query['sanitized']);
  $url_encoded_query = $query['url_encoded'];

  // Function returns the $query package
  return $query;
}