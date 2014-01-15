<?php


namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

use OpenCloud\ObjectStore\Resource\DataObject;

interface ElementInterface
{
    public static function factory(DataObject $object, $urlType, array $attributes = array());

    public function render();
} 