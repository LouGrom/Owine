<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713132439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appellation (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_187A5B984584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appellation ADD CONSTRAINT FK_187A5B984584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE company ADD rate DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery_address ADD province VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD reference VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD rate DOUBLE PRECISION DEFAULT NULL, DROP appellation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appellation');
        $this->addSql('ALTER TABLE company DROP rate');
        $this->addSql('ALTER TABLE delivery_address DROP province');
        $this->addSql('ALTER TABLE `order` DROP reference');
        $this->addSql('ALTER TABLE product ADD appellation VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP rate');
    }
}
