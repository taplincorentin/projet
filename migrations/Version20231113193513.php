<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231113193513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE balade_personne (balade_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_1BC368A7FE292D59 (balade_id), INDEX IDX_1BC368A7A21BD112 (personne_id), PRIMARY KEY(balade_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE balade_personne ADD CONSTRAINT FK_1BC368A7FE292D59 FOREIGN KEY (balade_id) REFERENCES balade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE balade_personne ADD CONSTRAINT FK_1BC368A7A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE balade CHANGE lieu ville VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balade_personne DROP FOREIGN KEY FK_1BC368A7FE292D59');
        $this->addSql('ALTER TABLE balade_personne DROP FOREIGN KEY FK_1BC368A7A21BD112');
        $this->addSql('DROP TABLE balade_personne');
        $this->addSql('ALTER TABLE balade CHANGE ville lieu VARCHAR(50) NOT NULL');
    }
}
