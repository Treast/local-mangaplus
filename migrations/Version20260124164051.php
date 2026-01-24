<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260124164051 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE chapters (title VARCHAR(255) NOT NULL, sub_title VARCHAR(255) NOT NULL, manga_plus_id INTEGER NOT NULL, download_url VARCHAR(255) DEFAULT NULL, released_at DATE DEFAULT NULL, readable_until DATE DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, manga_id INTEGER DEFAULT NULL, CONSTRAINT FK_C72143717B6461 FOREIGN KEY (manga_id) REFERENCES mangas (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C72143717B6461 ON chapters (manga_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE chapters');
    }
}
