<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203104151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_like (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B5FE0BBB16A2B381 (book_id), INDEX IDX_B5FE0BBBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_like ADD CONSTRAINT FK_B5FE0BBB16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_like ADD CONSTRAINT FK_B5FE0BBBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book_like');
    }
}
