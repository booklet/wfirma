<?php
// UWAGA
// Testy korzystają z konta demo w wFirma, istnieje możliwość, że z czasem
// przestana działać poprawnie, że względu na zmiany w koncie demo.

namespace Booklet;

class WFirmaTest extends \PHPUnit\Framework\TestCase
{
    public function testFnisAssoc()
    {
        $this->markTestIncomplete('Test wymaga zewnętrznego wywołania, dlatego wyłączony.');

        $wfirma = new WFirma('demo', 'demo');
        $parameters = [
            'conditions' => [
                [
                    'or' => [
                        [
                            'condition' => [
                                'field' => 'type',
                                'operator' => 'eq',
                                'value' => 'proforma',
                            ],
                        ],
                        [
                            'condition' => [
                                'field' => 'type',
                                'operator' => 'eq',
                                'value' => 'correction',
                            ],
                        ],
                    ],
                    'and' => [
                        [
                            'condition' => [
                                'field' => 'disposaldate',
                                'operator' => 'gt',
                                'value' => '2019-05-00',
                            ],
                        ],
                        [
                            'condition' => [
                                'field' => 'disposaldate',
                                'operator' => 'lt',
                                'value' => '2019-05-27',
                            ],
                        ],
                    ],
                ],
            ],
            'fields' => [
                ['field' => 'Invoice.id'],
                ['field' => 'Invoice.date'],
                ['field' => 'Invoice.type'],
                ['field' => 'Invoice.fullnumber'],
            ],
            'order' => [
                ['desc' => 'date'],
            ],
            'page' => 1,
            'limit' => 5,
        ];

        $invoices = $wfirma->invoice->find($parameters);

        $this->assertEquals('OK', $invoices['status']['code']);
        $this->assertEquals(4, count($invoices['invoices'][0]['invoice']));
    }

    public function testGet()
    {
        $this->markTestIncomplete('Test wymaga zewnętrznego wywołania, dlatego wyłączony.');

        $wfirma = new WFirma('demo', 'demo');
        $invoice = $wfirma->invoice->get(62407183);

        $this->assertEquals(62407183, $invoice['invoices'][0]['invoice']['id']);
    }

    public function testAdd()
    {
        $this->markTestIncomplete('Test wymaga zewnętrznego wywołania, dlatego wyłączony.');

        $wfirma = new WFirma('demo', 'demo');
        $data = [
            'contractor' => [
                'name' => 'Jan Testowy',
                'street' => 'Testowa 69',
                'zip' => '66-666',
                'city' => 'Miastowo',
                'email' => 'jan@testowy.pl',
            ],
        ];

        $new_contractor = $wfirma->contractor->add($data);

        $this->assertEquals('Jan Testowy', $new_contractor['contractors'][0]['contractor']['name']);
    }

    public function testEdit()
    {
        $this->markTestIncomplete('Test wymaga zewnętrznego wywołania, dlatego wyłączony.');

        $wfirma = new WFirma('demo', 'demo');
        // Create new contractor to get id
        $data = [
            'contractor' => [
                'name' => 'Jan T',
                'street' => 'Testowa 69',
                'zip' => '66-666',
                'city' => 'Miastowo',
                'email' => 'jan@testowy.pl',
            ],
        ];
        $new_contractor = $wfirma->contractor->add($data);
        $constractor_id = $new_contractor['contractors'][0]['contractor']['id'];

        // Update contractor data
        $new_data = [
            'contractor' => [
                'name' => 'Jan Testowy',
            ],
        ];
        $updated_contractor = $wfirma->contractor->edit($constractor_id, $new_data);

        $this->assertEquals('Jan Testowy', $updated_contractor['contractors'][0]['contractor']['name']);
    }

    public function testRequestException()
    {
        $this->markTestIncomplete('Test wymaga zewnętrznego wywołania, dlatego wyłączony.');

        $this->expectException(\Booklet\WFirma\Exceptions\WFirmaException::class);

        $wfirma = new WFirma('demo', 'wrong_password');
        $wfirma->invoice->find();
    }
}
