<?php
declare(strict_types=1);
namespace Meetup;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\json_decode;

class MeetupApiService
{
    private $httpClient;
    private $key;

    const API_URL = 'https://api.meetup.com/2/rsvps?event_id=%s&key=%s';

    /**
     * MeetupApiService constructor.
     *
     * @param $key
     */
    public function __construct($key)
    {
        $this->httpClient = new Client();
        $this->key = $key;
    }

    /**
     * If something goes wrong on the meetup.com API
     * we want to continue and render our page anyway
     *
     * @param  $eventUrl     URL from meetup.com web site
     * @return array
     */
    public function getAttendees($eventUrl)
    {
        if (strpos($eventUrl, 'meetup.com') === false) {
            return [];
        }

        try {
            $parts = explode('/', $eventUrl);
            $meetupId = $parts[count($parts) - 2];
            $uri = sprintf(self::API_URL, $meetupId, $this->key);
            $request = new Request('GET', $uri);
            $response = $this->httpClient->send($request);
            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());
            $attendees = $data->results;
            shuffle($attendees);

            return $attendees;
        } catch (\Exception $e) {
            return [];
        }
    }
}
