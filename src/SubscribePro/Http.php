<?php

namespace SubscribePro;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Psr\Log\LogLevel;

class Http
{
    /**
     * Default log file name
     */
    const DEFAULT_LOG_FILE_NAME = 'log/subscribepro.log';

    /**
     * Default log line format
     */
    const DEFAULT_LOG_LINE_FORMAT = "[%datetime%] %channel%.%level_name%: %message%\n";

    /**
     * Default log message format
     */
    const DEFAULT_LOG_MESSAGE_FORMAT = "{method} - {uri}\nRequest body: {req_body}\n{code} {phrase}\nResponse body: {res_body}\n{error}\n";

    /**
     * @var string
     */
    protected $baseUrl = 'https://api.subscribepro.com';

    /**
     * @var \SubscribePro\App
     */
    protected $app;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \GuzzleHttp\HandlerStack
     */
    protected $handlerStack;

    /**
     * @param App $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->handlerStack = HandlerStack::create();
    }

    protected function initClient()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'handler'  => $this->handlerStack,
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::AUTH => [$this->app->getClientId(), $this->app->getClientSecret()]
        ]);
    }

    /**
     * @return \GuzzleHttp\HandlerStack
     */
    public function getHandlerStack()
    {
        return $this->handlerStack;
    }

    /**
     * @param string|null $fileName
     * @param string|null $lineFormat
     * @param string|null $messageFormat
     * @return \SubscribePro\Http
     */
    public function initDefaultLogger($fileName = null, $lineFormat = null, $messageFormat = null)
    {
        $fileName = $fileName ?: static::DEFAULT_LOG_FILE_NAME;
        $lineFormat = $lineFormat ?: static::DEFAULT_LOG_LINE_FORMAT;
        $messageFormat = $messageFormat ?: static::DEFAULT_LOG_MESSAGE_FORMAT;

        $logHandler = new RotatingFileHandler($fileName);
        $logHandler->setFormatter(new LineFormatter($lineFormat, null, true));

        return $this->addLogger(new Logger('Logger', [$logHandler]), new MessageFormatter($messageFormat));
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \GuzzleHttp\MessageFormatter $messageFormatter
     * @param string $logLevel
     * @return $this
     */
    public function addLogger($logger, $messageFormatter, $logLevel = LogLevel::INFO)
    {
        $this->handlerStack->push(Middleware::log($logger, $messageFormatter, $logLevel));
        return $this;
    }

    /**
     * @param bool $force
     * @return \GuzzleHttp\Client
     */
    public function getClient($force = false)
    {
        if (null === $this->client || $force) {
            $this->initClient();
        }
        return $this->client;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function buildUrl($url)
    {
        return '/services/' . ltrim($url, '/');
    }

    /**
     * @param string $uri
     * @param array $params
     * @return array|int|null
     * @throws \RuntimeException
     */
    public function get($uri, $params = [])
    {
        $options = empty($params) ? [] : ['query' => $params];
        $response = $this->getClient()->get($this->buildUrl($uri), $options);

        return $this->processResponse($response);
    }

    /**
     * @param string $uri
     * @param array $postData
     * @return array|int|null
     * @throws \RuntimeException
     */
    public function post($uri, $postData = [])
    {
        $options = empty($postData) ? [] : ['json' => $postData];
        $response = $this->getClient()->post($this->buildUrl($uri), $options);

        return $this->processResponse($response);
    }

    /**
     * @param string $uri
     * @param array $putData
     * @return array|int|null
     * @throws \RuntimeException
     */
    public function put($uri, $putData = [])
    {
        $options = empty($putData) ? [] : ['json' => $putData];
        $response = $this->getClient()->put($this->buildUrl($uri), $options);

        return $this->processResponse($response);
    }

    /**
     * @param string $uri
     * @param string $filePath
     * @return array|int|null
     * @throws \RuntimeException
     */
    public function requestFile($uri, $filePath)
    {
        $response = $this->getClient()->get($this->buildUrl($uri), ['save_to' => $filePath]);

        return $this->processResponse($response);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array|int|null
     * @throws \RuntimeException
     */
    protected function processResponse($response)
    {
        if ($response->getStatusCode() < 300) {
            $body = (string)$response->getBody();
            return !empty($body) ? json_decode($body, true) : $response->getStatusCode();
        }

        throw new \RuntimeException($this->getErrorMessage($response), $response->getStatusCode());
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return string
     */
    protected function getErrorMessage($response)
    {
        $errorBody = json_decode((string)$response->getBody(), true);
        return !empty($errorBody['message']) ? $errorBody['message'] : $response->getReasonPhrase();
    }
}
