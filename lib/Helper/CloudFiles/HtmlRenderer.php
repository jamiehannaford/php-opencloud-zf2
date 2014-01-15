<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\ObjectStore\Resource\DataObject as BaseDataObject;

class HtmlRenderer
{
    const DEFAULT_ELEMENT_CLASS = 'LinkElement';

    protected $elementMap = array(
        // custom mime types...
    );

    protected $elementWildcards = array(
        'image/*' => 'ImageElement',
        'video/*' => 'VideoElement',
        'audio/*' => 'AudioElement'
    );

    public static function factory(BaseDataObject $object, $urlType)
    {
        $renderer = new self();
        $renderer->setObject($object);
        $renderer->setUrlType($urlType);

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

        if (!$elementClass instanceof ElementInterface) {
            throw new RenderException(sprintf(
                '%s is not an instance of %s', $elementClass, __NAMESPACE__ . '\\ElementInterface'
            ));
        }

        return $elementClass::factory($this->object);
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