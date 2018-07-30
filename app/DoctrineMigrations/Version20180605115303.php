<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180605115303 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE corporate ADD progress VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profile ADD progress VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD profile_id VARCHAR(255) DEFAULT NULL, ADD corporate_profile_id VARCHAR(255) DEFAULT NULL, ADD user_type VARCHAR(255) NOT NULL, ADD phone_number VARCHAR(255) DEFAULT NULL, ADD is_terms_accepted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64994AAAE9 FOREIGN KEY (corporate_profile_id) REFERENCES corporate (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON user (profile_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64994AAAE9 ON user (corporate_profile_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE corporate DROP progress');
        $this->addSql('ALTER TABLE profile DROP progress');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64994AAAE9');
        $this->addSql('DROP INDEX UNIQ_8D93D649CCFA12B8 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D64994AAAE9 ON user');
        $this->addSql('ALTER TABLE user DROP profile_id, DROP corporate_profile_id, DROP user_type, DROP phone_number, DROP is_terms_accepted');
    }
}
