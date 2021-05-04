<?php
declare(strict_types=1);

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ReadCsv;

class ReadCsvTest extends TestCase
{
    public function testDeserializeFile() :void
    {
        $readObject = new ReadCsv();
        $res = $readObject->deserializeFile('stock.csv');
        $this->assertIsArray($res);
    }
}
