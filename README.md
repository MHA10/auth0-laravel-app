# auth0-laravel-app
Auth0 Laravel App

Inspired by [Auth0 Laravel Quickstart](https://auth0.com/docs/quickstart/webapp/laravel/01-login#login-routes)

## Laravel Installation
If you do not already have a Laravel application set up, open a shell to a suitable directory for a new project and run the following command:
```bash
composer create-project --prefer-dist laravel/laravel auth0-laravel-app
```

All the commands in this guide assume you are running them from the root of your Laravel project, directory so you should cd into the new project directory:
```bash
cd auth0-laravel-app
```

Check if Laravel app installed correctly, by running on given port:
```bash
php artisan serve --port=8000
```

Check if project running successfully:
[localhost](http://127.0.0.1:8000)

## SDK Installation
Run the following command within your project directory to install the [Auth0 Laravel SDK](https://github.com/auth0/laravel-auth0)
```bash
composer require auth0/login:^7.9 --update-with-all-dependencies
```

Then generate an SDK configuration file for your application:
```bash
php artisan vendor:publish --tag auth0
```
## SDK Configuration
Run the following command from your project directory to download the [Auth0 CLI](https://github.com/auth0/auth0-cli)
```bash
curl -sSfL https://raw.githubusercontent.com/auth0/auth0-cli/main/install.sh | sh -s -- -b .
```

Then authenticate the CLI with your Auth0 account, choosing "as a user" when prompted:
```bash
./auth0 login
```

Next, create a new application with Auth0:
```bash
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
```bash
./auth0 apis create \
  --name "My Laravel Application's API" \
  --identifier "https://github.com/auth0/laravel-auth0" \
  --offline-access \
  --no-input \
  --json > .auth0.api.json
```

This produces two files in your project directory that configure the SDK.

As these files contain credentials it's important to treat these as sensitive. You should ensure you do not commit these to version control. If you're using Git, you should add them to your .gitignore file:
```bash
echo ".auth0.*.json" >> .gitignore
```

Make sure your APP_URL in .env is correct, it will be defining the callback and other routes for Auth0.

## Demonstration Routes

This sample includes a few demonstration routes to help you get started.

### Session-Based Authentication

The SDK automatically registers the following routes for session-based authentication:

| Method | Route                                        | Description                                                                                                |
| ------ | -------------------------------------------- | ---------------------------------------------------------------------------------------------------------- |
| GET    | [/login](https://localhost:8000/login)       | Starts the user authentication flow. Sets up some initial cookies, and redirects to Auth0 to authenticate. |
| GET    | [/callback](https://localhost:8000/callback) | Handles the return callback from Auth0. Completes setting up the user's Laravel session.                   |
| GET    | [/logout](https://localhost:8000/logout)     | Logs the user out.    

The `routes/web.php` file contains routes that demonstrate working with session-based authentication. These are:

| Method | Route                                      | Description                                                     |
| ------ | ------------------------------------------ | --------------------------------------------------------------- |
| GET    | [/private](https://localhost:8000/private) | Demonstrates how to protect a route with the `auth` middleware. |
| GET    | [/scope](https://localhost:8000/scope)     | Demonstrates how to protect a route with the `can` middleware.  |
| GET    | [/colors](https://localhost:8000/colors)   | Demonstrates how to make Management API calls.                  |

### Token-Based Authorization

The `routes/api.php` file contains routes that demonstrate token-based authorization. These are:

| Method | Route                                              | Description                                                          |
| ------ | -------------------------------------------------- | -------------------------------------------------------------------- |
| GET    | [/api](https://localhost:8000/api)                 | Demonstrates how to extract information from the request token.      |
| GET    | [/api/private](https://localhost:8000/api/private) | Demonstrates how to protect an API route with the `auth` middleware. |
| GET    | [/api/scope](https://localhost:8000/api/scope)     | Demonstrates how to protect an API route with the `can` middleware.  |
| GET    | [/api/me](https://localhost:8000/api/me)           | Demonstrates how to make Management API calls.                       |

You can test these with Bearer tokens.