<?php


namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

use OpenCloud\ObjectStore\Resource\DataObject;
use Zend\View\Renderer\RendererInterface;

/**
 * Standard interface for all HTML element objects.
 *
 * @package OpenCloud\Zf2\Helper\CloudFiles\HtmlElement
 */
interface ElementInterface
{
    /**
     * Factory for creating concrete element objects
     *
     * @param DataObject $object     Object being rendered
     * @param            $urlType    URL connection type
     * @param array      $attributes HTML tag attributes
     * @return mixed
     */
    public static function factory(RendererInterface $renderer, DataObject $object, $urlType, array $attributes = array());

    /**
     * Set data object
     *
     * @param DataObject $object
     */
    public function setObject(DataObject $object);

    /**
     * Set URL type
     *
     * @param $urlType
     */
    public function setUrlType($urlType);

    /**
     * Set attributes array
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * Return the concrete object into valid HTML markup
     *
     * @return string
     */
    public function render();
} 