php-opencloud-zf2
=================

A simple but powerful ZF2 module that allows your web app to communicate easily with Rackspace/OpenStack APIs. You can
manage your cloud account configurations, use Swift helper functions in your view files, monitor your cloud servers, sync
directories with a CDN, update DNS records. In short, you get the full benefit of an SDK without all the hassle.

## Installation

### Step 1: Install Composer (if you haven't already)

```bash
curl -sS https://getcomposer.org/installer | php
```

### Step 2: Install the module

Get composer to install the module by executing:

```bash
php composer.phar require jamiehannaford/php-opencloud-zf2:dev-master
```

This will automatically update your `composer.json` configuration file. Alternatively, you can manually insert the
requirement like so:

```json
{
    "require": {
        "jamiehannaford/php-opencloud-zf2": "~1.0"
    }
}
```

And then run:

```bash
php composer.phar install
```

## Step 3: ZF2 Configuration

You need to update your `application.config.php` file, and add in the module:

```php
return array(
    'modules' => array(
        // other modules...
        'OpenCloud'
    )
);
```

You then need to make sure you have an `opencloud.{local|global}.php` configuration file in your `config/autoload`
directory - since this is what holds all your API configuration values: