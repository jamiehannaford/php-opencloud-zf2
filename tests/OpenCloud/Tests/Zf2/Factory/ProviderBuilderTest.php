<?php

namespace OpenCloud\Zf2\Factory;

use OpenCloud\Tests\Zf2\OpenCloudTestCase;

class ProviderBuilderTest extends OpenCloudTestCase
{

    public function test_Finished_Product()
    {
        $this->assertInstanceOf('OpenCloud\OpenStack', $this->getServiceLocator()->get('OpenCloud\OpenStack'));
        $this->assertInstanceOf('OpenCloud\Rackspace', $this->getServiceLocator()->get('OpenCloud'));
        $this->assertInstanceOf('OpenCloud\Rackspace', $this->getServiceLocator()->get('OpenCloud\Rackspace'));
    }

}