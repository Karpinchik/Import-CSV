<?php
declare(strict_types=1);

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\DTO\AddDataToDb;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddDataToDbTest extends TestCase
{
    public function testAdd(): void
    {
        $stubEntityManagerInterface = $this->createMock(EntityManagerInterface::class);
        $stubValidatorInterface = $this->createMock(ValidatorInterface::class);
        $obj = new AddDataToDb($stubEntityManagerInterface, $stubValidatorInterface);
        $res = $obj->add((object)[]);
        $this->assertIsObject($res);
    }
}
