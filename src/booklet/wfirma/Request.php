<?php
namespace Booklet\WFirma;

use Booklet\WFirma;
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

    public function __construct(array $options = [])
    {
        $this->login = $options['login'];
        $this->password = $options['password'];
        $this->resource = $options['resource'];
        $this->action = $options['action'];
        $this->request_parameters = $options['request_parameters'] ?? null;
        $this->request_data = $options['request_data'] ?? null;
        $this->company_id = $options['company_id'] ?? null;
        $this->return_raw_response = $options['raw_response'] ?? false;
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

        return json_encode($request);
    }

    public function processResponseData(string $result)
    {
        $response = json_decode($result, true);

        $status_code = $response['status']['code'] ?? 'UNEXPECTED STATUS';
        if ($status_code !== 'OK') {
            throw new WFirmaException($status_code);
        }

        if ($this->return_raw_response) {
            return $response;
        }

        return (new ResponseDataProcessor($response, $this->action))->simplify();
    }
}
