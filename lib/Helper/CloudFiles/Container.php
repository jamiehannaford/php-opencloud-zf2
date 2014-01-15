<?php

namespace OpenCloud\Zf2\Helper\CloudFiles;

use OpenCloud\Common\Collection\PaginatedIterator;
use OpenCloud\Common\Service\ServiceInterface;
use OpenCloud\ObjectStore\Constants\UrlType;

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

    public function __call($name, $args)
    {
        if (method_exists($this->container, $name)) {
            return call_user_func_array(array($this->container, $name), $args);
        }
    }

    public function breakCache()
    {
        $this->files = array();
    }

    protected function checkCache($name)
    {
        if (!isset($this->files[$name])) {
            $this->files[$name] = $this->container->getObject($name);
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

    public function getObject($data)
    {
        return new DataObject($this, $data);
    }

    public function renderAllFiles($limit = 100, $urlType = UrlType::CDN, $htmlPrefix = false, $htmlSuffix = false)
    {
        $files = $this->container->objectList(array(PaginatedIterator::LIMIT => $limit));

        $outputString = '';
        $outputArray  = array();

        foreach ($files as $file) {

            $url = $this->getObject($file)->renderUrl($urlType);

            if ($htmlPrefix && $htmlSuffix) {
                $outputString .= $htmlPrefix . $url . $htmlSuffix;
            } else {
                $outputArray[] = $url;
            }
        }

        return ($htmlPrefix && $htmlSuffix) ? $outputString : $outputArray;
    }

}