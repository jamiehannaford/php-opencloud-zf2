<?php

namespace OpenCloud\Zf2\Factory;

use Guzzle\Http\Url;
use OpenCloud\Rackspace;
use OpenCloud\Zf2\Enum\Provider;
use OpenCloud\Zf2\Enum\Endpoint;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProviderBuilder
{
    const DEFAULT_AUTH_ENDPOINT = Endpoint::US;

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
        $config = $config['opencloud'];

        switch ($this->provider) {
            default:
            case Provider::RACKSPACE:
                $class = __NAMESPACE__ . '\\RackspaceFactory';
                break;
            case Provider::OPENSTACK:
                $class = __NAMESPACE__ . '\\OpenStackFactory';
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

        $config = $factory->getConfig();

        $authEndpoint = $this->extractAuthEndpoint($config);
        unset($config['auth_endpoint']);

        return new $class($authEndpoint, $config);
    }

    private function extractAuthEndpoint(array $config)
    {
        if (!isset($config['auth_endpoint'])) {
            $config['auth_endpoint'] = self::DEFAULT_AUTH_ENDPOINT;
        }

        $authOption = $config['auth_endpoint'];

        switch ($authOption) {
            case Endpoint::UK:
                $endpoint = Rackspace::UK_IDENTITY_ENDPOINT;
                break;
            case Endpoint::US:
                $endpoint = Rackspace::US_IDENTITY_ENDPOINT;
                break;
            default:
                $endpoint = $authOption;
                break;
        }

        return Url::factory($endpoint);
    }
}