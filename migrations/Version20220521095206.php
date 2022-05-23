<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521095206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('DROP INDEX IDX_B6BD307FF624B39D ON message');
        $this->addSql('ALTER TABLE message ADD adminname_id INT DEFAULT NULL, CHANGE sender_id username_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FED766068 FOREIGN KEY (username_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FD5EC4AAC FOREIGN KEY (adminname_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FED766068 ON message (username_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FD5EC4AAC ON message (adminname_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE title title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE content content LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE book CHANGE title title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE isbn isbn VARCHAR(13) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE description description LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE cover cover VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE link link VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE publisher publisher VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE authors authors VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE comment CHANGE content content LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FED766068');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FD5EC4AAC');
        $this->addSql('DROP INDEX IDX_B6BD307FED766068 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FD5EC4AAC ON message');
        $this->addSql('ALTER TABLE message ADD sender_id INT DEFAULT NULL, DROP username_id, DROP adminname_id');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FF624B39D ON message (sender_id)');
        $this->addSql('ALTER TABLE subcategory CHANGE name name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE type CHANGE name name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE username username VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE avatar avatar VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
