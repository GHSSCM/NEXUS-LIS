<?php

$requestUri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$requestedPath = __DIR__ . $requestUri;


// 1. Serve existing files directly (e.g. /style.css, /favicon.ico, /about/logo.png)
if ($requestUri !== '/' && file_exists($requestedPath)) {

  // die(file_exists($requestedPath)?'true':'false'); 
  if (is_dir($requestedPath)) {
    // It's a folder
    // You can check for index.html inside
    $indexFile = rtrim($requestedPath, '/') . '/index.html';

    if (file_exists($indexFile)) {
        http_response_code(200);
        readfile($indexFile);
        return true;
    }
  }
  return false;
}




// 2. Serve Nuxt static fallback if a folder with index.html exists (e.g. /about → /about/index.html)
$nuxtFallbackPath = rtrim($requestedPath, '/') . '/index.html';
if (file_exists($nuxtFallbackPath)) {
    http_response_code(200);
    readfile($nuxtFallbackPath);
    return true;
}

$service = explode('/',$requestUri)[1];

if(
 $service=='nexus.billing'||
 $service=='nexus.pharmacy'||
 $service=='nexus.bloodbank'||
 $service=='nexus.config'||
 $service=='nexus.lab'||
 $service=='nexus.patients'){
  
  $spaFallback = __DIR__.'/'.$service.'/index.html';
  if(file_exists($spaFallback)){
     http_response_code(200);
     readfile($spaFallback);
     return true;
  }

}


// 3. If root or unknown route → Laravel handles it
require_once __DIR__ . '/index.php';
