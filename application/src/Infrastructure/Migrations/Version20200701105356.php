<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701105356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_profile_phone_confirm_codes (id UUID NOT NULL, user_id UUID DEFAULT NULL, code INT NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, phone VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E536225CA76ED395 ON user_profile_phone_confirm_codes (user_id)');
        $this->addSql('COMMENT ON COLUMN user_profile_phone_confirm_codes.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_profile_phone_confirm_codes.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_profile_phone_confirm_codes.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_profile_phone_confirm_codes ADD CONSTRAINT FK_E536225CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_profiles ADD phone VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_profile_phone_confirm_codes');
        $this->addSql('ALTER TABLE user_profiles DROP phone');
    }
}
