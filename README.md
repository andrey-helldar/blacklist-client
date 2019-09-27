# Blacklist client

The blacklist client package for connecting to the Blacklist Server.

![blacklist client](https://user-images.githubusercontent.com/10347617/64910390-93ca2500-d71e-11e9-8885-a1682298b78f.png)

<p align="center">
    <a href="https://styleci.io/repos/206815468"><img src="https://styleci.io/repos/206815468/shield" alt="StyleCI" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/blacklist-client"><img src="https://img.shields.io/packagist/dt/andrey-helldar/blacklist-client.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/blacklist-client"><img src="https://poser.pugx.org/andrey-helldar/blacklist-client/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/blacklist-client"><img src="https://poser.pugx.org/andrey-helldar/blacklist-client/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/blacklist-client/license?format=flat-square" alt="License" /></a>
</p>


## Content

* [Installation](#installation)
* [Using](#using)
* [License](#license)


## Installation

To get the latest version of Laravel Blacklist Client, simply require the project using [Composer](https://getcomposer.org):

```
composer require andrey-helldar/blacklist-client
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/blacklist-client": "^1.0"
    }
}
```

Now, you can also publish the config file to change implementations (ie. interface to specific class):

```
php artisan vendor:publish --provider="Helldar\BlacklistClient\ServiceProvider"
```


## Using

First look at the [config](src/config/settings.php).

### check / exists

To check the existence of a spammer in the database, you need to transfer the data type and value:
```php
/*
 * DATABASE
 * foo@example.com - exists
 * bar@example.com - not exists
 */

use Helldar\BlacklistClient\Facades\Client;

return Client::check('http://example.com'); // false
return Client::check('192.168.1.1'); // false
return Client::check('+0 (000) 000-00-00'); // false

return Client::check('foo@example.com');
/* GuzzleHttp\Exception\ClientException with 423 code and content:
 *
 * {"error":{"code":400,"msg":["Checked foo@example.com was found in our database.]}}
 */
```

For example:
```php
use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;

class Foo
{
    public function store(array $data)
    {
        if (! $this->isSpammer($data['email'])) {
            // storing data
        }
    }

    private function isSpammer(string $value): bool
    {
        try {
            return Client::check($value);
        }
        catch (ClientException $exception) {
            return true;
        }
    }
}
```

### store

To storing a spammer to the database, use the method `store` of the facade `Client`:

```php
use Helldar\BlacklistClient\Facades\Client;

return Client::store('foo@example.com', 'email');
return Client::store('http://example.com', 'host');
return Client::store('192.168.1.1', 'ip');
return Client::store('+0 (000) 000-00-00', 'phone');
```

For example:
```php
use Helldar\BlacklistClient\Facades\Client;

$item = Client::store('foo@example.com', 'email');

return $item->expired_at;
```


## License

This package is released under the [MIT License](LICENSE).
