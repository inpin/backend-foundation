<?php

namespace Inpin\Foundation\Utils\Guzzle;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class InpinGuzzleProxy implements ClientInterface
{
    /**
     * @var null|Client
     */
    public $client = null;
    /**
     * @var array
     */
    private $config = [];

    /**
     * @return ClientInterface Client
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client($this->config);
        }

        return $this->client;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->client = null;
        $this->config = $config;
    }

    public function request($method, $uri = '', array $options = [])
    {
        $options['header']['Accept'] = 'application/json';
        $options['header']['Content-Type'] = 'application/json';

        return $this->getClient()->request($method, $uri, $options);
    }

    public function send(RequestInterface $request, array $options = [])
    {
        return $this->getClient()->send($request, $options);
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
        return $this->getClient()->sendAsync($request, $options);
    }

    public function requestAsync($method, $uri, array $options = [])
    {
        $options['header']['Accept'] = 'application/json';
        $options['header']['Content-Type'] = 'application/json';

        return $this->getClient()->requestAsync($method, $uri, $options);
    }

    public function getConfig($option = null)
    {
        return $this->getClient()->getConfig($option);
    }
}