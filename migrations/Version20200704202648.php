<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200704202648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, mode VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_address (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, address VARCHAR(50) NOT NULL, zip_code VARCHAR(10) NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, phone_number VARCHAR(20) NOT NULL, INDEX IDX_750D05F6C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, buyer_id INT NOT NULL, carrier_id INT DEFAULT NULL, total_quantity INT NOT NULL, total_amount DOUBLE PRECISION NOT NULL, tracking_number VARCHAR(20) NOT NULL, INDEX IDX_F52993988DE820D9 (seller_id), INDEX IDX_F52993986C755722 (buyer_id), UNIQUE INDEX UNIQ_F529939821DFC797 (carrier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, brand_id INT NOT NULL, order_product_id INT DEFAULT NULL, appellation VARCHAR(50) NOT NULL, area VARCHAR(30) NOT NULL, type VARCHAR(20) NOT NULL, cuvee_domaine VARCHAR(20) NOT NULL, capacity DOUBLE PRECISION NOT NULL, vintage VARCHAR(20) NOT NULL, color VARCHAR(20) NOT NULL, alcohol_volume DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, hs_code VARCHAR(20) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(50) DEFAULT NULL, status INT NOT NULL, INDEX IDX_D34A04AD8DE820D9 (seller_id), UNIQUE INDEX UNIQ_D34A04AD44F5D008 (brand_id), INDEX IDX_D34A04ADF65E9B0F (order_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, picture VARCHAR(50) DEFAULT NULL, selection_filter VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, selection_filter INT NOT NULL, INDEX IDX_CDFC73564584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(15) NOT NULL, company_name VARCHAR(40) DEFAULT NULL, firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(20) NOT NULL, address VARCHAR(100) NOT NULL, zip_code VARCHAR(10) NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(30) NOT NULL, phone_number VARCHAR(20) NOT NULL, siret_number VARCHAR(14) DEFAULT NULL, vat_number VARCHAR(13) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05F6C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939821DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES product_brand (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF65E9B0F FOREIGN KEY (order_product_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939821DFC797');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF65E9B0F');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44F5D008');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05F6C755722');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988DE820D9');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986C755722');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD8DE820D9');
        $this->addSql('DROP TABLE carrier');
        $this->addSql('DROP TABLE delivery_address');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_brand');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE user');
    }
}
