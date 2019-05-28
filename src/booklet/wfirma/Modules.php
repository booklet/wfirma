<?php
namespace Booklet\WFirma;

use Booklet\WFirma;

class Modules extends WFirma
{
    public function find(array $parameters = [])
    {
        return $this->request(static::MODULE_NAME_PLURAL, 'find', ['request_parameters' => $parameters]);
    }

    public function get(int $id)
    {
        return $this->request(static::MODULE_NAME_PLURAL, 'get/' . $id);
    }

    public function add(array $data)
    {
        return $this->request(static::MODULE_NAME_PLURAL, 'add', ['data' => $data]);
    }

    public function edit(int $id, array $data)
    {
        return $this->request(static::MODULE_NAME_PLURAL, 'edit/' . $id, ['data' => $data]);
    }

    public function delete(int $id)
    {
    }
}
