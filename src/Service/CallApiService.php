<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    public function getBreedList(): array
    {
        $response = $this->client->request(
            "GET",
            "https://dog.ceo/api/breeds/list/all"
        );

        return $response->toArray();
    }

}