<?php

namespace Deployer;

require 'recipe/laravel.php';
require __DIR__ . '/../vendor/autoload.php'; // Stellen Sie sicher, dass der Pfad korrekt ist

use Dotenv\Dotenv;

// Laden Sie die .env-Datei
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

host('staging')
    ->set('hostname', 'staging.example.com') // Beispiel-Hostname
    ->set('remote_user', 'your_remote_user') // Beispiel-Benutzername
    ->set('deploy_path', '/path/to/staging/deploy') // Beispiel-Pfad
    ->set('identity_file', '~/.ssh/your_identity_file') // Beispiel-SSH-Identitätsdatei
    ->set('domain', getenv('APP_URL'))
    ->set('php_version', '8.x') // Beispiel-PHP-Version
    ->set('db_type', 'mysql')
    ->set('db_host', getenv('DB_HOST'))
    ->set('db_name', getenv('DB_DATABASE'))
    ->set('db_user', getenv('DB_USERNAME'))
    ->set('db_password', getenv('DB_PASSWORD'))
    ->set('db_port', getenv('DB_PORT'))
    ->set('branch', 'your_branch') // Beispiel-Branch
    ->setLabels([
        'application' => 'YourApplicationName', // Beispiel-Anwendungsname
        'env' => 'staging',
    ]);

host('production')
    ->set('hostname', 'production.example.com') // Beispiel-Hostname
    ->set('remote_user', 'your_remote_user') // Beispiel-Benutzername
    ->set('deploy_path', '/path/to/production/deploy') // Beispiel-Pfad
    ->set('identity_file', '~/.ssh/your_identity_file') // Beispiel-SSH-Identitätsdatei
    ->set('domain', getenv('APP_URL'))
    ->set('php_version', '8.x') // Beispiel-PHP-Version
    ->set('db_type', 'mysql')
    ->set('db_host', getenv('DB_HOST'))
    ->set('db_name', getenv('DB_DATABASE'))
    ->set('db_user', getenv('DB_USERNAME'))
    ->set('db_password', getenv('DB_PASSWORD'))
    ->set('db_port', getenv('DB_PORT'))
    ->set('branch', 'your_branch') // Beispiel-Branch
    ->setLabels([
        'application' => 'YourApplicationName', // Beispiel-Anwendungsname
        'env' => 'production',
    ]);
