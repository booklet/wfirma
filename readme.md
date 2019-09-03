
# PHP wFirma
Module for constructing simple queries to the wFirma API. For PHP 7.0 and above.

## Use
With composer. Add repository in `composer.json` file:
```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/booklet/wfirma.git"
    },
  ],
  "require": {
    "booklet/wfirma": "dev-master",
  },
}
```
Usage:
```php
$wfirma = new \Booklet\WFirma($login, $password, $company_id); // $company_id is optional
```
(two letters 'o' in namespace, not three like in github account name)

### Queries

Get array of invoices:
```php
$invoices = $wfirma->invoices->find($parameters)->data(); // $parameters is optional
```

Get contractor:
```php
$contractor = $wfirma->contractors->get($id, $parameters)->data(); // $parameters is optional
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
$contractor = $wfirma->contractors->add($data, $parameters)->data(); // $parameters is optional
```

Edit invoice:
```php
$invoice = $wfirma->invoices->edit($id, $data, $parameters)->data(); // $parameters is optional
```

Delete invoice:
```php
$deleted_invoice = $wfirma->invoices->delete($id, $parameters)->data(); // $parameters is optional
```

For other custom module actions see the selected class (`src/booklet/wfirma/modules/`).

## General principle
```php
$response = $wfirma->{module_name}->{action}();
```

Response object functions:


```php
$response->data(); // simplify data from wfirma (see ResponseDataProcessor class)
$response->rawData(); // raw data from wfirma
$response->parameters(); // response parameters: limit, page, total
$response->requestResource();
$response->requestAction();
$response->requestParameters();
$response->requestFullQuery(); // full query send to wfirma
$response->requestData();
$response->requestCompanyId();
```

##  Available modules

See: `src/booklet/wfirma/modules/`.

## Sample parameters
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
        ['field' => 'InvoiceContent.name'],
        ['field' => 'InvoiceContent.count'],
        ['field' => 'InvoiceContent.price'],
        ['field' => 'Contractor.name'],
        ['field' => 'Contractor.nip'],
        ['field' => 'Contractor.email'],
    ],
    'order' => [
        ['desc' => 'date']
    ],
    'page' => 1,
    'limit' => 5,
];
```


## Run tests

In module directory run (if $PWD not working, set module path manually):

```
$ docker build -t php_70cli_with_composer .
$ docker run -v "$PWD"/:/var/www -ti php_70cli_with_composer /bin/bash
```

Inside docker container run:
```
$ cd var/www
$ composer install
$ ./test
```