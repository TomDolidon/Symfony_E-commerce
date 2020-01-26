<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126163627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO categorie VALUES (1,"Fruits", "images/fruits.jpg", "De la passion ou de ton imagination" )');
        $this->addSql('INSERT INTO categorie VALUES (3,"Junk Food", "images/junk_food.jpg", "Chère et cancérogène, tu es prévenu(e)" )');
        $this->addSql('INSERT INTO categorie VALUES (2,"Légumes", "images/legumes.jpg", "Plus tu en manges, moins tu en es un" )');

        $this->addSql('INSERT INTO produit VALUES (1, 1 , "Pomme", "Elle est bonne pour la tienne", "images/pommes.jpg", 3.42  )');
        $this->addSql('INSERT INTO produit VALUES (2, 1 , "Poire", "Ici tu n\'en es pas une", "images/poires.jpg", 2.11  )');
        $this->addSql('INSERT INTO produit VALUES (3, 1 , "Pêche", "Elle va te la donner", "images/peche.jpg", 2.84  )');

        $this->addSql('INSERT INTO produit VALUES (4, 2 , "Carotte", "C\'est bon pour ta vue", "images/carottes.jpg", 2.90  )');
        $this->addSql('INSERT INTO produit VALUES (5, 2 , "Tomate", "Fruit ou Légume ? Légume", "images/tomates.jpg", 1.70  )');
        $this->addSql('INSERT INTO produit VALUES (6, 2 , "Chou Romanesco", "Mange des fractales", "images/romanesco.jpg", 1.81  )');

        $this->addSql('INSERT INTO produit VALUES (7, 3 , "Nutella", "C\'est bon, sauf pour ta santé", "images/nutella.jpg", 4.50  )');
        $this->addSql('INSERT INTO produit VALUES (8, 3 , "Pizza", "Y\'a pas pire que za", "images/pizza.jpg", 8.25  )');
        $this->addSql('INSERT INTO produit VALUES (9, 3 , "Oreo", "Seulement si tu es un smartphone", "images/oreo.jpg", 2.50  )');
    }


    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
