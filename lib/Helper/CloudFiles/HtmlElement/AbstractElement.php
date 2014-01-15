<?php

namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

use OpenCloud\ObjectStore\Resource\DataObject;
use Zend\View\Helper\AbstractHtmlElement;

abstract class AbstractElement extends AbstractHtmlElement implements ElementInterface
{
    public static function factory(DataObject $object, $urlType, array $attributes = array())
    {
        $element = new static();
        $element->setObject($object);
        $element->setAttributes($attributes);
        $element->setUrlType($urlType);

        return $element->render();
    }
}