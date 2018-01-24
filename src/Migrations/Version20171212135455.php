<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171212135455 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE programmer_project (programmer_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_52F4AD82181DAE45 (programmer_id), INDEX IDX_52F4AD82166D1F9C (project_id), PRIMARY KEY(programmer_id, project_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE programmer_project ADD CONSTRAINT FK_52F4AD82181DAE45 FOREIGN KEY (programmer_id) REFERENCES programmer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programmer_project ADD CONSTRAINT FK_52F4AD82166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programmer ADD language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE programmer ADD CONSTRAINT FK_4136CCA982F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_4136CCA982F1BAF4 ON programmer (language_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE programmer DROP FOREIGN KEY FK_4136CCA982F1BAF4');
        $this->addSql('DROP TABLE programmer_project');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP INDEX IDX_4136CCA982F1BAF4 ON programmer');
        $this->addSql('ALTER TABLE programmer DROP language_id');
    }
}
