<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200616113418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE user_profiles (user_id UUID NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('COMMENT ON COLUMN user_profiles.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_history_auth (id UUID NOT NULL, user_id UUID DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, country_code VARCHAR(255) DEFAULT NULL, country_name VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, ip VARCHAR(255) DEFAULT NULL, guid VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7327BC27A76ED395 ON user_history_auth (user_id)');
        $this->addSql('COMMENT ON COLUMN user_history_auth.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_history_auth.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_history_auth.created IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_confirm_email_tokens (id UUID NOT NULL, user_id UUID NOT NULL, confirmation_email_token VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, expires TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C055324BA76ED395 ON user_confirm_email_tokens (user_id)');
        $this->addSql('COMMENT ON COLUMN user_confirm_email_tokens.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_confirm_email_tokens.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_confirm_email_tokens.expires IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, blocked BOOLEAN DEFAULT \'false\' NOT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, expires_confirmation_token TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX email_idx ON users (email)');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.expires_confirmation_token IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE oauth2_authorization_code (identifier CHAR(80) NOT NULL, client VARCHAR(32) NOT NULL, expiry TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_identifier VARCHAR(128) DEFAULT NULL, scopes TEXT DEFAULT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE INDEX IDX_509FEF5FC7440455 ON oauth2_authorization_code (client)');
        $this->addSql('COMMENT ON COLUMN oauth2_authorization_code.expiry IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_authorization_code.scopes IS \'(DC2Type:oauth2_scope)\'');
        $this->addSql('CREATE TABLE oauth2_refresh_token (identifier CHAR(80) NOT NULL, access_token CHAR(80) DEFAULT NULL, expiry TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE INDEX IDX_4DD90732B6A2DD68 ON oauth2_refresh_token (access_token)');
        $this->addSql('COMMENT ON COLUMN oauth2_refresh_token.expiry IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE oauth2_access_token (identifier CHAR(80) NOT NULL, client VARCHAR(32) NOT NULL, expiry TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_identifier VARCHAR(128) DEFAULT NULL, scopes TEXT DEFAULT NULL, revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE INDEX IDX_454D9673C7440455 ON oauth2_access_token (client)');
        $this->addSql('COMMENT ON COLUMN oauth2_access_token.expiry IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_access_token.scopes IS \'(DC2Type:oauth2_scope)\'');
        $this->addSql('CREATE TABLE oauth2_client (identifier VARCHAR(32) NOT NULL, secret VARCHAR(128) DEFAULT NULL, redirect_uris TEXT DEFAULT NULL, grants TEXT DEFAULT NULL, scopes TEXT DEFAULT NULL, active BOOLEAN NOT NULL, allow_plain_text_pkce BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('COMMENT ON COLUMN oauth2_client.redirect_uris IS \'(DC2Type:oauth2_redirect_uri)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_client.grants IS \'(DC2Type:oauth2_grant)\'');
        $this->addSql('COMMENT ON COLUMN oauth2_client.scopes IS \'(DC2Type:oauth2_scope)\'');
        $this->addSql('ALTER TABLE user_profiles ADD CONSTRAINT FK_6BBD6130A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_history_auth ADD CONSTRAINT FK_7327BC27A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_confirm_email_tokens ADD CONSTRAINT FK_C055324BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oauth2_authorization_code ADD CONSTRAINT FK_509FEF5FC7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD90732B6A2DD68 FOREIGN KEY (access_token) REFERENCES oauth2_access_token (identifier) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D9673C7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE user_profiles DROP CONSTRAINT FK_6BBD6130A76ED395');
        $this->addSql('ALTER TABLE user_history_auth DROP CONSTRAINT FK_7327BC27A76ED395');
        $this->addSql('ALTER TABLE user_confirm_email_tokens DROP CONSTRAINT FK_C055324BA76ED395');
        $this->addSql('ALTER TABLE oauth2_refresh_token DROP CONSTRAINT FK_4DD90732B6A2DD68');
        $this->addSql('ALTER TABLE oauth2_authorization_code DROP CONSTRAINT FK_509FEF5FC7440455');
        $this->addSql('ALTER TABLE oauth2_access_token DROP CONSTRAINT FK_454D9673C7440455');
        $this->addSql('DROP TABLE user_profiles');
        $this->addSql('DROP TABLE user_history_auth');
        $this->addSql('DROP TABLE user_confirm_email_tokens');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE oauth2_authorization_code');
        $this->addSql('DROP TABLE oauth2_refresh_token');
        $this->addSql('DROP TABLE oauth2_access_token');
        $this->addSql('DROP TABLE oauth2_client');
    }
}
