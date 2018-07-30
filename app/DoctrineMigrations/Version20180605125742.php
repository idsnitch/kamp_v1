<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180605125742 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile CHANGE physical_address physical_address VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE county county VARCHAR(255) DEFAULT NULL, CHANGE postal_address postal_address VARCHAR(255) DEFAULT NULL, CHANGE postal_code postal_code VARCHAR(255) DEFAULT NULL, CHANGE mobile_number mobile_number VARCHAR(255) DEFAULT NULL, CHANGE account_name account_name VARCHAR(255) DEFAULT NULL, CHANGE account_number account_number VARCHAR(255) DEFAULT NULL, CHANGE kin_first_name kin_first_name VARCHAR(255) DEFAULT NULL, CHANGE kin_middle_name kin_middle_name VARCHAR(255) DEFAULT NULL, CHANGE kin_last_name kin_last_name VARCHAR(255) DEFAULT NULL, CHANGE kin_relationship kin_relationship VARCHAR(255) DEFAULT NULL, CHANGE kin_id_number kin_id_number VARCHAR(255) DEFAULT NULL, CHANGE kin_date_of_birth kin_date_of_birth DATE DEFAULT NULL, CHANGE kin_gender kin_gender VARCHAR(255) DEFAULT NULL, CHANGE kin_physical_address kin_physical_address VARCHAR(255) DEFAULT NULL, CHANGE kin_city kin_city VARCHAR(255) DEFAULT NULL, CHANGE kin_county kin_county VARCHAR(255) DEFAULT NULL, CHANGE kin_postal_code kin_postal_code VARCHAR(255) DEFAULT NULL, CHANGE kin_mobile_number kin_mobile_number VARCHAR(255) DEFAULT NULL, CHANGE terms_of_service terms_of_service VARCHAR(255) DEFAULT NULL, CHANGE kin_postal_address kin_postal_address VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile CHANGE physical_address physical_address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE city city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE county county VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE postal_address postal_address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE postal_code postal_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE mobile_number mobile_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE account_name account_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE account_number account_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_first_name kin_first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_middle_name kin_middle_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_last_name kin_last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_relationship kin_relationship VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_id_number kin_id_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_date_of_birth kin_date_of_birth DATE NOT NULL, CHANGE kin_gender kin_gender VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_physical_address kin_physical_address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_city kin_city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_county kin_county VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_postal_address kin_postal_address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_postal_code kin_postal_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE kin_mobile_number kin_mobile_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE terms_of_service terms_of_service VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
