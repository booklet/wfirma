<?php
namespace Booklet;

use Booklet\WFirma\Request;

class RequestTest extends \PHPUnit\Framework\TestCase
{
    public function request()
    {
        return new Request([
            'login' => 'login',
            'password' => 'password',
            'resource' => 'resource',
            'action' => 'action',
            'request_parameters' => [
                'page' => 1,
                'limit' => 5,
                'conditions' => [
                    [
                        'and' => [
                            [
                                'condition' => [
                                    'field' => 'type',
                                    'operator' => 'eq',
                                    'value' => 'proforma',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'company_id' => 123,
        ]);
    }

    public function testGetUrl()
    {
        $this->assertEquals(
            'https://api2.wfirma.pl/resource/action?inputFormat=json&outputFormat=json&company_id=123',
            $this->request()->getUrl()
        );
    }

    public function testPrepareRequestData()
    {
        $this->assertEquals(
            '{"resource":{"parameters":{"page":1,"limit":5,"conditions":[{"and":[{"condition":{"field":"type","operator":"eq","value":"proforma"}}]}]}}}',
            $this->request()->prepareRequestData()
        );
    }
}
