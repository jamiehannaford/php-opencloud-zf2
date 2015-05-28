<?php

namespace OpenCloud;

use Zend\ServiceManager\ServiceLocatorInterface;

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

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'OpenCloud\OpenStack' => function (ServiceLocatorInterface $serviceManager) {
                    $builder = $serviceManager->get('ProviderBuilder');
                    $builder->setProvider('OpenStack');
                    $builder->setConfig($serviceManager->get('config'));
                    return $builder->build();
                },
                'OpenCloud\Rackspace' => function (ServiceLocatorInterface $serviceManager) {
                    $builder = $serviceManager->get('ProviderBuilder');
                    $builder->setProvider('Rackspace');
                    $builder->setConfig($serviceManager->get('config'));
                    return $builder->build();
                }
            ),
        );
    }

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'CloudFiles' => function ($pluginManager) {
                    $serviceManager = $pluginManager->getServiceLocator();
                    $client = $serviceManager->get('OpenCloud');
                    $config = $serviceManager->get('config');

                    $region = $config['opencloud']['region'];
                    $urlType = $config['opencloud']['url_type'];

                    $service = $client->objectStoreService('cloudFiles', $region, $urlType);

                    $helper = new \OpenCloud\Zf2\Helper\CloudFilesHelper($service);
                    $pluginManager->injectRenderer($helper);

                    return $helper;
                }
            ),
        );
    }
}