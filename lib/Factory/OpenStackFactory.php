<?php

namespace OpenCloud\Zf2\Factory;

class OpenStackFactory extends AbstractProviderFactory
{
    protected $clientClass = 'OpenCloud\OpenStack';
    protected $required    = array('username', 'password', array('tenantName', 'tenantId'));
}