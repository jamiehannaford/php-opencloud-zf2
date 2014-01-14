<?php

namespace OpenCloud\Zf2\Factory;

use OpenCloud\Zf2\Enum\Provider;

/**
 * Class responsible for creating factories which then create concrete client objects. Because OpenCloud is multi-vendor
 * in theory (OpenStack and Rackspace often having different implementations), an abstraction is required for creating
 * the different concrete classes.
 *
 * @package OpenCloud\Zf2\Factory
 */
class ProviderBuilder
{
    const CONFIG_KEY = 'opencloud';

    /**
     * @var string The chosen provider being built
     */
    protected $provider;

    /**
     * @var array Configuration values to be passed on to the client
     */
    protected $config;

    /**
     * @param $provider String representation of provider
     * @see \OpenCloud\Zf2\Enum\Provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param array $config Config values.
     */
    public function setConfig(array $config)
    {
        if (isset($config[self::CONFIG_KEY])) {
            $config = $config[self::CONFIG_KEY];
        }
        $this->config = $config;
    }

    /**
     * Will initialize the build process; first the factory is built, then the factory builds the client
     *
     * @return \Guzzle\Http\ClientInterface
     */
    public function build()
    {
        switch ($this->provider) {
            default:
            case Provider::RACKSPACE:
                $class = __NAMESPACE__ . '\\RackspaceFactory';
                break;
            case Provider::OPENSTACK:
                $class = __NAMESPACE__ . '\\OpenStackFactory';
                break;
        }

        return $this->buildFactory($class)->buildClient();
    }

    /**
     * Build the concrete factory class responsible for creating a concrete client object
     *
     * @param $factoryClass string FQCN of factory class
     * @return ProviderFactoryInterface
     */
    protected function buildFactory($factoryClass)
    {
        $factory = $factoryClass::newInstance();
        $factory->setConfig($this->config);
        $factory->validateConfig();

        return $factory;
    }

}