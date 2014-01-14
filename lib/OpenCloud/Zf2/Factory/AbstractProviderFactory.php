<?php

namespace OpenCloud\Zf2\Factory;

use OpenCloud\Zf2\Exception\ProviderException;

abstract class AbstractProviderFactory implements ProviderFactoryInterface
{
    protected $config;

    protected $clientClass;

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

    /**
     * @param $name
     * @throws \OpenCloud\Zf2\Exception\ProviderException
     */
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
}