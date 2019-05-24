<?php
namespace Booklet\WFirma\Modules;

use Booklet\WFirma\Request;

class Invoice
{
    const RESOURCE = 'invoices'

    public function find(array $options = [])
    {
        $request_params = [
            'resource' => self::RESOURCE,
        ];

        $request = new Request($request_params);
        return $request->makeRequest();

        $options['parameters'];
        $options['conditions'];
    }

    public function get()
    {
    }

    public function download()
    {
    }

    public function send()
    {
    }

    public function fiscalize()
    {
    }

    public function unfiscalize()
    {
    }

    public function add()
    {
    }

    public function edit()
    {
    }

    public function delete(])
    {
    }
}
