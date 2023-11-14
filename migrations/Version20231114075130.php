<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114075130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, organisateur_id INT NOT NULL, nom VARCHAR(20) NOT NULL, date_heure_depart DATETIME NOT NULL, ville VARCHAR(50) NOT NULL, INDEX IDX_DF7DFD0ED936B2FA (organisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance_personne (seance_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_E3754997E3797A94 (seance_id), INDEX IDX_E3754997A21BD112 (personne_id), PRIMARY KEY(seance_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0ED936B2FA FOREIGN KEY (organisateur_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE seance_personne ADD CONSTRAINT FK_E3754997E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seance_personne ADD CONSTRAINT FK_E3754997A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0ED936B2FA');
        $this->addSql('ALTER TABLE seance_personne DROP FOREIGN KEY FK_E3754997E3797A94');
        $this->addSql('ALTER TABLE seance_personne DROP FOREIGN KEY FK_E3754997A21BD112');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE seance_personne');
    }
}
