<?php
require_once 'google_config.php';


$google_client->setPrompt('select_account');

// Redirigir al usuario a la página de login de Google
header('Location: ' . $google_client->createAuthUrl());
exit();
