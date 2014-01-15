<?php

namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

class AudioElement extends AbstractElement
{
    public function render()
    {
        $url = $this->object->getPublicUrl($this->urlType);
        $mime = $this->object->getContentType();

        return '<audio ' . $this->htmlAttribs($this->attributes) . '>' . PHP_EOL
            . '<source src="' . $url . '" type="' . $mime . '">' . PHP_EOL
            . '</audio>';
    }
} 