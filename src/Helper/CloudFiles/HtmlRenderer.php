<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\ObjectStore\Resource\DataObject as BaseDataObject;
use Zend\View\Renderer\RendererInterface;

/**
 * Class which renders a remote URI into valid HTML markup, where necessary. For example, resources with an `image/*`
 * MIME type will result in `<img src="..." />` and so on. Currently this class only renders images, video and audio
 * resources into valid markup; anything else becomes a standard hyperlink.
 *
 * @package OpenCloud\Zf2\Helper\CloudFiles
 */
class HtmlRenderer
{
    const DEFAULT_ELEMENT_CLASS = 'LinkElement';

    /** @var Zend\View\Renderer\RendererInterface */
    protected $renderer;

    /** @var \OpenCloud\ObjectStore\Resource\DataObject */
    protected $object;

    /** @var string The type of URL used to access the resource */
    protected $urlType;

    /** @var array HTML tag attributes */
    protected $attributes;

    /** @var array Used to map custom MIME types (key) to its rendering class (value) */
    protected $elementMap = array(
        'application/x-shockwave-flash' => 'ObjectElement'
    );

    /** @var array Allows MIME types to be mapped to rendering classes using wildcards */
    protected $elementWildcards = array(
        'image/*' => 'ImageElement',
        'video/*' => 'VideoElement',
        'audio/*' => 'AudioElement'
    );

    /**
     * Standard factory method to instantiate a populated object.
     *
     * @param BaseDataObject $object     The object being rendered
     * @param                $urlType    The type of URL connection
     * @param array          $attributes HTML tag attributes
     * @return mixed
     */
    public static function factory(RendererInterface $renderer, BaseDataObject $object, $urlType, array $attributes = array())
    {
        $htmlRenderer = new self();
        $htmlRenderer->setRenderer($renderer);
        $htmlRenderer->setObject($object);
        $htmlRenderer->setUrlType($urlType);
        $htmlRenderer->setAttributes($attributes);

        return $htmlRenderer->build();
    }

    /**
     * @param RendererInterface $renderer
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param BaseDataObject $object
     */
    public function setObject(BaseDataObject $object)
    {
        $this->object = $object;
    }

    /**
     * @param $urlType
     */
    public function setUrlType($urlType)
    {
        $this->urlType = $urlType;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function build()
    {
        $mime = $this->object->getContentType();

        if (isset($this->elementMap[$mime])) {
            $elementClass = $this->elementMap[$mime];
        } elseif (false !== ($element = $this->searchWildcards($mime))) {
            $elementClass = $element;
        } else {
            $elementClass = self::DEFAULT_ELEMENT_CLASS;
        }

        $elementClass = __NAMESPACE__ . '\\HtmlElement\\' . $elementClass;

        return $elementClass::factory($this->renderer, $this->object, $this->urlType, $this->attributes);
    }

    /**
     * Search for a particular MIME type (using wildcards) and map it to a particular rendering class
     *
     * @param $mime MIME type being searched for
     * @return HtmlElement\ElementInterface|false
     */
    private function searchWildcards($mime)
    {
        foreach ($this->elementWildcards as $wildcard => $class) {
            $mimePrefix = current(explode('/', $mime));
            if (strpos($wildcard, $mimePrefix) !== false) {
                return $class;
            }
        }

        return false;
    }

}