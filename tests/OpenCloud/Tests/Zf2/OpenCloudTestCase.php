<?php

namespace OpenCloud\Tests\Zf2;

use OpenCloud\Zf2\Module as OpenCloudModule;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

class OpenCloudTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Create a service manager/locator object for tests that need access to service registry
     *
     * @return ServiceManager
     */
    public function getServiceLocator()
    {
        $config = OpenCloudModule::getModuleConfig();
        return new ServiceManager(new Config($config['service_manager']));
    }
}