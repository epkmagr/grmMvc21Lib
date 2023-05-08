<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428114820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INTEGER NOT NULL)');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE services (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(100) NOT NULL COLLATE "BINARY", image VARCHAR(100) DEFAULT NULL COLLATE "BINARY", price INTEGER NOT NULL, description CLOB NOT NULL COLLATE "BINARY", filter VARCHAR(80) DEFAULT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL COLLATE "BINARY", acronym VARCHAR(8) NOT NULL COLLATE "BINARY", name VARCHAR(255) NOT NULL COLLATE "BINARY", password VARCHAR(255) NOT NULL COLLATE "BINARY", is_admin BOOLEAN NOT NULL)');
        $this->addSql('DROP TABLE product');
    }
}
