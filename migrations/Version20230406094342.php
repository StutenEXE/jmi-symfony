<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406094342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id_nom INT NOT NULL, id_contact INT NOT NULL, INDEX id_nom (id_nom)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id_nom INT AUTO_INCREMENT NOT NULL, nom VARCHAR(180) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, prenom VARCHAR(180) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, num VARCHAR(180) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, email VARCHAR(180) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(id_nom)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = \'\' ');
    }
}
