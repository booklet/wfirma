<?php
namespace Booklet;

use Booklet\WFirma\Utils;

class WFirma
{
    const WFIRMA_API_URL = 'https://api2.wfirma.pl/';
    const INPUT_FORMAT = 'json';
    const OUTPUT_FORMAT = 'json';


    const RECORDS_PER_PAGE = 50;

    private $login;
    private $password;
    private $company_id;

    public function __construct(string $login, string $password, int $company_id = null)
    {
        $this->login = $login;
        $this->password = $password;
        $this->company_id = $company_id ?? null;
    }

    public function __get(string $name) {
        $class_name = '\\Booklet\\WFirma\\Modules\\' . Utils::stringToCamelCase($name);
        if (class_exists($class_name)) {
            return new $class_name();
        }
    }

    public function tmp_request($resource, $request, array $options = [])
    {
        // const INPUT_FORMAT = 'json';
        // const OUTPUT_FORMAT = 'json';
        $url = WFIRMA_API_URL . $resource . '?inputFormat=json&outputFormat=json';
        if ($this->company_id) {
            $url .= '&company_id=' . $this->company_id;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($ch, CURLOPT_USERPWD, $this->login . ':' . $this->password);
        $result = curl_exec($ch);

        return $result;
    }
}
