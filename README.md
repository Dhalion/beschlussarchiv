# Beschlussarchiv

## Gepflegte Bexychlussbücher

| Jahr | Status |                Kommentar                 |
| :--- | :----: | :--------------------------------------: |
| 2023 |   ✅   | Assume amendments are integrated already |
| 2022 |   ✅   |                   Done                   |
| 2021 |   ⬜   |                                          |
| 2020 |   ✅   |                   Done                   |
| 2019 |   ✅   |                   Done                   |
| 2018 |   ⬜   |                                          |
| 2017 |   ⬜   |                                          |
| 2016 |   ⬜   |                                          |
| 2015 |   ⬜   |                                          |

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
