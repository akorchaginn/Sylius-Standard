<?php declare(strict_types=1);

namespace Sylius\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190908090954 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE sylius_address ADD fias_code VARCHAR(255) DEFAULT NULL');
        $this->addSql("UPDATE sylius_address SET province_code = 'd13945a8-7017-46ab-b1e6-ede1e89317ad' where province_code = 'RU-AK'");
        $this->addSql("UPDATE sylius_address SET province_code = 'RU' where province_code = 'RU-AL'");
        $this->addSql("UPDATE sylius_zone_member SET code = 'd13945a8-7017-46ab-b1e6-ede1e89317ad' where code = 'RU-AK'");
        $this->addSql("UPDATE sylius_zone_member SET code = 'RU' where code = 'RU-AL'");
        $this->addSql("UPDATE sylius_province SET code = 'd13945a8-7017-46ab-b1e6-ede1e89317ad' where code = 'RU-AK'");
        $this->addSql("UPDATE sylius_province SET code = 'RU' where code = 'RU-AL'");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE sylius_address DROP fias_code');
        $this->addSql("UPDATE sylius_address SET province_code = 'RU-AK' where province_code = 'd13945a8-7017-46ab-b1e6-ede1e89317ad'");
        $this->addSql("UPDATE sylius_address SET province_code = 'RU-AL' where province_code = 'RU'");
        $this->addSql("UPDATE sylius_zone_member SET code = 'RU-AK' where code = 'd13945a8-7017-46ab-b1e6-ede1e89317ad'");
        $this->addSql("UPDATE sylius_zone_member SET code = 'RU-AL' where code = 'RU'");
        $this->addSql("UPDATE sylius_province SET code = 'RU-AK' where code = 'd13945a8-7017-46ab-b1e6-ede1e89317ad'");
        $this->addSql("UPDATE sylius_province SET code = 'RU-AL' where code = 'RU'");
    }
}
