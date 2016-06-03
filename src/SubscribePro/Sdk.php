<?php

namespace SubscribePro;

use SubscribePro\Exception\InvalidArgumentException;

/**
 * @method \SubscribePro\Service\Product\ProductService getProductService()
 * @method \SubscribePro\Service\Customer\CustomerService getCustomerService()
 * @method \SubscribePro\Service\Address\AddressService getAddressService()
 * @method \SubscribePro\Service\Subscription\SubscriptionService getSubscriptionService()
 * @method \SubscribePro\Service\PaymentProfile\PaymentProfileService getPaymentProfileService()
 * @method \SubscribePro\Service\Transaction\TransactionService getTransactionService()
 * @method \SubscribePro\Service\Token\TokenService getTokenService()
 * @method \SubscribePro\Service\General\GeneralService getGeneralService()
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
     * Config instance name
     */
    const CONFIG_INSTANCE_NAME = 'instance_name';

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
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        $config = array_merge([
            'client_id' => getenv(static::CLIENT_ID_ENV_NAME),
            'client_secret' => getenv(static::CLIENT_SECRET_ENV_NAME),
            'enable_logging' => false
        ], $config);

        if (!$config['client_id']) {
            throw new InvalidArgumentException('Required "client_id" key is not supplied in config and could not find fallback environment variable "' . static::CLIENT_ID_ENV_NAME . '"');
        }
        if (!$config['client_secret']) {
            throw new InvalidArgumentException('Required "client_secret" key is not supplied in config and could not find fallback environment variable "' . static::CLIENT_SECRET_ENV_NAME . '"');
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
        $namespace = $this->underscore($namespace);
        return (array)(empty($this->config[$namespace]) ? [] : $this->config[$namespace]);
    }

    /**
     * Get service by name
     *
     * @param string $namespace
     * @return \SubscribePro\Service\AbstractService
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    public function getService($namespace)
    {
        if (!isset($this->services[$namespace])) {
            $this->services[$namespace] = $this->createService($namespace);
        }
        return $this->services[$namespace];
    }

    /**
     * Create service by name
     *
     * @param string $namespace
     * @return \SubscribePro\Service\AbstractService
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    protected function createService($namespace)
    {
        $namespace = $this->camelize($namespace);
        $serviceClient = "SubscribePro\\Service\\{$namespace}\\{$namespace}Service";

        if (!class_exists($serviceClient)) {
            throw new InvalidArgumentException("'{$namespace}' namespace does not exist.");
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
            return $this->getService($this->underscore(substr($method, 3, -7)));
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    /**
     * @param string $name
     * @return string
     */
    protected function camelize($name)
    {
        return implode('', array_map('ucfirst', explode('_', $name)));
    }

    /**
     * @param string $name
     * @return string
     */
    protected function underscore($name)
    {
        return strtolower(trim(preg_replace('/([A-Z]|[0-9]+)/', '_$1', $name), '_'));
    }
}
