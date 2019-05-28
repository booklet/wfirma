<?php
// Convert response data to simply array of items
// this:
// [
//     'invoices' => [
//         [0] => [
//              'invoice' => [
//                   'id' => '63963196',
//                   'date' => '2019-05-22',
//                   'type' => 'proforma'
//              ]
//         ],
//         [1] => [
//              'invoice' => [
//                   'id' => '63855820',
//                   'date' => '2019-05-21',
//                   'type' => 'proforma'
//              ]
//         ],
//         'parameters' => [
//             'limit' => 5,
//             'page' => 1,
//             'total' => 9
//         ]
//     ],
//     'status' => [
//         'code' => 'OK'
//     ]
// ];
// convert to:
// [
//     [
//         'id' => '63963196',
//         'date' => '2019-05-22',
//         'type' => 'proforma'
//     ],
//     [
//         'id' => '63855820',
//         'date' => '2019-05-21',
//         'type' => 'proforma'
//     ],
// ];

namespace Booklet\WFirma;

class ResponseDataProcessor
{
    private $response;
    private $action;
    private $resource;

    public function __construct(array $response, string $action = 'find')
    {
        $this->response = $response;
        $this->action = $action;
        $this->setResourceName();
    }

    public function simplify()
    {
        $this->removeParameters();

        $simplfy_data = [];
        foreach ($this->response[$this->resource] as $item) {
            $simplfy_data[] = $item[array_keys($item)[0]];
        }

        // Actions: get, add, edit and delete, return array of one item, so we return this one item
        if ($this->isOneItemResponseRequest()) {
            return $simplfy_data[0];
        }

        return $simplfy_data;
    }

    private function setResourceName()
    {
        $response_array_keys = array_keys($this->response); // ['resource' => [], 'status' => []]
        // In case if array keys order change
        $this->resource = array_diff($response_array_keys, ['status'])[0];
    }

    private function removeParameters()
    {
        unset($this->response[$this->resource]['parameters']);
    }

    private function isOneItemResponseRequest()
    {
        return
            Utils::stringAreStartsWith($this->action, 'get/') or
            Utils::stringAreStartsWith($this->action, 'add') or
            Utils::stringAreStartsWith($this->action, 'edit/') or
            Utils::stringAreStartsWith($this->action, 'delete/')
        ;
    }
}
