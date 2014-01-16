php-opencloud-zf2
=================

A simple but powerful ZF2 module that allows your web app to communicate easily with Rackspace/OpenStack APIs. You can
manage your cloud account configurations, use Swift helper functions in your view files, monitor your cloud servers, sync
directories with a CDN, update DNS records... In short, you get the full benefit of an SDK without all the hassle.

## Installation

### Step 1: Install Composer (if you haven't already)

```bash
curl -sS https://getcomposer.org/installer | php
```

### Step 2: Install the module

```bash
php composer.phar require jamiehannaford/php-opencloud-zf2:dev-master
```

This will automatically update your `composer.json` configuration file and force Composer to install the module. Alternatively,
you can manually insert the requirement like so:

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

You then need to make sure you have an `opencloud.local.php` configuration file in your `config/autoload`
directory - since this is what holds all your API configuration values.

To make life easier, you can copy the dist verion shipped with this project:

```bash
cp vendor/jamiehannaford/php-opencloud-zf2/config/opencloud.local.php.dist config/autoload/opencloud.local.php
```

If using Rackspace, you must fill in the `username` and `apiKey` config options; if using OpenStack, you must fill in
the `username`, `password` config options, along with *either* `tenantId` or `tenantName`.