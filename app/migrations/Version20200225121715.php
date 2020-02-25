<?php declare(strict_types=1);

namespace Sylius\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225121715 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE TABLE sylius_1с_request (id INT NOT NULL, last_synchronize_input TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_synchronize_output TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, response_orders TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE SEQUENCE sylius_1с_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP TABLE sylius_1с_request');
        $this->addSql('DROP SEQUENCE sylius_1с_request_id_seq CASCADE');

    }
}
