<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\ImportData\ErrorResult;
use App\ImportData\ImportResult;
use App\ImportData\ParseData;
use PHPUnit\Framework\TestCase;
use App\Service\ImportCsv;

class ImportCsvTest extends TestCase
{
    public function testProcessImport(): void
    {
        $stubErrorResult = $this->createMock(ErrorResult::class);
        $stubImportResult = $this->createMock(ImportResult::class);
        $stubParseData = new ParseData($stubErrorResult);
        $stubParseData->importResult = $stubImportResult;
        $objImportCsv = $this->createMock(ImportCsv::class);
        $res = $objImportCsv->processImport("test.csv", true);
        $this->assertIsObject($res);
    }
}
