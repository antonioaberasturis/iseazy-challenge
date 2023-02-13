### Install the dependencies:

`composer install`

### Create configuration file:

`php -r "file_exists('.env') || copy('.env.example', '.env');"`

### Generate key:

`php artisan key:generate --ansi`

### Create container with Sail:

`php artisan sail:install --with=mysql`

### Launch container in background:

`./vendor/bin/sail up -d`

### Migrate database:

`./vendor/bin/sail artisan migrate:fresh --seed`

### Run the test:

`./vendor/bin/sail artisan test`