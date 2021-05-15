<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\ImportData\ImportResult;
use PHPUnit\Framework\TestCase;
use App\Service\AddDataToDb;
use Doctrine\ORM\EntityManagerInterface;

class AddDataToDbTest extends TestCase
{
    public function testAdd(): void
    {
        $objFilterData = $this->createMock(ImportResult::class);
        $stubEntityManagerInterface = $this->createMock(EntityManagerInterface::class);
        $objAddDataToDb = new AddDataToDb($stubEntityManagerInterface);
        $result = $objAddDataToDb->add($objFilterData);
        $this->assertIsObject($result);
    }
}
