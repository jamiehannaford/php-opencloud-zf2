<?php

namespace OpenCloud\Zf2\Factory;

abstract class AbstractProviderFactory implements ProviderFactoryInterface
{
    protected $config;

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
        return static::CLIENT_CLASS;
    }
}