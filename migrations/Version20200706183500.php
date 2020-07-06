<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200706183500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP INDEX UNIQ_F529939821DFC797, ADD INDEX IDX_F529939821DFC797 (carrier_id)');
        $this->addSql('ALTER TABLE `order` CHANGE carrier_id carrier_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP INDEX IDX_F529939821DFC797, ADD UNIQUE INDEX UNIQ_F529939821DFC797 (carrier_id)');
        $this->addSql('ALTER TABLE `order` CHANGE carrier_id carrier_id INT DEFAULT NULL');
    }
}
