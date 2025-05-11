<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510163721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE estimates ADD user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estimates ADD CONSTRAINT FK_85B8B0EEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_85B8B0EEA76ED395 ON estimates (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE created_at created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estimates DROP FOREIGN KEY FK_85B8B0EEA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_85B8B0EEA76ED395 ON estimates
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estimates DROP user_id
        SQL);
    }
}
