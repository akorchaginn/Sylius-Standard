<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 25.12.2018
 * Time: 7:52
 */

namespace Override\AddressingBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @param Request $request
 *
 * @return Response
 */
class AddressController extends Controller
{

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addressAction(Request $request)
    {
        $value = $request->get('value');
        
        $token = $this->getParameter("dadata_token");
        $headers = [
            'Authorization' => "Token $token",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $data = json_encode([
            'query' => $value,
            'count' => '10',
        ]);
        $client = new Client(['base_uri' => 'https://suggestions.dadata.ru/']);
        $response = $client->post('suggestions/api/4_1/rs/suggest/address', [
            "headers" => $headers,
            "body" => $data]);

        $data = json_decode($response->getBody());

        return new JsonResponse($data);
    }
}