<?php

// namespace App\Service;

// use Symfony\Contracts\HttpClient\HttpClientInterface;

// class VilleApiService
// {
//     private $client;

//     public function __construct(HttpClientInterface $client)
//     {
//         $this->client = $client;
//     }

//     public function getVilleListe()
//     {
//         $url = 'http://api.openweathermap.org/data/2.5/box/city?bbox=180,-90,180,90,100&appid=%s=';

//         $response = $this->client->request('GET', $url);
//         $data = $response->toArray();

//         $rawVilles = $data['list'];
//         $villes = [];

//         foreach ($rawVilles as $rawVille) {
//             $villes []= $rawVille['name'];
//         }
        
//         return $villes;
//     }
// }