<?php
namespace Booklet;

use Booklet\WFirma\Utils;
use Booklet\WFirma\Request;

class WFirma
{
    const WFIRMA_API_URL = 'https://api2.wfirma.pl/';

    private $login;
    private $password;
    private $company_id;

    public function __construct(string $login, string $password, int $company_id = null)
    {
        $this->login = $login;
        $this->password = $password;
        $this->company_id = $company_id ?? null;
    }

    public function __get(string $name)
    {
        $class_name = '\\Booklet\\WFirma\\Modules\\' . Utils::stringToCamelCase($name);
        if (class_exists($class_name)) {
            return new $class_name($this->login, $this->password, $this->company_id);
        }
    }

    public function request($resource, $action, array $request_parameters = [])
    {
        $request = new Request([
            'login' => $this->login,
            'password' => $this->password,
            'resource' => $resource,
            'action' => $action,
            'request_parameters' => $request_parameters['request_parameters'] ?? null,
            'data' => $request_parameters['data'] ?? null,
            'company_id' => $this->company_id,
        ]);

        return $request->makeRequest();
    }
}
