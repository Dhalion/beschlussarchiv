<?php

namespace Deployer;

require 'recipe/laravel.php';
require __DIR__ . '/../vendor/autoload.php'; // Stellen Sie sicher, dass der Pfad korrekt ist

use Dotenv\Dotenv;


set('keep_releases', 5);

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Load environment variables
task('load:env', function () {
    // print DB_HOST and DB_DATABASE variables
    writeln('DB_HOST: ' . getenv('DB_HOST'));
    writeln('DB_DATABASE: ' . getenv('DB_DATABASE'));
});




set('repository', 'https://github.com/Dhalion/beschlusswiki-v4.git');
set('application', 'Beschlussarchiv');
set('default_stage', 'staging');


// Shared files/dirs between deploys
add('shared_files', ['.env']);
add('shared_dirs', ['storage', 'config']);
add('writable_dirs', ['storage', 'vendor']);


// Hosts

host('10.0.0.3')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/var/www/share/beschlussarchiv')
    ->set('identity_file', '~/.ssh/deployer')
    ->set('domain', getenv('APP_URL'))
    ->set('php_version', '8.3')
    ->set('db_type', 'mysql')
    ->set('db_host', getenv('DB_HOST'))
    ->set('db_name', getenv('DB_DATABASE'))
    ->set('db_user', getenv('DB_USERNAME'))
    ->set('db_password', getenv('DB_PASSWORD'))
    ->set('db_port', getenv('DB_PORT'))
    ->set('branch', 'develop')
    ->setLabels([
        'application' => 'Beschlussarchiv',
        'env' => 'staging',
    ]);

host('production')
    ->set('hostname', 'beschlussarchiv.rote.tools')
    ->set('remote_user', 'opa02-tools_beschlussarchiv')
    ->set('deploy_path', '/home/pacs/opa02/users/tools_beschlussarchiv/doms/beschlussarchiv.rote.tools/beschlussarchiv')
    ->set('identity_file', '~/.ssh/beschlussarchiv.rote.tools')
    ->set('domain', getenv('APP_URL'))
    ->set('php_version', '8.2')
    ->set('db_type', 'mysql')
    ->set('db_host', getenv('DB_HOST'))
    ->set('db_name', getenv('DB_DATABASE'))
    ->set('db_user', getenv('DB_USERNAME'))
    ->set('db_password', getenv('DB_PASSWORD'))
    ->set('db_port', getenv('DB_PORT'))
    ->set('branch', 'develop')
    ->setLabels([
        'application' => 'Beschlussarchiv',
        'env' => 'production',
    ]);

// Tasks

// task('provision:update', function () {
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get update -y');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get install -y software-properties-common lsof');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-add-repository ppa:ondrej/php -y');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get update -y');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get install -y php8.3');
// });

// task('provision:install', function () {
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get update -y');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get install -y acl apt-transport-https build-essential curl debian-archive-keyring debian-keyring fail2ban gcc git libmcrypt4 libpcre3-dev libsqlite3-dev make ncdu nodejs pkg-config python-is-python3 redis php-redis sendmail sqlite3 ufw unzip uuid-runtime whois');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get install -y debian-keyring debian-archive-keyring apt-transport-https curl');
//     run('export DEBIAN_FRONTEND=noninteractive; rm -f /usr/share/keyrings/caddy-stable-archive-keyring.gpg');
//     run('export DEBIAN_FRONTEND=noninteractive; curl -1sLf "https://dl.cloudsmith.io/public/caddy/stable/gpg.key" | gpg --batch --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg');
//     run('export DEBIAN_FRONTEND=noninteractive; curl -1sLf "https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt" | tee /etc/apt/sources.list.d/caddy-stable.list');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get update -y');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get install -y caddy');

//     // Setzen Sie das Root-Passwort für MySQL während der Installation
//     $rootPassword = getenv('DB_ROOT_PASSWORD');
//     run("export DEBIAN_FRONTEND=noninteractive; debconf-set-selections <<< 'mysql-server mysql-server/root_password password $rootPassword'");
//     run("export DEBIAN_FRONTEND=noninteractive; debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password $rootPassword'");
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get install -y mysql-server');

//     run('curl -fsSL https://deb.nodesource.com/setup_18.x | bash -');
//     run('export DEBIAN_FRONTEND=noninteractive; apt-get install -y nodejs');


//     // Install Bun
//     run('curl -fsSL https://bun.sh/install | bash');
//     run('export BUN_INSTALL="$HOME/.bun"; export PATH="$BUN_INSTALL/bin:$PATH"; bun --version');
// });

// task('provision:databases', function () {
//     // Setzen Sie das Root-Passwort
//     $rootPassword = getenv('DB_ROOT_PASSWORD');
//     run("mysql --user='root' -e \"ALTER USER 'root'@'localhost' IDENTIFIED BY '$rootPassword'; FLUSH PRIVILEGES;\"");

//     // Erstellen Sie die Datenbank
//     $databaseName = getenv('DB_DATABASE');
//     run("mysql --user='root' --password='$rootPassword' -e \"CREATE DATABASE IF NOT EXISTS $databaseName CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;\"");

//     // Erstellen Sie den Datenbankbenutzer
//     $databaseUser = getenv('DB_USERNAME');
//     $databasePassword = getenv('DB_PASSWORD');
//     run("mysql --user='root' --password='$rootPassword' -e \"CREATE USER IF NOT EXISTS '$databaseUser'@'localhost' IDENTIFIED BY '$databasePassword';\"");
//     run("mysql --user='root' --password='$rootPassword' -e \"GRANT ALL PRIVILEGES ON $databaseName.* TO '$databaseUser'@'localhost'; FLUSH PRIVILEGES;\"");
// });



// task('provision:npm', function () {
//     // Installieren Sie globale Pakete mit bun
//     run('export BUN_INSTALL="$HOME/.bun"; export PATH="$BUN_INSTALL/bin:$PATH"; bun install -g fx zx pm2');
// });

task('provision:website', function () {
    // Sicherstellen, dass der Caddy-Dienst gestartet ist

    // Create Folder deploy_path
    run('mkdir -p {{deploy_path}}');

    // Create Folder deploy_path/config
    run('mkdir -p {{deploy_path}}/config');

    // // Create /config/Caddyfile with default content
    // run('echo "{{domain}} { root * {{deploy_path}}/public/index.php }}" | sudo tee {{deploy_path}}/config/Caddyfile');

    // // validate Caddyfile
    // run('caddy validate --config {{deploy_path}}/config/Caddyfile');

    // // import Caddyfile in /etc/caddy/Caddyfile
    // run('echo "import {{deploy_path}}/config/Caddyfile" | sudo tee -a /etc/caddy/Caddyfile');


    // Chown deploy_path to remote_user
    run('chown -R {{remote_user}}:{{remote_user}} {{deploy_path}}');

    // run('sudo systemctl stop snapd || true');


    // run('systemctl start caddy');
    // run('systemctl enable caddy');

    // // Reload Caddy-Dienst
    // run('systemctl reload caddy');
});



// Build JS
task('build:assets', function () {
    if (has('staging')) {
        run('cd {{release_path}} && bun install && bun run build');
    } else {
        run('cd {{release_path}} && npm install && npm run build');
    }
});

// Task to clear OPcache
task('clear_opcache', function () {
    run('php -r "if (function_exists(\'opcache_reset\')) { opcache_reset(); echo \'OPcache cleared.\'; } else { echo \'OPcache is not enabled.\'; }"');
});

after('deploy:vendors', 'build:assets');

// after('deploy:symlink', 'clear_opcache');

after('deploy:failed', 'deploy:unlock');
