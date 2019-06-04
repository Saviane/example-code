<?php

namespace App\Services\API;

use App\Modules\Services\Api\ApiService;

class DigitalOceanApiService extends ApiService
{
    /**
     * endereço da API
     */
    private $baseUri = 'https://api.digitalocean.com';

    /**
     * versão da API
     */
    private $version = 'v2';

    /**
     * Digital Ocean constructor.
     */
    public function __construct()
    {
        parent::__construct($this->baseUri);
        parent::setHeaders(['Authorization' => env('API_TOKEN_DO')]); // token para acesso
        parent::setVersion($this->version);
    }

    /**
     * Retorna todos os servidores (ligados e desligados)
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getServers()
    {
        return $this->doRequest('droplets');
    }

    /**
     * Retorna os dados do servidor referente o id
     *
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getServer($id)
    {
        return $this->doRequest('droplets/' . $id);
    }

    /**
     * Endpoint para desligar o servidor
     *
     * @param $id id do servidor
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function shutdown($id)
    {
        $this->setMethod('POST');
        $this->setFormParams(['type' => 'shutdown']);
        return $this->doRequest('droplets/' . $id . '/actions');
    }

    /**
     * Endpoint para ligar o servidor
     *
     * @param $id id do servidor
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function turnOn($id)
    {
        $this->setMethod('POST');
        $this->setFormParams(['type' => 'power_on']);
        return $this->doRequest('droplets/' . $id . '/actions');
    }

    /**
     * Endpoint para excluir o servidor 
     * (todos os dados serão apagados)
     *
     * @param $id id do servidor
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroyServer($id)
    {
        $this->setMethod('DELETE');
        return $this->doRequest('droplets/' . $id);
    }
}
