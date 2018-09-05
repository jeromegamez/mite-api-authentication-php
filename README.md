# mite API Authentication

Authentication middlewares to support access to the [mite](https://mite.yo.lk) API

## Installation

```bash
composer require gamez/mite-api-authentication
```

## Usage

### Guzzle

[http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html](http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html)

```php
use Gamez\Mite\MiteAuthenticationMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

$stack = HandlerStack::create();
$stack->push(new MiteAuthenticationMiddleware('accountname', 'apikey'));

$client = new Client(['handler' => $stack]);
```

### HTTPlug

[http://docs.php-http.org/en/latest/plugins/authentication.html](http://docs.php-http.org/en/latest/plugins/authentication.html)

```php
use Gamez\Mite\MiteAuthentication;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\Authentication\BasicAuth;
use Http\Client\Common\PluginClient;
use Http\Client\Common\Plugin\AuthenticationPlugin;

$authentication = new MiteAuthentication('accountname', 'apikey');
$authenticationPlugin = new AuthenticationPlugin($authentication);

$client = new PluginClient(
    HttpClientDiscovery::find(),
    [$authenticationPlugin]
);
```

### Custom

```php
use Gamez\Mite\MiteRequestAuthenticator;

$authenticator = new MiteRequestAuthenticator('accountname', 'apikey');
$request = ...; // an implementation of Psr\Http\Message\RequestInterface

$authenticatedRequest = $authenticator->authenticate($request);
``` 
