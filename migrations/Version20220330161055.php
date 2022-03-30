<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330161055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE t_assoc ADD margin DOUBLE PRECISION NOT NULL, DROP quantite, CHANGE vendeur vendeur ENUM(\'O\', \'N\', \'V\'), CHANGE id_detail id_detail INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE t_assoc ADD quantite INT DEFAULT 1 NOT NULL, DROP margin, CHANGE vendeur vendeur VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE id_detail id_detail INT DEFAULT NULL');
    }
}
