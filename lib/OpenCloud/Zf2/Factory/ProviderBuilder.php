<?php

namespace OpenCloud\Zf2\Factory;

use Guzzle\Http\Url;
use OpenCloud\Rackspace;
use OpenCloud\Zf2\Enum\Provider;
use OpenCloud\Zf2\Enum\Endpoint;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProviderBuilder
{
    const CONFIG_KEY = 'opencloud';
    const DEFAULT_AUTH_ENDPOINT = Endpoint::US;

    protected $provider;
    public $config;

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

        $factory = $this->buildFactory($class);

        return $this->buildClient($factory);
    }

    protected function buildFactory($factoryClass)
    {
        $factory = $factoryClass::newInstance();
        $factory->setConfig($this->config);
        $factory->validateConfig();

        return $factory;
    }

    protected function buildClient(ProviderFactoryInterface $factory)
    {
        $config = $factory->getConfig();

        $authEndpoint = $this->extractAuthEndpoint($config);
        unset($config['auth_endpoint']);

        $class = $factory->getClientClass();

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