<?php

namespace SubscribePro;

/**
 * @method \SubscribePro\Service\Product\ProductService getProductService()
 * @method \SubscribePro\Service\Customer\CustomerService getCustomerService()
 * @method \SubscribePro\Service\Address\AddressService getAddressService()
 * @method \SubscribePro\Service\Subscription\SubscriptionService getSubscriptionService()
 * @method \SubscribePro\Service\PaymentProfile\PaymentProfileService getPaymentProfileService()
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
     * @var array
     */
    protected $services = [];

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
     * Get a service by name
     *
     * @param string $namespace
     * @return \SubscribePro\Service\AbstractService
     * @throws \InvalidArgumentException
     */
    public function getService($namespace)
    {
        if (!isset($this->services[$namespace])) {
            $this->services[$namespace] = $this->createService($namespace);
        }
        return $this->services[$namespace];
    }

    /**
     * Create a service by name
     *
     * @param string $namespace
     * @return \SubscribePro\Service\AbstractService
     * @throws \InvalidArgumentException
     */
    protected function createService($namespace)
    {
        $namespace = camelize($namespace);
        $serviceClient = "SubscribePro\\Service\\{$namespace}\\{$namespace}Service";

        if (!class_exists($serviceClient)) {
            throw new \InvalidArgumentException("'{$namespace}' namespace does not exist.");
        }

        return new $serviceClient($this, $this->getNamespaceConfig($namespace));
    }

    /**
     * @param string $method
     * @param array $args
     * @return \SubscribePro\Service\AbstractService
     * @throws \BadMethodCallException
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) === 'get' && substr($method, -7) === 'Service') {
            return $this->getService(underscore(substr($method, 3, -7)));
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}
