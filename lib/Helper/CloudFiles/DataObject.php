<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\ObjectStore\Resource\Container as BaseContainer;


class DataObject
{
    protected $dataObject;

    public function __construct(BaseContainer $container, $name)
    {
        $this->dataObject = $container->getPartialObject($name);
    }

    public function render($urlType)
    {
        return HtmlRenderer::factory($this->dataObject, $urlType);
    }

    public function renderUrl($urlType)
    {
        return $this->dataObject->getPublicUrl($urlType);
    }

}