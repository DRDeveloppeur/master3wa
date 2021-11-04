<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104101414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket (id INT AUTO_INCREMENT NOT NULL, delivery_id_id INT DEFAULT NULL, user_id_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, ref_order VARCHAR(255) NOT NULL, is_payed TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_2246507B6F4F78C5 (delivery_id_id), INDEX IDX_2246507B9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B6F4F78C5 FOREIGN KEY (delivery_id_id) REFERENCES delivery (id)');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE basket');
    }
}
