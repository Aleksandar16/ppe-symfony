<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230171729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent CHANGE tenant_id_id tenant_id_id INT DEFAULT NULL, CHANGE residence_id_id residence_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE residence CHANGE owner_id_id owner_id_id INT DEFAULT NULL, CHANGE representative_id_id representative_id_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent CHANGE tenant_id_id tenant_id_id INT NOT NULL, CHANGE residence_id_id residence_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE residence CHANGE owner_id_id owner_id_id INT NOT NULL, CHANGE representative_id_id representative_id_id INT NOT NULL');
    }
}
