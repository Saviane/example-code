<?php

namespace App\Modules\Services\Api;

use App\Exceptions\ApiServiceException;
use App\Modules\Interfaces\ApiInterface;
use App\Modules\Useful\Services\LogService;
use GuzzleHttp\Client;

/**
 * Classe para abstrair as funcionalidades de requisição para APIs
 * (utiliza o client GuzzleHttp)
 *
 * Class ApiService
 * @package App\Modules\Services\Api
 */
abstract class ApiService implements ApiInterface
{
    private $baseUri;
    private $client;
    private $headers;
    private $formParams;
    private $method = 'GET';
    private $endpoint;
    private $version;
    private $jsonDecode = true;

    /**
     * ApiService constructor.
     * @param $baseUri
     */
    public function __construct($baseUri)
    {
        $this->client = new Client(['base_uri' => $baseUri]);
    }

    /**
     * Seta o endereço base da API
     *
     * @param mixed $baseUri
     */
    public function setBaseUri($baseUri): void
    {
        $this->baseUri = $baseUri;
    }

    /**
     * Seta os headers da requisição
     * @param mixed $headers
     */
    public function setHeaders($headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Seta a versão da API (quando necessário)
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * Seta o tipo de retorno (json ou resultado original)
     *
     * @param bool $jsonDecode
     */
    public function setJsonDecode(bool $jsonDecode): void
    {
        $this->jsonDecode = $jsonDecode;
    }

    /**
     * Seta o método da requisição
     *
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * Seta os paramêtros do corpo da requisição (no caso de POST ou PUT)
     *
     * @param array $params
     */
    public function setFormParams(array $params): void
    {
        $this->formParams = $params;
    }

    /**
     * Constrói a URL da requisição (endpoint)
     * Concatena a versão com o endpoint
     *
     * @param null $endpoint
     */
    private function makeRequest($endpoint = null)
    {
        if (!is_null($endpoint)) {
            $this->endpoint = $endpoint;
        }
        if (!is_null($this->version)) {
            $this->endpoint = $this->version . '/' . $this->endpoint;
        }
    }

    /**
     * Executa a requisção com base nas informações fornecida e trata seu retorno
     *
     * @param null $endpoint
     * @return mixed
     * @throws ApiServiceException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doRequest($endpoint = null)
    {
        try {
            $this->makeRequest($endpoint);

            $response = $this->client->request($this->method, $this->endpoint, [
                'headers' => $this->headers,
                'form_params' => $this->formParams
            ]);

            return $this->makeResponse($response->getBody()->getContents());

        } catch (\Exception $e) {

            LogService::write($e, 'ApiService error');
            throw new ApiServiceException($e->getMessage());
        }
    }

    /**
     * Monta a resposta da requisição (json ou retorno original)
     *
     * @param $rawResponse
     * @return mixed
     */
    private function makeResponse($rawResponse)
    {
        if ($this->jsonDecode) {
            return json_decode($rawResponse);
        }
        return $rawResponse;
    }
}
