<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210426151814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prod (int_product_data_id INT AUTO_INCREMENT NOT NULL, str_product_name VARCHAR(50) NOT NULL, str_product_desc VARCHAR(255) NOT NULL, str_product_code VARCHAR(10) NOT NULL, stock INT NOT NULL, str_discontinued VARCHAR(10) DEFAULT NULL, dtm_discontinued DATETIME DEFAULT NULL, flt_cost_gbr DOUBLE PRECISION NOT NULL, stm_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(int_product_data_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE prod');
    }
}
