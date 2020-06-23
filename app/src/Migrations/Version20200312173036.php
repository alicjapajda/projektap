<?php
/**
 * Migration20200312173036 class.
 */
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312173036 extends AbstractMigration
{
    /**
     * Getter Description.
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * Up action.
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event ADD cate_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA77D3008E5 FOREIGN KEY (cate_id) REFERENCES cate (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA77D3008E5 ON event (cate_id)');
    }

    /**
     * Down action.
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA77D3008E5');
        $this->addSql('DROP INDEX IDX_3BAE0AA77D3008E5 ON event');
        $this->addSql('ALTER TABLE event DROP cate_id');
    }
}
