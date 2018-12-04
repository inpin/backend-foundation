<?php

namespace Inpin\Foundation\Utils\Guzzle;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class InpinGuzzleAdapter
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct()
    {
        $this->client = new InpinGuzzleProxy();
    }

    public function setConfig(array $config)
    {
        $this->client->setConfig($config);

        return $this;
    }

    public function setMockArray(array $mockArray)
    {
        $mock = new MockHandler($mockArray);
        $handler = HandlerStack::create($mock);
        return $this->setConfig(['handler' => $handler]);
    }

    /**
     * To use the micro-services
     *
     * @param string $url
     * @param string $method
     * @param array $body
     * @param array $params
     * @param array $headers
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function apiCall(string $url, string $method = 'GET', array $body = [], array $params = [], array $headers = [])
    {
        return $this->client->request($method, $url, [
            'json' => $body,
            'query' => $params,
            'headers' => $headers,
        ]);
    }

    /**
     * This method will upload files
     *
     * @param string $url
     * @param array $files must be an array like: [['file-name-1' => '/path/to/file1'],['file-name-2' => '/path/to/file2'],...]
     * @param string $method
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadFile(string $url, array $files, string $method = 'POST')
    {
        $multipart = [];
        foreach ($files as $fileName => $filePath) {
            if (filter_var($filePath, FILTER_VALIDATE_URL)) {
                $multipart[] = [
                    'name' => $fileName,
                    'contents' => fopen($filePath, 'r'),
                ];
            } else {
                $multipart[] = [
                    'name' => $fileName,
                    'contents' => $filePath,
                ];
            }
        }

        return $this->client->request($method, $url, [
            'multipart' => $multipart,
        ]);
    }
}