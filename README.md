# Beschlussarchiv

## Gepflegte Beschlussbücher

| Jahr | Status |                Kommentar                 |
| :--- | :----: | :--------------------------------------: |
| 2023 |   ✅    | Assume amendments are integrated already |
| 2022 |   ✅    |                   Done                   |
| 2021 |   ✅    |                   Done                   |
| 2020 |   ✅    |                   Done                   |
| 2019 |   ✅    |                   Done                   |
| 2018 |   ⬜    |                                          |
| 2017 |   ⬜    |                                          |
| 2016 |   ⬜    |                                          |
| 2015 |   ⬜    |                                          |

## How to Install Composer Packages

The Repo doesn't ship with the vendor folder, you'll have to install it with composer.

Install it from within a temporary Docker Container:

```bash
docker run --rm -v ${PWD}:/app composer install --ignore-platform-req=ext-pcntl
```

Now you can start the Dev Container with

```bash
./vendor/bin/sail up
```

## Add CLI XDEBUG

Add an Alias to debug artisan commands:

```bash
alias artisan-debug="php -dxdebug.mode=debug -dxdebug.client_host=host.docker.internal -dxdebug.client_port=9003 -dxdebug.start_with_request=yes artisan"
```

## Common Problems

### No CSS after Deployment

Solution: Restart PHP FPM

```sh
sudo /etc/init.d/php8.3-fpm restart
```

## Supervisor Config for Message Queue Worker

```ini
[program:message_queue_worker]
process_name=%(program_name)s_%(process_num)02d
command=php {APP_DIR}/current artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user={USER}
numprocs=1
redirect_stderr=true
stdout_logfile={PATH_TO_APP}/shared/storage/logs/queue_worker.log
```

## Systemd Services

### Redis

```ini
[Unit]
Description=Redis Service

[Service]
WorkingDirectory=%h/redis
Environment="PATH=/usr/local/bin:/usr/bin:/bin"
ExecStart=/usr/bin/redis-server %h/redis/etc/redis.conf
Restart=always
PrivateTmp=true
NoNewPrivileges=true

[Install]
WantedBy=default.target
```

### Meilisearch (Search Engine)

```ini
[Unit]
Description=Meilisearch
After=systemd-user-sessions.service

[Service]
WorkingDirectory={MEILISEARCH_DIR}
ExecStart={MEILISEARCH_DIR}/bin/meilisearch --config-file-path {MEILISEARCH_DIR}/config.toml
Restart=on-failure

[Install]
WantedBy=multi-user.target
```

## Monitoring
Basic Resource Monitoring:
[Prometheus](https://monitor.open-administration.de/graph?g0.expr=sum%20by%20(user)%20(memory_usage%7Buser%3D~%22opa02-tools_beschlussarchiv%22%7D)%20or%20memory_usage%7Buser%3D~%22opa02-tools_beschlussarchiv%22%7D&g0.tab=0&g0.stacked=1&g0.show_exemplars=0&g0.range_input=12h&g0.end_input=2024-09-09%2019%3A24%3A35&g0.moment_input=2024-09-09%2019%3A24%3A35&g1.expr=%20rate(cpu_usage%7Buser%3D~%22opa02-tools_beschlussarchiv%22%7D%5B30s%5D)%20*%20100&g1.tab=0&g1.stacked=1&g1.show_exemplars=0&g1.range_input=12h&g1.end_input=2024-09-07%2019%3A32%3A31&g1.moment_input=2024-09-07%2019%3A32%3A31)
