<?php

namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

class ImageElement extends AbstractElement
{

    public function render()
    {
        return '<img ' . $this->htmlAttribs($this->attributes) 
        	. ' src="' . $this->object->getPublicUrl($this->urlType) . '"'
            . ((empty($this->attributes['alt'])) ? ' alt="'. $this->object->getName() . '"' : '')
            . '/>';
    }

} 