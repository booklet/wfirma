# PHP wFirma
Module for constructing simple queries to the wFirma API. For PHP 7.0 and above.

## Use
Add repository in `composer.json` file:
```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/boooklet/wfirma.git"
    },
  ],
  "require": {
    "boooklet/wfirma": "dev-master",
  },
}
```
Usage:
```php
$wfirma = new \Booklet\WFirma($login, $password, $company_id); // $company_id is optional
```
### Queries

Get array of invoices:
```php
$invoices = $wfirma->invoices->find($parameters); // $parameters is optional
```

Get contractor:
```php
$contractor = $wfirma->contractors->get($id, $parameters); // $parameters is optional
```

Create contractor:
```php
$data = [
    'contractor' => [
        'name' => 'Jan Testowy',
        'street' => 'Testowa 69',
        'zip' => '66-666',
        'city' => 'Miastowo',
        'email' => 'jan@testowy.pl',
    ],
];
$contractor = $wfirma->contractors->add($data, $parameters); // $parameters is optional
```

Edit invoice:
```php
$invoice = $wfirma->invoices->edit($id, $data, $parameters); // $parameters is optional
```

Delete invoice:
```php
$deleted_invoice = $wfirma->invoices->delete($id, $parameters); // $parameters is optional
```

For other custom module actions see the selected class (`src/booklet/wfirma/modules/`).\
The general principle of operation:
```php
$response = $wfirma->{module_name}->{action}();
```

### Simplify data

We simplify data structure returned from wfirma (see `ResponseDataProcessor` class).

If you want return raw response from api, add parameter:
```php
$invoices = $wfirma->invoices->find(['raw_response' => true]);
```

###  Available modules

See: `src/booklet/wfirma/modules/`.

### Sample parameters
Detailed information about conditional queries: [https://doc.wfirma.pl/](https://doc.wfirma.pl/).
```php
$parameters = [
    'conditions' => [
        [
            'or' => [
                [
                    'condition' => [
                        'field' => 'type',
                        'operator' => 'eq',
                        'value' => 'proforma',
                    ]
                ],
                [
                    'condition' => [
                        'field' => 'type',
                        'operator' => 'eq',
                        'value' => 'correction',
                    ]
                ]
            ],
            'and' => [
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
                        'value' => '2019-05-31',
                    ]
                ]
            ]
        ]
    ],
    'fields' => [
        ['field' => 'Invoice.id'],
        ['field' => 'Invoice.date'],
        ['field' => 'Invoice.type'],
        ['field' => 'Invoice.fullnumber'],
    ],
    'order' => [
        ['desc' => 'date']
    ],
    'page' => 1,
    'limit' => 5,
];
```
