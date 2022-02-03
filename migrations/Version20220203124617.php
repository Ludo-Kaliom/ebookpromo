<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203124617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331C54C8C93 ON book (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331C54C8C93');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_CBE5A331C54C8C93 ON book');
        $this->addSql('ALTER TABLE book DROP type_id');
    }
}
