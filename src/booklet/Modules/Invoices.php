<?php

namespace Booklet\WFirma\Modules;

use Booklet\WFirma\Modules;

class Invoices extends Modules
{
    public function download(int $invoice_id, array $parameters = [])
    {
        // /invoices/download/ID_FAKTURY
    }

    public function send(int $invoice_id, array $parameters = [])
    {
        // /invoices/send/ID_FAKTURY
    }

    public function fiscalize()
    {
    }

    public function unfiscalize()
    {
    }
}
