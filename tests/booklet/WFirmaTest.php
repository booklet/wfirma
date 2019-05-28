<?php
// ATTENTION
// Tests use a demo account in wFirma, it is possible that over time
// will stop working correctly because of changes in the demo account.

namespace Booklet;

class WFirmaTest extends \PHPUnit\Framework\TestCase
{
    public function testFind()
    {
        $this->markTestIncomplete('This test requires an external call, so we disabled it.');

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

        $invoices = $wfirma->invoices->find($parameters);

        $this->assertEquals(4, count($invoices[0]));
    }

    public function testGet()
    {
        $this->markTestIncomplete('This test requires an external call, so we disabled it.');

        $wfirma = new WFirma('demo', 'demo');
        $invoice = $wfirma->invoices->get(62407183);

        $this->assertEquals(62407183, $invoice['id']);
    }

    public function testGetRaw()
    {
        $this->markTestIncomplete('This test requires an external call, so we disabled it.');

        $wfirma = new WFirma('demo', 'demo');
        $invoice = $wfirma->invoices->get(62407183, ['raw_response' => true]);

        $this->assertEquals(62407183, $invoice['invoices'][0]['invoice']['id']);
    }

    public function testAdd()
    {
        $this->markTestIncomplete('This test requires an external call, so we disabled it.');

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

        $new_contractor = $wfirma->contractors->add($data);

        $this->assertEquals('Jan Testowy', $new_contractor['name']);
    }

    public function testEdit()
    {
        $this->markTestIncomplete('This test requires an external call, so we disabled it.');

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
        $new_contractor = $wfirma->contractors->add($data);
        $constractor_id = $new_contractor['id'];

        // Update contractor data
        $new_data = [
            'contractor' => [
                'name' => 'Jan Testowy',
            ],
        ];
        $updated_contractor = $wfirma->contractors->edit($constractor_id, $new_data);

        $this->assertEquals('Jan Testowy', $updated_contractor['name']);
    }

    public function testRequestException()
    {
        $this->markTestIncomplete('This test requires an external call, so we disabled it.');

        $this->expectException(\Booklet\WFirma\Exceptions\WFirmaException::class);

        $wfirma = new WFirma('demo', 'wrong_password');
        $wfirma->invoices->find();
    }
}
