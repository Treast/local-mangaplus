<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260124072954 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE series_genres (serie_id INTEGER NOT NULL, genre_id INTEGER NOT NULL, PRIMARY KEY (serie_id, genre_id), CONSTRAINT FK_CB98062BD94388BD FOREIGN KEY (serie_id) REFERENCES series (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CB98062B4296D31F FOREIGN KEY (genre_id) REFERENCES genres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CB98062BD94388BD ON series_genres (serie_id)');
        $this->addSql('CREATE INDEX IDX_CB98062B4296D31F ON series_genres (genre_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE series_genres');
    }
}
