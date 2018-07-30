<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180416115340 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE corporate ADD kin_first_name VARCHAR(255) DEFAULT NULL, ADD kin_middle_name VARCHAR(255) DEFAULT NULL, ADD kin_last_name VARCHAR(255) DEFAULT NULL, ADD kin_relationship VARCHAR(255) DEFAULT NULL, ADD kin_id_number VARCHAR(255) DEFAULT NULL, ADD kin_date_of_birth DATE DEFAULT NULL, ADD kin_gender VARCHAR(255) DEFAULT NULL, ADD kin_physical_address VARCHAR(255) DEFAULT NULL, ADD kin_city VARCHAR(255) DEFAULT NULL, ADD kin_county VARCHAR(255) DEFAULT NULL, ADD kin_postal_address VARCHAR(255) DEFAULT NULL, ADD kin_postal_code VARCHAR(255) DEFAULT NULL, ADD kin_telephone_number VARCHAR(255) DEFAULT NULL, ADD kin_mobile_number VARCHAR(255) DEFAULT NULL, ADD kin_email_address VARCHAR(255) DEFAULT NULL, ADD is_kin_minor TINYINT(1) NOT NULL, ADD kin_guardian VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD other_kin_first_name VARCHAR(255) DEFAULT NULL, ADD other_kin_middle_name VARCHAR(255) DEFAULT NULL, ADD other_kin_last_name VARCHAR(255) DEFAULT NULL, ADD other_kin_relationship VARCHAR(255) DEFAULT NULL, ADD other_kin_id_number VARCHAR(255) DEFAULT NULL, ADD other_kin_date_of_birth DATE DEFAULT NULL, ADD other_kin_gender VARCHAR(255) DEFAULT NULL, ADD other_kin_physical_address VARCHAR(255) DEFAULT NULL, ADD other_kin_city VARCHAR(255) DEFAULT NULL, ADD other_kin_county VARCHAR(255) DEFAULT NULL, ADD other_kin_postal_address VARCHAR(255) DEFAULT NULL, ADD other_kin_postal_code VARCHAR(255) DEFAULT NULL, ADD other_kin_telephone_number VARCHAR(255) DEFAULT NULL, ADD other_kin_mobile_number VARCHAR(255) DEFAULT NULL, ADD other_kin_email_address VARCHAR(255) DEFAULT NULL, ADD is_other_kin_minor TINYINT(1) NOT NULL, ADD other_kin_guardian VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE corporate DROP kin_first_name, DROP kin_middle_name, DROP kin_last_name, DROP kin_relationship, DROP kin_id_number, DROP kin_date_of_birth, DROP kin_gender, DROP kin_physical_address, DROP kin_city, DROP kin_county, DROP kin_postal_address, DROP kin_postal_code, DROP kin_telephone_number, DROP kin_mobile_number, DROP kin_email_address, DROP is_kin_minor, DROP kin_guardian');
        $this->addSql('ALTER TABLE profile DROP other_kin_first_name, DROP other_kin_middle_name, DROP other_kin_last_name, DROP other_kin_relationship, DROP other_kin_id_number, DROP other_kin_date_of_birth, DROP other_kin_gender, DROP other_kin_physical_address, DROP other_kin_city, DROP other_kin_county, DROP other_kin_postal_address, DROP other_kin_postal_code, DROP other_kin_telephone_number, DROP other_kin_mobile_number, DROP other_kin_email_address, DROP is_other_kin_minor, DROP other_kin_guardian');
    }
}
