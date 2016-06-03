<?php

namespace SubscribePro;

use SubscribePro\Exception\InvalidArgumentException;
use SubscribePro\Exception\BadMethodCallException;

/**
 * @method \SubscribePro\Service\Product\ProductService getProductService()
 * @method \SubscribePro\Service\Customer\CustomerService getCustomerService()
 * @method \SubscribePro\Service\Address\AddressService getAddressService()
 * @method \SubscribePro\Service\Subscription\SubscriptionService getSubscriptionService()
 * @method \SubscribePro\Service\PaymentProfile\PaymentProfileService getPaymentProfileService()
 * @method \SubscribePro\Service\Transaction\TransactionService getTransactionService()
 * @method \SubscribePro\Service\Token\TokenService getTokenService()
 * @method \SubscribePro\Service\General\GeneralService getGeneralService()
 * @method \SubscribePro\Tools\Report getReportTool()
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
     * @var array
     */
    protected $tools = [];

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
     * @param string $name
     * @return array
     */
    protected function getServiceConfig($name)
    {
        $name = $this->underscore($name);
        return (array)(empty($this->config[$name]) ? [] : $this->config[$name]);
    }

    /**
     * Get service by name
     *
     * @param string $name
     * @return \SubscribePro\Service\AbstractService
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    public function getService($name)
    {
        if (!isset($this->services[$name])) {
            $this->services[$name] = $this->createService($name);
        }
        return $this->services[$name];
    }

    /**
     * Create service by name
     *
     * @param string $name
     * @return \SubscribePro\Service\AbstractService
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    protected function createService($name)
    {
        $name = $this->camelize($name);
        $serviceClient = "SubscribePro\\Service\\{$name}\\{$name}Service";

        if (!class_exists($serviceClient)) {
            throw new InvalidArgumentException("Service with '{$name}' name does not exist.");
        }

        return new $serviceClient($this, $this->getServiceConfig($name));
    }

    /**
     * Create tool by name
     *
     * @param string $name
     * @return mixed
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    protected function createTool($name)
    {
        $name = $this->camelize($name);
        $tool = "SubscribePro\\Tools\\{$name}";

        if (!class_exists($tool)) {
            throw new InvalidArgumentException("Tool with '{$name}' name does not exist.");
        }

        return new $tool($this);
    }

    /**
     * Get tool by name
     *
     * @param string $name
     * @return mixed
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    public function getTool($name)
    {
        if (!isset($this->tools[$name])) {
            $this->tools[$name] = $this->createTool($name);
        }
        return $this->tools[$name];
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) === 'get' && substr($method, -7) === 'Service') {
            return $this->getService($this->underscore(substr($method, 3, -7)));
        }

        if (substr($method, 0, 3) === 'get' && substr($method, -4) === 'Tool') {
            return $this->getTool($this->underscore(substr($method, 3, -4)));
        }

        throw new BadMethodCallException("Method {$method} does not exist.");
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
