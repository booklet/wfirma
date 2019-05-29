<?php
namespace Booklet\WFirma;

use Booklet\WFirma;

class Modules extends WFirma
{
    public function find(array $parameters = [])
    {
        return $this->request('find', array_merge($parameters, ['request_parameters' => $parameters]));
    }

    public function get(int $id, array $parameters = [])
    {
        return $this->request('get/' . $id, $parameters);
    }

    public function add(array $data, array $parameters = [])
    {
        return $this->request('add', array_merge($parameters, ['request_data' => $data]));
    }

    public function edit(int $id, array $data, array $parameters = [])
    {
        return $this->request('edit/' . $id, array_merge($parameters, ['request_data' => $data]));
    }

    public function delete(int $id, array $parameters = [])
    {
        return $this->request('delete/' . $id, $parameters);
    }
}
