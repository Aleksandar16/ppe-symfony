<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228182508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rent (id INT AUTO_INCREMENT NOT NULL, tenant_id_id INT NOT NULL, residence_id_id INT NOT NULL, inventory_file VARCHAR(255) NOT NULL, arrival_date DATETIME NOT NULL, departure_date DATETIME NOT NULL, tenant_comments LONGTEXT NOT NULL, tenant_signature VARCHAR(255) NOT NULL, tenant_validated_at VARCHAR(45) NOT NULL, representative_comments LONGTEXT NOT NULL, representative_signature VARCHAR(255) NOT NULL, representative_validated_at DATETIME NOT NULL, INDEX IDX_2784DCC60D47263 (tenant_id_id), INDEX IDX_2784DCC4384A887 (residence_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE residence (id INT AUTO_INCREMENT NOT NULL, owner_id_id INT NOT NULL, representative_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(45) NOT NULL, country VARCHAR(255) NOT NULL, inventory_file VARCHAR(255) NOT NULL, INDEX IDX_32758238FDDAB70 (owner_id_id), INDEX IDX_3275823C01675FE (representative_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) DEFAULT NULL, email VARCHAR(45) NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC60D47263 FOREIGN KEY (tenant_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC4384A887 FOREIGN KEY (residence_id_id) REFERENCES residence (id)');
        $this->addSql('ALTER TABLE residence ADD CONSTRAINT FK_32758238FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE residence ADD CONSTRAINT FK_3275823C01675FE FOREIGN KEY (representative_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC4384A887');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC60D47263');
        $this->addSql('ALTER TABLE residence DROP FOREIGN KEY FK_32758238FDDAB70');
        $this->addSql('ALTER TABLE residence DROP FOREIGN KEY FK_3275823C01675FE');
        $this->addSql('DROP TABLE rent');
        $this->addSql('DROP TABLE residence');
        $this->addSql('DROP TABLE user');
    }
}
