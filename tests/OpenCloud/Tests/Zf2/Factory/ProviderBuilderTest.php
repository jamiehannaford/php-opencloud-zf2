<?php

namespace OpenCloud\Zf2\Factory;

use OpenCloud\Tests\Zf2\OpenCloudTestCase;

class ProviderBuilderTest extends OpenCloudTestCase
{

    public function test_Rackspace_Client()
    {
        $manager = $this->getServiceLocator();

        $this->assertInstanceOf('OpenCloud\Rackspace', $manager->get('OpenCloud'));
        $this->assertInstanceOf('OpenCloud\Rackspace', $manager->get('OpenCloud\Rackspace'));
    }

    public function test_OpenStack_Client()
    {
        $manager = $this->getServiceLocator();
        $manager->setService('config', $this->getOpenStackConfig());

        $this->assertInstanceOf('OpenCloud\OpenStack', $manager->get('OpenCloud\OpenStack'));
    }

}