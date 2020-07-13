<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200709004222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recherche (id INT AUTO_INCREMENT NOT NULL, selection VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chambre ADD statut TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFAC13C4F3 FOREIGN KEY (num_batiment_id) REFERENCES batiment (id)');
        $this->addSql('DROP INDEX num_batiment_id ON chambre');
        $this->addSql('CREATE INDEX IDX_C509E4FFAC13C4F3 ON chambre (num_batiment_id)');
        $this->addSql('ALTER TABLE etudiant CHANGE type_etudiant type_etudiant VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE recherche');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FFAC13C4F3');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FFAC13C4F3');
        $this->addSql('ALTER TABLE chambre DROP statut');
        $this->addSql('DROP INDEX idx_c509e4ffac13c4f3 ON chambre');
        $this->addSql('CREATE INDEX num_batiment_id ON chambre (num_batiment_id)');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFAC13C4F3 FOREIGN KEY (num_batiment_id) REFERENCES batiment (id)');
        $this->addSql('ALTER TABLE etudiant CHANGE type_etudiant type_etudiant VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
