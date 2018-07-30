<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180607102410 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE music ADD recording_file2_id VARCHAR(255) DEFAULT NULL, ADD recording_file3_id VARCHAR(255) DEFAULT NULL, ADD recording_file4_id VARCHAR(255) DEFAULT NULL, ADD recording_file5_id VARCHAR(255) DEFAULT NULL, ADD recording_file6_id VARCHAR(255) DEFAULT NULL, ADD recording_file7_id VARCHAR(255) DEFAULT NULL, ADD recording_file8_id VARCHAR(255) DEFAULT NULL, ADD recording_file9_id VARCHAR(255) DEFAULT NULL, ADD recording_file10_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A237D3238 FOREIGN KEY (recording_file2_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A9BC1555D FOREIGN KEY (recording_file3_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A6166DE4 FOREIGN KEY (recording_file4_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224ABEAA0A81 FOREIGN KEY (recording_file5_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224AAC1FA56F FOREIGN KEY (recording_file6_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A14A3C20A FOREIGN KEY (recording_file7_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A4CC0D25C FOREIGN KEY (recording_file8_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224AF47CB539 FOREIGN KEY (recording_file9_id) REFERENCES recording_file (id)');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224A151F58A FOREIGN KEY (recording_file10_id) REFERENCES recording_file (id)');
        $this->addSql('CREATE INDEX IDX_CD52224A237D3238 ON music (recording_file2_id)');
        $this->addSql('CREATE INDEX IDX_CD52224A9BC1555D ON music (recording_file3_id)');
        $this->addSql('CREATE INDEX IDX_CD52224A6166DE4 ON music (recording_file4_id)');
        $this->addSql('CREATE INDEX IDX_CD52224ABEAA0A81 ON music (recording_file5_id)');
        $this->addSql('CREATE INDEX IDX_CD52224AAC1FA56F ON music (recording_file6_id)');
        $this->addSql('CREATE INDEX IDX_CD52224A14A3C20A ON music (recording_file7_id)');
        $this->addSql('CREATE INDEX IDX_CD52224A4CC0D25C ON music (recording_file8_id)');
        $this->addSql('CREATE INDEX IDX_CD52224AF47CB539 ON music (recording_file9_id)');
        $this->addSql('CREATE INDEX IDX_CD52224A151F58A ON music (recording_file10_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A237D3238');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A9BC1555D');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A6166DE4');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224ABEAA0A81');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224AAC1FA56F');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A14A3C20A');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A4CC0D25C');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224AF47CB539');
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224A151F58A');
        $this->addSql('DROP INDEX IDX_CD52224A237D3238 ON music');
        $this->addSql('DROP INDEX IDX_CD52224A9BC1555D ON music');
        $this->addSql('DROP INDEX IDX_CD52224A6166DE4 ON music');
        $this->addSql('DROP INDEX IDX_CD52224ABEAA0A81 ON music');
        $this->addSql('DROP INDEX IDX_CD52224AAC1FA56F ON music');
        $this->addSql('DROP INDEX IDX_CD52224A14A3C20A ON music');
        $this->addSql('DROP INDEX IDX_CD52224A4CC0D25C ON music');
        $this->addSql('DROP INDEX IDX_CD52224AF47CB539 ON music');
        $this->addSql('DROP INDEX IDX_CD52224A151F58A ON music');
        $this->addSql('ALTER TABLE music DROP recording_file2_id, DROP recording_file3_id, DROP recording_file4_id, DROP recording_file5_id, DROP recording_file6_id, DROP recording_file7_id, DROP recording_file8_id, DROP recording_file9_id, DROP recording_file10_id');
    }
}
