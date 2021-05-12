<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210512081449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Product (ProductDataId INT AUTO_INCREMENT NOT NULL, ProductName VARCHAR(50) NOT NULL, ProductDesc VARCHAR(255) NOT NULL, ProductCode VARCHAR(10) NOT NULL, Added DATETIME DEFAULT NULL, Discontinued DATETIME DEFAULT NULL, TimestampDate DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, stock INT NOT NULL, cost DOUBLE PRECISION NOT NULL, UNIQUE INDEX ProductData_ProductCode_uindex (ProductCode), PRIMARY KEY(ProductDataId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Product');
    }
}
