# auth0-laravel-app
Auth0 Laravel App

## Laravel Installation
If you do not already have a Laravel application set up, open a shell to a suitable directory for a new project and run the following command:
```
composer create-project --prefer-dist laravel/laravel auth0-laravel-app
```

All the commands in this guide assume you are running them from the root of your Laravel project, directory so you should cd into the new project directory:
```
cd auth0-laravel-app
```

Check if Laravel app installed correctly, by running on given port:
```
php artisan serve --port=8000
```

Check if project running successfully:
[localhost](http://127.0.0.1:8000)

## SDK Installation
Run the following command within your project directory to install the [Auth0 Laravel SDK](https://github.com/auth0/laravel-auth0)
```
composer require auth0/login:^7.9 --update-with-all-dependencies
```

Then generate an SDK configuration file for your application:
```
php artisan vendor:publish --tag auth0
```
## SDK Configuration
Run the following command from your project directory to download the [Auth0 CLI](https://github.com/auth0/auth0-cli)
```
curl -sSfL https://raw.githubusercontent.com/auth0/auth0-cli/main/install.sh | sh -s -- -b .
```

Then authenticate the CLI with your Auth0 account, choosing "as a user" when prompted:
```
./auth0 login
```

Next, create a new application with Auth0:
```
./auth0 apps create \
  --name "My Laravel Application" \
  --type "regular" \
  --auth-method "post" \
  --callbacks "http://localhost:8000/callback" \
  --logout-urls "http://localhost:8000" \
  --reveal-secrets \
  --no-input \
  --json > .auth0.app.json
```

You should also create a new API:
```
./auth0 apis create \
  --name "My Laravel Application's API" \
  --identifier "https://github.com/auth0/laravel-auth0" \
  --offline-access \
  --no-input \
  --json > .auth0.api.json
```

This produces two files in your project directory that configure the SDK.

As these files contain credentials it's important to treat these as sensitive. You should ensure you do not commit these to version control. If you're using Git, you should add them to your .gitignore file:
```
echo ".auth0.*.json" >> .gitignore
```

Make sure your APP_URL in .env is correct, it will be defining the callback and other routes for Auth0.
