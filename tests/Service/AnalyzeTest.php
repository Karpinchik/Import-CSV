<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\Analyze;
use App\ImportData\AllItemsAfterRead;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnalyzeTest extends TestCase
{
    public function testCheckCostAndStock() :void
    {
        $stubGetReadData = $this->createMock(AllItemsAfterRead::class);
        $stubObjAnalyze = $this->createMock(ValidatorInterface::class);
        $objAnalyze = new Analyze($stubObjAnalyze);
        $some = $objAnalyze->checkCostAndStock($stubGetReadData);
        $this->assertIsObject($some);
    }
}
