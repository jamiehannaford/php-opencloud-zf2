<?php

return array(
    'service_manager' => array(
        'invokables' => array(
            'ProviderBuilder' => 'OpenCloud\Zf2\Factory\ProviderBuilder'
        ),
        'aliases' => array(
            'OpenCloud' => 'OpenCloud\Rackspace'
        )
    ),
);