<?php

namespace OpenCloud\Tests\Zf2\Factory;

use OpenCloud\Tests\Zf2\Zf2TestCase;
use OpenCloud\Zf2\Factory\RackspaceFactory;

class ProviderFactoryTest extends Zf2TestCase
{

    public function test_Factory()
    {
        $providerFactory = new RackspaceFactory();
        $providerFactory->setConfig(array(
            'username' => 'foo', 'apiKey' => 'baz', 'auth_endpoint' => 'rackspace-uk'
        ));

        $this->assertEquals('OpenCloud\Rackspace', $providerFactory->getClientClass());
        $this->assertNotEmpty($providerFactory->getConfig());

        $this->assertInstanceOf('OpenCloud\Rackspace', $providerFactory->buildClient());
    }

} 