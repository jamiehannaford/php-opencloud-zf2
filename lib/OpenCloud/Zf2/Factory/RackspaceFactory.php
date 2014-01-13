<?php

namespace OpenCloud\Zf2\Factory;

use OpenCloud\Rackspace;

class RackspaceFactory extends AbstractProviderFactory
{
    const CLIENT_CLASS = 'OpenCloud\Rackspace';

    public function validateConfig()
    {
        if (!isset($this->config['username'])) {
            throw new ProviderException(sprintf(
                'The %s config option is required to instantiate the %s service',
                'username',
                'OpenCloud\Rackspace'
            ));
        }

        if (!isset($this->config['apiKey'])) {
            throw new ProviderException(sprintf(
                'The %s config option is required to instantiate the %s service',
                'apiKey',
                'OpenCloud\Rackspace'
            ));
        }
    }

}