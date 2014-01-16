<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\Common\Collection\PaginatedIterator;
use OpenCloud\Common\Service\ServiceInterface;
use OpenCloud\ObjectStore\Constants\UrlType;

/**
 * Facade object which provides a simple interface to the underlying Container model. It offers functionality one
 * might expect from HTML views.
 *
 * @package OpenCloud\Zf2\Helper\CloudFiles
 */
class Container 
{
    /** @var OpenCloud\ObjectStore\Resource\Container Wrapped object */
    protected $container;

    /** @var array A cache of files which have been loaded */
    protected $files = array();

    /**
     * @param ServiceInterface $service Parent service
     * @param                  $name    Name of container
     */
    public function __construct(ServiceInterface $service, $name)
    {
        $this->container = $service->getContainer($name);
    }

    /**
     * @return array
     */
    public function getCache()
    {
        return $this->files;
    }

    /**
     * Clear the local cache
     */
    public function clearCache()
    {
        $this->files = array();
    }

    /**
     * Check to see whether a file exists in the local cache
     *
     * @param $name DataObject name
     */
    protected function checkCache($name)
    {
        if (!isset($this->files[$name])) {
            $this->files[$name] = $this->getObject($name);
        }
    }

    /**
     * Render a file into valid HTML markup
     *
     * @param        $name    File name
     * @param string $urlType Connection type
     * @return mixed
     */
    public function renderFile($name, $urlType = UrlType::CDN)
    {
        $this->checkCache($name);

        return $this->files[$name]->render($urlType);
    }

    /**
     * Output a file's URI
     *
     * @param        $name    File name
     * @param string $urlType Connection type
     * @return string
     */
    public function renderFileUrl($name, $urlType = UrlType::CDN)
    {
        $this->checkCache($name);

        return $this->files[$name]->renderUrl($urlType);
    }

    /**
     * Return a facade for an object
     *
     * @param $name File name
     * @return DataObject
     */
    public function getObject($name)
    {
        return new DataObject($this->container, $name);
    }

    /**
     * Render all files in a container. If a prefix and suffix are provided, each object will be wrapped in the tags
     * provided; otherwise they will be populated in a standard array for later use.
     *
     * @param int    $limit      The total amount of resources to return
     * @param string $urlType    The connection type
     * @param bool   $htmlPrefix HTML tag prefix
     * @param bool   $htmlSuffix HTML tag suffix
     * @return array|string
     */
    public function renderAllFiles($limit = 100, $urlType = UrlType::CDN, $htmlPrefix = false, $htmlSuffix = false)
    {
        $files = $this->container->objectList(array(PaginatedIterator::LIMIT => $limit));

        $outputString = '';
        $outputArray  = array();

        foreach ($files as $file) {

            $url = $this->getObject($file->getName())->renderUrl($urlType);

            if ($htmlPrefix && $htmlSuffix) {
                $outputString .= $htmlPrefix . $url . $htmlSuffix;
            } else {
                $outputArray[] = $url;
            }
        }

        return ($htmlPrefix && $htmlSuffix) ? $outputString : $outputArray;
    }

}