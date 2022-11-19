<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221119184025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artistic_work DROP FOREIGN KEY FK_CE5AAFC74E7AF8F');
        $this->addSql('ALTER TABLE artistic_work DROP FOREIGN KEY FK_CE5AAFC712469DE2');
        $this->addSql('ALTER TABLE artistic_work_vente DROP FOREIGN KEY FK_C3A9B41712469DE2');
        $this->addSql('ALTER TABLE artistic_work_vente DROP FOREIGN KEY FK_C3A9B417484AC5B1');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783AA76ED395');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A12469DE2');
        $this->addSql('ALTER TABLE gallery_vente DROP FOREIGN KEY FK_6C17FA6F12469DE2');
        $this->addSql('ALTER TABLE gallery_vente DROP FOREIGN KEY FK_6C17FA6FA76ED395');
        $this->addSql('DROP TABLE artistic_work');
        $this->addSql('DROP TABLE artistic_work_vente');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE gallery_vente');
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('DROP INDEX UNIQ_FB8F9240989D9B62 ON artistic_work_echange');
        $this->addSql('ALTER TABLE artistic_work_echange DROP slug');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artistic_work (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, category_id INT DEFAULT NULL, slug VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_CE5AAFC7989D9B62 (slug), INDEX IDX_CE5AAFC74E7AF8F (gallery_id), INDEX IDX_CE5AAFC712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE artistic_work_vente (id INT AUTO_INCREMENT NOT NULL, gallery_vente_id INT DEFAULT NULL, category_id INT DEFAULT NULL, slug VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, price NUMERIC(10, 0) DEFAULT NULL, INDEX IDX_C3A9B41712469DE2 (category_id), UNIQUE INDEX UNIQ_C3A9B417989D9B62 (slug), INDEX IDX_C3A9B417484AC5B1 (gallery_vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contact (name VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, email VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, subject VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, message TEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_472B783A12469DE2 (category_id), INDEX IDX_472B783AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gallery_vente (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6C17FA6F12469DE2 (category_id), INDEX IDX_6C17FA6FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE artistic_work ADD CONSTRAINT FK_CE5AAFC74E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE artistic_work ADD CONSTRAINT FK_CE5AAFC712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE artistic_work_vente ADD CONSTRAINT FK_C3A9B41712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE artistic_work_vente ADD CONSTRAINT FK_C3A9B417484AC5B1 FOREIGN KEY (gallery_vente_id) REFERENCES gallery_vente (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE gallery_vente ADD CONSTRAINT FK_6C17FA6F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE gallery_vente ADD CONSTRAINT FK_6C17FA6FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE artistic_work_echange ADD slug VARCHAR(191) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FB8F9240989D9B62 ON artistic_work_echange (slug)');
    }
}
