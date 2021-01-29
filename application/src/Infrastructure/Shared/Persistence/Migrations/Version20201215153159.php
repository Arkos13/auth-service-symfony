<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215153159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE user_confirm_password_tokens (id UUID NOT NULL, user_id UUID NOT NULL, confirmation_email_token VARCHAR(255) NOT NULL, expires TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_91CA21ACA76ED395 ON user_confirm_password_tokens (user_id)');
        $this->addSql('COMMENT ON COLUMN user_confirm_password_tokens.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_confirm_password_tokens.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_confirm_password_tokens.expires IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE user_confirm_password_tokens');
    }
}
