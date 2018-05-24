<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 05/05/2018
 * Time: 12:29
 */

namespace App\Repositories;


use GuzzleHttp\Client;

class GuzzleHttpRequest
{

    protected $client;

    function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function get($url){
        $response = $this->client->request('GET', $url);

        return ['status' => json_decode($response->getStatusCode()), 'body' => json_decode($response->getBody()->getContents(), true)];
    }

    protected function post($url, $data = false, $token = null)
    {
        $token = \Request::cookie('front_us_token', null);

        if($data)
        {
            if($token){
                $response = $this->client->request('POST', $url, [
                    'headers' =>
                        [
                            'Authorization' => "Bearer " . $token
                        ],
                    'form_params' => $data
                ]);
            }else{
                $response = $this->client->request('POST', $url, [
                    'form_params' => $data
                ]);
            }


        }else{
            if($token){
                $response = $this->client->request('POST', $url, [
                    'headers' =>
                        [
                            'Authorization' => "Bearer " . $token
                        ]
                ]);
            }else{
                $response = $this->client->request('POST', $url);
            }

        }

        return ['status' => json_decode($response->getStatusCode()), 'body' => json_decode($response->getBody()->getContents(), true)];

    }

}