<?php

namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

class VideoElement extends AbstractElement
{
    const DEFAULT_W = 320;
    const DEFAULT_H = 240;

    public function render()
    {
        if (!isset($this->attributes['width'])) {
            $this->attributes['width'] = self::DEFAULT_W;
        }

        if (!isset($this->attributes['height'])) {
            $this->attributes['height'] = self::DEFAULT_H;
        }

        $url = $this->object->getPublicUrl($this->urlType);
        $mime = $this->object->getContentType();

        return '<video ' . $this->htmlAttribs($this->attributes) 
        	. (!isset($this->attributes['controls']) ? ' controls ' : '') . '>' . PHP_EOL
            . '<source src="' . $url . '" type="' . $mime . '">' . PHP_EOL
            . '</video>';
    }

}