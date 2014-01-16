<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\ObjectStore\Resource\Container as BaseContainer;

/**
 * Facade object which provides a simple interface to the underlying DataObject model. It offers functionality one
 * might expect from HTML views.
 *
 * @package OpenCloud\Zf2\Helper\CloudFiles
 */
class DataObject
{
    /** @var OpenCloud\ObjectStore\Resource\DataObject The object being wrapped  */
    protected $dataObject;

    /**
     * @param BaseContainer $container Parent container
     * @param               $name      Name of object
     */
    public function __construct(BaseContainer $container, $name)
    {
        $this->dataObject = $container->getPartialObject($name);
    }

    /**
     * Render the data object into valid HTML markup
     *
     * @param $urlType The connection type
     * @return mixed
     */
    public function render($urlType)
    {
        return HtmlRenderer::factory($this->dataObject, $urlType);
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