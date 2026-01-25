<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260125181951 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__chapters AS SELECT title, sub_title, manga_plus_id, cbz_path, download_status, released_at, readable_until, id, created_at, updated_at, manga_id FROM chapters');
        $this->addSql('DROP TABLE chapters');
        $this->addSql('CREATE TABLE chapters (title VARCHAR(255) NOT NULL, sub_title VARCHAR(255) NOT NULL, manga_plus_id INTEGER NOT NULL, cbz_path VARCHAR(255) DEFAULT NULL, download_status VARCHAR(18) DEFAULT \'not_downloaded\' NOT NULL, released_at DATETIME DEFAULT NULL, readable_until DATETIME DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, manga_id INTEGER DEFAULT NULL, downloaded_at DATETIME DEFAULT NULL, CONSTRAINT FK_C72143717B6461 FOREIGN KEY (manga_id) REFERENCES mangas (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO chapters (title, sub_title, manga_plus_id, cbz_path, download_status, released_at, readable_until, id, created_at, updated_at, manga_id) SELECT title, sub_title, manga_plus_id, cbz_path, download_status, released_at, readable_until, id, created_at, updated_at, manga_id FROM __temp__chapters');
        $this->addSql('DROP TABLE __temp__chapters');
        $this->addSql('CREATE INDEX IDX_C72143717B6461 ON chapters (manga_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__chapters AS SELECT title, sub_title, manga_plus_id, cbz_path, download_status, released_at, readable_until, id, created_at, updated_at, manga_id FROM chapters');
        $this->addSql('DROP TABLE chapters');
        $this->addSql('CREATE TABLE chapters (title VARCHAR(255) NOT NULL, sub_title VARCHAR(255) NOT NULL, manga_plus_id INTEGER NOT NULL, cbz_path VARCHAR(255) DEFAULT NULL, download_status VARCHAR(14) DEFAULT \'not_downloaded\' NOT NULL, released_at DATE DEFAULT NULL, readable_until DATE DEFAULT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, manga_id INTEGER DEFAULT NULL, CONSTRAINT FK_C72143717B6461 FOREIGN KEY (manga_id) REFERENCES mangas (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO chapters (title, sub_title, manga_plus_id, cbz_path, download_status, released_at, readable_until, id, created_at, updated_at, manga_id) SELECT title, sub_title, manga_plus_id, cbz_path, download_status, released_at, readable_until, id, created_at, updated_at, manga_id FROM __temp__chapters');
        $this->addSql('DROP TABLE __temp__chapters');
        $this->addSql('CREATE INDEX IDX_C72143717B6461 ON chapters (manga_id)');
    }
}
