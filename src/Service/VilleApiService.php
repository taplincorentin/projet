<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class VilleApiService
{

    private $httpClient;

    public function __construct()
    {
        $this->httpClient = HttpClient::create();
    }

    public function getVilleListe()
    {
        $url = 'http://api.openweathermap.org/data/2.5/box/city?bbox=180,-90,180,90,100&appid=%s=6977d652c686df85875de405090c55f2';

        $response = $this->httpClient->request('GET', $url);
        $data = $response->toArray();

        $rawVilles = $data['list'];
        $villes = [];

        foreach ($rawVilles as $rawVille) {
            $villes []= $rawVille['name'];
        }
        
        return $villes;
    }
}