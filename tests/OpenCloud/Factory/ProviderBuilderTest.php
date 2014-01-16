<?php

namespace OpenCloud\Tests\Zf2\Factory;

use OpenCloud\Tests\Zf2\Zf2TestCase;
use OpenCloud\Zf2\Enum\Provider;
use OpenCloud\Rackspace;
use OpenCloud\Zf2\Factory\ProviderBuilder;

class ProviderBuilderTest extends Zf2TestCase
{

    public function test_Rackspace_Client()
    {
        $manager = $this->getServiceLocator();

        $this->assertInstanceOf('OpenCloud\Rackspace', $manager->get('OpenCloud'));

        $config = $this->getRackspaceConfig();
        $config['opencloud']['auth_endpoint'] = 'rackspace-uk';
        $manager->setService('config', $config);

        $this->assertInstanceOf('OpenCloud\Rackspace', $manager->get('OpenCloud\Rackspace'));
    }

    public function test_OpenStack_Client()
    {
        $manager = $this->getServiceLocator();
        $manager->setService('config', $this->getOpenStackConfig());

        $this->assertInstanceOf('OpenCloud\OpenStack', $manager->get('OpenCloud\OpenStack'));
    }

    public function test_Default_Endpoint()
    {
        $config = $this->getRackspaceConfig();
        unset($config['opencloud']['auth_endpoint']);

        $builder = new ProviderBuilder();
        $builder->setProvider(Provider::RACKSPACE);
        $builder->setConfig($config);

        $service = $builder->build();
        $this->assertEquals($service->getAuthUrl(), Rackspace::US_IDENTITY_ENDPOINT);
    }

    /**
     * @expectedException \OpenCloud\Zf2\Exception\ProviderException
     */
    public function test_Missing_Config()
    {
        $builder = new ProviderBuilder();
        $builder->setProvider(Provider::RACKSPACE);
        $builder->setConfig(array());

        $builder->build();
    }

    /**
     * OpenStack Keystone requires _either_ a tenantId or tenantName.
     *
     * @expectedException \OpenCloud\Zf2\Exception\ProviderException
     */
    public function test_Missing_Config_Array()
    {
        $config = $this->getOpenStackConfig();
        unset($config['opencloud']['tenantId']);

        $builder = new ProviderBuilder();
        $builder->setProvider(Provider::OPENSTACK);
        $builder->setConfig($config);

        $builder->build();
    }

}