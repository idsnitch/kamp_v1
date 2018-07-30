<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180607153346 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE corporate ADD idemnify_first_name VARCHAR(255) DEFAULT NULL, ADD idemnify_last_name VARCHAR(255) DEFAULT NULL, ADD idemnify_at DATETIME DEFAULT NULL, CHANGE first_director_names first_director_names VARCHAR(255) DEFAULT NULL, CHANGE first_director_position first_director_position VARCHAR(255) DEFAULT NULL, CHANGE first_director_id_number first_director_id_number VARCHAR(255) DEFAULT NULL, CHANGE itax_pin itax_pin VARCHAR(255) DEFAULT NULL, CHANGE reg_number reg_number VARCHAR(255) DEFAULT NULL, CHANGE registration_date registration_date DATETIME DEFAULT NULL, CHANGE account_name account_name VARCHAR(255) DEFAULT NULL, CHANGE account_number account_number VARCHAR(255) DEFAULT NULL, CHANGE bank_branch bank_branch VARCHAR(255) DEFAULT NULL, CHANGE terms_of_service terms_of_service VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE corporate DROP idemnify_first_name, DROP idemnify_last_name, DROP idemnify_at, CHANGE first_director_names first_director_names VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE first_director_position first_director_position VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE first_director_id_number first_director_id_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE itax_pin itax_pin VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE reg_number reg_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE registration_date registration_date DATETIME NOT NULL, CHANGE account_name account_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE account_number account_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE bank_branch bank_branch VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE terms_of_service terms_of_service VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
