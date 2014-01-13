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
                    $builder->setServiceLocator($serviceManager);
                    return $builder->build();
                },
            'OpenCloud\Rackspace' => function ($serviceManager) {
                    $builder = $serviceManager->get('ProviderBuilder');
                    $builder->setProvider('Rackspace');
                    $builder->setServiceLocator($serviceManager);
                    return $builder->build();
                }
        ),
        'aliases' => array(
            'OpenCloud' => 'OpenCloud\Rackspace'
        )
    )
);