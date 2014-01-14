<?php

namespace OpenCloud\Zf2\Factory;

use Guzzle\Http\Url;
use OpenCloud\Rackspace;
use OpenCloud\Zf2\Exception\ProviderException;
use OpenCloud\Zf2\Enum\Endpoint;

/**
 * Abstract Provider Factory that provides base functionality for other concrete factories. The role of this class is
 * to build concrete client objects which implement \Guzzle\Http\ClientInterface
 *
 * @package OpenCloud\Zf2\Factory
 */
abstract class AbstractProviderFactory implements ProviderFactoryInterface
{
    /** Default authentication endpoint */
    const DEFAULT_AUTH_ENDPOINT = Endpoint::US;

    /** @var array Configuration values for the client, such as auth options */
    protected $config;

    /** @var string FQCN of client */
    protected $clientClass;

    /** @var array Required options for the client */
    protected $required = array();

    public static function newInstance()
    {
        return new static();
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getClientClass()
    {
        return $this->clientClass;
    }

    public function validateConfig()
    {
        array_walk($this->required, array($this, 'validateOption'));
    }

    public function validateOption($name)
    {
        if (is_array($name) && count(array_diff($name, array_keys($this->config))) == count($name)) {
            $error = sprintf('The %s config options are required to instantiate the %s service; you must specify at
                least one', implode($name, ', '), get_class($this));
        } elseif (is_string($name) && empty($this->config[$name])) {
            $error = sprintf('The %s config option is required to instantiate the %s service', $name, get_class($this));
        }

        if (isset($error)) {
            throw new ProviderException($error);
        }
    }

    public function buildClient()
    {
        $authEndpoint = $this->extractAuthEndpoint();

        unset($this->config['auth_endpoint']);

        return new $this->clientClass($authEndpoint, $this->config);
    }

    /**
     * Searchs the configuration values provided and attempts to build a suitable URL for authentication.
     *
     * @return \Guzzle\Http\Url
     */
    private function extractAuthEndpoint()
    {
        $auth = empty($this->config['auth_endpoint']) ? self::DEFAULT_AUTH_ENDPOINT : $this->config['auth_endpoint'];

        switch ($auth) {
            case Endpoint::UK:
                $endpoint = Rackspace::UK_IDENTITY_ENDPOINT;
                break;
            case Endpoint::US:
                $endpoint = Rackspace::US_IDENTITY_ENDPOINT;
                break;
            default:
                $endpoint = $auth;
                break;
        }

        return Url::factory($endpoint);
    }
}