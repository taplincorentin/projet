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

        $data = $response->toArray();

        $rawList = $data['message'];
        $list = [];

        foreach ($rawList as $key=>$values) {
            $list[$key] = array_combine($values, $values);
        }

        //dd($list);
        return $list;
    }

}