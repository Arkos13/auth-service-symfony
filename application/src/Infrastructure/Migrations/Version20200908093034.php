<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908093034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user_profiles ADD birthday TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_profiles ADD gender VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_profiles ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE user_profiles ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_profiles.birthday IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_profiles.created IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_profiles.updated IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE users ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE users ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN users.created IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.updated IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE users DROP created');
        $this->addSql('ALTER TABLE users DROP updated');
        $this->addSql('ALTER TABLE user_profiles DROP birthday');
        $this->addSql('ALTER TABLE user_profiles DROP gender');
        $this->addSql('ALTER TABLE user_profiles DROP created');
        $this->addSql('ALTER TABLE user_profiles DROP updated');
    }
}
