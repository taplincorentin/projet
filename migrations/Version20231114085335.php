<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114085335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade ADD organisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE balade ADD CONSTRAINT FK_540083D7D936B2FA FOREIGN KEY (organisateur_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_540083D7D936B2FA ON balade (organisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade DROP FOREIGN KEY FK_540083D7D936B2FA');
        $this->addSql('DROP INDEX IDX_540083D7D936B2FA ON balade');
        $this->addSql('ALTER TABLE balade DROP organisateur_id');
    }
}
