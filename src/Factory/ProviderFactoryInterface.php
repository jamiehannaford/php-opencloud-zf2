<?php

namespace OpenCloud\Zf2\Factory;

/**
 * Interface for concrete provider factories
 *
 * @package OpenCloud\Zf2\Factory
 */
interface ProviderFactoryInterface
{
    /**
     * Returns a new instance of the concrete factory
     *
     * @return static
     */
    public static function newInstance();

    /**
     * Set config array
     *
     * @param array $config Configuration values
     */
    public function setConfig(array $config);

    /**
     * Get config array
     *
     * @return array
     */
    public function getConfig();

    /**
     * Get FQCN string of client
     *
     * @return string
     */
    public function getClientClass();

    /**
     * Validates the currently set configuration values; passing them one-by-one to a validation method.
     *
     * @return void
     */
    public function validateConfig();

    /**
     * Validation method that checks whether required values have been provided or not. The field names should exist
     * as string-formatted array values. If an nested array is provided, the method assumes that the user must provide
     * at least one of the sub-array values - as long as one is provided, the check passes; if none are provided, the
     * check fails. An example:
     *  array(
     *    'username', 'password', array('tenantId', 'tenantName')
     *  )
     * Both `username` and `password` are required; and _either_ `tenantId` _or_ `tenantName` will suffice.
     *
     * @param string|array Name of required option
     * @throws \OpenCloud\Zf2\Exception\ProviderException
     */
    public function validateOption($name);

    /**
     * Builds concrete client object and passes in the auth URL and configuration values.
     *
     * @return \Guzzle\Http\ClientInterface
     */
    public function buildClient();
} 