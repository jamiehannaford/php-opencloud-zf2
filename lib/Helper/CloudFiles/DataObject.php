<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\ObjectStore\Resource\DataObject as BaseDataObject;

class DataObject
{
    protected $container;

    protected $dataObject;

    public function __construct(Container $container, $data)
    {
        $this->container = $container;

        if ($data instanceof BaseDataObject) {
            $this->dataObject = $data;
        } else {
            $this->dataObject = $this->container->getObject($data);
        }
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