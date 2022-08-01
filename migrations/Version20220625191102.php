<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625191102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD COLUMN user VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE admin ADD COLUMN passwords VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__admin AS SELECT id, username, password FROM admin');
        $this->addSql('DROP TABLE admin');
        $this->addSql('CREATE TABLE admin (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO admin (id, username, password) SELECT id, username, password FROM __temp__admin');
        $this->addSql('DROP TABLE __temp__admin');
    }
}
