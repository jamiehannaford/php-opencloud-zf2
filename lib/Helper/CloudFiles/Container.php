<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\Common\Collection\PaginatedIterator;
use OpenCloud\Common\Service\ServiceInterface;
use OpenCloud\ObjectStore\Constants\UrlType;
use OpenCloud\Rackspace;

class Container 
{
    protected $client;
    protected $container;

    protected $files = array();

    public function __construct(ServiceInterface $service, $name)
    {
        $this->service = $service;
        
        $this->container = $this->service->getContainer($name);
    }

    public function breakCache()
    {
        $this->files = array();
    }

    protected function checkCache($name)
    {
        if (!isset($this->files[$name])) {
            $this->files[$name] = $this->getObject($name);
        }
    }

    public function renderFile($name, $urlType = UrlType::CDN)
    {
        $this->checkCache($name);

        return $this->files[$name]->render($urlType);
    }

    public function renderFileUrl($name, $urlType = UrlType::CDN)
    {
        $this->checkCache($name);

        return $this->files[$name]->renderUrl($urlType);
    }

    public function getObject($name)
    {
        return new DataObject($this->container, $name);
    }

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