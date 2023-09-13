<?php

// Set sessions to only use cookies. 1 = true
ini_set('session.use_only_cookies', 1);

//Set session to strict mode. 1 = true
//Session ids can only be created by the server
//Requirements for session IDs are higher and they are more complex making them more difficult to "guess" and brute force
ini_set('session.use_strict_mode', 1);

//React recommended this, restrict to same domain
ini_set('session.cookie_samesite', 'Strict');

session_set_cookie_params([
    'lifetime' => 1800, // 30 minutes
    'domain' => 'localhost', //
    'path' => '/', //works on any path on the current domain,
    'secure' => true, //HTTPS only
    'httponly' => true
]);

//Start the session
session_start();

//session_regenerate_id(true); //TODO Do automatically after a certain amount of time (this is also done on login)