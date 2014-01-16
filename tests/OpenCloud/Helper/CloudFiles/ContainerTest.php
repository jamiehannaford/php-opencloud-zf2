<?php


namespace OpenCloud\Tests\Zf2\Helper\CloudFiles;

use OpenCloud\Tests\Zf2\Zf2TestCase;
use OpenCloud\Zf2\Helper\CloudFiles\Container;

class ContainerTest extends Zf2TestCase
{

    private function getContainer()
    {
        $this->addMockSubscriber($this->makeResponse('{}', 200));
        return $container = new Container($this->getClient()->objectStoreService('cloudFiles', 'ORD'), 'foo');
    }

    public function test_Cache()
    {
        $container = $this->getContainer();

        $this->addMockSubscriber($this->makeResponse('{}', 200));
        $this->assertNotNull($container->renderFileUrl('foo.jpg'));

        $this->assertCount(1, $container->getCache());
        $container->clearCache();
        $this->assertCount(0, $container->getCache());
    }

    public function test_Render()
    {
        $container = $this->getContainer();

        $this->addMockSubscriber($this->makeResponse('{}', 200));
        $this->assertInternalType('string', $container->renderFile('foo'));
    }

}