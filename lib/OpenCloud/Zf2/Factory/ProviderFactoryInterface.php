<?php

namespace OpenCloud\Zf2\Factory;

interface ProviderFactoryInterface
{
    public static function newInstance();

    public function setConfig(array $config);

    public function getConfig();

    public function validateConfig();

    public function getClientClass();
} 