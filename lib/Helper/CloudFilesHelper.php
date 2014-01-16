<?php

namespace OpenCloud\Zf2\Helper;

use OpenCloud\Common\Service\ServiceInterface;
use OpenCloud\Zf2\Helper\CloudFiles\Container;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception\InvalidArgumentException;

/**
 * Helper class for playing with Cloud Files in the views. Allows rendering of remote CDN objects, among other things.
 *
 * @package OpenCloud\Zf2\Helper
 */
class CloudFilesHelper extends AbstractHelper
{
    /** @var \OpenCloud\Common\Service\ServiceInterface */
    protected $service;

    /** @var array Cache of loaded container objects */
    protected $containers = array();

    /**
     * @param ServiceInterface $service The Cloud Files / Swift service
     */
    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Magic method which allows access to this object through method execution
     *
     * @param null $name Container name
     * @return \Zend\Zf2\Helper\CloudFiles\Container
     * @throws \Zend\View\Exception\InvalidArgumentException
     */
    public function __invoke($name = null)
    {
        if ($name == null) {
            throw new InvalidArgumentException(
                'A container name must be provided as an argument to the helper if there is no container set'
            );
        }

        return $this->getContainer($name);
    }

    /**
     * Return a container wrapper based on its name, saving to cache if necessary.
     *
     * @param $name Container name
     * @return \Zend\Zf2\Helper\CloudFiles\Container
     * @throws \Zend\View\Exception\InvalidArgumentException
     */
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

    /**
     * Create a new container wrapper and save it to cache
     *
     * @param $name Container name
     */
    protected function createContainer($name)
    {
        $this->containers[$name] = new Container($this->service, $name);
    }

}