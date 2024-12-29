<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241225100534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL, rate_to_usd NUMERIC(15, 5) NOT NULL, date_update DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX agent_username_uindex ON agent');
        $this->addSql('ALTER TABLE agent CHANGE agent_id agent_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('CREATE INDEX IDX_268B9C9D3414710B ON agent (agent_id)');
        $this->addSql('ALTER TABLE trade CHANGE close_rate close_rate NUMERIC(15, 5) NOT NULL');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A4366A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7E1A4366A76ED395 ON trade (user_id)');
        $this->addSql('DROP INDEX user_username_uindex ON user');
        $this->addSql('ALTER TABLE user CHANGE agent_id agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6493414710B ON user (agent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE currency');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493414710B');
        $this->addSql('DROP INDEX IDX_8D93D6493414710B ON user');
        $this->addSql('ALTER TABLE user CHANGE agent_id agent_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX user_username_uindex ON user (username)');
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A4366A76ED395');
        $this->addSql('DROP INDEX IDX_7E1A4366A76ED395 ON trade');
        $this->addSql('ALTER TABLE trade CHANGE close_rate close_rate NUMERIC(15, 5) DEFAULT NULL');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D3414710B');
        $this->addSql('DROP INDEX IDX_268B9C9D3414710B ON agent');
        $this->addSql('ALTER TABLE agent CHANGE agent_id agent_id INT NOT NULL, CHANGE roles roles JSON DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX agent_username_uindex ON agent (username)');
    }
}
