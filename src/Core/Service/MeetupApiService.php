<?php

namespace Core\Service;

use GuzzleHttp\Client;

class MeetupApiService
{
    private $httpClient;

    private $key;

    public function __construct($key)
    {
        $this->httpClient = new Client();
        $this->key = $key;
    }

    public function getMeetupAttendees($meetupId)
    {
        $uri = sprintf('https://api.meetup.com/2/rsvps?event_id=%s&key=%s', $meetupId, $this->key);
        $request = new \GuzzleHttp\Psr7\Request('GET', $uri);
        $response = $this->httpClient->send($request);
        $data = \GuzzleHttp\json_decode($response->getBody()->getContents());

        return $data->results;
    }
}