<?php

namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

use OpenCloud\ObjectStore\Resource\DataObject;
use Zend\View\Helper\AbstractHtmlElement;
use Zend\View\Renderer\RendererInterface;

/**
 * Abstract class that provides base functionality for element objects
 *
 * @package OpenCloud\Zf2\Helper\CloudFiles\HtmlElement
 */
abstract class AbstractElement extends AbstractHtmlElement implements ElementInterface
{
    /** @var \OpenCloud\ObjectStore\Resource\DataObject */
	protected $object;

    /** @var string */
	protected $urlType;

    /** @var array */
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

    public static function factory(RendererInterface $renderer, DataObject $object, $urlType, array $attributes = array())
    {
        $element = new static();
        $element->setView($renderer);
        $element->setObject($object);
        $element->setAttributes($attributes);
        $element->setUrlType($urlType);

        return $element->render();
    }
}