<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260127193454 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__series AS SELECT title, image_url, last_updated_at, id, created_at, updated_at, synched_at FROM series');
        $this->addSql('DROP TABLE series');
        $this->addSql('CREATE TABLE series (title VARCHAR(255) NOT NULL, image_url VARCHAR(255) DEFAULT NULL, last_updated_at DATETIME DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, synched_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO series (title, image_url, last_updated_at, id, created_at, updated_at, synched_at) SELECT title, image_url, last_updated_at, id, created_at, updated_at, synched_at FROM __temp__series');
        $this->addSql('DROP TABLE __temp__series');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__series AS SELECT title, image_url, last_updated_at, id, synched_at, created_at, updated_at FROM series');
        $this->addSql('DROP TABLE series');
        $this->addSql('CREATE TABLE series (title VARCHAR(255) NOT NULL, image_url VARCHAR(255) DEFAULT NULL, last_updated_at DATE DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, synched_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO series (title, image_url, last_updated_at, id, synched_at, created_at, updated_at) SELECT title, image_url, last_updated_at, id, synched_at, created_at, updated_at FROM __temp__series');
        $this->addSql('DROP TABLE __temp__series');
    }
}
