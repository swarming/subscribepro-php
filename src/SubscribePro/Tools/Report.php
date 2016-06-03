<?php

namespace SubscribePro\Tools;

use SubscribePro\Exception\InvalidArgumentException;

class Report
{
    /**
     * @var \SubscribePro\Http
     */
    protected $httpClient;

    /**
     * Report codes
     */
    const REPORT_DAILY_SUBSCRIPTIONS = 'daily_subscriptions';
    const REPORT_COMPLETE_SUBSCRIPTIONS = 'complete_subscriptions';
    const REPORT_SUBSCRIPTION_HISTORY = 'subscription_history';
    const REPORT_EXPIRED_CREDIT_CARD = 'expired_credit_card';
    const REPORT_CUSTOMER_ACTIVITY = 'customer_activity';
    const REPORT_FAILED_SUBSCRIPTIONS = 'failed_subscriptions';
    const REPORT_SUBSCRIPTION_ORDER_HISTORY = 'subscription_order_history';
    const REPORT_COMPLETE_SALES_ORDERS = 'complete_sales_orders';
    const REPORT_COMPLETE_TRANSACTION = 'complete_transaction';
    const REPORT_PRODUCTS = 'products';

    /**
     * @var array
     */
    protected $reportCodes = [
        self::REPORT_DAILY_SUBSCRIPTIONS,
        self::REPORT_COMPLETE_SUBSCRIPTIONS,
        self::REPORT_SUBSCRIPTION_HISTORY,
        self::REPORT_EXPIRED_CREDIT_CARD,
        self::REPORT_CUSTOMER_ACTIVITY,
        self::REPORT_FAILED_SUBSCRIPTIONS,
        self::REPORT_SUBSCRIPTION_ORDER_HISTORY,
        self::REPORT_COMPLETE_SALES_ORDERS,
        self::REPORT_COMPLETE_TRANSACTION,
        self::REPORT_PRODUCTS,
    ];

    /**
     * @param \SubscribePro\Sdk $sdk
     */
    public function __construct(\SubscribePro\Sdk $sdk)
    {
        $this->httpClient = $sdk->getHttp();
    }

    /**
     * Get report in csv format
     *  Allowed code values:
     * - daily_subscriptions
     * - complete_subscriptions
     * - subscription_history
     * - expired_credit_card
     * - customer_activity
     * - failed_subscriptions
     * - subscription_order_history
     * - complete_sales_orders
     * - complete_transaction
     * - products
     *
     * @param string $code
     * @param string $filePath
     * @return void
     * @throws \SubscribePro\Exception\HttpException
     * @throws \SubscribePro\Exception\InvalidArgumentException
     */
    public function loadReport($code, $filePath)
    {
        if (!in_array($code, $this->reportCodes)) {
            throw new InvalidArgumentException('Invalid report code. Allowed values: ' . implode(', ', $this->reportCodes));
        }
        if ($this->isDirectory($filePath)) {
            throw new InvalidArgumentException("{$filePath} is a directory.");
        }
        if (!$this->canWriteToFile($filePath)) {
            throw new InvalidArgumentException("{$filePath} is not writable.");
        }

        $this->httpClient->getTotFile("/v2/reports/{$code}", $filePath);
    }

    /**
     * @param string $filePath
     * @return bool
     */
    protected function canWriteToFile($filePath)
    {
        return file_exists($filePath) ? is_writable($filePath) : is_writable(dirname($filePath));
    }

    /**
     * @param string $filePath
     * @return bool
     */
    protected function isDirectory($filePath)
    {
        return is_dir($filePath);
    }
}