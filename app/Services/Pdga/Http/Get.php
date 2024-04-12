<?php

namespace App\Services\Pdga\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class Get
{
    use Query;

    protected $apiRate = 250000;

    /**
     * @return array|mixed
     */
    protected function sendRequest(Url $url)
    {
        $auth = new Auth($url);
        $session = $auth->getAuthorization();

        $client = new Client();

        $cookieJar = CookieJar::fromArray([
            $session['session_name'] => $session['sessid'],
        ], 'pdga.com');

        $response = $client->get($url->fullUrl(), [
            'cookies' => $cookieJar,
            'query' => $this->getParameters(),
        ]);
        usleep($this->apiRate);

        if ($response->getStatusCode() != 200) {
            return [];
        }

        return json_decode($response->getBody(), true);
    }
}
