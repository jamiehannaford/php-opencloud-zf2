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
    ),
    'view_helpers' => array(
    	'factories' => array(
    		'CloudFiles' => function ($serviceManager) {
				$sl = $serviceManager->getServiceLocator();
	    		$client = $sl->get('OpenCloud');
	    		$config = $sl->get('config');
	    		
	    		$region = $config['opencloud']['region'];
	    		$urlType = $config['opencloud']['url_type'];
	    		
	    		$service = $client->objectStoreService('cloudFiles', $region, $urlType);
	    		
	    		return new \OpenCloud\Zf2\Helper\CloudFilesHelper($service);
    		}
    	)
    )
);