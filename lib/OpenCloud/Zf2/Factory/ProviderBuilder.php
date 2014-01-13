<?php

namespace OpenCloud\Zf2\Factory;

use OpenCloud\Zf2\Enum\Provider;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProviderBuilder
{
    protected $provider;
    protected $serviceLocator;

    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function build()
    {
        $config = $this->serviceLocator->get('config');

        switch ($this->provider) {
            default:
            case Provider::RACKSPACE:
                $class = 'RackspaceFactory';
                break;
            case Provider::OPENSTACK:
                $class = 'OpenStackFactory';
                break;
        }

        $factory = $this->buildFactory($class, $config);

        return $this->buildClient($factory);
    }

    protected function buildFactory($factoryClass, array $config)
    {
        $factory = $factoryClass::newInstance();
        $factory->setConfig($config);
        $factory->validateConfig();

        return $factory;
    }

    protected function buildClient(ProviderFactoryInterface $factory)
    {
        $class = $factory->getClientClass();

        if (!class_exists($class)) {
            throw new RuntimeException(sprintf(
                '%s class does not exist. Please check you have installed the SDK correctly with Composer'
            ));
        }

        return new $class($factory->getConfig());
    }
}