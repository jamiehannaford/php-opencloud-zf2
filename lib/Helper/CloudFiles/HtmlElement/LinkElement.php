<?php

namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

/**
 * Class for rendering <a> tags
 *
 * @package OpenCloud\Zf2\Helper\CloudFiles\HtmlElement
 */
class LinkElement extends AbstractElement
{
    public function render()
    {
        $url = $this->object->getPublicUrl($this->urlType);
        $name = $this->object->getName();

        //return '<a ' . $this->htmlAttribs($this->attributes) . ' href="' . $url . '">' . $name . '</a>';
    }
}