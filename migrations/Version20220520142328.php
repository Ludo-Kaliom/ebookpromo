<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220520142328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, username_id INT DEFAULT NULL, first_message_id INT DEFAULT NULL, message LONGTEXT NOT NULL, created_at DATE NOT NULL, INDEX IDX_DADD4A25ED766068 (username_id), INDEX IDX_DADD4A25C2E2722E (first_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25ED766068 FOREIGN KEY (username_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25C2E2722E FOREIGN KEY (first_message_id) REFERENCES message (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE answer');
        $this->addSql('ALTER TABLE article CHANGE title title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE content content LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE book CHANGE title title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE isbn isbn VARCHAR(13) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE description description LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE cover cover VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE link link VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE publisher publisher VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE authors authors VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE comment CHANGE content content LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE subcategory CHANGE name name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE type CHANGE name name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE username username VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE avatar avatar VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
