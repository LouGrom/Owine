<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713162000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appellation DROP FOREIGN KEY FK_187A5B984584665A');
        $this->addSql('DROP INDEX UNIQ_187A5B984584665A ON appellation');
        $this->addSql('ALTER TABLE appellation DROP product_id, CHANGE name name VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE product ADD appellation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7CDE30DD FOREIGN KEY (appellation_id) REFERENCES appellation (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7CDE30DD ON product (appellation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appellation ADD product_id INT NOT NULL, CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE appellation ADD CONSTRAINT FK_187A5B984584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_187A5B984584665A ON appellation (product_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7CDE30DD');
        $this->addSql('DROP INDEX IDX_D34A04AD7CDE30DD ON product');
        $this->addSql('ALTER TABLE product DROP appellation_id');
    }
}
