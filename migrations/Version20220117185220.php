<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220117185220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poc (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image_filename VARCHAR(255) NOT NULL, github_link VARCHAR(255) NOT NULL, live_demo_link VARCHAR(255) DEFAULT NULL, keywords LONGTEXT NOT NULL, INDEX IDX_9D6EF6C8F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poc_language (poc_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_BA71BA6D11110831 (poc_id), INDEX IDX_BA71BA6D82F1BAF4 (language_id), PRIMARY KEY(poc_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poc_category (poc_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_68E6D21911110831 (poc_id), INDEX IDX_68E6D21912469DE2 (category_id), PRIMARY KEY(poc_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poc ADD CONSTRAINT FK_9D6EF6C8F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE poc_language ADD CONSTRAINT FK_BA71BA6D11110831 FOREIGN KEY (poc_id) REFERENCES poc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poc_language ADD CONSTRAINT FK_BA71BA6D82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poc_category ADD CONSTRAINT FK_68E6D21911110831 FOREIGN KEY (poc_id) REFERENCES poc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poc_category ADD CONSTRAINT FK_68E6D21912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poc_category DROP FOREIGN KEY FK_68E6D21912469DE2');
        $this->addSql('ALTER TABLE poc_language DROP FOREIGN KEY FK_BA71BA6D82F1BAF4');
        $this->addSql('ALTER TABLE poc_language DROP FOREIGN KEY FK_BA71BA6D11110831');
        $this->addSql('ALTER TABLE poc_category DROP FOREIGN KEY FK_68E6D21911110831');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE poc');
        $this->addSql('DROP TABLE poc_language');
        $this->addSql('DROP TABLE poc_category');
    }
}
