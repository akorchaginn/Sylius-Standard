<?php


namespace Sylius\Migrations;


use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version201904142034 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE sylius_product ADD id_1c VARCHAR(255)');
        $this->addSql('ALTER TABLE sylius_product_variant ADD id_1c VARCHAR(255)');
        $this->addSql('ALTER TABLE sylius_customer ADD id_1c VARCHAR(255)');
        $this->addSql('ALTER TABLE sylius_order ADD id_1c VARCHAR(255)');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE sylius_product DROP id_1c');
        $this->addSql('ALTER TABLE sylius_product_variant DROP id_1c');
        $this->addSql('ALTER TABLE sylius_customer DROP id_1c');
        $this->addSql('ALTER TABLE sylius_order DROP id_1c');
    }

}