<?php

// Get the requested URI
$requestUri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Full path to the requested file inside the public directory
$requestedFile = __DIR__  . $requestUri;

// If the file exists (e.g. CSS, JS, image), serve it directly
if ($requestUri !== '/' && file_exists($requestedFile)) {
    return false; // Let the built-in server serve the file
}

// Otherwise, forward the request to Laravel
require_once __DIR__ . '/index.php';
