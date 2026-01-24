<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260124154219 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__mangas AS SELECT title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id, created_at, updated_at, serie_id, description, simul_released FROM mangas');
        $this->addSql('DROP TABLE mangas');
        $this->addSql('CREATE TABLE mangas (title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, manga_plus_id INTEGER NOT NULL, portrait_image_url VARCHAR(255) NOT NULL, landscape_image_url VARCHAR(255) DEFAULT NULL, view_count INTEGER NOT NULL, language VARCHAR(2) NOT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, serie_id INTEGER DEFAULT NULL, description CLOB DEFAULT NULL, simul_released BOOLEAN DEFAULT 0 NOT NULL, synched_at DATETIME DEFAULT NULL, CONSTRAINT FK_8271C42FD94388BD FOREIGN KEY (serie_id) REFERENCES series (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mangas (title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id, created_at, updated_at, serie_id, description, simul_released) SELECT title, author, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id, created_at, updated_at, serie_id, description, simul_released FROM __temp__mangas');
        $this->addSql('DROP TABLE __temp__mangas');
        $this->addSql('CREATE INDEX IDX_8271C42FD94388BD ON mangas (serie_id)');
        $this->addSql('ALTER TABLE series ADD COLUMN synched_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__mangas AS SELECT title, author, description, simul_released, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id, created_at, updated_at, serie_id FROM mangas');
        $this->addSql('DROP TABLE mangas');
        $this->addSql('CREATE TABLE mangas (title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, simul_released BOOLEAN DEFAULT 0 NOT NULL, manga_plus_id VARCHAR(255) NOT NULL, portrait_image_url VARCHAR(255) NOT NULL, landscape_image_url VARCHAR(255) DEFAULT NULL, view_count INTEGER NOT NULL, language VARCHAR(2) NOT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, serie_id INTEGER DEFAULT NULL, CONSTRAINT FK_8271C42FD94388BD FOREIGN KEY (serie_id) REFERENCES series (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mangas (title, author, description, simul_released, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id, created_at, updated_at, serie_id) SELECT title, author, description, simul_released, manga_plus_id, portrait_image_url, landscape_image_url, view_count, language, id, created_at, updated_at, serie_id FROM __temp__mangas');
        $this->addSql('DROP TABLE __temp__mangas');
        $this->addSql('CREATE INDEX IDX_8271C42FD94388BD ON mangas (serie_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__series AS SELECT title, image_url, last_updated_at, id, created_at, updated_at FROM series');
        $this->addSql('DROP TABLE series');
        $this->addSql('CREATE TABLE series (title VARCHAR(255) NOT NULL, image_url VARCHAR(255) DEFAULT NULL, last_updated_at DATE DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO series (title, image_url, last_updated_at, id, created_at, updated_at) SELECT title, image_url, last_updated_at, id, created_at, updated_at FROM __temp__series');
        $this->addSql('DROP TABLE __temp__series');
    }
}
