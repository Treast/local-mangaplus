<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260123202425 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE mangas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, manga_plus_id VARCHAR(255) NOT NULL, portrait_image_url VARCHAR(255) NOT NULL, landscape_image_url VARCHAR(255) NOT NULL, view_count INTEGER NOT NULL, language VARCHAR(2) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE mangas');
    }
}
