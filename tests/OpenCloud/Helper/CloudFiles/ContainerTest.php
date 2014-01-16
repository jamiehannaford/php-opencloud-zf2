<?php


namespace OpenCloud\Tests\Zf2\Helper\CloudFiles;

use Guzzle\Http\Message\Response;
use OpenCloud\Tests\Zf2\Zf2TestCase;
use OpenCloud\Zf2\Helper\CloudFiles\Container;
use Zend\View\Renderer\PhpRenderer;

class ContainerTest extends Zf2TestCase
{

    private function getContainer()
    {
        $this->addMockSubscriber($this->makeResponse('{}', 200));
        $renderer = new PhpRenderer();
        $service = $this->getClient()->objectStoreService('cloudFiles', 'ORD');
        return new Container($renderer, $service, 'foo');
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

    public function test_Render_All()
    {
        $container = $this->getContainer();

        $json = '[{"name":"test_obj_1"},{"name":"test_obj_2"}]';

        $this->addMockSubscriber($this->makeResponse($json, 200));
        $this->assertInternalType('array', $container->renderAllFiles());

        $this->addMockSubscriber($this->makeResponse($json, 200));
        $this->assertInternalType('string', $container->renderAllFiles(100, 'CDN', '<div>','</div>'));
    }

    public function test_Render_Image()
    {
        $container = $this->getContainer();

        $this->addMockSubscriber(new Response(200, array('Content-Type' => 'image/jpg'), null));
        $element = $container->renderFile('foo1');

        $this->assertStringStartsWith('<img', $element);
        $this->assertStringEndsWith('/>', $element);
    }

    public function test_Render_Audio()
    {
        $container = $this->getContainer();

        $this->addMockSubscriber(new Response(200, array('Content-Type' => 'audio/ogg'), null));
        $element = $container->renderFile('foo2');

        $this->assertStringStartsWith('<audio', $element);
        $this->assertStringEndsWith('</audio>', $element);
    }

    public function test_Render_Video()
    {
        $container = $this->getContainer();

        $this->addMockSubscriber(new Response(200, array('Content-Type' => 'video/mp4'), null));
        $element = $container->renderFile('foo3');

        $this->assertStringStartsWith('<video', $element);
        $this->assertStringEndsWith('</video>', $element);
    }

    public function test_Render_Other()
    {
        $container = $this->getContainer();

        $this->addMockSubscriber(new Response(200, array('Content-Type' => 'application/pdf'), null));
        $element = $container->renderFile('foo4');

        $this->assertStringStartsWith('<a', $element);
        $this->assertStringEndsWith('</a>', $element);
    }

    public function test_Render_Flash()
    {
        $renderer = new PhpRenderer();
        $service = $this->getClient()->objectStoreService('cloudFiles', 'ORD');

        $response1 = new Response(204, array(
            'X-Container-Object-Count' => '5',
            'X-Trans-Id' => 'tx30e27bcc8bf34c0ebfdf078337895478',
            'X-Timestamp' => '1331584412.96818',
            'X-Container-Meta-Book' => 'MobyDick',
            'X-Container-Meta-Subject' => 'Whaling',
            'X-Container-Bytes-Used' => '3846773'
        ));

        $this->addMockSubscriber($response1);

        $response2 = new Response(204, array(
            'X-Cdn-Ssl-Uri' => 'https://83c49b9a2f7ad18250b3-346eb45fd42c58ca13011d659bfc1ac1.ssl.cf0.rackcdn.com',
            'X-Ttl' => '259200',
            'X-Cdn-Uri' => 'http://081e40d3ee1cec5f77bf-346eb45fd42c58ca13011d659bfc1ac1.r49.cf0.rackcdn.com',
            'X-Cdn-Enabled' => 'True',
            'X-Log-Retention' => 'False',
            'X-Cdn-Streaming-Uri' => 'http://084cc2790632ccee0a12-346eb45fd42c58ca13011d659bfc1ac1.r49.stream.cf0.rackcdn.com',
            'X-Trans-Id' => 'tx82a6752e00424edb9c46fa2573132e2c'
        ));

        $this->addMockSubscriber($response2);

        $container = new Container($renderer, $service, 'foo');

        $this->addMockSubscriber(new Response(200, array('Content-Type' => 'application/x-shockwave-flash'), null));
        $element = $container->renderFile('foo');

        $this->assertStringStartsWith('<object', $element);
        $this->assertStringEndsWith('</object>', $element);
    }

}