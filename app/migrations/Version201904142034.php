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
        $this->addSql('ALTER TABLE sylius_order_item ADD product_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_order_item ADD variant_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product_review ALTER title DROP NOT NULL');
        $this->addSql('CREATE INDEX IDX_16C8119EE551C011 ON sylius_channel (hostname)');
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
        $this->addSql('DROP INDEX IDX_16C8119EE551C011');
        $this->addSql('ALTER TABLE sylius_product_review ALTER title SET NOT NULL');
        $this->addSql('ALTER TABLE sylius_order_item DROP product_name');
        $this->addSql('ALTER TABLE sylius_order_item DROP variant_name');
    }

}