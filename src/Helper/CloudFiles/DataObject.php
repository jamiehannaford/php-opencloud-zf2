<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\ObjectStore\Resource\Container as BaseContainer;
use Zend\View\Renderer\RendererInterface;

/**
 * Facade object which provides a simple interface to the underlying DataObject model. It offers functionality one
 * might expect from HTML views.
 *
 * @package OpenCloud\Zf2\Helper\CloudFiles
 */
class DataObject
{
    /** @var Zend\View\Renderer\RendererInterface */
    protected $renderer;

    /** @var OpenCloud\ObjectStore\Resource\DataObject The object being wrapped */
    protected $dataObject;

    /**
     * @param BaseContainer $container Parent container
     * @param               $name      Name of object
     */
    public function __construct(RendererInterface $renderer, BaseContainer $container, $name)
    {
        $this->renderer = $renderer;
        $this->dataObject = $container->getPartialObject($name);
    }

    /**
     * Render the data object into valid HTML markup
     *
     * @param $urlType The connection type
     * @return mixed
     */
    public function render(array $attrs, $urlType)
    {
        return HtmlRenderer::factory($this->renderer, $this->dataObject, $urlType, $attrs);
    }

    /**
     * Output the object's URI
     *
     * @param $urlType The connection type
     * @return string
     */
    public function renderUrl($urlType)
    {
        return $this->dataObject->getPublicUrl($urlType);
    }

}