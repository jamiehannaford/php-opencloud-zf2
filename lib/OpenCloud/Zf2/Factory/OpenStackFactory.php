<?php

namespace OpenCloud\Zf2\Factory;

class OpenStackFactory extends AbstractProviderFactory
{
    const CLIENT_CLASS = 'OpenCloud\OpenStack';

    public function validateConfig()
    {
        if (!isset($this->config['username'])) {
            throw new ProviderException(sprintf(
                'The %s config option is required to instantiate the %s service',
                'username',
                'OpenCloud\OpenStack'
            ));
        }

        if (!isset($this->config['password'])) {
            throw new ProviderException(sprintf(
                'The %s config option is required to instantiate the %s service',
                'password',
                'OpenCloud\OpenStack'
            ));
        }

        if (!isset($this->config['tenantId']) || !isset($this->config['tenantName'])) {
            throw new ProviderException(sprintf(
                'The %s config option is required to instantiate the %s service',
                'tenantId/tenantName',
                'OpenCloud\OpenStack'
            ));
        }
    }

} 