<?php

namespace OpenCloud\Zf2\Helper;

use OpenCloud\Common\Service\ServiceInterface;
use OpenCloud\Zf2\Helper\CloudFiles\Container;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception\InvalidArgumentException;

class CloudFilesHelper extends AbstractHelper
{
    protected $service;

    protected $containers = array();

    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke($name = null)
    {
        if ($name == null) {
            throw new InvalidArgumentException(
                'A container name must be provided as an argument to the helper if there is no container set'
            );
        }

        return $this->getContainer($name);
    }

    protected function getContainer($name)
    {
        if (!is_string($name) && !is_int($name)) {
            throw new InvalidArgumentException('A container name must be a valid string or int');
        }

        if (!isset($this->containers[$name])) {
            $this->createContainer($name);
        }

        return $this->containers[$name];
    }

    protected function createContainer($name)
    {
        $this->containers[$name] = new Container($this->service, $name);
    }

}