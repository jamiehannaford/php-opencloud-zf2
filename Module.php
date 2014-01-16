<?php

namespace OpenCloud;

/**
 * Module config class
 *
 * @package OpenCloud
 */
class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return self::getModuleConfig();
    }

    /**
     * Static method used to retrieve config - useful for creating service manager objects in test cases.
     *
     * @return array Nested config structure
     */
    public static function getModuleConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Configures Zend's standard autoloader to find module namespaces
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ . '\\Zf2' => __DIR__ . '/src/',
                ),
            ),
        );
    }
}