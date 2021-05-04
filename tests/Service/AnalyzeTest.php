<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\Analyze;
use App\Service\ImportResult;
use PHPUnit\Framework\TestCase;

class AnalyzeTest extends TestCase
{
    public function testCheckCostAndStock() :void
    {
        $objAnalyze = new Analyze();

        $objAnalyze->importResult = new ImportResult();
        $some = $objAnalyze->checkCostAndStock((array()));
        $this->assertIsObject($some);
    }
}
