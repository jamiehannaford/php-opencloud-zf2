<?php

namespace OpenCloud\Tests\Zf2;

use OpenCloud\Module as OpenCloudModule;
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
        $config  = OpenCloudModule::getModuleConfig();

        $manager = new ServiceManager(new Config($config['service_manager']));
        $manager->setAllowOverride(true);
        $manager->setService('config', $this->getRackspaceConfig());

        return $manager;
    }

    public function getOpenStackConfig()
    {
        return array(
            'opencloud' => array(
                'username' => 'foo',
                'password' => 'bar',
                'tenantId' => 'baz',
                'auth_endpoint' => 'http://identity.foo.com/v2.0'
            )
        );
    }

    public function getRackspaceConfig()
    {
        return array(
            'opencloud' => array(
                'username' => 'foo',
                'apiKey'   => 'bar',
                'auth_endpoint' => 'rackspace-us'
            )
        );
    }
}