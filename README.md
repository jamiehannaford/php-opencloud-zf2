php-opencloud-zf2
=================

A simple but powerful ZF2 module that allows your web app to communicate easily with Rackspace/OpenStack APIs. You can
manage your cloud account configurations, use Swift helper functions in your view files, monitor your cloud servers, sync
directories with a CDN, update DNS records... In short, you get the full benefit of an SDK without all the overhead.

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

### Step 3: ZF2 Configuration

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
directory - since this is what holds all your API configuration values. To make life easier, you can copy the dist
version shipped with this project:

```bash
cp ./vendor/jamiehannaford/php-opencloud-zf2/config/opencloud.local.php.dist ./config/autoload/opencloud.local.php
```

If using Rackspace, you must fill in the `username` and `apiKey` config options.

If using OpenStack, you must fill in the `username`, `password` config options, along with *either* `tenantId` or `tenantName`.

## Usage

You can retrieve a Rackspace client object using the Service Manager:

```php

public function indexAction()
{
    // get Rackspace client
    $rackspace = $this->getServiceLocator()->get('OpenCloud');

    // this also works
    $rackspace = $this->getServiceLocator()->get('OpenCloud\Rackspace');

    // get OpenStack client
    $openstack = $this->getServiceLocator()->get('OpenCloud\OpenStack');
}
```

Once this client object is available, you have full access to the [php-opencloud SDK](https://github.com/rackspace/php-opencloud).

### View helpers

Please see the [CloudFilesHelper wiki](https://github.com/jamiehannaford/php-opencloud-zf2/wiki/Using-the-CloudFiles-View-Helper)
for more information about how you can streamline the process of accessing CDN resources in your HTML views.