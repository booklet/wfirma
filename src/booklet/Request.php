<?php

namespace Booklet\WFirma;

use Booklet\WFirma\Exceptions\WFirmaException;

class Request
{
    private $login;
    private $password;
    private $resource;
    private $action;
    private $request;
    private $data;
    private $company_id;

    public function __construct(array $parameters = [])
    {
        $this->login = $parameters['login'];
        $this->password = $parameters['password'];
        $this->resource = $parameters['resource'];
        $this->action = $parameters['action'];
        $this->request_parameters = $parameters['request_parameters'] ?? null;
        $this->request_data = $parameters['request_data'] ?? null;
        $this->company_id = $parameters['company_id'] ?? null;
    }

    public function makeRequest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->prepareRequestData()));
        curl_setopt($ch, CURLOPT_USERPWD, $this->login . ':' . $this->password);

        $result = curl_exec($ch);

        return $this->processResponseData($result);
    }

    public function getRequestPrameters()
    {
        return [
            'resource' => $this->resource,
            'action' => $this->action,
            'request_parameters' => $this->request_parameters,
            'request_data' => $this->request_data,
            'company_id' => $this->company_id,
        ];
    }

    public function getUrl()
    {
        $url_params = [
            'inputFormat' => 'json',
            'outputFormat' => 'json',
            'company_id' => $this->company_id,
        ];

        return WFirma::WFIRMA_API_URL . $this->resource . '/' . $this->action . '?' . http_build_query($url_params);
    }

    public function prepareRequestData()
    {
        // Wrap request data
        if (isset($this->request_data)) {
            // new, edit ...
            $data = $this->request_data;
        } else {
            // find, get, delete ...
            $data = [
                'parameters' => $this->request_parameters,
            ];
        }
        $request = [
            $this->resource => $data,
        ];

        return $request;
    }

    public function processResponseData(string $result)
    {
        $response = json_decode($result, true);

        $this->checkResponseStatus($response);

        return new Response($this, $response);
    }

    private function checkResponseStatus($response)
    {
        $status_code = $response['status']['code'] ?? 'UNEXPECTED STATUS';
        if ($status_code !== 'OK') {
            throw new WFirmaException($status_code);
        }
    }
}
