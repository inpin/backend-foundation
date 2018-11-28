<?php

namespace Inpin\Foundation\Utils;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class MicroServiceHelper
{
    private static $mockArray = [];

    /**
     * To fill the $mockArray
     *
     * @param array $mockArray
     */
    public static function setMockArray(array $mockArray)
    {
        self::$mockArray = $mockArray;
    }

    /**
     * This method will check if $mockArray is filled then the Client will be created with a mockHandler attached to it
     *
     * @return Client
     */
    public static function createClient()
    {
        $options = [];
        if (count(self::$mockArray) > 0) {
            $mock = new MockHandler(self::$mockArray);
            $handler = HandlerStack::create($mock);
            $options['handler'] = $handler;
        }

        return new Client($options);
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
    public static function apiCall(string $url, string $method = 'GET', array $body = [], array $params = [], array $headers = [])
    {
        return self::createClient()->request($method, $url, [
            'body' => $body,
            'query' => $params,
            'headers' => array_merge([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ], $headers),
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
    public static function uploadFile(string $url, array $files, string $method = 'POST')
    {
        $multipart = [];
        foreach ($files as $fileName => $filePath) {
            $multipart[] = [
                'name' => $fileName,
                'contents' => fopen($filePath, 'r'),
            ];
        }

        return self::createClient()->request($method, $url, [
            'multipart' => $multipart,
        ]);
    }
}