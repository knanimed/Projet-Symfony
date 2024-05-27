<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515163510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bookauthor (id INT AUTO_INCREMENT NOT NULL, book_id_id INT NOT NULL, author_id_id INT NOT NULL, INDEX IDX_3955212D71868B2E (book_id_id), INDEX IDX_3955212D69CCBE9A (author_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE borrowing (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, book_id INT NOT NULL, dateborrowed DATE NOT NULL, bookreturned TINYINT(1) NOT NULL, INDEX IDX_226E5897CB944F1A (student_id), INDEX IDX_226E589716A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bookauthor ADD CONSTRAINT FK_3955212D71868B2E FOREIGN KEY (book_id_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE bookauthor ADD CONSTRAINT FK_3955212D69CCBE9A FOREIGN KEY (author_id_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E5897CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E589716A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE reset_password ADD CONSTRAINT FK_B9983CE5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password DROP FOREIGN KEY FK_B9983CE5A76ED395');
        $this->addSql('ALTER TABLE bookauthor DROP FOREIGN KEY FK_3955212D71868B2E');
        $this->addSql('ALTER TABLE bookauthor DROP FOREIGN KEY FK_3955212D69CCBE9A');
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E5897CB944F1A');
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E589716A2B381');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE bookauthor');
        $this->addSql('DROP TABLE borrowing');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE user');
    }
}
