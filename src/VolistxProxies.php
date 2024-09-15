<?php

namespace Volistx\Proxies;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use UnexpectedValueException;

class VolistxProxies
{
    /**
     * The config repository instance.
     *
     * @var Repository
     */
    protected Repository $config;

    /**
     * The Guzzle HTTP client instance.
     *
     * @var Client
     */
    protected Client $http;

    /**
     * Create a new instance of StackPathProxies.
     *
     * @param Repository $config
     * @param Client $http
     */
    public function __construct(Repository $config, Client $http)
    {
        $this->config = $config;
        $this->http = $http;
    }

    /**
     * Retrieve StackPath proxies list.
     *
     * @return array
     */
    public function load(): array
    {
        return $this->retrieve();
    }

    /**
     * Retrieve requested proxy list by name.
     *
     * @return array
     * @throws GuzzleException
     */
    protected function retrieve(): array
    {
        try {
            $url = $this->config->get('vproxies.url');

            $response = $this->http->request('GET', $url);

            if ($response->getStatusCode() !== 200) {
                throw new UnexpectedValueException('Failed to load trust proxies from StackPath server.');
            }
        } catch (RequestException $e) {
            throw new UnexpectedValueException('Failed to load trust proxies from StackPath server.', 1, $e);
        }

        return array_filter(explode("\n", $response->getBody()->getContents()));
    }
}