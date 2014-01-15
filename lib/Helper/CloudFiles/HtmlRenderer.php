<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\ObjectStore\Resource\DataObject as BaseDataObject;
use OpenCloud\Zf2\Exception\RenderException;
use OpenCloud\Zf2\Helper\CloudFiles\HtmlElement\ElementInterface;

class HtmlRenderer
{
    const DEFAULT_ELEMENT_CLASS = 'LinkElement';

	protected $object;
	
	protected $urlType;
	
	protected $attributes;

    protected $elementMap = array(
        // custom mime types...
    );

    protected $elementWildcards = array(
        'image/*' => 'ImageElement',
        'video/*' => 'VideoElement',
        'audio/*' => 'AudioElement'
    );

    public static function factory(BaseDataObject $object, $urlType, array $attributes = array())
    {
        $renderer = new self();
        $renderer->setObject($object);
        $renderer->setUrlType($urlType);
        $renderer->setAttributes($attributes);

        return $renderer->build();
    }

    public function setObject(BaseDataObject $object)
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

        return $elementClass::factory($this->object, $this->urlType, $this->attributes);
    }

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