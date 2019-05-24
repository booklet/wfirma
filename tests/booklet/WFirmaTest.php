<?php
namespace Booklet;

class WFirmaTest extends \PHPUnit\Framework\TestCase
{
    public function testFnisAssoc()
    {
        $wfirma = new WFirma('login', 'password');



        $this->assertEquals(123, $wfirma->invoice);
    }
}
