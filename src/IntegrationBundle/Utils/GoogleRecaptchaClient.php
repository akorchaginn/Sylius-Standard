<?php


namespace IntegrationBundle\Utils;

use GuzzleHttp\Client;

class GoogleRecaptchaClient
{
    const GOOGLE_ENDPOINT = 'https://www.google.com';

    /**
     * @var string
     */
    private $secretToken;

    /**
     * GoogleRecaptchaClient constructor.
     * @param string $secretToken
     */
    public function __construct(string $secretToken)
    {
        $this->secretToken = $secretToken;
    }

    /**
     * @param string $clientToken
     * @param string $clientIP
     * @return mixed
     */
    public function verify(string $clientToken, string $clientIP = '')
    {
        $httpClient = new Client([
            'base_uri' => self::GOOGLE_ENDPOINT,
        ]);

        $request = 'secret=' . $this->secretToken . '&response=' . $clientToken;
        if ($clientIP !== '') {
            $request .= 'remoteip=' . $clientIP;
        }

        $response = json_decode($httpClient->post('/recaptcha/api/siteverify?' . $request)->getBody(), true);
        return (boolean)$response['success'];
    }
}
