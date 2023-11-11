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

        // foreach ($rawList as $key=>$values) {
        //     $list[$key] = array_combine($values, $values);
        // }

        foreach ($rawList as $key => $values) {
            if (empty($values)) {
                $list[] = $key;
            } else {
                foreach ($values as $value) {
                    $list[] = "$key $value";
                }
            }
        }

        $list2 = array_combine($list, $list);
    
        //dd($list2);
        return $list2;
    }

}