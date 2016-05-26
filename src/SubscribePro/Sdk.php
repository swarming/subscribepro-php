<?php

namespace SubscribePro;

/**
 * @method \SubscribePro\Service\Product\ProductService createProductService(array $config = [])
 * @method \SubscribePro\Service\Customer\CustomerService createCustomerService(array $config = [])
 * @method \SubscribePro\Service\Address\AddressService createAddressService(array $config = [])
 * @method \SubscribePro\Service\Subscription\SubscriptionService createSubscriptionService(array $config = [])
 */
class Sdk
{
    /**
     * Version SDK
     *
     * @const string
     */
    const VERSION = '0.1.0';

    /**
     * The name of the environment variable that contains the client ID
     *
     * @const string
     */
    const CLIENT_ID_ENV_NAME = 'SUBSCRIBEPRO_CLIENT_ID';

    /**
     * The name of the environment variable that contains the client secret
     *
     * @const string
     */
    const CLIENT_SECRET_ENV_NAME = 'SUBSCRIBEPRO_CLIENT_SECRET';

    /**
     * @var \SubscribePro\App
     */
    protected $app;

    /**
     * @var \SubscribePro\Http
     */
    protected $http;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        $config = array_merge([
            'client_id' => getenv(static::CLIENT_ID_ENV_NAME),
            'client_secret' => getenv(static::CLIENT_SECRET_ENV_NAME),
            'enable_logging' => false
        ], $config);

        if (!$config['client_id']) {
            throw new \InvalidArgumentException('Required "client_id" key not supplied in config and could not find fallback environment variable "' . static::CLIENT_ID_ENV_NAME . '"');
        }
        if (!$config['client_secret']) {
            throw new \InvalidArgumentException('Required "client_secret" key not supplied in config and could not find fallback environment variable "' . static::CLIENT_SECRET_ENV_NAME . '"');
        }

        $this->app = new App($config['client_id'], $config['client_secret']);
        unset($config['client_id']);
        unset($config['client_secret']);

        $this->http = new Http($this->app);

        if ($config['enable_logging']) {
            $this->http->initDefaultLogger();
            unset($config['enable_logging']);
        }

        $this->config = $config;
    }

    /**
     * @return \SubscribePro\Http
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * @param string $namespace
     * @return array
     */
    protected function getNamespaceConfig($namespace)
    {
        $namespace = underscore($namespace);
        return (array)(empty($this->config[$namespace]) ? [] : $this->config[$namespace]);
    }

    /**
     * Get a service by name using an array of constructor options
     *
     * @param string $namespace
     * @param array $config
     * @return \SubscribePro\Service\AbstractService
     * @throws \InvalidArgumentException
     */
    public function createService($namespace, array $config = [])
    {
        $namespace = camelize($namespace);
        $serviceClient = "SubscribePro\\Service\\{$namespace}\\{$namespace}Service";

        if (!class_exists($serviceClient)) {
            throw new \InvalidArgumentException("'{$namespace}' namespace does not exist.");
        }

        $config = array_merge($this->getNamespaceConfig($namespace), $config);
        return new $serviceClient($this->http, $config);
    }

    /**
     * @param string $method
     * @param array $args
     * @return \SubscribePro\Service\AbstractService
     * @throws \BadMethodCallException
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 6) === 'create' && substr($method, -7) === 'Service') {
            $config = sizeof($args) ? array_shift($args) : [];
            return $this->createService(underscore(substr($method, 6, -7)), $config);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}
