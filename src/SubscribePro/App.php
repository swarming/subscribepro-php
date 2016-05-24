<?php

namespace SubscribePro;

class App
{
    /**
     * @var string The app ID.
     */
    protected $clientId;

    /**
     * @var string The app secret.
     */
    protected $clientSecret;

    /**
     * @param string $id
     * @param string $secret
     */
    public function __construct($id, $secret)
    {
        $this->clientId = $id;
        $this->clientSecret = $secret;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
}
