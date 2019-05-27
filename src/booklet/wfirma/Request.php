<?php
namespace Booklet\WFirma;

use \Booklet\WFirma;

class Request
{
    private $login;
    private $password;
    private $resource;
    private $action;
    private $request;
    private $data;
    private $company_id;

    public function __construct(array $options = [])
    {
        $this->login = $options['login'];
        $this->password = $options['password'];
        $this->resource = $options['resource'];
        $this->action = $options['action'];
        $this->request = $options['request_parameters'] ?? null;
        $this->data = $options['data'] ?? null;
        $this->company_id = $options['company_id'] ?? null;
    }

    public function makeRequest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->prepareRequestData());
        curl_setopt($ch, CURLOPT_USERPWD, $this->login . ':' . $this->password);

        $result = curl_exec($ch);

        return $this->processResponseData($result);
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
        if (isset($this->data)) {
            // new, edit ...
            $request = [
                $this->resource => $this->data,
            ];

        } else {
            // find, get, delete ...
            $request = [
                $this->resource => [
                    'parameters' => $this->request,
                ],
            ];
        }

        return json_encode($request);
    }

    // TODO Check response data
    public function processResponseData($result)
    {
        return json_decode($result);
    }
}
