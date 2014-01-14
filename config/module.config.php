<?php

return array(
    'service_manager' => array(
        'invokables' => array(
            'ProviderBuilder' => 'OpenCloud\Zf2\Factory\ProviderBuilder'
        ),
        'factories' => array(
            'OpenCloud\OpenStack' => function ($serviceManager) {
                    $builder = $serviceManager->get('ProviderBuilder');
                    $builder->setProvider('OpenStack');
                    $builder->setConfig($serviceManager->get('config'));
                    return $builder->build();
                },
            'OpenCloud\Rackspace' => function ($serviceManager) {
                    $builder = $serviceManager->get('ProviderBuilder');
                    $builder->setProvider('Rackspace');
                    $builder->setConfig($serviceManager->get('config'));
                    return $builder->build();
                }
        ),
        'aliases' => array(
            'OpenCloud' => 'OpenCloud\Rackspace'
        )
    )
);