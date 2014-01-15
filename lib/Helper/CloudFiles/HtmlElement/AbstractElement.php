<?php

namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

use OpenCloud\ObjectStore\Resource\DataObject;
use Zend\View\Helper\AbstractHtmlElement;

abstract class AbstractElement extends AbstractHtmlElement implements ElementInterface
{
	protected $object;
	
	protected $urlType;
	
	protected $attributes;

    public function setObject(DataObject $object)
    {
        $this->object = $object;
    }

    public function setUrlType($urlType)
    {
        $this->urlType = $urlType;
    }
    
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

	public function htmlAttribs() {}

    public static function factory(DataObject $object, $urlType, array $attributes = array())
    {
        $element = new static();
        $element->setObject($object);
        $element->setAttributes($attributes);
        $element->setUrlType($urlType);

        return $element->render();
    }
}