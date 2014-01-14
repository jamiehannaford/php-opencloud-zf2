<?php

namespace OpenCloud\Zf2\Factory;

use OpenCloud\Zf2\Enum\Provider;

class ProviderBuilder
{
    const CONFIG_KEY = 'opencloud';

    protected $provider;
    protected $config;

    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    public function setConfig(array $config)
    {
        if (isset($config[self::CONFIG_KEY])) {
            $config = $config[self::CONFIG_KEY];
        }
        $this->config = $config;
    }

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

    protected function buildFactory($factoryClass)
    {
        $factory = $factoryClass::newInstance();
        $factory->setConfig($this->config);
        $factory->validateConfig();

        return $factory;
    }

}