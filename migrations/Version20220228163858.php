<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228163858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC60D47263');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC4384A887');
        $this->addSql('DROP INDEX idx_2784dcc60d47263 ON rent');
        $this->addSql('CREATE INDEX IDX_2784DCC9033212A ON rent (tenant_id)');
        $this->addSql('DROP INDEX idx_2784dcc4384a887 ON rent');
        $this->addSql('CREATE INDEX IDX_2784DCC8B225FBD ON rent (residence_id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC60D47263 FOREIGN KEY (tenant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC4384A887 FOREIGN KEY (residence_id) REFERENCES residence (id)');
        $this->addSql('ALTER TABLE residence DROP FOREIGN KEY FK_3275823C01675FE');
        $this->addSql('ALTER TABLE residence DROP FOREIGN KEY FK_32758238FDDAB70');
        $this->addSql('DROP INDEX idx_32758238fddab70 ON residence');
        $this->addSql('CREATE INDEX IDX_32758237E3C61F9 ON residence (owner_id)');
        $this->addSql('DROP INDEX idx_3275823c01675fe ON residence');
        $this->addSql('CREATE INDEX IDX_3275823FC3FF006 ON residence (representative_id)');
        $this->addSql('ALTER TABLE residence ADD CONSTRAINT FK_3275823C01675FE FOREIGN KEY (representative_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE residence ADD CONSTRAINT FK_32758238FDDAB70 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(55) NOT NULL, ADD firstname VARCHAR(55) NOT NULL, CHANGE role role LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE email email VARCHAR(180) NOT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC9033212A');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC8B225FBD');
        $this->addSql('DROP INDEX idx_2784dcc9033212a ON rent');
        $this->addSql('CREATE INDEX IDX_2784DCC60D47263 ON rent (tenant_id)');
        $this->addSql('DROP INDEX idx_2784dcc8b225fbd ON rent');
        $this->addSql('CREATE INDEX IDX_2784DCC4384A887 ON rent (residence_id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC9033212A FOREIGN KEY (tenant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC8B225FBD FOREIGN KEY (residence_id) REFERENCES residence (id)');
        $this->addSql('ALTER TABLE residence DROP FOREIGN KEY FK_32758237E3C61F9');
        $this->addSql('ALTER TABLE residence DROP FOREIGN KEY FK_3275823FC3FF006');
        $this->addSql('DROP INDEX idx_32758237e3c61f9 ON residence');
        $this->addSql('CREATE INDEX IDX_32758238FDDAB70 ON residence (owner_id)');
        $this->addSql('DROP INDEX idx_3275823fc3ff006 ON residence');
        $this->addSql('CREATE INDEX IDX_3275823C01675FE ON residence (representative_id)');
        $this->addSql('ALTER TABLE residence ADD CONSTRAINT FK_32758237E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE residence ADD CONSTRAINT FK_3275823FC3FF006 FOREIGN KEY (representative_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP name, DROP firstname, CHANGE email email VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE role role VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE is_verified is_verified TINYINT(1) DEFAULT NULL');
    }
}
