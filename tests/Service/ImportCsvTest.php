<?php
declare(strict_types=1);

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ImportCsv;
use App\Service\Analyze;
use App\Service\ReadCsv;
use App\Service\CheckCsv;
use App\Service\AddDataToDb;

class ImportCsvTest extends TestCase
{
    public function testProcessImport(): void
    {
        $stubCheckCsv = $this->createMock(CheckCsv::class);
        $stubCheckCsv->method('checkFormat')
                     ->willReturn(true);
        $stubReadCSv = $this->createMock(ReadCsv::class);
        $stubReadCSv->method('deserializeFile')
                    ->willReturn(['count' => 4]);
        $stubAnalyze = $this->createMock(Analyze::class);
        $stubAnalyze->method('checkCostAndStock')
                    ->willReturn((object)[]);
        $stubAddDataToDb = $this->createMock(AddDataToDb::class);
        $stubAddDataToDb->method('add')
                        ->willReturn((object)[]);
        $obj = new ImportCsv($stubCheckCsv, $stubReadCSv, $stubAnalyze, $stubAddDataToDb);
        $res = $obj->processImport('stock.csv', true);
        $obj->objFilterData = $res;
        $this->assertIsObject($res);
    }
}
