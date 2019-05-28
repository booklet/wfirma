<?php
namespace Booklet\WFirma\Modules;

use Booklet\WFirma\Modules;

class Invoice extends Modules
{
    const MODULE_NAME_PLURAL = 'invoices';

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
