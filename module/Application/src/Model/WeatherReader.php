<?php
namespace Application\Model;

use Laminas\Http\Request;
use Laminas\Http\Client;
use Laminas\Json\Json;
use Laminas\Http\Client\Adapter\Curl;

class WeatherReader {
    /**
     * The API's endpoint.
     */
    const ENDPOINT = 'http://api.weatherapi.com/v1/forecast.xml';

    /**
     * The number of forecast days to request.
     * 
     * Note: The free version of the API only allows up to 3 days.
     */
    const FORECAST_DAYS = 3;

    /**
     * The area to get weather for.
     */
    const AREA = 'Margam';

    /**
     * API timeout in seconds.
     */
    const TIMEOUT = 5;

    /**
     * The API key.
     */
    private $key;

    /**
     * Constructor.
     */
    public function __construct($key) {
        $this->key = $key;
    }

    /**
     * Gets the weather by calling the weather api. The response is returned as an array, with the keys being the date strings
     */
    public function getWeather() {
        // build request/client
        $request = new Request();
        $request->setUri(self::ENDPOINT);
        $request->setMethod(Request::METHOD_GET);
        $client = new Client();
        $client->setRequest($request);
        $client->setOptions(['timeout' => self::TIMEOUT]);
        $client->setParameterGet([
            'days' => self::FORECAST_DAYS,
            'key' => $this->key,
            'q' => self::AREA,
        ]);

        // call the API
        $response = $client->send();
        
        // check it was a good response
        if (!$response->isOk()) {
            return null;
        }

        // get raw forecast array from xml encoded body
        $responseBody = simplexml_load_string($response->getBody());
        $rawForecast = json_decode(json_encode((array)$responseBody->forecast), TRUE);

        // deal with the response
        $forecast = [];
        foreach ($rawForecast as $forecastDay) {
            foreach ($forecastDay as $f) {
                $datetime = new \DateTime($f['date']);
                $forecast[$datetime->format('D d')] = $f;
            }
        }

        // return built forecast
        return $forecast;
    }
}