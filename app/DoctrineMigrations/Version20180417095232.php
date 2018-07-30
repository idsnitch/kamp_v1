<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180417095232 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE document_file (id VARCHAR(255) NOT NULL, document_file_name VARCHAR(255) DEFAULT NULL, document_file_size VARCHAR(255) DEFAULT NULL, document_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music (id VARCHAR(255) NOT NULL, document_file_id VARCHAR(255) DEFAULT NULL, recording_file_id VARCHAR(255) DEFAULT NULL, which_profile_id VARCHAR(255) DEFAULT NULL, which_corporate_profile_id VARCHAR(255) DEFAULT NULL, album_title VARCHAR(255) NOT NULL, date_ofproduction DATE NOT NULL, country_of_production VARCHAR(255) NOT NULL, format VARCHAR(255) NOT NULL, main_artist VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CD52224A37A4DFB0 (document_file_id), INDEX IDX_CD52224A1C9D420E (recording_file_id), INDEX IDX_CD52224A3849067E (which_profile_id), INDEX IDX_CD52224A458F08FC (which_corporate_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recording_file (id VARCHAR(255) NOT NULL, document_file_name VARCHAR(255) DEFAULT NULL, document_file_size VARCHAR(255) DEFAULT NULL, document_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A37A4DFB0 FOREIGN KEY (document_file_id) REFERENCES document_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A1C9D420E FOREIGN KEY (recording_file_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A3849067E FOREIGN KEY (which_profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A458F08FC FOREIGN KEY (which_corporate_profile_id) REFERENCES corporate (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A37A4DFB0');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A1C9D420E');
        $this->addSql('DROP TABLE document_file');
        $this->addSql('DROP TABLE music');
        $this->addSql('DROP TABLE recording_file');
    }
}
