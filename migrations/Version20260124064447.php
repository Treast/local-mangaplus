<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260124064447 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE genres (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A8EBE516989D9B62 ON genres (slug)');
        $this->addSql('CREATE TABLE series (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, last_updated_at DATE NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__mangas AS SELECT id, title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language FROM mangas');
        $this->addSql('DROP TABLE mangas');
        $this->addSql('CREATE TABLE mangas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, manga_plus_id VARCHAR(255) NOT NULL, portrait_image_url VARCHAR(255) NOT NULL, landscape_image_url VARCHAR(255) NOT NULL, view_count INTEGER NOT NULL, language VARCHAR(2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, serie_id INTEGER DEFAULT NULL, CONSTRAINT FK_8271C42FD94388BD FOREIGN KEY (serie_id) REFERENCES series (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mangas (id, title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language) SELECT id, title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language FROM __temp__mangas');
        $this->addSql('DROP TABLE __temp__mangas');
        $this->addSql('CREATE INDEX IDX_8271C42FD94388BD ON mangas (serie_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE series');
        $this->addSql('CREATE TEMPORARY TABLE __temp__mangas AS SELECT title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id FROM mangas');
        $this->addSql('DROP TABLE mangas');
        $this->addSql('CREATE TABLE mangas (title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, manga_plus_id VARCHAR(255) NOT NULL, portrait_image_url VARCHAR(255) NOT NULL, landscape_image_url VARCHAR(255) NOT NULL, view_count INTEGER NOT NULL, language VARCHAR(2) NOT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO mangas (title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id) SELECT title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id FROM __temp__mangas');
        $this->addSql('DROP TABLE __temp__mangas');
    }
}
