# PHP wFirma
Module for constructing simple queries to the wFirma API

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
Initialization (`$company_id` optional)
```php
$wfirma = new \Booklet\WFirma($login, $password, $company_id);
```
### Queries

Get array of invoices
```php
$invoices = $wfirma->invoices->find($parameters);
```

Get contractor
```php
$contractors = $wfirma->invoices->get($id);
```

The general principle of operation
```php
$response = $wfirma->{module_name}->{action}();
```

###  Available modules

See: `src/booklet/wfirma/modules/`

### Sample parameters
Detailed information about conditional queries: [https://doc.wfirma.pl/](https://doc.wfirma.pl/)
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
                        'value' => '2019-05-27',
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
