<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505103101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT locale (id, title, code) VALUES (1, 'English','eng');");
        $this->addSql("INSERT locale (id, title, code) VALUES (2, 'French', 'fra');");
        $this->addSql("INSERT country (id, locale_id, title) VALUES (1, 1, 'United Kingdom');");
        $this->addSql("INSERT country (id, locale_id, title) VALUES (2, 2, 'France');");
        $this->addSql("INSERT vat (id, country_id, rate, type) VALUES (1,1, 7,'food');");
        $this->addSql("INSERT vat (id, country_id, rate, type) VALUES (2,1, 15,'alcohol');");
        $this->addSql("INSERT vat (id, country_id, rate, type) VALUES (3,2, 5,'food');");
        $this->addSql("INSERT vat (id, country_id, rate, type) VALUES (4,2, 12,'alcohol');");
        $this->addSql("INSERT product (id, title, description, price, type) VALUES (1, 'Bread', 'Wonderlful cristy bread', 50, 'food');");
        $this->addSql("INSERT product (id, title, description, price, type) VALUES (2, 'Wine', 'Red semi-sweet', 100, 'alcohol');");
        $this->addSql("INSERT product_vat (product_id, vat_id) VALUES (1, 1);");
        $this->addSql("INSERT product_vat (product_id, vat_id) VALUES (1, 3);");
        $this->addSql("INSERT product_vat (product_id, vat_id) VALUES (2, 2);");
        $this->addSql("INSERT product_vat (product_id, vat_id) VALUES (2, 4);");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("TRUNCATE TABLE locale;");
        $this->addSql("TRUNCATE TABLE country;");
        $this->addSql("TRUNCATE TABLE vat;");
        $this->addSql("TRUNCATE TABLE product;");
        $this->addSql("TRUNCATE TABLE product_vat;");
    }
}
