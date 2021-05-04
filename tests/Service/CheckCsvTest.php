<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\CheckCsv;
use PHPUnit\Framework\TestCase;

class CheckCsvTest extends TestCase
{
    public function testCheckFormat() :void
    {
        $check = new CheckCsv();
        $res = $check->checkFormat('test.csv');
        $this->assertTrue($res);
    }
}
