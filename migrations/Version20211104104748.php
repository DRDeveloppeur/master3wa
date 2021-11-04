<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104104748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, mark_id_id INT NOT NULL, sub_categorie_id_id INT NOT NULL, categorie_id_id INT NOT NULL, ref INT NOT NULL, model VARCHAR(255) NOT NULL, tag VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, ray VARCHAR(255) NOT NULL, INDEX IDX_D34A04ADAFF12FCB (mark_id_id), INDEX IDX_D34A04AD908703A8 (sub_categorie_id_id), INDEX IDX_D34A04AD8A3C7387 (categorie_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADAFF12FCB FOREIGN KEY (mark_id_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD908703A8 FOREIGN KEY (sub_categorie_id_id) REFERENCES sub_categorie (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
    }
}
