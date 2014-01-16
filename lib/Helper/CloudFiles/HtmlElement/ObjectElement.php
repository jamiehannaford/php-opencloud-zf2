<?php

namespace OpenCloud\Zf2\Helper\CloudFiles\HtmlElement;

use Zend\View\Helper\HtmlFlash;

class ObjectElement extends AbstractElement
{

    public function render()
    {
        $zendElement = new HtmlFlash();
        $zendElement->setView($this->view);

        return $zendElement((string) $this->object->getPublicUrl($this->urlType), $this->attributes);
    }

} 