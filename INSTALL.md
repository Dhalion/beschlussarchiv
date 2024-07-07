# How to Install

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
alias artisan-debug="php -dxdebug.mode=debug -dxdebug.start_with_request=yes artisan"
```
