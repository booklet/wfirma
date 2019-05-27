<?php
namespace Booklet;

include 'secret.php';

class WFirmaTest extends \PHPUnit\Framework\TestCase
{
    public function testFnisAssoc()
    {
        $wfirma = new WFirma(WFIRMA_LOGIN, WFIRMA_PASSWORD, 112321);

        $parameters = [
            'page' => 1,
            'limit' => 5,
            'conditions' => [
                [
                  //  'or' => [
                  //      [
                  //          'condition' => [
                  //              'field' => 'type',
                  //              'operator' => 'eq',
                  //              'value' => 'proforma',
                  //          ]
                  //      ],
                  //      [
                  //          'condition' => [
                  //              'field' => 'type',
                  //              'operator' => 'eq',
                  //              'value' => 'correction',
                  //          ]
                  //      ]
                  //  ],
                    'and' => [
                        [
                            'condition' => [
                                'field' => 'type',
                                'operator' => 'eq',
                                'value' => 'proforma',
                            ]
                        ],
                        [
                            'condition' => [
                                'field' => 'disposaldate',
                                'operator' => 'gt',
                                'value' => '2019-05-00',
                            ]
                        ],
                        [
                            'condition' => [
                                'field' => 'disposaldate',
                                'operator' => 'lt',
                                'value' => '2019-05-27',
                            ]
                        ]
                    ]
                ]
            ]
        ];

  //      $invoices = $wfirma->invoice->find($parameters);

  //    die(print_r($invoices));

        $this->assertEquals([], []);
    }



    public function testGet()
    {
        $wfirma = new WFirma(WFIRMA_LOGIN, WFIRMA_PASSWORD, 112321);

      //  $invoice = $wfirma->invoice->get(63855820);

      //  die(print_r($invoice));

        $this->assertEquals([], []);
    }

    public function testAdd()
    {
        $wfirma = new WFirma(WFIRMA_LOGIN, WFIRMA_PASSWORD, 112321);
        $data = [
            'contractor' => [
                'name' => 'Pan testowy',
                'street' => 'Ulica testowa 23',
                'zip' => '63-300',
                'city' => 'Pleszew',
                'email' => 'pantestowy@booklet.pl',
            ]
        ];

      //  $new_contractor = $wfirma->contractor->add($data);

        //die(print_r($new_contractor));

        $this->assertEquals([], []);
    }



    public function testEdit()
    {
        $wfirma = new WFirma(WFIRMA_LOGIN, WFIRMA_PASSWORD, 112321);
        $data = [
            'contractor' => [
                'name' => 'NOWY Pan testowy',
            ]
        ];
        // test items
        // [id] => 26013520
        // [id] => 26013559
        // $new_contractor = $wfirma->contractor->edit(26013520, $data);

        // die(print_r($new_contractor));

        $this->assertEquals([], []);
    }




}
