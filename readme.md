# PHP wFirma
Moduł do konstruowania prostych zapytań do API wFirma

## Użycie
W `composer.json` dodajemy repozytorium gita:
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
Inicjalizacja (`$company_id` opcjonalnie)
```php
$wfirma = new \Booklet\WFirma($login, $password, $company_id);
```
Zapytania
```php
$invoices = $wfirma->invoice->find($parameters);
$contractors = $wfirma->contractor->find($parameters);
$response = $wfirma->{moduł_w_liczbie_pojedynczej}->get($id);
```
Dostępne moduły: patrz `src/booklet/wfirma/modules/`

### Przykładowe parametry
Szczegółowe informacje odnośnie zapytań warunkowych: [https://doc.wfirma.pl/](https://doc.wfirma.pl/)
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
