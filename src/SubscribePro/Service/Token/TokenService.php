<?php

namespace SubscribePro\Service\Token;

use SubscribePro\Sdk;
use SubscribePro\Service\AbstractService;

class TokenService extends AbstractService
{
    /**
     * Service name
     */
    const NAME = 'token';

    const API_NAME_TOKEN = 'token';

    /**
     * @param \SubscribePro\Sdk $sdk
     * @return \SubscribePro\Service\DataFactoryInterface
     */
    protected function createDataFactory(Sdk $sdk)
    {
        return new TokenFactory(
            $this->getConfigValue(self::CONFIG_INSTANCE_NAME, '\SubscribePro\Service\Token\Token')
        );
    }

    /**
     * @param array $data
     * @return \SubscribePro\Service\Token\TokenInterface
     */
    public function createToken(array $data = [])
    {
        return $this->dataFactory->create($data);
    }

    /**
     * @param string $token
     * @return \SubscribePro\Service\Token\TokenInterface
     * @throws \SubscribePro\Exception\HttpException
     */
    public function loadToken($token)
    {
        $response = $this->httpClient->get("/services/v1/vault/tokens/{$token}.json");
        return $this->retrieveItem($response, self::API_NAME_TOKEN);
    }

    /**
     * @param \SubscribePro\Service\Token\TokenInterface $token
     * @return \SubscribePro\Service\Token\TokenInterface
     * @throws \SubscribePro\Exception\HttpException
     * @throws \BadMethodCallException
     */
    public function saveToken($token)
    {
        $response = $this->httpClient->post('/services/v1/vault/token.json', [self::API_NAME_TOKEN => $token->getFormData()]);
        return $this->retrieveItem($response, self::API_NAME_TOKEN, $token);
    }
}
