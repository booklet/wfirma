<?php
namespace Booklet;

use Booklet\WFirma\Utils;

class UtilsTest extends \PHPUnit\Framework\TestCase
{
    public function testStringToCamelCase()
    {
        $this->assertEquals('CompanyAccounts', Utils::stringToCamelCase('company_accounts'));
        $this->assertEquals('ABCAaaBBBCcc', Utils::stringToCamelCase('_a_B_c_aaa_BBB_ccc'));
    }
}
