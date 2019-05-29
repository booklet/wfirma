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

    // Dynamic create and return module
    public function __get(string $name)
    {
        $class_name = '\\Booklet\\WFirma\\Modules\\' . Utils::stringToCamelCase($name);
        if (class_exists($class_name)) {
            return new $class_name($this->login, $this->password, $this->company_id);
        }
    }

    public function request($action, array $parameters = [])
    {
        $request = new Request([
            'login' => $this->login,
            'password' => $this->password,
            'resource' => $this->getResourceModuleNameFromClassName(),
            'action' => $action,
            'request_parameters' => $parameters['request_parameters'] ?? null,
            'request_data' => $parameters['request_data'] ?? null,
            'company_id' => $this->company_id,
        ]);

        return $request->makeRequest();
    }

    // Booklet\WFirma\Modules\Invoices => invoices
    private function getResourceModuleNameFromClassName()
    {
        $parts = explode('\\', get_class($this));

        return strtolower(end($parts));
    }
}
