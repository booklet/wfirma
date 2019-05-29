<?php
namespace Booklet\WFirma;

class Response
{
    private $request;
    private $response;
    private $request_parameters;
    private $response_processor;

    public function __construct(Request $request, array $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->request_parameters = $request->getRequestPrameters();
        $this->response_processor = new ResponseDataProcessor($response, $this->request_parameters['action']);
    }

    public function data()
    {
        return $this->response_processor->simplifyDataStructure();
    }

    public function rawData()
    {
        return $this->response;
    }

    public function parameters()
    {
        return $this->response_processor->getParametersFromResponse();
    }

    public function requestResource()
    {
        return $this->request_parameters['resource'];
    }

    public function requestAction()
    {
        return $this->request_parameters['action'];
    }

    public function requestParameters()
    {
        return $this->request_parameters['request_parameters'];
    }

    public function requestFullQuery()
    {
        return $this->request->prepareRequestData();
    }

    public function requestData()
    {
        return $this->request_parameters['request_data'];
    }

    public function requestCompanyId()
    {
        return $this->request_parameters['company_id'];
    }
}
